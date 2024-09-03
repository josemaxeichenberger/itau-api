<?php
include("../controle_sessao.php");
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'cliente') {
    header("Location: ../pagina_de_acesso_nao_autorizado.php");
    exit();
}
function my_autoload($pClassName)
{
	include('../Class' . "/" . $pClassName . ".class.php");
}

spl_autoload_register("my_autoload");
$id = isset($_POST['id']) ? htmlspecialchars(trim($_POST['id'])) : '';
$representante = isset($_POST['representante']) ? htmlspecialchars(trim($_POST['representante'])) : '';
$representante2 = isset($_POST['representante2']) ? htmlspecialchars(trim($_POST['representante2'])) : '';
$cpf = isset($_POST['cpf']) ? str_replace(['.', ',', '-'], '', htmlspecialchars(trim($_POST['cpf']))) : '';
$telefone = isset($_POST['telefone']) ? htmlspecialchars(trim($_POST['telefone'])) : '';
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
$rua = isset($_POST['rua']) ? htmlspecialchars(trim($_POST['rua'])) : '';
$numero = isset($_POST['numero']) ? htmlspecialchars(trim($_POST['numero'])) : '';
$bairro = isset($_POST['bairro']) ? htmlspecialchars(trim($_POST['bairro'])) : '';
$cidade = isset($_POST['cidade']) ? htmlspecialchars(trim($_POST['cidade'])) : '';
$estado = isset($_POST['estado']) ? htmlspecialchars(trim($_POST['estado'])) : '';

$banco = isset($_POST['banco']) ? htmlspecialchars(trim($_POST['banco'])) : '';
$agencia = isset($_POST['agencia']) ? htmlspecialchars(trim($_POST['agencia'])) : '';
$conta = isset($_POST['conta']) ? htmlspecialchars(trim($_POST['conta'])) : '';
if (empty($representante) || empty($representante2) || empty($cpf) || empty($telefone) || empty($email) || empty($banco) || empty($agencia) || empty($conta) || empty($estado) || empty($cidade) || empty($bairro) || empty($numero)) {
	$_SESSION["EfetuarOperacao"] = false;
	$_SESSION['updated'] = 0;
} else {
	$_SESSION["EfetuarOperacao"] = true;
	$_SESSION['updated'] = 1;
}
$fornecedores = new fornecedores();
$fornecedores->setId($id);
$fornecedores->setRepresentante($representante . ' ' . $representante2);
$fornecedores->setCpf($cpf);
$fornecedores->setTelefone($telefone);
$fornecedores->setEmail($email);
$fornecedores->setRua($rua);
$fornecedores->setNumero($numero);
$fornecedores->setBairro($bairro);
$fornecedores->setCidade($cidade);
$fornecedores->setEstado($estado);
$fornecedores->setBanco($banco);
$fornecedores->setAgencia($agencia);
$fornecedores->setConta($conta);
$fornecedores->setUpdated($_SESSION['updated']);
$fornecedores = $fornecedores->UpdateFornecedor();
