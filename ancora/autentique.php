<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'ancora') {
  header("Location: ../pagina_de_acesso_nao_autorizado.php");
  exit();
}
function formatarCPF($cpf) {
  // Remove caracteres não numéricos do CPF
  // $cpf = preg_replace('/[^0-9]/', '', $cpf);

  // Verifica se o CPF possui 11 dígitos
  if (strlen($cpf) != 11) {
      return "CPF inválido".$cpf;
  }

  // Formata o CPF com separadores
  $cpfFormatado = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);

  return $cpfFormatado;
}
function idAntecipacao($str) {
  $s1 = explode('_', $str);
  $s2 = explode('.', $s1[2]);
  
  return $s2[0];
}
require_once('../Class/Config.php');
require_once('../Class/EmailSender.class.php');
require_once('../Class/emails.class.php');
// require_once('../Class/ancoras.class.php');
require_once('../Class/assinante.class.php');
require_once('../Class/instalacoes.class.php');
$dominio = DOMINIO;
$instalacoes = new instalacoes();
$instalacoes->setDominio1($dominio);
$ANCORA = $instalacoes->VeificaDominio1();






$con = new mysqli(DB_HOST, DB_USER,DB_PASS, DB_NAME);


function prepared_query($mysqli, $sql, $params, $types = "") {

  if (is_null($mysqli)) {
    $mysqli = $con;
  }

  $stmt = $mysqli->prepare($sql);
  if (sizeof($params) > 0) {
    $types = $types ?: str_repeat("s", count($params));
    $stmt->bind_param($types, ...$params);
  }    
  $stmt->execute();
  return $stmt;
}

$dados = json_decode(file_get_contents('php://input'), true);
$arq = json_encode($dados['arquivo']);
$ant = idAntecipacao(json_encode($arq));
$email = $dados['emailEmpresa'];
$id_operacao = $con->real_escape_string($dados['id_operacao']);

if (is_null($id_operacao)) {
  echo json_encode("{}");
  return;
}
// chave certsign
$access_token = $ANCORA['access_token'];
$env = 'app';

// $env = 'sandbox';
// $access_token = "9db5ccda-9186-4d71-afbf-17e73efb23d4";
$filename = $dados["arquivo"];
$data = file_get_contents($filename);

// echo "ANTECIPAÇÃO ID IS".$ant;
// echo $data;


$fooObject = (object) null;
$fooObject->document = (object) array("path" => "/".$filename);
$fooObject->document->content_base64 = "data:application/pdf;base64,".base64_encode("$data");
$fooObject->document->block_after = false;
$jsonBody = json_encode($fooObject, JSON_UNESCAPED_SLASHES);
$url = "https://$env.clicksign.com/api/v1/documents?access_token=$access_token";
$ch = curl_init($url);
// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
// Execute cURL session
$output = curl_exec($ch);
// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}
// Close cURL session
curl_close($ch);
// Decode the JSON response
$phpObj = json_decode($output, true);



$document_key = $phpObj["document"]["key"];
$sql = "SELECT * FROM assinante where 1 = 1";
$stmt = prepared_query($con, $sql, [], '');
$retrieve = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close(); 
$signer1_retrieved = $retrieve[0]["clicksign_key"];
$auths =$retrieve[0]["auths"];

// echo "RETREIVED THEN THE FIRST SIGNER >>>".var_dump($signer1_retrieved);
if (is_null($signer1_retrieved)) {
// create or retrieve signer 1
  $signer1 = (object) null;
  // $signer1->signer = (object) array("email" => "allan.murara@gmail.com");
  $signer1->signer = (object) array("email" =>  $ANCORA['access_token']);
  $signer1->signer->auths = [$auths];
  $signer1->signer->delivery = "none";
  $signer1->signer->has_documentation = false;   
  // $signer1->signer->selfie_enabled = false;
  // $signer1->signer->handwritten_enabled = false;
  // $signer1->signer->liveness_enabled = false;
  // $signer1->signer->facial_biometrics_enabled = false;
  $signer1->signer->name = $ANCORA['nome_representante'];
  $signer1Body = json_encode($signer1, JSON_UNESCAPED_SLASHES);

  // exec("curl 'https://$env.clicksign.com/api/v1/signers?access_token=$access_token' \
  // --header 'Accept: application/json' \
  // --header 'Content-Type: application/json' \
  // --header 'Host: $env.clicksign.com' \
  // -d '$signer1Body'", $outputAddSignature1);  
  // $signer1_retrieved_output = json_decode($outputAddSignature1[0], true);

  $url = "https://$env.clicksign.com/api/v1/signers?access_token=$access_token";

  $ch = curl_init($url);
  
  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Accept: application/json',
      'Content-Type: application/json',
      "Host: $env.clicksign.com"
  ]);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $signer1Body);
  
  // Execute cURL session
  $outputAddSignature1 = curl_exec($ch);
  
  // Check for cURL errors
  if (curl_errno($ch)) {
      echo 'Curl error: ' . curl_error($ch);
  }
  
  // Close cURL session
  curl_close($ch);
  
  // Decode the JSON response
   $signer1_retrieved_output = json_decode($outputAddSignature1, true);
  

  $signer1_retrieved = $signer1_retrieved_output["signer"]["key"];
  // var_dump($signer1_retrieved_output);
  // echo "update assinante set clicksign_key = '$signer1_retrieved'";
  // $sql = "update assinante set clicksign_key = $signer1_retrieved";
  $query = mysqli_query($con, "update assinante set clicksign_key = '$signer1_retrieved'");
  // echo "SIGNER 1 ADDED IS _____________________________".var_dump($signer1_retrieved);
  // echo " >>>>> ASSINANTE UPDATED >>>>>>".$query;
  // $stmt = prepared_query($con, $sql, [$signer1_retrieved], 's');
  // $retrieve = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  // $stmt->close(); 
}

// echo 1;
// add signer 1 to document_key
$addListSigner1 = (object) null;
$addListSigner1->list = (object) array("document_key" => $document_key);
$addListSigner1->list->signer_key = $signer1_retrieved;
$addListSigner1->list->sign_as = "party";
$addListSigner1->list->message = "Por favor, assine o documento.";
$addListSigner1->list->name = $ANCORA['nome_representante'];
$addListBody = json_encode($addListSigner1, JSON_UNESCAPED_SLASHES);

// exec("curl 'https://$env.clicksign.com/api/v1/lists?access_token=$access_token' \
// --header 'Accept: application/json' \
// --header 'Content-Type: application/json' \
// --header 'Host: $env.clicksign.com' \
// -d '$addListBody'", $outputSigner1);  


$url = "https://$env.clicksign.com/api/v1/lists?access_token=$access_token";

$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $addListBody);

// Execute cURL session
$outputSigner1 = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Close cURL session


// Decode the JSON response
$signer1_added = json_decode($outputSigner1,true);

// add signer 1 to document END 

// sing through API



  // return;
  $sql = "SELECT antecDet.operacao as operacao, fornecedores.updated as updated, fornecedores.razao as razao,fornecedores.representante as representante, fornecedores.email as email, fornecedores.clicksign_key as clicksign_key, fornecedores.cnpj as cnpj, fornecedores.cpf as cpf, fornecedores.representante as nome, antec.data as data_oper, antec.valor as valor, antec.id as id FROM antecipadas antec inner join antecipadasDetalhes antecDet on antecDet.antecipada = antec.id  inner join fornecedores on fornecedores.id = antec.fornecedor WHERE antec.id = ?";
  // echo "NOW ADD SIGNER 2>>>>";
  // $sql = " FROM antecipadas antec inner join fornecedores on fornecedores.tipo = 'cliente' and fornecedores.id = antec.fornecedor WHERE antec.id = ?";
  $stmt = prepared_query($con, $sql, [$id_operacao], 'i');
  $fornecedor = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  // echo "FORNEC IS".var_dump($fornecedor);
  $stmt->close(); 
  
$fornec_cnpj = $fornecedor[0]['cnpj'];

$signer2_retrieved = $fornecedor[0]["clicksign_key"];
foreach($fornecedor as $oper) {
  $operid = $oper['operacao'];
  $query = mysqli_query($con, "update operacoes set clicksign_key = '$document_key' where id = '$operid'");  
}
 $oper = $fornecedor[0]['operacao'];

// echo "FOUND OPER".$oper;
// echo "UPDATING"."update operacoes set clicksign_key = '$document_key' where id = $oper";



if (is_null($signer2_retrieved) || $fornecedor[0]['updated'] == 1) {
  if (is_null($fornecedor[0]["email"])) {
    die();
  }
  [$fornecedor_nome, $fornecedor_sobrenome] = explode(" ", $fornecedor[0]["nome"]);
  $signer2 = (object) null;
  $signer2->signer = (object) array("email" => $fornecedor[0]["email"]);
  // $signer2->signer = (object) array("email" => "mrlobulo@gmail.com");
  // $signer2->signer->auths = array("icp_brasil");
  $signer2->signer->auths = array("email");
  $CPF = formatarCPF($fornecedor[0]["cpf"]);
  $signer2->signer->name = $fornecedor_nome.' '.$fornecedor_sobrenome;
  $signer2->signer->documentation = $CPF;
  $signer2->signer->selfie_enabled = false;
  $signer2->signer->handwritten_enabled = false;
  $signer2->signer->liveness_enabled = false;
  $signer2->signer->facial_biometrics_enabled = false;
  $signer2Body = json_encode($signer2, JSON_UNESCAPED_SLASHES);
  
  $url = "https://$env.clicksign.com/api/v1/signers?access_token=$access_token";

  $ch = curl_init($url);
  
  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Accept: application/json',
      'Content-Type: application/json',
      "Host: $env.clicksign.com"
  ]);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $signer2Body);
  
  // Execute cURL session
  $outputAddSignature2 = curl_exec($ch);
  
  // Check for cURL errors
  if (curl_errno($ch)) {
      echo 'Curl error: ' . curl_error($ch);
  }
  
  // Close cURL session
  curl_close($ch);
  
  // echo "LALLALA >>>> TRY TO ADD.".var_dump($outputAddSignature2);
  // exit;
  $signer2_retrieved = json_decode($outputAddSignature2, true);
  if (isset($signer2_retrieved['errors'])) {
    $error = $signer2_retrieved['errors'][0];
    echo json_encode("{ erro : $error }");
    die();
  }
  $signer2_retrieved = $signer2_retrieved["signer"]["key"];
  $sql = "update fornecedores set clicksign_key = '$signer2_retrieved', updated = 0 where fornecedores.tipo = 'cliente' and fornecedores.cnpj = $fornec_cnpj";
  // echo "UPDATING FORNECEDOR >>>>>>>>".$sql;
  $query = mysqli_query($con, $sql);
  // $stmt = prepared_query($con, $sql, [$signer2_retrieved, $fornecedor[0]["cnpj"]], 'si');
  // echo "UPDAERT IS".$query;
  // $retrieve = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  // $stmt->close(); 
}
// exit;
// add signer 2 to document_key
$addListSigner2 = (object) null;
$addListSigner2->list = (object) array("document_key" => $document_key);
$addListSigner2->list->signer_key = $signer2_retrieved;
$addListSigner2->list->sign_as = "party";
$addListSigner2->list->message = "Por favor, assine o documento.";
// $addListSigner2->list->name = "Allan Felipe Murara";
$addListBody2 = json_encode($addListSigner2, JSON_UNESCAPED_SLASHES);
// echo "ADD LIST BODY 2".$addListBody2;
$url = "https://$env.clicksign.com/api/v1/lists?access_token=$access_token";

$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $addListBody2);

// Execute cURL session
$outputSigner2 = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);
// echo "SIGNER ADDED 2 OUTPUT".var_dump($outputSigner2);
$signer2_added = json_decode($outputSigner2, true);
// add signer 1 to document END
$request_sign_body = (object) null;
$request_sign_body->request_signature_key = $signer2_added["list"]["request_signature_key"];
$request_sign_body->message = 'Por favor assine o documento.';


if (isset($signer2_added['errors'])) {
  // echo  "ERROR>>>>".$signer2_retrieved_output['errors'];
  $error = $signer2_added['errors'][0];
  echo json_encode("{ erro : 'Erro ao adicionar assinante 2, contrato ficará pendente.' }");
  die();
}


if (is_null($signer2_added["list"])) {
  echo json_encode("{}");
  die();
} else {
  $request_signature_body = json_encode($request_sign_body, JSON_UNESCAPED_SLASHES);
  // echo "ADD LIST BODY 2".$addListBody2;
  $url = "https://$env.clicksign.com/api/v1/lists?access_token=$access_token";

  $ch = curl_init($url);
  
  // Set cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Accept: application/json',
      'Content-Type: application/json',
      "Host: $env.clicksign.com"
  ]);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $addListBody2);
  
  // Execute cURL session
  $outputSigner2 = curl_exec($ch);
  
  // Check for cURL errors
  if (curl_errno($ch)) {
      echo 'Curl error: ' . curl_error($ch);
  }
  
  // Close cURL session
  curl_close($ch);



  echo json_encode($outputSigner2, true);
  // request_signature_key
  $fornecedor[0]['clicksign_key'] = $document_key;
  $fornecedor[0]["fornecedor"] = $fornecedor[0]["razao"];
  $destinatario = $fornecedor[0]["email"];
  $VAR_NOME = $fornecedor[0]["razao"];
  // $ANCORA =   $fornecedor[0]["representante"];
  $sql = "SELECT *, antecipadasDetalhes.valor as valor_antecip, ( select antecipadas.valor from antecipadas where id = ? ) as valor_antecip_liq FROM antecipadasDetalhes 
  inner join boletos on boletos.operacao = antecipadasDetalhes.operacao
  inner join operacoes on operacoes.id = antecipadasDetalhes.operacao
  inner join fornecedores on fornecedores.cnpj = operacoes.cnpj 
  WHERE antecipadasDetalhes.antecipada = ?";
    // return;
  $stmt = prepared_query($con, $sql, [$id_operacao,$id_operacao], 'ii');
  $antecip = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
  $destinatario = $fornecedor[0]["email"];
  $msg = $sql;
  $assunto = 'Antecipação Criada';

  $clicksign_key = $fornecedor[0]['clicksign_key'];
  $sign_url = '';
  $access_token = $ANCORA['access_token'];
  $url = "https://app.clicksign.com/api/v1/documents/$clicksign_key?access_token=$access_token";

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Content-Type: application/json',
    'Host: app.clicksign.com'
  ]);

  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpCode === 200) {
    $doc_return = json_decode($response, true);
    if (isset($doc_return["document"]["signers"][1]["url"])) {
      $LINK  =  $doc_return["document"]["signers"][1]["url"];
    } else {
      // Handle missing URL
      $LINK  = '';
    }
    if (isset($doc_return["document"]["signers"][0]["url"])) {
      $LINK_ANCORA  =  $doc_return["document"]["signers"][0]["url"];
    } else {
      // Handle missing URL
      $LINK_ANCORA  = '';
    }
  } else {
    // Handle HTTP request failure
    $LINK  =  '';
  }

  $RESUMO = $antecip;

  $trs = '';
  $table = '';

  $total_juros = 0;
  $total_liquido = 0;


  foreach ($RESUMO as $a) {
    $trs .= ' 
       <tr style="background-color: #FFF; color: #000; text-align: left; border: 0px solid white;">
       <td style="padding: 10px;">' . $a['razao'] . '</td>
       <td style="padding: 10px;">' . $a['nota'] . '</td>
       <td style="padding: 10px;">' . date('d/m/Y', strtotime($a['vencimento_velho'])) . '</td>
       <td style="padding: 10px;">' . number_format($a['valorOriginal'], 2, ",", ".") . '</td>
       <td style="padding: 10px;">' . date('d/m/Y', strtotime($a['vencimento'])) . '</td>
       <td style="padding: 10px;">R$ ' . number_format($a['juros_posterg'], 2, ",", ".") . '</td>
       <td style="padding: 10px;">R$ ' . number_format($a['valor_antecip'], 2, ",", ".") . '</td>
       </tr>
     ';

    // $total_juros += $a['juros'];
    $taxas = $a['taxas_posterg'];
    $total_liquido += $a['valor_antecip'];
  }



  $table = '<table style="border: hidden 0px #FFF; font-size: 12px;">
     <thead>
       <tr style="background-color: #E0E0E0; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
         <td style="padding: 10px; ">Emitente/Sacado</td>
         <td style="padding: 10px; ">Documento</td>
         <td style="padding: 10px; ">Vencimento Original</td>
         <td style="padding: 10px; ">Valor Original</td>                
         <td style="padding: 10px; ">Novo Vencimento</td>
         <td style="padding: 10px; ">Juros</td>
         <td style="padding: 10px; ">Valor Líquido</td>
       </tr>
     </thead>
     <tbody>
       ' . $trs . '
     </tbody>
     <tfoot style="">
       <tr style="background-color: #E0E0E0; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
         <td style="padding: 10px; ">Total Taxas</td>
         <td></td>
         <td> </td>
         <td> </td>
         <td> </td>
         <td> </td>
         <td style="padding: 10px; "> R$' . number_format($taxas, 2, ",", ".") . '</td>
       </tr>
       <tr style="background-color: #D1D1D1; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
         <td style="padding: 10px; "> Valor Líquido</td>
         <td> </td>
         <td> </td>
         <td> </td>
         <td> </td>
         <td> </td>
         <td style="padding: 10px; "> R$' . number_format($total_liquido, 2, ",", ".") . '</td>
       </tr>
       <tr style="background-color: #010840; color: #FFF; text-align: center; font-weight: bold; text-transform: uppercase;">
         <td style="padding: 10px;">Banco</td>
         <td style="padding: 10px;">' . $a['banco'] . '</td>
         <td style="padding: 10px;">Conta</td>
         <td style="padding: 10px;">' . $a['conta'] . '</td>
         <td style="padding: 10px;"></td>
         <td style="padding: 10px;">Agencia</td>
         <td style="padding: 10px;">' . $a['agencia'] . '</td>
       </tr>
     </tfoot>
   </table>
   ';



  //   $EmailSender = new EmailSender();
  //   $EmailSender->Email_operacao_concluida_Antecipacao($destinatario, $VAR_NOME, $RESUMO, $LINK);
  // $EmailSender->send_postergacao_criada_mail($destinatario, $msg, $assunto, $posterg);
  $template = file_get_contents('../Class/fornecedores/operacao-concluida.html');
  $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
  //   $template = str_replace('{NUMERO_OPERACAO_VENDOR}', '0000' . $NUMERO_OPERACAO_VENDOR, $template);
  $template = str_replace('{RESUMO}', $table, $template);
  //   $template = str_replace('{VALOR_LIQUIDO_OPERACAO}', $VALOR_LIQUIDO_OPERACAO, $template);
  $template = str_replace('{LINK}', $LINK, $template);

  $email = new emails();
  $email->setRecipient_email($destinatario);
  $email->setSubject('Operação Concluída');
  $email->setBody($template);
  $email->setStatus('pendente');
  $email->setType('Assinatura');
  $email->setCreated_at(date('Y-m-d H:i:s'));
  $email->setSent_at(null);
  $email->Insert();
  $DATA_OPERACAO = date('d/m/Y',strtotime($fornecedor[0]['data_oper']));
  $NUMERO_OPERACAO_VENDOR =  $id_operacao;


  // $EmailSender1->Email_Pedido_de_assinatura_Fornacedor($destinatario, $VAR_NOME, $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO, $ANCORA, $LINK);
  $template = file_get_contents('../Class/fornecedores/assinatura.html');
  $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
  $template = str_replace('{NUMERO_OPERACAO_VENDOR}', '0000' . $NUMERO_OPERACAO_VENDOR, $template);
  $template = str_replace('{DATA_OPERACAO}', $DATA_OPERACAO, $template);
  $template = str_replace('{VALOR_LIQUIDO_OPERACAO}', $VALOR_LIQUIDO_OPERACAO, $template);
  $template = str_replace('{LINK}', $LINK, $template);

  $email = new emails();
  $email->setRecipient_email($destinatario);
  $email->setSubject('Faça sua Assinatura');
  $email->setBody($template);
  $email->setStatus('pendente');
  $email->setType('Assinatura');
  $email->setCreated_at(date('Y-m-d H:i:s'));
  $email->setSent_at(null);
  $email->Insert();

  $template = file_get_contents('../Class/fornecedores/assinatura.html');
  $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
  $template = str_replace('{NUMERO_OPERACAO_VENDOR}', '0000' . $NUMERO_OPERACAO_VENDOR, $template);
  $template = str_replace('{DATA_OPERACAO}', $DATA_OPERACAO, $template);
  $template = str_replace('{VALOR_LIQUIDO_OPERACAO}', $VALOR_LIQUIDO_OPERACAO, $template);
  $template = str_replace('{LINK}', $LINK_ANCORA, $template);

  $email = new emails();
  $email->setRecipient_email($ANCORA['email_resgiter']);
  $email->setSubject('Faça sua Assinatura');
  $email->setBody($template);
  $email->setStatus('pendente');
  $email->setType('Assinatura');
  $email->setCreated_at(date('Y-m-d H:i:s'));
  $email->setSent_at(null);
  $email->Insert();
}



$sql = "SELECT secret_signerkey FROM assinante where 1 = 1";
$stmt = prepared_query($con, $sql, [], '');
$retrieve = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt->close(); 

$secret_signerkey = $retrieve[0]["secret_signerkey"];
 $request_signature_key = $signer1_added["list"]["request_signature_key"];
 $hmac_secret = hash_hmac('sha256',$request_signature_key , $secret_signerkey);
$signBody = (object) null;
$signBody->request_signature_key = $signer1_added["list"]["request_signature_key"];
$signBody->secret_hmac_sha256 = $hmac_secret;

$signData = json_encode($signBody);

$url = "https://$env.clicksign.com/api/v1/sign?access_token=$access_token";

$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $signData);

// Execute cURL session
$outputTryToSign = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

?>

