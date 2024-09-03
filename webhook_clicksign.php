<?php

// Ativa o relatório de todos os erros
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('log_errors', 1);
ini_set('error_log', 'arquivo_de_log.log'); // Ajuste o caminho conforme necessário
require_once('Class/Config.php');
require_once('Class/instalacoes.class.php');
require_once('Class/emails.class.php');
$dominio = DOMINIO;
$instalacoes = new instalacoes();
$instalacoes->setDominio1($dominio);
$ANCORA = $instalacoes->VeificaDominio1();

$headers = apache_request_headers();
$body = file_get_contents('php://input');
$dados = json_decode($body, true);
// Decodifica o corpo JSON para um array associativo
$dadosCompletos = array(
  'headers' => $headers,
  'body' => $dados
);

// Converte o array para formato JSON
$jsonData = json_encode($dadosCompletos, JSON_PRETTY_PRINT);

// Nome do arquivo (ajuste o caminho conforme necessário)
$nomeArquivo = 'dados_requisicao.json';

// Verifica se o arquivo já existe
if (!file_exists($nomeArquivo)) {
  // Cria o arquivo se ele não existir
  $arquivo = fopen($nomeArquivo, 'w') or die('Não foi possível criar o arquivo');
  fclose($arquivo);
}
// Tenta salvar os dados no arquivo
if (file_put_contents($nomeArquivo, $jsonData)) {
  echo 'Dados salvos com sucesso em ' . $nomeArquivo;
} else {
  echo 'Erro ao salvar os dados.';
}

if ($headers["Content-Hmac"] == "sha256=" . hash_hmac('sha256', $body, $ANCORA['webhook_HMAC_SHA256_Secret'])) {

  $key = $dados["document"]["key"];
  file_put_contents("arquivo_de_log.log", $key, FILE_APPEND);
  // require_once('/home/lawsmart/public_html/send_mail.php');
  require_once('Class/Config.php');
  require_once('Class/EmailSender.class.php');

  $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


  mysqli_query($con, "update operacoes set status = 5 where clicksign_key = '$key'");


  $sql = "SELECT * FROM `operacoes` WHERE `clicksign_key` = '$key' ";

  $res  =  mysqli_fetch_assoc(mysqli_query($con, $sql));
  file_put_contents("arquivo_de_log.log", $res['tipo'], FILE_APPEND);

  if ($res['tipo'] == 'fornecedor') {
    //antecipação
    file_put_contents("arquivo_de_log.log", $res['tipo'], FILE_APPEND);
    $operacao_id = $res['id'];
    $cnpj = $res['cnpj'];
    $sql = "SELECT * FROM `antecipadasDetalhes` WHERE `operacao` = '{$operacao_id}'";
    $result  =  mysqli_fetch_assoc(mysqli_query($con, $sql));
    $antecipada = $result['antecipada'];
    $DATA_OPERACAO = $result['data'];
    $sql = "SELECT MAX(antecipada), SUM(valor) AS valor, MAX(data) AS ultima_data
    FROM `antecipadasDetalhes`
    WHERE `antecipada` =    '{$antecipada}'";

    $antecipadas  =  mysqli_fetch_assoc(mysqli_query($con, $sql));
    $sql2 = "SELECT * FROM `antecipadas` WHERE `id` = '{$antecipada}'";
    $antecipadaT  =  mysqli_fetch_assoc(mysqli_query($con, $sql2));

    file_put_contents("arquivo_de_log.log", $antecipadas, FILE_APPEND);
    $dest_address =  $ANCORA['email_resgiter'];

    $sql = "SELECT * FROM `fornecedores` WHERE `cnpj` = '{$cnpj}'";
    $fornecedor  =  mysqli_fetch_assoc(mysqli_query($con, $sql));
    $VAR_NOME = $fornecedor['razao'];
    $dest_address2 = $fornecedor['email'];
    $VALOR_LIQUIDO_OPERACAO   =   number_format($antecipadaT['valorOriginal'], 2, ",", ".");
    $NUMERO_OPERACAO_VENDOR = $antecipada;
    $DATA_OPERACAO = $result['data'];
    // $EmailSender = new EmailSender();
    $TIPO_PERACAO = ' Antecipação ';
    // $x =  $EmailSender->Email_SinaturasOk($dest_address, $VAR_NOME, $VALOR_LIQUIDO_OPERACAO,  $NUMERO_OPERACAO_VENDOR, $TIPO_PERACAO);

    // $x = $EmailSender->Email_SinaturasOk($dest_address2, $VAR_NOME, $VALOR_LIQUIDO_OPERACAO,  $NUMERO_OPERACAO_VENDOR, $TIPO_PERACAO);

    //Assunto
    $Subject = 'Assinaturas efetuadas de ambas as partes, proseguir com o processo!';
    // Carregue o conteúdo do arquivo HTML
    $template = file_get_contents('Class/fornecedores/assinatura-ok.html');
    $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
    $template = str_replace('{NUMERO_OPERACAO_VENDOR}', $NUMERO_OPERACAO_VENDOR, $template);
    $template = str_replace('{TIPO_PERACAO}', $TIPO_PERACAO, $template);
    $template = str_replace('{VALOR_LIQUIDO_OPERACAO}', $VALOR_LIQUIDO_OPERACAO, $template);



    $email = new emails();
    $email->setRecipient_email($dest_address);
    $email->setSubject($Subject);
    $email->setBody($template);
    $email->setStatus('pendente');
    $email->setType('notification');
    $email->setCreated_at(date('Y-m-d H:i:s'));
    $email->setSent_at(null);
    $email->Insert();

    $email = new emails();
    $email->setRecipient_email($dest_address2);
    $email->setSubject($Subject);
    $email->setBody($template);
    $email->setStatus('pendente');
    $email->setType('notification');
    $email->setCreated_at(date('Y-m-d H:i:s'));
    $email->setSent_at(null);
    $email->Insert();







    $logContent = date("Y-m-d H:i:s") . " - Resultado para antecipada: " . var_export($antecipada, true) . PHP_EOL;
    file_put_contents("arquivo_de_log.log", $logContent, FILE_APPEND);
    $logContent = date("Y-m-d H:i:s") . " - Resultado para CNPJ: " . var_export($cnpj, true) . PHP_EOL;
    file_put_contents("arquivo_de_log.log", $logContent, FILE_APPEND);
  }

  if ($res['tipo'] == 'cliente') {
    //postergação
    $operacao_id = $res['id'];
    $cnpj = $res['cnpj'];
    $sql = "SELECT * FROM `postergacoesDetalhes` WHERE `id_operacao` = '{$operacao_id}'";
    $result  =  mysqli_fetch_assoc(mysqli_query($con, $sql));
    $id_postergacao = $result['id_postergacao'];

    $sql = "SELECT * FROM `postergacoes` WHERE `id` = '{$id_postergacao}'";
    $postergacoes  =  mysqli_fetch_assoc(mysqli_query($con, $sql));

    // $DATA_OPERACAO =  $postergacoes['data'];
    // $sql = "SELECT id_postergacao,SUM(valor) AS valor  FROM `postergacoesDetalhes` WHERE `id_postergacao`=    '{$id_postergacao}'";
    // $antecipadas  =  mysqli_fetch_assoc(mysqli_query($con, $sql));

    $dest_address = 'fixtech@lawsmart.com.br';
    $dest_address2 = 'gilberto@lawfinancas.com.br';
    $sql = "SELECT * FROM `fornecedores` WHERE `cnpj` = '{$cnpj}'";
    $fornecedor  =  mysqli_fetch_assoc(mysqli_query($con, $sql));
    $VAR_NOME = $fornecedor['razao'];
    $VALOR_LIQUIDO_OPERACAO   = $postergacoes['valor'];
    $NUMERO_OPERACAO_VENDOR  = $id_postergacao;
    $EmailSender = new EmailSender();
    $TIPO_PERACAO = ' Postergação ';
    $x =  $EmailSender->Email_SinaturasOk($dest_address, $VAR_NOME, $VALOR_LIQUIDO_OPERACAO,  $NUMERO_OPERACAO_VENDOR, $TIPO_PERACAO);
    $TIPO_PERACAO = ' Postergação ';
    $x =  $EmailSender->Email_SinaturasOk($dest_address2, $VAR_NOME, $VALOR_LIQUIDO_OPERACAO,  $NUMERO_OPERACAO_VENDOR, $TIPO_PERACAO);

    $logContent = date("Y-m-d H:i:s") . " - Resultado para cnpj: " . var_export($cnpj, true) . PHP_EOL;
    // Salvando no arquivo de log
    file_put_contents("arquivo_de_log.log", $logContent, FILE_APPEND);
  }






  // $operacao_query = mysqli_query($con, "SELECT *, id_postergacao as id, fornecedores.razao as fornecedor, dataOPE as data_oper FROM `postergacoesDetalhes`
  //   inner join operacoes on operacoes.id = postergacoesDetalhes.id_operacao
  //   inner join fornecedores on operacoes.cnpj = fornecedores.cnpj
  //   where operacoes.clicksign_key = '$key'");
  // $operacao = mysqli_fetch_all($operacao_query, MYSQLI_ASSOC);
  // $destinatario = $fornecedor[0]["email"];
  // $msg = $sql;
  // $assunto = 'Antecipação Criada';

  // $data = date('d/m/Y',strtotime($fornecedor[0]['data_oper']));
  // $dest_name = $fornecedor[0]["razao"];

  // $EmailSender = new EmailSender();
  // $EmailSender->send_pagamento_mail($destinatario, $dest_name, $key,$data);
  // dispatch_event_mail('postergacao_paga', $operacao[0]['email'], $operacao[0]["razao"], $operacao[0]);

  http_response_code(200);

  return true;
} else {
  // $headers = var_dump($headers);
  // die($headers);
  error_log("FALSE TOKEN");
  http_response_code(201);
}







//   $doc_id = $dados["document"]["key"];
