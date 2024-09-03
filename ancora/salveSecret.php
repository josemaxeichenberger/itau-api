<?php
session_start();

function my_autoload($pClassName)
{
    include('../Class' . "/" . $pClassName . ".class.php");
}
spl_autoload_register("my_autoload");


if (isset($_SESSION['accessToken']) && isset($_POST['secretRSA'])) {
    $secret_signerkey = $_POST['secretRSA'];
    $new_assinante = new assinante();
    $new_assinante->setSecret_signerkey($secret_signerkey);    
    $res = $new_assinante->Update();
    http_response_code(200);
    echo json_encode(["message" => "Os dados foram salvos com sucesso"]);

}
