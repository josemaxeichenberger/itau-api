<?php
  header("Access-Control-Allow-Origin: *");
require_once  '../Class/instalacoes.class.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $controller = new instalacoes();
    $controller->setId($id);
    $res = $controller->Select();
    http_response_code(200);
    echo json_encode($res);

} elseif ($method === 'POST') {
    $id                 =$_POST['id'];
    $razao              =$_POST['razao'];
    $nome_fantazia      =$_POST['nome_fantasia'];
    $nome_representante =$_POST['nome_representante'];
    $cnpj               =$_POST['cnpj'];
    $cpf                =$_POST['cpf'];
    $rg                 =$_POST['rg'];
    $data_nascimento    =$_POST['data_nascimento'];
    $estado_civil       =$_POST['estado_civil'];
    $nacionalidade      =$_POST['nacionalidade'];
    $profissao          =$_POST['profissao'];
    $telefone           =$_POST['telefone'];
    $email_register     =$_POST['email_register'];
    $senha              =$_POST['senha'];
    $cep                =$_POST['cep'];
    $rua                =$_POST['rua'];
    $bairro             =$_POST['bairro'];
    $cidade             =$_POST['cidade'];
    $estado             =$_POST['estado'];
    $numero             =$_POST['numero'];
    $complemento        =$_POST['complemento'];
    $cep_ancora         =$_POST['cep_ancora'];
    $rua_ancora         =$_POST['rua_ancora'];
    $bairro_ancora      =$_POST['bairro_ancora'];
    $cidade_ancora      =$_POST['cidade_ancora'];
    $estado_ancora      =$_POST['estado_ancora'];
    $numero_ancora      =$_POST['numero_ancora'];
    $complemento_ancora =$_POST['complemento_ancora'];
    $controller = new instalacoes();
    $controller->setId($id);
    $controller->setRazao($razao);
    $controller->setNome_fantasia($nome_fantazia);
    $controller->setNome_representante($nome_representante);
    $controller->setCnpj($cnpj);
    $controller->setCpf($cpf);
    $controller->setRg($rg);
    $controller->setData_nascimento($data_nascimento);
    $controller->setEstado_civil($estado_civil);
    $controller->setNacionalidade($nacionalidade);
    $controller->setProfissao($profissao);    
    $controller->setTelefone($telefone);
    $controller->setEmail_resgiter($email_register);
    $controller->setSenha($senha);
    $controller->setCep($cep);
    $controller->setRua($rua);
    $controller->setBairro($bairro);
    $controller->setCidade($cidade);
    $controller->setEstado($estado);
    $controller->setNumero($numero);
    $controller->setComplemento($complemento);
    $controller->setCep_ancora($cep_ancora);
    $controller->setRua_ancora($rua_ancora);
    $controller->setBairro_ancora($bairro_ancora);
    $controller->setCidade_ancora($cidade_ancora);
    $controller->setEstado_ancora($estado_ancora);
    $controller->setNumero_ancora($numero_ancora);
    $controller->setComplemento_ancora($complemento_ancora);
    $res = $controller->Update();
    
    echo json_encode($res);

}  elseif ($method === 'DELETE' && isset($pathParts[1])) {
    // Implementação para DELETE

} else {
    http_response_code(404);
    echo "404 Not Found";
}
