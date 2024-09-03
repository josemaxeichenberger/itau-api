<?php
session_start();
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'fornecedor') {
    header("Location: pagina_de_acesso_nao_autorizado.php");
    exit();
}

function idAntecipacao($str) {
    $s1 = explode('_', $str);
    $s2 = explode('.', $s1[2]);
  
    return $s2[0];
}

$dados = json_decode(file_get_contents('php://input'), true);
$arq = $dados['arquivo'];
$ant = idAntecipacao($arq);
$email = $dados['emailEmpresa'];

$signers = "{\"email\":\"gilberto@lawsecsa.com.br\",\"action\":\"SIGN\"},{\"email\":\"$email\",\"action\":\"SIGN\"}";
$query = "\"query\": \"mutation CreateDocumentMutation(\$document: DocumentInput!, \$signers: [SignerInput!]!, \$file: Upload!) { createDocument(sandbox: false, document: \$document, signers: \$signers, file: \$file) { id name refusable sortable created_at signatures { public_id name email created_at action { name } link { short_link } user { id name email }}}}\"";
$variables = "\"variables\":{\"document\":{\"name\":\"Contrato Antecipação $ant\", \"qualified\":true},\"signers\":[$signers], \"file\": null }";
$map = "{ \"0\": [\"variables.file\"] }";
$file = "0=@" . realpath($arq); // Use realpath para obtener la ruta completa del archivo

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.autentique.com.br/v2/graphql");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Connection: keep-alive',
    'Authorization: Bearer 4ca37a7d5880040736b507e3c71ecf4b128a2c16be59a2c289f41278c7edae8d',
));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
    'operations' => "{ $query, $variables }",
    'map' => $map,
    $file
));
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$output = curl_exec($ch);
curl_close($ch);

echo json_encode($output);
?>
