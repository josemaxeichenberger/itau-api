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
            if(isset($_POST['tipo'])){
            $tipo = $_POST['tipo']; // Assuming 'cnpj' is the POST parameter
            $sql = new fornecedores();
            $sql->setTipo($tipo);
            
            $forn = $sql->SelectTipo();
                
            }else{
                            
            $sql = new fornecedores();
            $forn = $sql->Select();
            }
            if ($forn) {
                echo json_encode($forn);
            } else {
                echo json_encode(['error' => 'Fornecedor not found']);
            }
        }
    
    ?>
    