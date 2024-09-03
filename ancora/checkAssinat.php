<?php
session_start();

function my_autoload($pClassName)
{
    include('../Class' . "/" . $pClassName . ".class.php");
}
spl_autoload_register("my_autoload");


if (isset($_SESSION['accessToken'])) {

    $new_assinante = new assinante();

    $res = $new_assinante->Select();
    $_SESSION["auths"] = $res['auths'];
    if ($res) {
        echo json_encode(["status" => 200]);
    } else {
        echo json_encode(["status" => 404]);
    }
}
