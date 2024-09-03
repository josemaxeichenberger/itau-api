<?php
include("../controle_sessao.php");
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'ancora') {
    header("Location: ../pagina_de_acesso_nao_autorizado.php");
    exit();
  }
function my_autoload($pClassName)
{
    include('../Class' . "/" . $pClassName . ".class.php");
}
spl_autoload_register("my_autoload");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($_GET['f']) {
        case 'fornecedor':
            $cnpj = $_GET['cnpj'];
            $fornecedores = new fornecedores();
            $fornecedores->setCnpj($cnpj);
            $fornecedores = $fornecedores->SelectCnpj();
            echo json_encode($fornecedores);

            break;
        case 'operacoes':
            $hoje = date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));
            $cnpj = $_GET['cnpj'];
            $operacoes = new operacoes();
            $operacoes->setCnpj($cnpj);
            $operacoes->setStatus(0);
            $operacoes->setVencimento($hoje);
            $operacoes = $operacoes->SelectOpDescontoAncora();
            echo json_encode($operacoes);
            break;

        case 'baixadas':
            $hoje = date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));
            $cnpj = $_GET['cnpj'];
            $operacoes = new operacoes();
            $operacoes->setCnpj($cnpj);
            $operacoes->setStatus(1);
            $operacoes->setVencimento($hoje);
            $operacoes = $operacoes->SelectOpDescontoAncora();
            echo json_encode($operacoes);
            break;

        case 'taxas':
            $taxas = new taxas();
            $taxas = $taxas->SelectAll();
            echo json_encode($taxas, JSON_FORCE_OBJECT);
            break;

        case 'feriados':
            $data = $_GET['data'];
            $datas = new data();
            $datas->setData($data);
            $datas = $datas->SelectData();

            echo  json_encode($datas, JSON_FORCE_OBJECT);
            break;
        case 'PercentualLimiteUsado':
            $cnpj = $_GET['cnpj'];
            $fornecedores = new fornecedores();
            $fornecedores->setCnpj($cnpj);
            $fornecedor = $fornecedores->SelectCnpj();
            $operacoes = new operacoes();
            $operacoes->setCnpj($cnpj);
            $operacoes = $operacoes->Total_UsadoLimite();
            $totalUsado = $operacoes['totalUsado'];
            if (isset($fornecedor['limite'])) {
                $limite = $fornecedor['limite'];
                if ($limite > 0) {
                    $porcentagemUsada = number_format(($totalUsado / $limite) * 100, 2);
                    echo json_encode($porcentagemUsada, JSON_FORCE_OBJECT);
                }else{
                    echo json_encode('0.00',JSON_FORCE_OBJECT);
                }
              
            } else {
                echo json_encode('false',JSON_FORCE_OBJECT);
            }




            break;
    }
}
