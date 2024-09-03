<?php
session_status();
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'cliente') {
    header("Location: ../pagina_de_acesso_nao_autorizado.php");
    exit();
}
require_once('../Class/Config.php');
$con = new mysqli(DB_HOUST, DB_USER, DB_PASS, DB_NAME);

function prepared_query($mysqli, $sql, $params, $types = "")
{
    $stmt = $mysqli->prepare($sql);
    if (sizeof($params) > 0) {
        $types = $types ?: str_repeat("s", count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt;
}

$stmt = $con->prepare('DELETE FROM cdi');
$stmt->execute();
$stmt->close();

$url = 'https://www.debit.com.br/tabelas/tabela-completa.php?indice=cdi';
$dom = new DOMDocument('1.0');
@$dom->loadHTMLFile($url);

$tds    = $dom->getElementsByTagName('td');
$mesAno = '';
$valor  = 0;
foreach ($tds as $el) {
    $class = $el->getAttribute('class');
    if ($class == 'mdl-data-table__cell--non-numeric ') {
        $mesAno = (strlen($el->nodeValue) > 4) ? $el->nodeValue : '';
    } else {
        if ($mesAno != '') {
            $valor  = $el->nodeValue;
            $mesAno = explode('/', $mesAno);
            echo $mesAno[0] . '/' . $mesAno[1] . '->' . $valor . '%<br>';
            $sql    = "INSERT INTO cdi (ano, mes, valor) VALUES (?, ?, ?)";
            $stmt   = prepared_query($con, $sql, [$mesAno[1], $mesAno[0], str_replace(',', '.', $valor)], 'iid');
            $stmt->close();
            $mesAno = '';
        }
    }
}
