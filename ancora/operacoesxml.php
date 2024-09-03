<?php
 
 ob_start(); 
 header('Content-type: application/xml');
 header('Content-Disposition: attachment; filename="seuarquivo.xml"');
 include("../controle_sessao.php");
 function my_autoload($pClassName)
 {
     include('../Class' . "/" . $pClassName . ".class.php");
 }
 
 spl_autoload_register("my_autoload");
 if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'ancora') {
    header("Location: ../pagina_de_acesso_nao_autorizado.php");
    exit();
  }
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><dataset></dataset>');
$acao = isset($_GET['a']) ? htmlspecialchars($_GET['a']) : null;
$status  = 4;
$inicio = isset($_GET['inicio']) ? htmlspecialchars($_GET['inicio']) : null;
$termino = isset($_GET['termino']) ? htmlspecialchars( $_GET['termino']) : null;
$vertice = array();
$list = array();
$postergacoesDetalhes = new postergacoesDetalhes() ; 
$postergacoes = $postergacoesDetalhes->generateMultipleIdsQuery($status, $inicio, $termino);   
foreach($postergacoes as $multiple_row) {
    $vertice[$multiple_row['id']] = explode(',', $multiple_row['multiple_ids']);
    for ($i = 0; $i < count($vertice[$multiple_row['id']]); $i++) {
        array_push($list, $vertice[$multiple_row['id']][$i]);
    }
}
foreach ($vertice as $key => $value) {
    $values = implode(',', $value);
    $antecipadas_agrupadas = new operacoes();
    $antecipadas_agrupadas->setId($values);
    $antecipadas_agrupadas = $antecipadas_agrupadas->SomaOperacaoId();
    
    foreach ($antecipadas_agrupadas as $row) {
        $fornecedor = new fornecedores();
        $fornecedor->setCnpj($row['cnpj']);
        $fornecedor = $fornecedor->SelectCnpj();
        // Crie um elemento de registro para cada conjunto de dados
        $record = $xml->addChild('record');

        $record->addChild('id',  '0000'.$key);
        $record->addChild('operacao', $row['id']); // Preencha com os dados apropriados
        $record->addChild('data_original', $row["dataOPE"]); // Preencha com os dados apropriados
        $record->addChild('data_final', $row["vencimento"]);
        $record->addChild('cnpj', $fornecedor["cnpj"]); // Preencha com os dados apropriados
        $record->addChild('valor', number_format($row['valorOriginal'], 2, ',', '.')); // Preencha com os dados apropriados
        $record->addChild('taxas', $row["taxas"]); // Preencha com os dados apropriados
        $record->addChild('juros', $row["juros"]); // Preencha com os dados apropriados
        $record->addChild('valor_final', number_format($row['valor'], 2, ',', '.')); // Preencha com os dados apropriados
?>



       
    <?php }
}

$antecipadas = new operacoes();
$antecipada =$antecipadas->consultarOperacoesAntecipadas($status, $inicio, $termino);
foreach($antecipada as $row) {


    if (in_array($row['id_oper'], $list) == 1) {
    } else {
        // Crie um elemento de registro para cada conjunto de dados
        $record = $xml->addChild('record');

        // Adicione os elementos filho com os dados relevantes do código PHP original
        $record->addChild('id',  '0000'.$key);
        $record->addChild('operacao', $row['id']); // Preencha com os dados apropriados
        $record->addChild('data_original', $row["dataOPE"]); // Preencha com os dados apropriados
        $record->addChild('data_final', $row["vencimento"]);
        $record->addChild('cnpj', $fornecedor["cnpj"]); // Preencha com os dados apropriados
        $record->addChild('valor', number_format($row['valorOriginal'], 2, ',', '.')); // Preencha com os dados apropriados
        $record->addChild('taxas', $row["taxas"]); // Preencha com os dados apropriados
        $record->addChild('juros', $row["juros"]); // Preencha com os dados apropriados
        $record->addChild('valor_final', number_format($row['valor'], 2, ',', '.')); // Preencha com os dados apropriados
    }
    ?>

<?php }

// Define a saída do XML formatada
$dom = dom_import_simplexml($xml)->ownerDocument;
$dom->formatOutput = true;
// Define o cabeçalho HTTP para indicar que é um arquivo XML

// Saída do XML

// Saída do XML
echo $dom->saveXML();

ob_end_flush(); // Encerre o buffer de saída e envie para o navegador
?>