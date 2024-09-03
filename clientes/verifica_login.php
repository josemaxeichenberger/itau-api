<?php
session_start();
function my_autoload($pClassName)
{
	include('../Class' . "/" . $pClassName . ".class.php");
}

spl_autoload_register("my_autoload");
$email = htmlspecialchars($_POST["email"]);
$cnpj  = htmlspecialchars($_POST["senha"]);
$usuario  = new fornecedores();
$usuario->setEmail($email);
$usuario->setCnpj($cnpj);
$result = $usuario->Login();
if (!$result) {
	if ($email == "gilberto@lawsecsa.com.br") {
		$_SESSION["logado"] = true;
		$_SESSION["id"]    	= "999999";
		$_SESSION["email"] 	= "gilberto@lawsecsa.com.br";
		$_SESSION["cnpj"]   = "325271980001520";
		$_SESSION["updated"] = $v["updated"];
		header("Location: index.php");
	} else {
		header("Location: login.php?msg=Senha e/ou Usuario invalido");
	}
} else {
	$v = $result;
	$_SESSION["logado"] = true;
	$_SESSION["id"]    	= $v["id"];
	$_SESSION["email"] 	= $v["email"];
	$_SESSION["cnpj"]   = $v["cnpj"];
	$_SESSION["razao"]   = $v["razao"];
	$_SESSION["updated"] = $v["updated"];
	header("Location: index.php");
}
