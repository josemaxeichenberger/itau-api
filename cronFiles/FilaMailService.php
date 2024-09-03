<?php

function my_autoload($pClassName)
{
    include('../Class' . "/" . $pClassName . ".class.php");
}

spl_autoload_register("my_autoload"); // Carrega as classes 
require_once('../Class/Config.php');
$dominio =DOMINIO;
$instalacoes = new instalacoes();
$instalacoes->setDominio1($dominio);
$ANCORA = $instalacoes->VeificaDominio1();

$email = new emails();
$email->setStatus('pendente');
$list = $email->SelectStatus();
foreach ($list as  $value) {
    $destinatario = $value['recipient_email'];
    if ($destinatario != $ANCORA['email_resgiter']) {
        $fornecedor = new fornecedores();
        $fornecedor->setEmail($destinatario);
        $for = $fornecedor->VerificaBlock();

        $op = new operacoes();
        $op->setCnpj($for['cnpj']);
        $res =  $op->ExiteOP();

        if ($for['status'] == 0) {
            $e = new emails();
            $e->setId($value['id']);
            $e->setStatus('Bloqueado');
            $e->setSent_at(date('Y-m-d H:i:s'));
            $e->UpdateSend();
            continue;
        }
        if($res['COUNT'] <= 0){
            $e = new emails();
            $e->setId($value['id']);
            $e->setStatus('Sem Op');
            $e->setSent_at(date('Y-m-d H:i:s'));
            $e->UpdateSend();
            continue;
        }
    }

    $msg = $value['body'];
    $assunto = $value['subject'];
    $EmailSender = new EmailSender();
    $send =  $EmailSender->enviarEmailSimples($destinatario, $msg, $assunto);
    if ($send == true) {
        $e = new emails();
        $e->setId($value['id']);
        $e->setStatus('enviado');
        $e->setSent_at(date('Y-m-d H:i:s'));
        $e->UpdateSend();
    } else {
        $e = new emails();
        $e->setId($value['id']);
        $e->setStatus('Erro');
        $e->setSent_at(date('Y-m-d H:i:s'));
        $e->UpdateSend();
    }
}
