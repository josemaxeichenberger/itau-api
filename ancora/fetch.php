<?php
session_start();
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'ancora') {
	header("Location: ../pagina_de_acesso_nao_autorizado.php");
	exit();
  }
require_once('../Class/Config.php');
$con = new mysqli(DB_HOUST, DB_USER,DB_PASS, DB_NAME);

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

if ($_GET) {
	// $cnpj = 34474610000149;
	// // ;//$_GET['cnpj'];
	// if ($_GET['cnpj']) {
	// 	$cnpj = $_GET['cnpj'];
	// }
	// else {
		$cnpj = $_SESSION['cnpj'];
	// }
	switch ($_GET['f']) {
		case 'fornecedor':
			$sql = "SELECT * FROM `fornecedores` where cnpj=?";
			$stmt = prepared_query($con, $sql, [$cnpj], 's');
			$forn = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$stmt->close();
			echo json_encode($forn[0], JSON_FORCE_OBJECT);
			break;

		case 'operacoes':
			$hoje = date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));
			//$hoje = '2020-10-10';
			$sql = "SELECT * FROM operacoes WHERE cnpj=? AND status=? AND vencimento>=? ORDER BY vencimento ASC";
			$stmt = prepared_query($con, $sql, [$cnpj, 0, $hoje], 'sis');
			$ope = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$stmt->close();
			echo json_encode($ope);
			break;

		case 'baixadas':
			$hoje = date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));
			$sql = "SELECT * FROM operacoes WHERE cnpj=? AND status=? AND vencimento>=? ORDER BY vencimento ASC";
			$stmt = prepared_query($con, $sql, [$cnpj, 1, $hoje], 'sis');
			$ope = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$stmt->close();
			echo json_encode($ope);
			break;

		case 'taxas':
			$sql = "SELECT * FROM taxas";
			$stmt = prepared_query($con, $sql, []);
			$txs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$stmt->close();
			echo json_encode($txs);
			break;

		case 'feriados':
			$data = $_GET['data'];
			$sql = "SELECT * FROM data WHERE data=?";
			$stmt = prepared_query($con, $sql, [$data]);
			$frds = $stmt->get_result()->fetch_row();
			$stmt->close();
			$frds = ($frds == '') ? [] : $frds;
			echo (sizeof($frds) > 0) ? json_encode('true') : json_encode('false');
			break;
	}
} else {
	$dados = json_decode(file_get_contents('php://input'), true);
	$metodo = $dados['metodo'];
	unset($dados['metodo']);
	switch ($metodo) {
		case 'antecipadas':
			$sql = "INSERT INTO antecipadas (fornecedor, data, valorOriginal, descontoJuros, descontoTaxas, valor, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$stmt = prepared_query($con, $sql, [$dados['fornecedor'], $dados['data'], $dados['valorOriginal'], $dados['descontoJuros'], $dados['descontoTaxas'], $dados['valor'], $dados['status']], 'isddddi');
			$stmt->close();

			$res = $con->query("SELECT MAX(LAST_INSERT_ID(id)) AS id FROM antecipadas");
			$id = $res->fetch_row();
			$res->close();

			echo $id[0];
			break;
		case 'detalhes':
			$sql = "INSERT INTO antecipadasDetalhes (antecipada, operacao, data, valorOriginal, descontoJuros, valor) VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = prepared_query($con, $sql, [$dados['antecipada'], $dados['operacao'], $dados['data'], $dados['valorOriginal'], $dados['descontoJuros'], $dados['valor']], 'iisddd');
			$stmt->close();
			$sql = "UPDATE operacoes SET dataOPE=?, status=1 WHERE id=?";
			$stmt = prepared_query($con, $sql, [$dados['data'], $dados['operacao']], 'si');
			$stmt->close();

			$id_oper = $dados['operacao'];
			$res = $con->query("select vencimento, cnpj from operacoes where id = {$id_oper}");
			$op = $res->fetch_assoc();
			$res->close();

			$res = $con->query("SELECT COALESCE(MAX(nosso_numero),0) AS nossoNmr FROM `boletos`");
			$nmr = $res->fetch_row();
			$res->close();
			$nmr = floatval($nmr[0]) + 1;
			$nn = str_pad($nmr, 8, '10000', STR_PAD_LEFT);

			$sql = "INSERT INTO boletos (cnpj, vencimento, valor, operacao, documento, nosso_numero, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$stmt = prepared_query($con, $sql, [$op['cnpj'], $op['vencimento'], $dados['valorOriginal'], $dados['operacao'], $dados['nota'], $nn, 'P'], 'ssdisss');
			$stmt->close();

			echo 'ok';
			break;
	}
}
