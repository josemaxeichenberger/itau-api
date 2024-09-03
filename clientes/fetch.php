<?php
session_start();
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'cliente') {
    header("Location: ../pagina_de_acesso_nao_autorizado.php");
    exit();
}
// require_once('/home/lawsmart/send_mail.php');

require_once('../Class/Config.php');
$con = new mysqli(DB_HOUST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($con, 'utf8');

function prepared_query($mysqli, $sql, $params, $types = "")
{
	$stmt = $mysqli->prepare($sql);
	if (sizeof($params) > 0) {
		$types = $types ?: str_repeat("s", count($params));
		$stmt->bind_param($types, ...$params);
	}
	// echo var_dump($stmt);
	$stmt->execute();
	return $stmt;
}

if ($_GET) {
	$cnpj = $_SESSION['cnpj'];

	switch ($_GET['f']) {
		case 'fornecedor':
			$sql = "SELECT * FROM `fornecedores` where cnpj=?";
			$stmt = prepared_query($con, $sql, [$cnpj], 's');
			$forn = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$stmt->close();
			echo json_encode($forn[0], JSON_FORCE_OBJECT);
			break;
			case 'fornecedortotalUsado':
				$sql = "SELECT SUM(valor) as totalUsado FROM operacoes WHERE cnpj = ? AND status = 5 AND confirmada = 1";
				$stmt = prepared_query($con, $sql, [$cnpj], 's');
				$fornSaldo = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
				$stmt->close();
				echo json_encode($fornSaldo[0], JSON_FORCE_OBJECT);
				break;
		case 'operacoes':
			$hoje = date('Y-m-d', strtotime('+0 days', strtotime(date('Y-m-d'))));
			//$hoje = '2020-10-10';
			$sql = "SELECT * FROM operacoes WHERE cnpj=? AND status=? AND vencimento>=? ORDER BY vencimento ASC";
			$stmt = prepared_query($con, $sql, [$cnpj, 0, $hoje], 'sis');
			$ope = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$stmt->close();
			// echo "1";	

			// $test = dispatch_event_mail('antecipacao_criada', 'allan.murara@gmail.com', 'allan murara');
			// return;
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
			echo 'ok';
			break;

		case 'nova_postergacao':
			$sql = "INSERT INTO `postergacoes` (`id`, `data`, `valorOriginal`, `juros`, `taxas`, `valor`, `status`, `tipo`, `confirmada`) VALUES (NULL, CURRENT_DATE(), '0', '0', '0', '0', NULL, NULL, NULL);";
			$stmt = prepared_query($con, $sql, [], '');
			$stmt->close();
			$res = $con->query("SELECT MAX(LAST_INSERT_ID(id)) AS id FROM postergacoes");
			echo $res->fetch_row()[0];
			break;

		case 'postergada':
			$sql = "UPDATE operacoes SET dataOPE=?, status=? WHERE id=?";
			$stmt = prepared_query($con, $sql, [date('Y-m-d'), 4, $dados['id']], 'sii');
			$stmt->close();

			$sql = "INSERT INTO operacoes (cnpj, nota, vencimento, valor, dataOPE, tipo, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$stmt = prepared_query($con, $sql, [$dados['fornecedor'], $dados['nota'], $dados['vencimento'], $dados['valor'], date('Y-m-d'), 'cliente', 6], 'sssdssi');
			$stmt->close();

			$res = $con->query("SELECT MAX(LAST_INSERT_ID(id)) AS id FROM operacoes");
			$id = $res->fetch_row();
			$res->close();

			$res = $con->query("SELECT COALESCE(MAX(nosso_numero),0) AS nossoNmr FROM `boletos`");
			$nmr = $res->fetch_row();
			$res->close();
			$nmr = floatval($nmr[0]) + 1;
			$nn = str_pad($nmr, 8, '10000', STR_PAD_LEFT);
			$emissao = date('Y-m-d');
			$sql = "INSERT INTO boletos (cnpj, vencimento, valor, operacao, documento, nosso_numero, status,emissao) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt = prepared_query($con, $sql, [$dados['fornecedor'], $dados['vencimento'], $dados['valor'], $id[0], $dados['nota'], $nn, 'P',$emissao], 'ssdissss');
			$stmt->close();

			$sql = "INSERT INTO `postergacoesDetalhes` (`id`, `id_postergacao`, `id_operacao`, `valorOriginal`, `juros`, `taxas`, `valor`, `status`, `tipo`, `id_postergada`) VALUES (NULL, ?, ?, ?, ?, ?, ?, NULL, NULL, ?);";
			$stmt = prepared_query($con, $sql, [$dados['postergacao_id'], $id[0], $dados['valorOriginal'], $dados['juros'], $dados['taxas'], $dados['valor'],  $dados['id']], 'idddddi');
			$stmt->close();

			$sql = "SELECT * FROM postergacoes WHERE id=?";
			$stmt = prepared_query($con, $sql, [$dados['postergacao_id']]);
			$postergacao = $stmt->get_result()->fetch_assoc();
			$stmt->close();
			$valor_postergado = $postergacao['valor'] + $dados['valor'];
			$valor_original_postergado = $postergacao['valorOriginal'] + $dados['valorOriginal'];
			$taxas_postergado = $postergacao['taxas'] + $dados['taxas'];
			$juros_postergado = $postergacao['juros'] + $dados['juros'];

			$sql = "UPDATE postergacoes SET valor=?, valorOriginal=?, taxas=?, juros=? WHERE id=?";
			$stmt = prepared_query($con, $sql, [$valor_postergado, $valor_original_postergado, $taxas_postergado, $juros_postergado, $dados['postergacao_id']], 'ddddi');
			$stmt->close();

			echo $id[0];
			break;
	}
}
