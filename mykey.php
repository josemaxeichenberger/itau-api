<?php
// session_start();
// if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'fornecedor') {
//   header("Location: pagina_de_acesso_nao_autorizado.php");
//   exit();
// }
function idAntecipacao($str)
{
  $s1 = explode('_', $str);
  $s2 = explode('.', $s1[2]);

  return $s2[0];
}

require_once('Class/Config.php');
require_once('Class/EmailSender.class.php');
require_once('Class/emails_assinatura.class.php');
$con = new mysqli(DB_HOUST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($con, 'utf8');


function prepared_query($mysqli, $sql, $params, $types = "")
{

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


// chave certsign
$access_token = '7e92bc9f-bcc4-4eea-be40-5ba90020777a';
$env = 'app';







$sql = "SELECT clicksign_key FROM assinante where 1 = 1";
$stmt = prepared_query($con, $sql, [], '');
$retrieve = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

 $signer1_retrieved = $retrieve[0]["clicksign_key"];
echo "RETREIVED THEN THE FIRST SIGNER >>>".var_dump($signer1_retrieved);
if (is_null($signer1_retrieved)) {
  $signer1 = (object) null;
  $signer1->signer = (object) array("email" => "cinque@lawsmart.com.br");
  $signer1->signer->auths = ["api"];
  $signer1->signer->delivery = "none";
  $signer1->signer->has_documentation = false;
  $signer1->signer->name = "MOACIR LUIZ FACHINI";
  $signer1Body = json_encode($signer1, JSON_UNESCAPED_SLASHES);

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
echo "RETREIVED THEN THE FIRST SIGNER >>>".var_dump($signer1_retrieved);
  $query = mysqli_query($con, "update assinante set clicksign_key = '$signer1_retrieved'");
}
// echo 1;
