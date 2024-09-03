<?php
require_once('Class/EmailSender.class.php');

$destinatario = 'jme.jose.max@gmail.com';
$msg = 'postergacao_criada';
$assunto = 'POSTERGAÇÃO';
$EmailSender = new EmailSender();
$res =  $EmailSender->enviarEmailSimples($destinatario, $msg, $assunto);
// dispatch_event_mail('postergacao_criada', $fornecedor[0]["email"], $fornecedor[0]["razao"], $fornecedor[0], $posterg);
// send_mail('jme.jose.max@gmail.com', 'José', 'postergacao_criada', 'Teste');
echo $res;