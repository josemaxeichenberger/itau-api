<?php
session_start();

function my_autoload($pClassName)
{
    include('../Class' . "/" . $pClassName . ".class.php");
}
spl_autoload_register("my_autoload");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST["id"]) && isset($_POST["status"])) {
        $id = htmlspecialchars($_POST["id"]);
        $status = htmlspecialchars($_POST["status"]);


        $fornecedores = new emails();
        $fornecedores->setId($id);
        $fornecedores->setStatus($status);
        $result = $fornecedores->UpdateStatus();
        if ($result) {
            // Se necessário, faça algo com o resultado aqui

            // Prepare o JSON de resposta
            echo 'true';
        } else {
            // Em caso de falha na operação
            echo 'false';
        }
    }
}
