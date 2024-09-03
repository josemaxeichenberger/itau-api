<?php
session_start();
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'cliente') {
  header("Location: ../pagina_de_acesso_nao_autorizado.php");
  exit();
}
function idAntecipacao($str)
{
  $s1 = explode('_', $str);
  $s2 = explode('.', $s1[2]);

  return $s2[0];
}

require_once('../Class/Config.php');
require_once('../Class/EmailSender.class.php');
require_once('../Class/fornecedores.class.php');
require_once('../Class/emails_assinatura.class.php');
$con = new mysqli(DB_HOUST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($con, 'utf8');


function prepared_query($mysqli, $sql, $params, $types = "")
{
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
$access_token = 'adf1d531-65de-4213-b0f7-947443bfd863';
$env = "app";
// $access_token = '9db5ccda-9186-4d71-afbf-17e73efb23d4';
// $env = 'sandbox';

$filename = $dados["arquivo"];
$data = file_get_contents('../' . $filename);

$fooObject = (object) null;
$fooObject->document = (object) array("path" => "/" . $filename);
$fooObject->document->content_base64 = "data:application/pdf;base64," . base64_encode("$data");
$fooObject->document->block_after = false;
$jsonBody = json_encode($fooObject, JSON_UNESCAPED_SLASHES);

// Configuração das opções cURL-1
$ch = curl_init();
curl_setopt_array($ch, [
  CURLOPT_URL => "https://$env.clicksign.com/api/v1/documents?access_token=$access_token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => $jsonBody,
  CURLOPT_HTTPHEADER => [
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
  ]
]);

// Executa a solicitação cURL e obtém a resposta
$output = curl_exec($ch);

// Verifica por erros
if ($output === false) {
  echo 'Erro cURL: ' . curl_error($ch);
}

// Fecha a sessão cURL
curl_close($ch);

$phpObj = json_decode($output, true);
// cURL-1 fim

// busca o clicksign_key do assinante
$document_key = $phpObj["document"]["key"];
$sql = "SELECT clicksign_key FROM assinante where 1 = 1";
$stmt = prepared_query($con, $sql, [], '');
$retrieve = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$query = mysqli_query($con, "update operacoes set clicksign_key = '$document_key' where id in ($id_operacao)");
$signer1_retrieved = $retrieve[0]["clicksign_key"];

// echo "RETREIVED THEN THE FIRST SIGNER >>>".var_dump($signer1_retrieved);
if (is_null($signer1_retrieved)) {
  // create or retrieve signer 1
  $signer1 = (object) null;
  // $signer1->signer = (object) array("email" => "allan.murara@gmail.com");
  $signer1->signer = (object) array("email" => $dados['emailEmpresa']);
  $signer1->signer->auths = ["api"];
  $signer1->signer->name = "Gilberto e.";
  // $signer1->signer->delivery = "none";
  $signer1Body = json_encode($signer1, JSON_UNESCAPED_SLASHES);


  // URL da API
  $url = "https://$env.clicksign.com/api/v1/signers?access_token=$access_token";

  // Inicializar uma sessão cURL
  $ch = curl_init();

  // Configurar a URL e outras opções
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
  ));
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $signer1Body);

  // Executar a requisição cURL
  $outputAddSignature1 = curl_exec($ch);

  // Verificar por erros
  if (curl_errno($ch)) {
    echo 'Erro ao realizar a requisição cURL: ' . curl_error($ch);
  }

  // Fechar a sessão cURL
  curl_close($ch);

  // Analisar a resposta JSON
  $signer1_retrieved_output = json_decode($outputAddSignature1, true);

  // Extrair a chave do signatário
  $signer1_retrieved = $signer1_retrieved_output["signer"]["key"];
  // var_dump($signer1_retrieved_output);
  // echo "update assinante set clicksign_key = '$signer1_retrieved'";
  // $sql = "update assinante set clicksign_key = $signer1_retrieved";
  $query = mysqli_query($con, "update assinante set clicksign_key = '$signer1_retrieved'");
  // echo " >>>>> ASSINANTE UPDATED >>>>>>".$query;
  // $stmt = prepared_query($con, $sql, [$signer1_retrieved], 's');
  $retrieve = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
}


// add signer 1 to  _key
$addListSigner1 = (object) null;
$addListSigner1->list = (object) array("document_key" => $document_key);
$addListSigner1->list->signer_key = $signer1_retrieved;
$addListSigner1->list->sign_as = "party";
$addListSigner1->list->message = "Por favor, assine o documento.";
$addListSigner1->list->name = "Gilberto E.";
$addListBody = json_encode($addListSigner1, JSON_UNESCAPED_SLASHES);
// echo "WE ARE HERE AFTER ALLL >>>>";
// Configuração das opções cURL
$ch = curl_init();
curl_setopt_array($ch, [
  CURLOPT_URL => "https://$env.clicksign.com/api/v1/lists?access_token=$access_token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => $addListBody,
  CURLOPT_HTTPHEADER => [
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
  ]
]);

// Executa a solicitação cURL e obtém a resposta
$outputSigner1 = curl_exec($ch);

// Verifica por erros
if ($outputSigner1 === false) {
  echo 'Erro cURL: ' . curl_error($ch);
}

// Fecha a sessão cURL
curl_close($ch);

// Decodifica a resposta JSON
$signer1_added = json_decode($outputSigner1, true);


$sql = "SELECT fornecedores.representante as representante,fornecedores.cpf as cpf, fornecedores.representante as nome, fornecedores.updated as updated, fornecedores.razao as razao, fornecedores.email as email,  antec.valor as valor, antec.dataOPE as data_oper, fornecedores.clicksign_key as clicksign_key, fornecedores.cnpj as cnpj, antec.id as id FROM operacoes antec inner join fornecedores on fornecedores.cnpj = antec.cnpj  WHERE antec.id = ?";

$stmt = prepared_query($con, $sql, [$id_operacao], 'i');
$fornecedor = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$fornec_cnpj = $fornecedor[0]['cnpj'];
$signer2_retrieved = $fornecedor[0]["clicksign_key"];


if (is_null($signer2_retrieved) || $signer2_retrieved == '' || $fornecedor[0]['updated'] == 1) {
  if (is_null($fornecedor[0]["email"])) {
    echo json_encode('{}');
    die();
  }

  $signer2 = (object) null;
  $signer2->signer = (object) array("email" => $fornecedor[0]["email"]);
  // $signer2->signer = (object) array("email" => "mrlobulo@gmail.com");
  $nome = explode(" ", $fornecedor[0]["razao"]);
  $signer2->signer->name = $fornecedor[0]["razao"];
  $signer2->signer->auths = array("icp_brasil");
  $signer2->signer->name = $fornecedor[0]["nome"];
  // $signer2->signer->has_documentation = false;   
  $signer2->signer->selfie_enabled = false;
  $signer2->signer->handwritten_enabled = false;
  $signer2->signer->liveness_enabled = false;
  $signer2->signer->facial_biometrics_enabled = false;
  $signer2->signer->documentation = $fornecedor[0]["cpf"];

  // $signer2->signer->delivery = "none";


  // Encode os dados do signatário em JSON
  $signer2Body = json_encode($signer2, JSON_UNESCAPED_SLASHES);

  // Configuração das opções cURL
  $ch = curl_init();
  curl_setopt_array($ch, [
    CURLOPT_URL => "https://$env.clicksign.com/api/v1/signers?access_token=$access_token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $signer2Body,
    CURLOPT_HTTPHEADER => [
      'Accept: application/json',
      'Content-Type: application/json',
      "Host: $env.clicksign.com"
    ]
  ]);

  // Executa a solicitação cURL e obtém a resposta
  $outputAddSignature2 = curl_exec($ch);

  // Verifica por erros
  if ($outputAddSignature2 === false) {
    echo 'Erro cURL: ' . curl_error($ch);
  }

  // Fecha a sessão cURL
  curl_close($ch);

  // Decodifica a resposta JSON
  $signer2_retrieved_output = json_decode($outputAddSignature2, true);

  if (isset($signer2_retrieved_output['errors'])) {
    // echo  "ERROR>>>>".$signer2_retrieved_output['errors'];
    $error = $signer2_retrieved_output['errors'][0];
    echo json_encode("{ erro : $error }");
    die();
  }
  $signer2_retrieved = $signer2_retrieved_output["signer"]["key"];
  $sql = "update fornecedores set clicksign_key = '$signer2_retrieved', updated = 0 where fornecedores.cnpj = $fornec_cnpj";
  // echo "UPDATING FORNECEDOR >>>>>>>>".$sql;
  $query = mysqli_query($con, $sql);
  // $stmt = prepared_query($con, $sql, [$signer2_retrieved, $fornecedor[0]["cnpj"]], 'si');
  // echo "UPDAERT IS".$query;
  // $retrieve = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  // $stmt->close(); 
}

// add signer 2 to document_key
$addListSigner2 = (object) null;
$addListSigner2->list = (object) array("document_key" => $document_key);
$addListSigner2->list->signer_key = $signer2_retrieved;
$addListSigner2->list->sign_as = "party";
$addListSigner2->list->message = "Por favor, assine o documento.";
// $addListSigner2->list->name = "Allan Felipe Murara";
$addListBody2 = json_encode($addListSigner2, JSON_UNESCAPED_SLASHES);

// Configuração das opções cURL
$ch = curl_init();
curl_setopt_array($ch, [
  CURLOPT_URL => "https://$env.clicksign.com/api/v1/lists?access_token=$access_token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => $addListBody2,
  CURLOPT_HTTPHEADER => [
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
  ]
]);

// Executa a solicitação cURL e obtém a resposta
$outputSigner2 = curl_exec($ch);

// Verifica por erros
if ($outputSigner2 === false) {
  echo 'Erro cURL: ' . curl_error($ch);
}

// Fecha a sessão cURL
curl_close($ch);

// Decodifica a resposta JSON
$signer2_added = json_decode($outputSigner2, true);
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

  $ch = curl_init();
  curl_setopt_array($ch, [
    CURLOPT_URL => "https://$env.clicksign.com/api/v1/notifications?access_token=$access_token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $request_signature_body,
    CURLOPT_HTTPHEADER => [
      'Accept: application/json',
      'Content-Type: application/json',
      "Host: $env.clicksign.com"
    ]
  ]);

  // Executa a solicitação cURL e obtém a resposta
  $requestedSignature = curl_exec($ch);

  // Verifica por erros
  if ($requestedSignature === false) {
    echo 'Erro cURL: ' . curl_error($ch);
  }

  // Fecha a sessão cURL
  curl_close($ch);

  // Resposta JSON vazia
  echo json_encode([]);

  // require_once('/home/lawsmart/send_mail.php');
  $fornecedor[0]['clicksign_key'] = $document_key;
  $fornecedor[0]["fornecedor"] = $fornecedor[0]["razao"];

  $ANCORA =  "Agricopel"; // $fornecedor[0]["representante"];
  // $sql = "SELECT distinct *, postergacoesDetalhes.valor as valor_antecip, postergacoesDetalhes.juros as juros_posterg, operacoes.vencimento, ( select vencimento from operacoes where operacoes.id = postergacoesDetalhes.id_postergada ) as vencimento_velho
  // FROM postergacoesDetalhes
  // inner join boletos on boletos.operacao = postergacoesDetalhes.id_operacao
  // inner join operacoes on operacoes.id = postergacoesDetalhes.id_operacao
  // inner join fornecedores on fornecedores.cnpj = operacoes.cnpj
  // WHERE postergacoesDetalhes.id_postergacao = '{$id_operacao}' 
  //   or postergacoesDetalhes.id_operacao in ({$id_operacao})
  // group by postergacoesDetalhes.id_operacao";
  $sql = "SELECT  postergacoesDetalhes.id_postergacao, postergacoesDetalhes.id_operacao,
               postergacoesDetalhes.valorOriginal AS valorOriginal,
               postergacoesDetalhes.valor AS valor_antecip,
               postergacoesDetalhes.juros AS juros_posterg,
               postergacoesDetalhes.taxas AS taxas_posterg,
               operacoes.vencimento,
               (SELECT vencimento FROM operacoes WHERE operacoes.id = postergacoesDetalhes.id_postergada) AS vencimento_velho,
               boletos.*, operacoes.*, fornecedores.*
        FROM postergacoesDetalhes
        INNER JOIN boletos ON boletos.operacao = postergacoesDetalhes.id_operacao
        INNER JOIN operacoes ON operacoes.id = postergacoesDetalhes.id_operacao
        INNER JOIN fornecedores ON fornecedores.cnpj = operacoes.cnpj
        WHERE postergacoesDetalhes.id_postergacao = '{$id_operacao}' OR
              postergacoesDetalhes.id_operacao IN ({$id_operacao})
        GROUP BY  postergacoesDetalhes.id_postergacao, postergacoesDetalhes.id_operacao, 
                 postergacoesDetalhes.valor, 
                 postergacoesDetalhes.valorOriginal, 
                 postergacoesDetalhes.juros, 
                 postergacoesDetalhes.taxas,
                 operacoes.vencimento, 
                 vencimento_velho,
                 boletos.id, 
                 operacoes.id, 
                 fornecedores.id";


  $posterg_query = mysqli_query($con, $sql);
  $posterg = mysqli_fetch_all($posterg_query, MYSQLI_ASSOC);
  $NUMERO_OPERACAO_VENDOR =  '000' . $posterg[0]['id_postergacao'];
  $destinatario = $fornecedor[0]["email"];
  $VAR_NOME = $fornecedor[0]["razao"];



  $clicksign_key = $fornecedor[0]['clicksign_key'];
  $sign_url = '';
  $access_token = 'adf1d531-65de-4213-b0f7-947443bfd863';
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
  } else {
    // Handle HTTP request failure
    $LINK  =  '';
  }

  $msg = 'postergacao_criada';
  $assunto = 'POSTERGAÇÃO';
  $RESUMO = $posterg;
  $EmailSender = new EmailSender();
  $EmailSender->Email_operacao_concluida_Postergacao($destinatario, $VAR_NOME, $RESUMO, $LINK);
  // $EmailSender->send_postergacao_criada_mail($destinatario, $msg, $assunto, $posterg);

  $DATA_OPERACAO = date('d/m/Y', strtotime($fornecedor[0]['data_oper']));




  // $EmailSender1 = new EmailSender();
  // $EmailSender1->Email_Pedido_de_assinatura_cliente($destinatario, $VAR_NOME, $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO, $ANCORA, $LINK);
  // Carregue o conteúdo do arquivo HTML
  $templatePath = '/home/law/public_html/agricopel/Class/clientes/assinatura.html';

  $template = file_get_contents($templatePath);
  $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
  $template = str_replace('{NUMERO_OPERACAO_VENDOR}', $NUMERO_OPERACAO_VENDOR, $template);
  $template = str_replace('{DATA_OPERACAO}', $DATA_OPERACAO, $template);
  $template = str_replace('{ANCORA}', $ANCORA, $template);
  $template = str_replace('{LINK}', $LINK, $template);

  $this->mail->isHTML(true);
  $this->mail->Body = $template;
  // Enviar e-mail
  $this->mail->send();

  $email = new emails_assinatura();
  $email->setRecipient_email($destinatario);
  $email->setSubject('Faça sua Assinatura');
  $email->setBody($template);
  $email->setStatus('pendente');
  $email->setType('Assinatura');
  $email->setCreated_at(date('Y-m-d H:i:s'));
  $email->setData_sendto(date('Y-m-d H:i:s', strtotime('+1 hour')));
  $email->setSent_at(null);
  $email->Insert();

  // dispatch_event_mail('postergacao_criada', $fornecedor[0]["email"], $fornecedor[0]["razao"], $fornecedor[0], $posterg);
  // send_mail('jme.jose.max@gmail.com', 'José', 'postergacao_criada', $sql);
}

$sql = "SELECT secret_signerkey FROM assinante where 1 = 1";
$stmt = prepared_query($con, $sql, [], '');
$retrieve = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$secret_signerkey = $retrieve[0]["secret_signerkey"];
$hmac_secret = hash_hmac('sha256', $signer1_added["list"]["request_signature_key"], $secret_signerkey);

$signBody = (object) null;
$signBody->request_signature_key = $signer1_added["list"]["request_signature_key"];
$signBody->secret_hmac_sha256 = $hmac_secret;

$signData = json_encode($signBody);

// Configuração das opções cURL
$ch = curl_init();
curl_setopt_array($ch, [
  CURLOPT_URL => "https://$env.clicksign.com/api/v1/sign?access_token=$access_token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => $signData,
  CURLOPT_HTTPHEADER => [
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
  ]
]);

// Executa a solicitação cURL e obtém a resposta
$outputTryToSign = curl_exec($ch);

// Verifica por erros
if ($outputTryToSign === false) {
  echo 'Erro cURL: ' . curl_error($ch);
}

// Fecha a sessão cURL
curl_close($ch);

// echo $arq;
// $signers = "{\"email\":\"gilberto@lawsecsa.com.br\",\"action\":\"SIGN\"},{\"email\":\"$email\",\"action\":\"SIGN\"}";
// $query = "\"query\": \"mutation CreateDocumentMutation(\$document: DocumentInput!, \$signers: [SignerInput!]!, \$file: Upload!) { createDocument(app: false, document: \$document, signers: \$signers, file: \$file) { id name refusable sortable created_at signatures { public_id name email created_at action { name } link { short_link } user { id name email }}}}\"";
// $variables = "\"variables\":{\"document\":{\"name\":\"Contrato Antecipação $ant\", \"qualified\":true},\"signers\":[$signers], \"file\": null }";
// $map = "{ \"0\": [\"variables.file\"] }";
// $file = "0=@$arq";
// exec("curl https://api.autentique.com.br/v2/graphql -H 'Connection: keep-alive' -H 'Authorization: Bearer 4ca37a7d5880040736b507e3c71ecf4b128a2c16be59a2c289f41278c7edae8d' -F operations='{ $query, $variables }' -F map='$map' -F $file --compressed 2>&1", $output);
// echo json_encode($output);
