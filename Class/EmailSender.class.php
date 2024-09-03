<?php

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailSender
{

    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer();
        $this->mail->CharSet = "UTF-8";
        // Configurações do servidor de e-mail
        $this->mail->isSMTP();
        $this->mail->Host = 'mail.lawsmart.com.br'; // Substitua pelo seu servidor SMTP
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'no-reply@lawsmart.com.br'; // Substitua pelo seu e-mail
        $this->mail->Password = 'hD@=&$o*eSdd';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587; // Substitua pela porta do seu servidor SMTP
        // Configurações do remetente
        $this->mail->setFrom('no-reply@lawsmart.com.br', 'Law Smart');
        $this->mail->addBCC('jme.jose.max@gmail.com'); // Adicione um BCC

    }
    function get_sign_url($doc_key)
    {
        $access_token = '7e92bc9f-bcc4-4eea-be40-5ba90020777a';
        $url = "https://app.clicksign.com/api/v1/documents/$doc_key?access_token=$access_token";

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
                return $doc_return["document"]["signers"][1]["url"];
            } else {
                // Handle missing URL
                return null;
            }
        } else {
            // Handle HTTP request failure
            return null;
        }
    }
    public function enviarEmailSimples($destinatario, $msg, $assunto)
    {
        try {
            // Destinatário
            $this->mail->addAddress($destinatario);

            // Assunto e corpo do e-mail
            $this->mail->Subject = $assunto;
            $this->mail->msgHTML($msg);
            $this->mail->send();
            return true;
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function send_postergacao_criada_mail($destinatario, $msg, $assunto, $posterg)
    {

        $trs = '';
        $table = '';

        $total_juros = 0;
        $total_liquido = 0;


        foreach ($posterg as $a) {
            $trs .= ' 
              <tr style="background-color: #FFF; color: #000; text-align: left; border: 0px solid white;">
              <td style="padding: 10px;">' . $a['razao'] . '</td>
              <td style="padding: 10px;">' . $a['nota'] . '</td>
              <td style="padding: 10px;">' . $a['vencimento'] . '</td>
              <td style="padding: 10px;">' . number_format($a['valorOriginal'], 2, ",", ".") . '</td>
              <td style="padding: 10px;">R$ ' . number_format($a['juros'], 2, ",", ".") . '</td>
              <td style="padding: 10px;">R$ ' . number_format($a['valor_antecip'], 2, ",", ".") . '</td>
              </tr>
            ';

            $total_juros += $a['juros'];
            $total_liquido += $a['valor_antecip'];
        }



        $table = '<table style="border: hidden 0px #FFF; font-size: 12px;">
            <thead>
              <tr style="background-color: #E0E0E0; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
                <td style="padding: 10px; ">Emitente/Sacado</td>
                <td style="padding: 10px; ">Documento</td>
                <td style="padding: 10px; ">Vencimento</td>
                <td style="padding: 10px; ">Valor</td>
                <td style="padding: 10px; ">Deságio</td>
                <td style="padding: 10px; ">Líquido</td>
              </tr>
            </thead>
            <tbody>
              ' . $trs . '
            </tbody>
            <tfoot style="">
              <tr style="background-color: #E0E0E0; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
                <td style="padding: 10px; ">Total Deságio</td>
                <td></td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td style="padding: 10px; "> R$' . number_format($total_juros, 2, ",", ".") . '</td>
              </tr>
              <tr style="background-color: #D1D1D1; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
                <td style="padding: 10px; "> Valor Líquido</td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td style="padding: 10px; "> R$' . number_format($total_liquido, 2, ",", ".") . '</td>
              </tr>
              <tr style="background-color: #010840; color: #FFF; text-align: center; font-weight: bold; text-transform: uppercase;">
                <td style="padding: 10px;"> </td>
                <td style="padding: 10px;">Conta</td>
                <td> </td>
                <td style="padding: 10px;">' . $a['conta'] . '-' . $a['agencia'] . '</td>
                <td> </td>
                <td> </td>
              </tr>
            </tfoot>
          </table>
          ';




        try {
            // Destinatário
            $this->mail->addAddress($destinatario);

            // Assunto e corpo do e-mail
            $this->mail->Subject = $assunto;
            $this->mail->msgHTML($table); // Use 'Body' para e-mails comuns, 'msgHTML()' é para e-mails HTML

            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }


    function send_postergacao_assinar_mail($dest_address, $dest_name, $clicksign_key, $data)
    {
        $sign_url = '';
        $access_token = '7e92bc9f-bcc4-4eea-be40-5ba90020777a';
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
                $sign_url  =  $doc_return["document"]["signers"][1]["url"];
            } else {
                // Handle missing URL
                $sign_url  = null;
            }
        } else {
            // Handle HTTP request failure
            $sign_url  =  null;
        }


        $ELEMENTO = '<div style="box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px">

        <span style="color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;width:0">
        Por favor assine o documento.
        </span>
        <div style="padding-bottom:32px;padding-top:32px;width:100%;background-color:#0057ff">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;min-width:100%" width="100%">
        <tbody><tr bgcolor="#0057FF">
        <td align="center" bgcolor="#0057FF" style="font-family:sans-serif;font-size:14px;vertical-align:top;text-align:center" valign="top">
        <img align="center" alt="Logo" style="border:none;max-width:200px;max-height:120px" src="https://lawsmart.com.br/agricopel/assets/media/misc/LSC.png" data-image-whitelisted="" class="CToWUd" data-bit="iit">
        </td>
        </tr>
        </tbody></table>
        </div>
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;background:#fff;border-radius:3px" width="100%">
        <tbody><tr>
        <td style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:30px 20px" valign="top">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%" width="100%">
        <tbody><tr>
        <td align="center" style="font-family:sans-serif;font-size:14px;vertical-align:top;text-align:center" valign="top">
        <h1 align="center" style="box-sizing:border-box;color:#1b2936;font-family:Helvetica Neue,Helvetica,sans-serif;margin-top:0;font-weight:500;font-size:28px;margin-bottom:20px">Solicitação de Assinatura de LAW FINANÇAS
        </h1><p align="left" style="box-sizing:border-box;color:#1b2936;font-family:Helvetica Neue,Helvetica,sans-serif;margin-top:0;font-weight:normal;font-size:14px"></p><pre style="border:0;background-color:transparent;color:inherit;font-family:inherit;font-size:inherit;text-align:left;padding:0 20px;white-space:pre-wrap">Por favor assine o documento.</pre>
        <p></p>
        <a name="m_7544775856846327713_button" style="margin-top:20px;margin-bottom:20px;padding:15px 30px;background:#ff8500;border:solid 1px rgba(0,0,0,0.2);border-radius:4px;box-sizing:border-box;color:#ffffff;display:inline-block;font-size:14px;font-weight:bold;font-family:Arial,Helvetica Neue,Helvetica,sans-serif;text-decoration:none" href="' . $sign_url . '" target="_blank" >Visualizar para assinar</a>
        <div style="padding:10px 60px 30px 60px">
        <div style="color:#000;padding:8px 5px;margin:0;border-bottom:1px solid #eeeeee" width="100%">
        <table>
        <tbody><tr>
        <td align="left" valign="middle">
        <a href="mailto:gilberto@lawsecsa.com.br" target="_blank">gilberto@lawsecsa.com.br</a>:
        <span style="color:#f5ad13">Assinará como parte</span>
        </td>
        </tr>
        </tbody></table>
        </div>
        <div style="color:#000;padding:8px 5px;margin:0;border-bottom:1px solid #eeeeee" width="100%">
        <table>
        <tbody><tr>
        <td align="left" valign="middle">
        <a href="mailto:' . $dest_address . '" target="_blank">' . $dest_address . '</a>:
        <span style="color:#f5ad13">Assinará como parte</span>
        </td>
        </tr>
        </tbody></table>
        </div>
        <div style="color:#83878d;padding:8px 5px;margin:0;border-bottom:1px solid #eeeeee" width="100%">
        <table>
        <tbody><tr>
        <td valign="middle">
        Data limite de assinatura:' . $data . '
        </td>
        </tr>
        </tbody></table>
        </div>
        </div>
        
        <a href="' . $sign_url . '" target="_blank" ><strong>Visualizar para assinar</strong></a>
        
        
        
        
        
        </td>
        </tr>
        </tbody></table>
        </td>
        </tr>
        
        
        
        </tbody>
        </div>
        
        
        </div>';

        try {
            // Destinatário
            $this->mail->addAddress($dest_address);

            // Assunto e corpo do e-mail
            $this->mail->Subject = $dest_name . ', Lembrete de assinatura da solicitação de postergação';
            $this->mail->msgHTML($ELEMENTO); // Use 'Body' para e-mails comuns, 'msgHTML()' é para e-mails HTML

            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function send_antecipacao_criada_mail($destinatario, $msg, $assunto, $antecip)
    {

        $trs = '';
        $table = '';

        $total_juros = 0;
        $total_liquido = 0;


        foreach ($antecip as $a) {
            $trs .= ' 
              <tr style="background-color: #FFF; color: #000; text-align: left; border: 0px solid white;">
              <td style="padding: 10px;">' . $a['razao'] . '</td>
              <td style="padding: 10px;">' . $a['nota'] . '</td>
              <td style="padding: 10px;">' . $a['vencimento'] . '</td>
              <td style="padding: 10px;">' . number_format($a['valorOriginal'], 2, ",", ".") . '</td>
              <td style="padding: 10px;">R$ ' . number_format($a['juros'], 2, ",", ".") . '</td>
              <td style="padding: 10px;">R$ ' . number_format($a['valor_antecip'], 2, ",", ".") . '</td>
              </tr>
            ';

            $total_juros += $a['juros'];
            $total_liquido += $a['valor_antecip'];
        }



        $table = '<table style="border: hidden 0px #FFF; font-size: 12px;">
            <thead>
              <tr style="background-color: #E0E0E0; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
                <td style="padding: 10px; ">Emitente/Sacado</td>
                <td style="padding: 10px; ">Documento</td>
                <td style="padding: 10px; ">Vencimento</td>
                <td style="padding: 10px; ">Valor</td>
                <td style="padding: 10px; ">Deságio</td>
                <td style="padding: 10px; ">Líquido</td>
              </tr>
            </thead>
            <tbody>
              ' . $trs . '
            </tbody>
            <tfoot style="">
              <tr style="background-color: #E0E0E0; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
                <td style="padding: 10px; ">Total Deságio</td>
                <td></td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td style="padding: 10px; "> R$' . number_format($total_juros, 2, ",", ".") . '</td>
              </tr>
              <tr style="background-color: #D1D1D1; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
                <td style="padding: 10px; "> Valor Líquido</td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td style="padding: 10px; "> R$' . number_format($total_liquido, 2, ",", ".") . '</td>
              </tr>
              <tr style="background-color: #010840; color: #FFF; text-align: center; font-weight: bold; text-transform: uppercase;">
                <td style="padding: 10px;"> </td>
                <td style="padding: 10px;">Conta</td>
                <td> </td>
                <td style="padding: 10px;">' . $a['conta'] . '-' . $a['agencia'] . '</td>
                <td> </td>
                <td> </td>
              </tr>
            </tfoot>
          </table>
          ';

        try {
            // Destinatário
            $this->mail->addAddress($destinatario);

            // Assunto e corpo do e-mail
            $this->mail->Subject = $assunto;
            $this->mail->msgHTML($table); // Use 'Body' para e-mails comuns, 'msgHTML()' é para e-mails HTML

            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function send_antecipacao_assinar_mail($dest_address, $dest_name, $clicksign_key, $data)
    {
        $sign_url = '';
        $access_token = $_SESSION['accessToken'];
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
                $sign_url  =  $doc_return["document"]["signers"][1]["url"];
            } else {
                // Handle missing URL
                $sign_url  = null;
            }
        } else {
            // Handle HTTP request failure
            $sign_url  =  null;
        }


        $ELEMENTO = '<div style="box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px">

        <span style="color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;width:0">
        Por favor assine o documento.
        </span>
        <div style="padding-bottom:32px;padding-top:32px;width:100%;background-color:#0057ff">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;min-width:100%" width="100%">
        <tbody><tr bgcolor="#0057FF">
        <td align="center" bgcolor="#0057FF" style="font-family:sans-serif;font-size:14px;vertical-align:top;text-align:center" valign="top">
        <img align="center" alt="Logo" style="border:none;max-width:200px;max-height:120px" src="https://lawsmart.com.br/agricopel/assets/media/misc/LSC.png" data-image-whitelisted="" class="CToWUd" data-bit="iit">
        </td>
        </tr>
        </tbody></table>
        </div>
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;background:#fff;border-radius:3px" width="100%">
        <tbody><tr>
        <td style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:30px 20px" valign="top">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%" width="100%">
        <tbody><tr>
        <td align="center" style="font-family:sans-serif;font-size:14px;vertical-align:top;text-align:center" valign="top">
        <h1 align="center" style="box-sizing:border-box;color:#1b2936;font-family:Helvetica Neue,Helvetica,sans-serif;margin-top:0;font-weight:500;font-size:28px;margin-bottom:20px">Solicitação de Assinatura de LAW FINANÇAS
        </h1><p align="left" style="box-sizing:border-box;color:#1b2936;font-family:Helvetica Neue,Helvetica,sans-serif;margin-top:0;font-weight:normal;font-size:14px"></p><pre style="border:0;background-color:transparent;color:inherit;font-family:inherit;font-size:inherit;text-align:left;padding:0 20px;white-space:pre-wrap">Por favor assine o documento.</pre>
        <p></p>
        <a name="m_7544775856846327713_button" style="margin-top:20px;margin-bottom:20px;padding:15px 30px;background:#ff8500;border:solid 1px rgba(0,0,0,0.2);border-radius:4px;box-sizing:border-box;color:#ffffff;display:inline-block;font-size:14px;font-weight:bold;font-family:Arial,Helvetica Neue,Helvetica,sans-serif;text-decoration:none" href="' . $sign_url . '" target="_blank" >Visualizar para assinar</a>
        <div style="padding:10px 60px 30px 60px">
        <div style="color:#000;padding:8px 5px;margin:0;border-bottom:1px solid #eeeeee" width="100%">
        <table>
        <tbody><tr>
        <td align="left" valign="middle">
        <a href="mailto:gilberto@lawsecsa.com.br" target="_blank">gilberto@lawsecsa.com.br</a>:
        <span style="color:#f5ad13">Assinará como parte</span>
        </td>
        </tr>
        </tbody></table>
        </div>
        <div style="color:#000;padding:8px 5px;margin:0;border-bottom:1px solid #eeeeee" width="100%">
        <table>
        <tbody><tr>
        <td align="left" valign="middle">
        <a href="mailto:' . $dest_address . '" target="_blank">' . $dest_address . '</a>:
        <span style="color:#f5ad13">Assinará como parte</span>
        </td>
        </tr>
        </tbody></table>
        </div>
        <div style="color:#83878d;padding:8px 5px;margin:0;border-bottom:1px solid #eeeeee" width="100%">
        <table>
        <tbody><tr>
        <td valign="middle">
        Data limite de assinatura:' . $data . '
        </td>
        </tr>
        </tbody></table>
        </div>
        </div>
        
        <a href="' . $sign_url . '" target="_blank" ><strong>Visualizar para assinar</strong></a>
        
        
        
        
        
        </td>
        </tr>
        </tbody></table>
        </td>
        </tr>
        
        
        
        </tbody>
        </div>
        
        
        </div>';

        try {
            // Destinatário
            $this->mail->addAddress($dest_address);

            // Assunto e corpo do e-mail
            $this->mail->Subject = $dest_name . ', Lembrete de assinatura da solicitação de postergação';
            $this->mail->msgHTML($ELEMENTO); // Use 'Body' para e-mails comuns, 'msgHTML()' é para e-mails HTML

            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }



    function send_pagamento_mail($dest_address, $dest_name, $clicksign_key, $data)
    {
        $sign_url = '';


        $ELEMENTO = '<div style="box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px">

        <span style="color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;width:0">
        Por favor assine o documento.
        </span>
        <div style="padding-bottom:32px;padding-top:32px;width:100%;background-color:#0057ff">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;min-width:100%" width="100%">
        <tbody><tr bgcolor="#0057FF">
        <td align="center" bgcolor="#0057FF" style="font-family:sans-serif;font-size:14px;vertical-align:top;text-align:center" valign="top">
        <img align="center" alt="Logo" style="border:none;max-width:200px;max-height:120px" src="https://lawsmart.com.br/agricopel/assets/media/misc/LSC.png" data-image-whitelisted="" class="CToWUd" data-bit="iit">
        </td>
        </tr>
        </tbody></table>
        </div>
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%;background:#fff;border-radius:3px" width="100%">
        <tbody><tr>
        <td style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:30px 20px" valign="top">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;width:100%" width="100%">
        <tbody><tr>
        <td align="center" style="font-family:sans-serif;font-size:14px;vertical-align:top;text-align:center" valign="top">
        <h1 align="center" style="box-sizing:border-box;color:#1b2936;font-family:Helvetica Neue,Helvetica,sans-serif;margin-top:0;font-weight:500;font-size:28px;margin-bottom:20px">Solicitação de Assinatura de LAW FINANÇAS
        </h1><p align="left" style="box-sizing:border-box;color:#1b2936;font-family:Helvetica Neue,Helvetica,sans-serif;margin-top:0;font-weight:normal;font-size:14px"></p><pre style="border:0;background-color:transparent;color:inherit;font-family:inherit;font-size:inherit;text-align:left;padding:0 20px;white-space:pre-wrap">Documento foi assinado.</pre>
        <p></p>
        <a name="m_7544775856846327713_button" style="margin-top:20px;margin-bottom:20px;padding:15px 30px;background:#ff8500;border:solid 1px rgba(0,0,0,0.2);border-radius:4px;box-sizing:border-box;color:#ffffff;display:inline-block;font-size:14px;font-weight:bold;font-family:Arial,Helvetica Neue,Helvetica,sans-serif;text-decoration:none" href="' . $sign_url . '" target="_blank" >Visualizar</a>
        <div style="padding:10px 60px 30px 60px">
        <div style="color:#000;padding:8px 5px;margin:0;border-bottom:1px solid #eeeeee" width="100%">
        <table>
        <tbody><tr>
        <td align="left" valign="middle">
        <a href="mailto:gilberto@lawsecsa.com.br" target="_blank">gilberto@lawsecsa.com.br</a>:
        <span style="color:#f5ad13">Assinará como parte</span>
        </td>
        </tr>
        </tbody></table>
        </div>
        <div style="color:#000;padding:8px 5px;margin:0;border-bottom:1px solid #eeeeee" width="100%">
        <table>
        <tbody><tr>
        <td align="left" valign="middle">
        <a href="mailto:' . $dest_address . '" target="_blank">' . $dest_address . '</a>:
        <span style="color:#f5ad13">Assinado</span>
        </td>
        </tr>
        </tbody></table>
        </div>
        <div style="color:#83878d;padding:8px 5px;margin:0;border-bottom:1px solid #eeeeee" width="100%">
        <table>
        <tbody><tr>
        <td valign="middle">
        Data limite de assinatura:' . $data . '
        </td>
        </tr>
        </tbody></table>
        </div>
        </div>
        
        <a href="' . $sign_url . '" target="_blank" ><strong>Visualizar</strong></a>
        
        
        
        
        
        </td>
        </tr>
        </tbody></table>
        </td>
        </tr>
        
        
        
        </tbody>
        </div>
        
        
        </div>';

        try {
            // Destinatário
            $this->mail->addAddress($dest_address);

            // Assunto e corpo do e-mail
            $this->mail->Subject = 'Assinatura Confirmada,' . $dest_name;
            $this->mail->msgHTML($ELEMENTO); // Use 'Body' para e-mails comuns, 'msgHTML()' é para e-mails HTML

            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function Email_Pedido_de_assinatura_cliente($dest_address, $VAR_NOME, $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO, $ANCORA, $LINK)
    {



        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = 'Faça sua Assinatura';

            // Carregue o conteúdo do arquivo HTML
            $templatePath = 'clientes/assinatura.html';

            if (file_exists($templatePath)) {
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
            } else {
                echo "Error: Template file not found.";
            }

            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function Email_duplicatas_vencendo_Cliente($dest_address, $VAR_NOME, $ANCORA, $LINK, $TABELA)
    {
        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = 'Duplicatas Vencendo';
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('clientes/duplicatas-vencendo.html');
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{TABELA}', $TABELA, $template);
            $template = str_replace('{ANCORA}', $ANCORA, $template);
            $template = str_replace('{LINK}', $LINK, $template);
            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function Email_operacao_concluida_Postergacao($dest_address, $VAR_NOME, $RESUMO, $LINK)

    {
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


        
          try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = 'Operação realizada com sucesso';
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('clientes/operacao-concluida.html');
            $template = str_replace('{RESUMO}', $table, $template);
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{LINK}', $LINK, $template);

            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function Email_operacao_concluida_Antecipacao($dest_address, $VAR_NOME, $RESUMO, $LINK)

    {


        $trs = '';
        $table = '';

        $total_juros = 0;
        $total_liquido = 0;

        $qtd = count($RESUMO);
        foreach ($RESUMO as $a) {
            $desscontos = 0;
            $desscontos =   $a['descontoJuros'];
            $trs .= ' 
              <tr style="background-color: #FFF; color: #000; text-align: left; border: 0px solid white;">
              <td style="padding: 10px; ">' . $a['razao'] . '</td>
              <td style="padding: 10px;text-align: center;">' . $a['nota'] . '</td>
              <td style="padding: 10px;text-align: center;">' . date('d-m-Y', strtotime($a['vencimento'])) . '</td>
              <td style="padding: 10px;text-align: center;">' . number_format($a['Original'], 2, ",", ".") . '</td>
              <td style="padding: 10px;white-space: nowrap;text-align: center;">R$ ' . number_format($desscontos, 2, ",", ".") . '</td>
              <td style="padding: 10px;white-space: nowrap;text-align: center;">R$ ' . number_format($a['valor_antecip'], 2, ",", ".") . '</td>
              </tr>
            ';

            $total_juros =  $a['descontoTaxas'];
            $total_liquido += $a['valor_antecip'];
        }

        $total_liquido =  $total_liquido - $total_juros;

        $table = '<table style="border: hidden 0px #FFF; font-size: 12px;">
            <thead>
              <tr style="background-color: #E0E0E0; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
                <td style="padding: 10px; ">Emitente/Sacado</td>
                <td style="padding: 10px; ">Documento</td>
                <td style="padding: 10px; ">Vencimento</td>
                <td style="padding: 10px; ">Valor</td>
                <td style="padding: 10px; ">Juros</td>
                <td style="padding: 10px; ">Líquido</td>
              </tr>
            </thead>
            <tbody>
              ' . $trs . '
            </tbody>
            <tfoot style="">
              <tr style="background-color: #E0E0E0; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
                <td style="padding: 10px; ">Total de Tarifas</td>
                <td></td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td style="padding: 10px; "> R$' . number_format($total_juros, 2, ",", ".") . '</td>
              </tr>
              <tr style="background-color: #D1D1D1; color: #000; text-align: center; font-weight: bold; text-transform: uppercase;">
                <td style="padding: 10px; "> Valor Líquido</td>
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
                <td style="padding: 10px;">Agencia</td>
                <td style="padding: 10px;">' . $a['agencia'] . '</td>
              </tr>
            </tfoot>
          </table>
          ';


        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = 'Operação realizada com sucesso';
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('fornecedores/operacao-concluida.html');
            $template = str_replace('{RESUMO}', $table, $template);
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{LINK}', $LINK, $template);

            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function Email_suply_chain($dest_address, $VAR_NOME, $ANCORA, $LINK, $TABELA)
    {
        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = 'Funcionalidades da plataforma';
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('clientes/suply-chain.html');
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{TABELA}', $TABELA, $template);
            $template = str_replace('{ANCORA}', $ANCORA, $template);
            $template = str_replace('{LINK}', $LINK, $template);
            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function Email_SucessoAntacipacao($dest_address, $VAR_NOME, $VALOR_LIQUIDO,  $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO, $ASSUNTO)
    {
        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = $ASSUNTO;
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('fornecedores/sucesso.html');
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{NUMERO_OPERACAO_VENDOR}', $NUMERO_OPERACAO_VENDOR, $template);
            $template = str_replace('{DATA_OPERACAO}', $DATA_OPERACAO, $template);
            $template = str_replace('{VALOR_LIQUIDO}', $VALOR_LIQUIDO, $template);
            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function Email_RecusadoAntacipacao($dest_address, $VAR_NOME, $VALOR_LIQUIDO,  $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO, $ASSUNTO)
    {
        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = $ASSUNTO;
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('fornecedores/recusado.html');
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{NUMERO_OPERACAO_VENDOR}', $NUMERO_OPERACAO_VENDOR, $template);
            $template = str_replace('{DATA_OPERACAO}', $DATA_OPERACAO, $template);
            $template = str_replace('{VALOR_LIQUIDO}', $VALOR_LIQUIDO, $template);
            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function Email_SucessoPostargada($dest_address, $VAR_NOME, $ANCORA, $LINK, $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO, $ASSUNTO)
    {
        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = $ASSUNTO;
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('clientes/sucesso.html');
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{NUMERO_OPERACAO_VENDOR}', $NUMERO_OPERACAO_VENDOR, $template);
            $template = str_replace('{DATA_OPERACAO}', $DATA_OPERACAO, $template);
            $template = str_replace('{ANCORA}', $ANCORA, $template);
            $template = str_replace('{LINK}', $LINK, $template);
            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function Email_RecusarPostergada($dest_address, $VAR_NOME, $ANCORA, $LINK, $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO, $ASSUNTO)
    {
        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = $ASSUNTO;
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('clientes/recusao.html');
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{NUMERO_OPERACAO_VENDOR}', $NUMERO_OPERACAO_VENDOR, $template);
            $template = str_replace('{DATA_OPERACAO}', $DATA_OPERACAO, $template);
            $template = str_replace('{ANCORA}', $ANCORA, $template);
            $template = str_replace('{LINK}', $LINK, $template);
            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function Email_law_chain($dest_address, $VAR_NOME, $ANCORA, $LINK)
    {
        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = 'Conheça a Law Smart Chain!';
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('clientes/law-chain.html');
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{ANCORA}', $ANCORA, $template);
            $template = str_replace('{LINK}', $LINK, $template);
            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }


    function Email_Pedido_de_assinatura_Fornacedor($dest_address, $VAR_NOME, $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO, $VALOR_LIQUIDO_OPERACAO, $LINK)
    {
        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = 'Faça sua Assinatura';
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('fornecedores/assinatura.html');
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{NUMERO_OPERACAO_VENDOR}', '0000' . $NUMERO_OPERACAO_VENDOR, $template);
            $template = str_replace('{DATA_OPERACAO}', $DATA_OPERACAO, $template);
            $template = str_replace('{VALOR_LIQUIDO_OPERACAO}', $VALOR_LIQUIDO_OPERACAO, $template);
            $template = str_replace('{LINK}', $LINK, $template);
            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    function Email_antecipar_duplicatas_Fornacedor($dest_address, $VAR_NOME, $TABELA, $ANCORA,  $LINK)
    {
        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = 'Faça sua Assinatura';
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('fornecedores/antecipar-duplicatas.html');
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{TABELA}', $TABELA, $template);
            $template = str_replace('{ANCORA}', $ANCORA, $template);
            $template = str_replace('{LINK}', $LINK, $template);
            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function Email_aguardando_recebiveis_Fornacedor($dest_address, $VAR_NOME, $TABELA, $ANCORA,  $LINK)
    {
        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = 'Faça sua Assinatura';
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('fornecedores/aguardando-recebiveis.html');
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{TABELA}', $TABELA, $template);
            $template = str_replace('{ANCORA}', $ANCORA, $template);
            $template = str_replace('{LINK}', $LINK, $template);
            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            // echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            $e->getMessage();
        }
    }


    function Email_SinaturasOk($dest_address, $VAR_NOME, $VALOR_LIQUIDO_OPERACAO,  $NUMERO_OPERACAO_VENDOR, $TIPO_PERACAO)
    {
        try {
            // Destinatário
            $this->mail->addAddress($dest_address);
            //Assunto
            $this->mail->Subject = 'Assinaturas efetuadas de ambas as partes, proseguir com o processo!';
            // Carregue o conteúdo do arquivo HTML
            $template = file_get_contents('fornecedores/assinatura-ok.html');
            $template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
            $template = str_replace('{NUMERO_OPERACAO_VENDOR}', $NUMERO_OPERACAO_VENDOR, $template);
            $template = str_replace('{TIPO_PERACAO}', $TIPO_PERACAO, $template);
            $template = str_replace('{VALOR_LIQUIDO_OPERACAO}', $VALOR_LIQUIDO_OPERACAO, $template);
            // Defina o corpo do e-mail com o template HTML
            $this->mail->isHTML(true);
            $this->mail->Body = $template;
            // Enviar e-mail
            $this->mail->send();
            echo 'O e-mail foi enviado com sucesso.';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

// // // // Exemplo de uso:
// $emailSender = new EmailSender();
// $emailSender->Email_SinaturasOk('jme.jose.max@gmail.com', 'teste', '2000.00',  '0007', '0000-00-00');
