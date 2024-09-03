<?php
session_start();

function my_autoload($pClassName)
{
    include('Class' . "/" . $pClassName . ".class.php");
}
spl_autoload_register("my_autoload");



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header("Location: login.php");
        exit;
    }

    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);
    $usuario = new fornecedores();
    $usuario->setEmail($email);
    $usuario->setCnpj($senha);
    $result = $usuario->Login();
    


    if ($result) {
        if ($result['status'] == 0) {
            header("Location: login.php?msg=Bloqueado");
            exit;
        }
        
        $_SESSION["logado"] = true;
        $_SESSION["id"]     = $result["id"];
        $_SESSION["email"]  = $result["email"];
        $_SESSION["cnpj"]   = $result["cnpj"];
        $_SESSION["razao"]  = $result["razao"];
        $_SESSION["updated"] = $result["updated"];

        $acessos = new acessos();
        $acessos->setCpf_cnpj($result["cnpj"]);
        $acessos->setId_user($result["id"]);
        $acessos->setEmail_user($result["email"]);
        $acessos->setData_hora(date('Y-m-d H:i:s'));
        $acessos->Insert();
        if (empty($result["email"]) || empty($result["cnpj"]) || empty($result["razao"]) || empty($result["representante"]) || empty($result["conta"]) || empty($result["banco"]) || empty($result["agencia"])) {
            $_SESSION["EfetuarOperacao"] = false;
        } else {
            $_SESSION["EfetuarOperacao"] = true;
        }

        if ($result["tipo"] == "fornecedor") {
            $_SESSION["tipo"] = $result["tipo"];
            header("Location: index.php");
            exit;
        } else {
            header("Location: clientes/index.php");
            $_SESSION["tipo"] = $result["tipo"];
            exit;
        }
    } else {
        // $senha  =  //hash('sha256',  $senha);
        $usuario = new ancora();
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $ancora = $usuario->login();
        // echo "<pre>";
        // var_dump($ancora);
        // exit;
        if ($ancora) {
            // senha é "Rm$9T#q2Xz@8P!2420"  em hash('sha256',  "Rm$9T#q2Xz@8P!2420");
            $_SESSION["nome_representante"] = $ancora['nome_representante'];
            $_SESSION["telefone"] = $ancora['telefone'];
            $_SESSION["accessToken"] = $ancora['access_token'];
            $_SESSION["client_id"] = $ancora['client_id'];
            $_SESSION["secret_id"] = $ancora['secret_id'];
            $_SESSION["auths"] = $ancora['auths'];
            $_SESSION["tipo"] = 'ancora';
            $_SESSION["logado"] = true;
            $_SESSION["razao"]  = $ancora['razao'];
            $_SESSION["id"]     = $ancora['id'];
            $_SESSION["email"]  = $ancora['email'];
            $_SESSION["email_resgiter"]  = $ancora['email_resgiter'];
            $_SESSION["cnpj"]   = $ancora['cnpj'];
            $_SESSION["cpf"]   = $ancora['cpf'];
            $_SESSION["updated"] = 1;
            $acessos = new acessos();
            $acessos->setCpf_cnpj($ancora["cnpj"]);
            $acessos->setId_user($ancora["id"]);
            $acessos->setEmail_user($ancora["email"]);
            $acessos->setData_hora(date('Y-m-d H:i:s'));
            $x = $acessos->Insert();
            // var_dump($x);
            header("Location: ancora/index.php");
            exit;
        } else {
            header("Location: login.php?msg=Senha e/ou Usuário inválido");
            exit;
        }
    }
}
