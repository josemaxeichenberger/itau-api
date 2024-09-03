<?php

function idAntecipacao($str)
{
  $s1 = explode('_', $str);
  $s2 = explode('.', $s1[2]);

  return $s2[0];
}

require_once('../Class/Config.php');
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

$url = "https://$env.clicksign.com/api/v1/documents?access_token=$access_token";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Accept: application/json',
  'Content-Type: application/json',
  "Host: $env.clicksign.com"
));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);

$response = curl_exec($ch);

if (curl_errno($ch)) {
  echo 'Curl error: ' . curl_error($ch);
}

curl_close($ch);

$phpObj = json_decode($response, true);
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
  $signer1->signer = (object) array("email" => $emailEmpresa);
  $signer1->signer->auths = ["api"];
  $signer1->signer->name = "Gilberto e.";
  $signer1Body = json_encode($signer1, JSON_UNESCAPED_SLASHES);

  $url = "https://$env.clicksign.com/api/v1/signers?access_token=$access_token";

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
  ));
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $signer1Body);

  $outputAddSignature1 = array();
  exec("curl 'https://$env.clicksign.com/api/v1/signers?access_token=$access_token' \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --header 'Host: $env.clicksign.com' \
  -d '$signer1Body'", $outputAddSignature1);
  $signer1_retrieved_output = json_decode($outputAddSignature1[0], true);
  $signer1_retrieved = $signer1_retrieved_output["signer"]["key"];
  $query = mysqli_query($con, "update assinante set clicksign_key = '$signer1_retrieved'");
}
// echo 1;
// add signer 1 to document_key
$addListSigner1 = (object) null;
$addListSigner1->list = (object) array("document_key" => $document_key);
$addListSigner1->list->signer_key = $signer1_retrieved;
$addListSigner1->list->sign_as = "party";
$addListSigner1->list->message = "Por favor, assine o documento.";
$addListSigner1->list->name = "Gilberto E.";
$addListBody = json_encode($addListSigner1, JSON_UNESCAPED_SLASHES);

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
curl_close($ch);

// // adiciona a primeira acinatuda a do cliente
// $addListSigner1 = (object) null;
// $addListSigner1->list = (object) array("document_key" => $document_key);
// $addListSigner1->list->signer_key = $signer1_retrieved;
// $addListSigner1->list->sign_as = "party";
// $addListSigner1->list->message = "Por favor, assine o documento.";
// $addListSigner1->list->name = "Gilberto E.";
// $addListBody = json_encode($addListSigner1, JSON_UNESCAPED_SLASHES);

// $url = "https://$env.clicksign.com/api/v1/lists?access_token=$access_token";

// $ch = curl_init($url);

// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//   'Accept: application/json',
//   'Content-Type: application/json',
//   "Host: $env.clicksign.com"
// ));
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $addListBody);

// $outputSigner1 = array();
// $url = "https://$env.clicksign.com/api/v1/lists?access_token=$access_token";

// $ch = curl_init($url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//   'Accept: application/json',
//   'Content-Type: application/json',
//   "Host: $env.clicksign.com",
// ]);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $addListBody);

// $outputSigner1 = curl_exec($ch);

// if ($outputSigner1 === false) {
//   echo 'Curl error: ' . curl_error($ch);
// } else {
//   $signer1_added = json_decode($outputSigner1, true);
//   // Handle $signer1_added as needed
// }

// curl_close($ch);



// return;
$sql = "SELECT fornecedores.cpf as cpf, fornecedores.representante as nome, fornecedores.updated as updated, fornecedores.razao as razao, fornecedores.email as email,  antec.valor as valor, antec.dataOPE as data_oper, fornecedores.clicksign_key as clicksign_key, fornecedores.cnpj as cnpj, antec.id as id FROM operacoes antec inner join fornecedores on fornecedores.cnpj = antec.cnpj  WHERE antec.id = ?";
// echo $sql;
$stmt = prepared_query($con, $sql, [$id_operacao], 'i');
$fornecedor = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$fornec_cnpj = $fornecedor[0]['cnpj'];
$signer2_retrieved = $fornecedor[0]["clicksign_key"];
// echo "SGINER 2 RETRIEVEE".$signer2_retrieved;
if (is_null($signer2_retrieved) ) {
  if (is_null($fornecedor[0]["email"])) {
    echo json_encode('{}');
    die();
  }
  $emailFornecedor = $fornecedor[0]["email"];
  $razaoSocialFornecedor = $fornecedor[0]["razao"];
  $cpfFornecedor = $fornecedor[0]["cpf"];
  $nomeFornecedor = $fornecedor[0]["nome"];

  $signer2 = (object) null;
  $signer2->signer = (object) array("email" => $emailFornecedor);
  $nome = explode(" ", $razaoSocialFornecedor);
  $signer2->signer->name = preg_replace("/\d+/", "", $nome[0] . " " . $nome[1]);
  $signer2->signer->auths = array("icp_brasil");
  // $signer2->signer->name = $nomeFornecedor;
  $signer2->signer->selfie_enabled = false;
  $signer2->signer->handwritten_enabled = false;
  $signer2->signer->liveness_enabled = false;
  $signer2->signer->facial_biometrics_enabled = false;
  $signer2->signer->documentation = $cpfFornecedor;
  $signer2Body = json_encode($signer2, JSON_UNESCAPED_SLASHES);

  $url = "https://$env.clicksign.com/api/v1/signers?access_token=$access_token";

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
  ));
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $signer2Body);

  $outputAddSignature2 = array();
  $url = "https://$env.clicksign.com/api/v1/signers?access_token=$access_token";

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com",
  ]);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $signer2Body);

  $outputAddSignature2 = curl_exec($ch);

  if ($outputAddSignature2 === false) {
    echo 'Curl error: ' . curl_error($ch);
  } else {
    $signer2_retrieved_output = json_decode($outputAddSignature2, true);
    // Handle $signer2_retrieved_output as needed
  }

  curl_close($ch);

  if (isset($signer2_retrieved_output['errors'])) {
    $error = $signer2_retrieved_output['errors'][0];
    echo json_encode("{ erro : $error }");
    die();
  }
  $signer2_retrieved = $signer2_retrieved_output["signer"]["key"];
  $sql = "update fornecedores set clicksign_key = '$signer2_retrieved', updated = 0 where fornecedores.cnpj = $fornec_cnpj";
  $query = mysqli_query($con, $sql);
}

// add signer 2 to document_key
$addListSigner2 = (object) null;
$addListSigner2->list = (object) array("document_key" => $document_key);
$addListSigner2->list->signer_key = $signer2_retrieved;
$addListSigner2->list->sign_as = "party";
$addListSigner2->list->message = "Por favor, assine o documento.";
$addListBody2 = json_encode($addListSigner2, JSON_UNESCAPED_SLASHES);

$url = "https://$env.clicksign.com/api/v1/lists?access_token=$access_token";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Accept: application/json',
  'Content-Type: application/json',
  "Host: $env.clicksign.com"
));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $addListBody2);
curl_close($ch);
$outputSigner2 = array();

$url = "https://$env.clicksign.com/api/v1/lists?access_token=$access_token";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Accept: application/json',
  'Content-Type: application/json',
  "Host: $env.clicksign.com",
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $addListBody2);

$outputSigner2 = curl_exec($ch);

if ($outputSigner2 === false) {
  echo 'Curl error: ' . curl_error($ch);
} else {
  $signer2_added = json_decode($outputSigner2, true);
  // Handle $signer2_added as needed
}

curl_close($ch);

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
  $url = "https://$env.clicksign.com/api/v1/notifications?access_token=$access_token";

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request_signature_body);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'Content-Type: application/json',
    "Host: $env.clicksign.com"
  ));

  $requestedSignature = curl_exec($ch);


  curl_close($ch);
  echo json_encode([]);
  // require_once('/home/lawsmart/send_mail.php');
  $fornecedor[0]['clicksign_key'] = $document_key;
  $fornecedor[0]["fornecedor"] = $fornecedor[0]["razao"];
  $sql = "SELECT pd.id_operacao, pd.valor AS valor_antecip, pd.juros AS juros_posterg, o.vencimento, (SELECT vencimento FROM operacoes WHERE operacoes.id = pd.id_postergada) AS vencimento_velho, b.id, b.cnpj, b.vencimento AS vencimento_boleto, b.valor, b.operacao, b.documento, b.nosso_numero, b.nosso_numero_banco, b.nosso_numero_dac, b.emissao, b.registro, b.ocorrencia, b.data_ocorrencia, b.data_registro, b.remessa, b.retorno, b.tarifa, b.iof, b.abatimento, b.descontos, b.mora_multa, b.creditado, b.outros_creditos, b.cod_liquidacao, b.mensagem, b.status FROM postergacoesDetalhes pd INNER JOIN boletos b ON b.operacao = pd.id_operacao INNER JOIN operacoes o ON o.id = pd.id_operacao INNER JOIN fornecedores f ON f.cnpj = o.cnpj WHERE pd.id_postergacao = $id_operacao OR pd.id_operacao IN ($id_operacao)";
  // return;
  // $stmt = prepared_query($con, $sql, [$id_operacao, $id_operacao], 'si');
  // $posterg_query = mysqli_query($con, $sql);
  // $posterg = mysqli_fetch_all($posterg_query, MYSQLI_ASSOC);
  // 
  // dispatch_event_mail('postergacao_criada', $fornecedor[0]["email"], $fornecedor[0]["razao"], $fornecedor[0], $posterg);

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

$url = "https://$env.clicksign.com/api/v1/sign?access_token=$access_token";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $signData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Accept: application/json',
  'Content-Type: application/json',
  "Host: $env.clicksign.com"
));

$outputTryToSign = array();



curl_close($ch);

// echo $arq;
// $signers = "{\"email\":\"gilberto@lawsecsa.com.br\",\"action\":\"SIGN\"},{\"email\":\"$email\",\"action\":\"SIGN\"}";
// $query = "\"query\": \"mutation CreateDocumentMutation(\$document: DocumentInput!, \$signers: [SignerInput!]!, \$file: Upload!) { createDocument(app: false, document: \$document, signers: \$signers, file: \$file) { id name refusable sortable created_at signatures { public_id name email created_at action { name } link { short_link } user { id name email }}}}\"";
// $variables = "\"variables\":{\"document\":{\"name\":\"Contrato Antecipação $ant\", \"qualified\":true},\"signers\":[$signers], \"file\": null }";
// $map = "{ \"0\": [\"variables.file\"] }";
// $file = "0=@$arq";
// exec("curl https://api.autentique.com.br/v2/graphql -H 'Connection: keep-alive' -H 'Authorization: Bearer 4ca37a7d5880040736b507e3c71ecf4b128a2c16be59a2c289f41278c7edae8d' -F operations='{ $query, $variables }' -F map='$map' -F $file --compressed 2>&1", $output);
// echo json_encode($output);
