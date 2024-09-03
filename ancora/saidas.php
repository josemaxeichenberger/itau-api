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
require_once('../Class/Config.php');
$dominio = DOMINIO;
$instalacoes = new instalacoes();
$instalacoes->setDominio1($dominio);
$ANCORA = $instalacoes->VeificaDominio1();



$acao = isset($_POST['a']) ? $_POST['a'] : null;
if ($acao == 'confirmar') {
	$id = isset($_POST['id']) ? $_POST['id'] : null;
	$Antecipadas = new antecipadasDetalhes();
	$Antecipadas->setAntecipada($id);
	$Antecipada = $Antecipadas->buscaNotas();
	foreach ($Antecipada as $row) {
		$query = new operacoes();
		$query->setId($row['operacao']);
		$query = $query->Select();
		if ($query['confirmada'] == '1') {
			$status = 0;
		} else {
			$status = 1;
		}
		$query = new operacoes();
		$query->setId($row['operacao']);
		$query->setConfirmada($status);
		$query->Update_confirmada();
	}
	$antecipadas = new antecipadas();
	$antecipadas->setId($id);
	$an = $antecipadas->Select();

	$DATA_OPERACAO = $an['data'];
	$NUMERO_OPERACAO_VENDOR = '000' . $id;
	$email = new EmailSender();
	$ASSUNTO = 'Antecipação Confirmada com Sucesso!';
	$LINK = 'https://'.$dominio;
	$fornecedor = new fornecedores();
	$fornecedor->setId($an['fornecedor']);
	$for = $fornecedor->SelectID();
	$dest_address = $for['email'];
	$VAR_NOME = $for['razao'];
	$VALOR_LIQUIDO = $an['valor'];
	// $email->Email_SucessoAntacipacao($dest_address, $VAR_NOME, $VALOR_LIQUIDO,  $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO, $ASSUNTO);
	$template = file_get_contents('../Class/fornecedores/sucesso.html');
	$template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
	$template = str_replace('{NUMERO_OPERACAO_VENDOR}', $NUMERO_OPERACAO_VENDOR, $template);
	$template = str_replace('{DATA_OPERACAO}', $DATA_OPERACAO, $template);
	$template = str_replace('{VALOR_LIQUIDO}', $VALOR_LIQUIDO, $template);
  
	$email = new emails();
	$email->setRecipient_email($dest_address);
	$email->setSubject('Antecipação Confirmada com Sucesso!');
	$email->setBody($template);
	$email->setStatus('pendente');
	$email->setType('notification');
	$email->setCreated_at(date('Y-m-d H:i:s'));
	$email->setSent_at(null);
	$email->Insert();





}
if ($acao == 'confirmarPostergadas') {
	$id = isset($_POST['id_postergacao']) ? $_POST['id_postergacao'] : null;

	$Postergadas = new postergacoesDetalhes();
	$Postergadas->setId_postergacao($id);
	$Postergadas = $Postergadas->SelectNotas();

	foreach ($Postergadas as $row) {
		$query = new operacoes();
		$query->setId($row['id_postergada']);
		$query = $query->Select();
		if ($query['confirmada'] == '1') {
			$status = 0;
		} else {
			$status = 1;
		}
		$query = new operacoes();
		$query->setId($row['id_operacao']);
		$query->setConfirmada($status);
		$query->Update_confirmada();

		$query = new operacoes();
		$query->setId($row['id_operacao']);
		$r = $query->Select();
		$cnpj = $r['cnpj'];
	}

	$postergacoes = new postergacoes();
	$postergacoes->setId($id);
	$pos = $postergacoes->SelectId();
	$fornecedor = new fornecedores();
	$fornecedor->setCnpj($cnpj);
	$for = $fornecedor->SelectCnpj();
	$dest_address = $for['email'];
	$VAR_NOME = $for['razao'];
	$DATA_OPERACAO = $pos['data'];
	$NUMERO_OPERACAO_VENDOR = '000' . $id;
	$email = new EmailSender();
	$ASSUNTO = 'Postergação Confirmada com Sucesso!';
	$LINK = 'https://'.$dominio;




	$fornecedor = new fornecedores();
	$fornecedor->setId($an['fornecedor']);
	$for = $fornecedor->SelectID();
	$dest_address = $for['email'];
	$VAR_NOME = $for['razao'];

	$email->Email_SucessoPostargada($dest_address, $VAR_NOME, $ANCORA['razao'], $LINK, $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO, $ASSUNTO);
}
if ($acao == 'RecusarPostergadas') {
	$id = isset($_POST['id']) ? $_POST['id'] : null;

	$Postergadas = new postergacoesDetalhes();
	$Postergadas->setId_postergacao($id);
	$Postergadas = $Postergadas->SelectNotas();;
	$query = new operacoes();
	$query->setId($Postergadas[0]['id_operacao']);
	$r = $query->Select();
	$cnpj = $r['cnpj'];
	$postergacoes = new postergacoes();
	$postergacoes->setId($id);
	$pos = $postergacoes->SelectId();
	$fornecedor = new fornecedores();
	$fornecedor->setCnpj($cnpj);
	$for = $fornecedor->SelectCnpj();
	$dest_address = $for['email'];
	$VAR_NOME = $for['razao'];
	$DATA_OPERACAO = $pos['data'];
	$NUMERO_OPERACAO_VENDOR = '000' . $id;
	$ANCORA = 'Agricopel';
	$email = new EmailSender();
	$ASSUNTO = 'Recusado!';
	$LINK = 'https://'.$dominio;




	$fornecedor = new fornecedores();
	$fornecedor->setId($an['fornecedor']);
	$for = $fornecedor->SelectID();
	$dest_address = $for['email'];
	$VAR_NOME = $for['razao'];

	$email->Email_RecusarPostergada($dest_address, $VAR_NOME, $ANCORA, $LINK, $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO, $ASSUNTO);
	foreach ($Postergadas as $row) {

		$query = new operacoes();
		$query->setId($row['id_postergada']);
		$query->setStatus(0);
		$query->Update_Status();
		// //deleta a que foi criada 


		$PostergadasDetalhe = new postergacoesDetalhes();
		$PostergadasDetalhe->setId_postergacao($id);
		$PostergadasDetalhe->DeleteOp();
		$Postergadas = new postergacoes();
		$Postergadas->setId($id);
		$Postergadas->Delete();

		$boletos = new boletos();
		$boletos->setOperacao($row['id_operacao']);
		$boletos->DeleteOp();
		$query2 = new operacoes();
		$query2->setId($row['id_operacao']);
		$res = $query2->Delete();
	}
}
if ($acao == 'RecusarAntecipadas') {
	$id = isset($_POST['id']) ? $_POST['id'] : null;
	$Antecipadas = new antecipadasDetalhes();
	$Antecipadas->setAntecipada($id);
	$Antecipada = $Antecipadas->buscaNotas();





	foreach ($Antecipada as $row) {
		$query = new operacoes();
		$query->setId($row['operacao']);
		$query->setStatus(0);
		$query->Update_Status();
		$antecipadasDetalhes = new antecipadasDetalhes();
		$antecipadasDetalhes->setAntecipada($id);
		$antecipadasDetalhes->Delete();
		$antecipadas = new antecipadas();
		$antecipadas->setId($id);
		$boletos = new boletos();
		$boletos->setOperacao($row['operacao']);
		$boletos->DeleteOp();
	}
	$antecipadas = new antecipadas();
	$antecipadas->setId($id);
	$an = $antecipadas->Select();

	$DATA_OPERACAO = $an['data'];
	$NUMERO_OPERACAO_VENDOR = '000' . $id;
	$email = new EmailSender();
	$ASSUNTO = 'Recusado!';
	$LINK = 'https://'.$dominio;
	$fornecedor = new fornecedores();
	$fornecedor->setId($an['fornecedor']);
	$for = $fornecedor->SelectID();
	$dest_address = $for['email'];
	$VAR_NOME = $for['razao'];
	$VALOR_LIQUIDO = $an['valor'];
	// $email->Email_RecusadoAntacipacao($dest_address, $VAR_NOME, $VALOR_LIQUIDO,  $NUMERO_OPERACAO_VENDOR, $DATA_OPERACAO,$ASSUNTO);
	$template = file_get_contents('../Class/fornecedores/recusado.html');
	$template = str_replace('{VAR_NOME}', $VAR_NOME, $template);
	$template = str_replace('{NUMERO_OPERACAO_VENDOR}', $NUMERO_OPERACAO_VENDOR, $template);
	$template = str_replace('{DATA_OPERACAO}', $DATA_OPERACAO, $template);
	$template = str_replace('{VALOR_LIQUIDO}', $VALOR_LIQUIDO, $template);
  
	$email = new emails();
	$email->setRecipient_email($dest_address);
	$email->setSubject('Antecipação Recusada!');
	$email->setBody($template);
	$email->setStatus('pendente');
	$email->setType('notification');
	$email->setCreated_at(date('Y-m-d H:i:s'));
	$email->setSent_at(null);
	$email->Insert();
}
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<base href="">
	<title>LSC</title>
	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="pt-br" />
	<meta property="og:type" content="" />
	<meta property="og:title" content="" />
	<meta property="og:url" content="" />
	<meta property="og:site_name" content="" />
	<link rel="canonical" href="" />
	<link rel="shortcut icon" href="../assets/media/misc/LSC-icone.png" />

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="white-translucent">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="white" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="LAW SMART">
	<link rel="shortcut icon" sizes="16x16" href="../assets/media/misc/LSC-icone.png">
	<link rel="shortcut icon" sizes="196x196" href="../assets/media/misc/LSC-icone.png">
	<link rel="apple-touch-icon-precomposed" href="../assets/media/misc/LSC-icone.png">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<link href="../assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
	<link href="../assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

	<link rel="apple-touch-icon" sizes="180x180" href="../assets/media/misc/LSC-icone.png">
	<link rel="stylesheet" type="text/css" href="../addtohomescreen.css">
	<script src="../addtohomescreen.js"></script>

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" style="background-image: url('../assets/media/misc/page-bg-dark.jpg')" class="dark-mode page-bg header-fixed header-tablet-and-mobile-fixed aside-enabled">
	<!--begin::Main-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="page d-flex flex-row flex-column-fluid">
			<!--begin::Wrapper-->
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<!--begin::Header-->
				<?php include("top.php"); ?>
				<!--end::Header-->
				<!--begin::Container-->
				<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
					<!--begin::Aside-->
					<?php include("side.php"); ?>
					<!--end::Aside-->
					<!--begin::Post-->
					<div class="content flex-row-fluid" id="kt_content">
						<!--begin::Row-->




						<div class="row g-5 g-xl-8">
							<div class="col-xl-12">


								<div class="row g-5 g-xl-8">

									<div class="col-xl-4">
										<!--begin::Statistics Widget 5-->
										<a href="#" class="card bg-white hoverable card-xl-stretch mb-xl-8">
											<!--begin::Body-->
											<div class="card-body">
												<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
												<span class="svg-icon svg-icon-info svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path d="M21 10H13V11C13 11.6 12.6 12 12 12C11.4 12 11 11.6 11 11V10H3C2.4 10 2 10.4 2 11V13H22V11C22 10.4 21.6 10 21 10Z" fill="black" />
														<path opacity="0.3" d="M12 12C11.4 12 11 11.6 11 11V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V11C13 11.6 12.6 12 12 12Z" fill="black" />
														<path opacity="0.3" d="M18.1 21H5.9C5.4 21 4.9 20.6 4.8 20.1L3 13H21L19.2 20.1C19.1 20.6 18.6 21 18.1 21ZM13 18V15C13 14.4 12.6 14 12 14C11.4 14 11 14.4 11 15V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18ZM17 18V15C17 14.4 16.6 14 16 14C15.4 14 15 14.4 15 15V18C15 18.6 15.4 19 16 19C16.6 19 17 18.6 17 18ZM9 18V15C9 14.4 8.6 14 8 14C7.4 14 7 14.4 7 15V18C7 18.6 7.4 19 8 19C8.6 19 9 18.6 9 18Z" fill="black" />
													</svg>
												</span>
												<?php
												$montantepositivo = new movimentacao();
												$montantepositivo = $montantepositivo->Get_MontantePositivo();
												$montantenegativo = new movimentacao();
												$montantenegativo = $montantenegativo->Get_MontanteNegativo();
												$mes_aplicado = new movimentacao();
												$mes_aplicado = $mes_aplicado->Get_Mes_Aplicado();
												$total_antecipado = new antecipadas();
												$total_antecipado = $total_antecipado->Total_Antecipado();
												$valormontante = ($montantepositivo["aportes"] - $montantenegativo["retiradas"]);
												$totaloperado_query = new antecipadas();
												$totaloperado_query = $totaloperado_query->Total_OperadoFluxoDisponivel();

												$conta_opera = new  operacoes();
												$conta_opera = $conta_opera->Count();

												$total_postergado = new operacoes();
												$total_postergado = $total_postergado->Total_PostergadoMes();
												$total_postergadoValue = $total_postergado['valor'];


												$totalpago_query = new boletos();
												$totalpago_query->setStatus(9);
												$totalpago_query = $totalpago_query->SelectTotalPago();


												$total_operado = 0;
												if ($totaloperado_query) {
													foreach ($totaloperado_query as $antecipacao) {
														if ($antecipacao['valor']) {
															$total_operado += $antecipacao['valor'];
														} else {
															$total_operado += 0;
														}
													}
												}

												?>
												<!--end::Svg Icon-->
												<div class="text-black fw-bolder fs-2 mb-2 mt-5">R$ <?php echo number_format($valormontante + $totalpago_query['total_pago'] - $total_operado - $total_postergadoValue, 2, ',', '.'); ?></div>
												<div class="fw-bold text-black">Saldo do Dia</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Statistics Widget 5-->
									</div>
									<div class="col-xl-4">
										<!--begin::Statistics Widget 5-->
										<a href="#" class="card bg-info hoverable card-xl-stretch mb-xl-8">
											<!--begin::Body-->
											<div class="card-body">
												<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
												<span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"></rect>
														<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black"></rect>
														<rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"></rect>
														<rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"></rect>
													</svg>
												</span>
												<!--end::Svg Icon-->
												<div class="text-white fw-bolder fs-2 mb-2 mt-5">R$ 0,00</div>
												<div class="fw-bold text-white">Entradas para Hoje</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Statistics Widget 5-->
									</div>


									<div class="col-xl-4">
										<!--begin::Statistics Widget 5-->
										<a href="#" class="card bg-danger hoverable card-xl-stretch mb-5 mb-xl-8">
											<!--begin::Body-->
											<div class="card-body">
												<!--begin::Svg Icon | path: icons/duotune/graphs/gra007.svg-->
												<span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M10.9607 12.9128H18.8607C19.4607 12.9128 19.9607 13.4128 19.8607 14.0128C19.2607 19.0128 14.4607 22.7128 9.26068 21.7128C5.66068 21.0128 2.86071 18.2128 2.16071 14.6128C1.16071 9.31284 4.96069 4.61281 9.86069 4.01281C10.4607 3.91281 10.9607 4.41281 10.9607 5.01281V12.9128Z" fill="black"></path>
														<path d="M12.9607 10.9128V3.01281C12.9607 2.41281 13.4607 1.91281 14.0607 2.01281C16.0607 2.21281 17.8607 3.11284 19.2607 4.61284C20.6607 6.01284 21.5607 7.91285 21.8607 9.81285C21.9607 10.4129 21.4607 10.9128 20.8607 10.9128H12.9607Z" fill="black"></path>
													</svg>
												</span>
												<?php
												$date = date('Y-m-d');
												$totaloperado = new operacoes();
												$totaloperado->setDataope($date);
												$totaloperado->setVencimento($date);
												$totaloperado = $totaloperado->TotalOperadoSaidasVencimento();
												$conta_opera = new operacoes();
												$conta_opera = $conta_opera->Count();
												?>
												<div class="text-white fw-bolder fs-2 mb-2 mt-5">R$ <?php echo number_format($totaloperado['valor'], 2, ',', '.'); ?></div>
												<div class="fw-bold text-white">Saidas Para hoje</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Statistics Widget 5-->
									</div>
								</div>
							</div>

						</div>



						<div class="row gy-5 g-xl-8">
							<!--begin::Col-->
							<div class="col-xl-12">
								<div class="col-xl-12">
									<div class="card mb-8 mb-xl-10">
										<div class="card-header border-0 pt-10">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bolder fs-3 mb-1">Fluxo do Periodo</span>
												<span class="text-muted mt-1 fw-bold fs-7">Abaixo listamos as todos fornecedores disponiveis no sistema.</span>
											</h3>
											<?php
											$inicio = isset($_GET['inicio']) ? htmlspecialchars($_GET['inicio']) : null;
											$termino = isset($_GET['termino']) ? htmlspecialchars($_GET['termino']) : null;
											$status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : null;
											$tipo = isset($_GET['tipo']) ? htmlspecialchars($_GET['tipo']) : null;

											?>
											<form name="filtro" method="get" style="width: 100%;" action="saidas.php">
												<div class="row">

													<div class="col-md-3">
														<select name="status" class="form-control">
															<option value="">Todas</option>
															<option value="4" <?php if ($status == "4") {
																					echo "selected";
																				} ?>>Postergado</option>
															<option value="1" <?php if ($status == "1") {
																					echo "selected";
																				} ?>>Antecipado</option>
														</select>
													</div>

													<div class="col-md-2">
														<input type="date" name="inicio" class="form-control" value="<?php echo $inicio; ?>">
													</div>
													<div class="col-md-2">
														<input type="date" name="termino" class="form-control" value="<?php echo $termino; ?>">
													</div>
													<div class="col-md-1">
														<input type="submit" name="envio" class="form-control" value="Filtrar">
													</div>
												</div>
											</form>
										</div>
										<div class="card-body py-3">
											<!--begin::Table container-->
											<div class="table-responsive">
												<!--begin::Table-->
												<table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="fluxo_table">
													<!--begin::Table head-->
													<thead>
														<tr class="fw-bolder text-muted">
															<th class="min-w-200px">Cliente</th>
															<th class="min-w-100px">Transação Id</th>
															<th class="min-w-120px">Data</th>
															<th class="min-w-80px">Valor</th>
															<th class="min-w-120px">Tipo</th>
															<th class="min-w-120px">Pag</th>
														</tr>
													</thead>
													<tbody>
														<!-- ///Antecipadas -->
														<?php
														if ($status == null || $status == 1) {
															$operacaoAntecipadas = new operacoes();
															$operacaoAntecipadas = $operacaoAntecipadas->GetOperacoesEntradasDia();
															foreach ($operacaoAntecipadas as $row) {
																$toReal = $row['total_detalhe_valor'] - $row['antecipacao_total_taxas'];
														?>

																<tr>
																	<td>
																		<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $row["razao"]; ?></a>
																		<span class="text-muted fw-bold text-muted d-block fs-7"><?php echo $row["cnpj"]; ?></span>
																	</td>

																	<td>
																		<a href="operacao.php?id=<?php echo $row['antecipacao_id'] ?>" class="text-dark fw-bolder text-hover-primary fs-6">0000<?php echo $row["antecipacao_id"]; ?></a>
																	</td>
																	<td>
																		<div class="fs-6 text-gray-800 fw-bolder"><?php echo date('d-m-Y', strtotime($row["antecipacao_data"])); ?></div>
																	</td>
																	<td>
																		<div class="fs-6 text-gray-800 fw-bolder">R$ <?php echo number_format($toReal, 2, ',', '.'); ?></div>
																	</td>
																	<td>
																		<span class="badge badge-light-success">Antecipação</span>
																	</td>
																	<td>
																		<span>
																			<a onclick="SaidasAntecipadas('<?php echo $row['antecipacao_id'] ?>','<?php echo number_format($row['total_detalhe_valor'], 2, '.', ''); ?>')">
																				<button data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Informar Pagamento" class="btn btn-active-icon-primary btn-active-text-primary" style="margin:0; padding:0;" id="efetuar-antecipadas">
																					<!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr016.svg-->
																					<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																							<path opacity="0.3" d="M10.3 14.3L11 13.6L7.70002 10.3C7.30002 9.9 6.7 9.9 6.3 10.3C5.9 10.7 5.9 11.3 6.3 11.7L10.3 15.7C9.9 15.3 9.9 14.7 10.3 14.3Z" fill="black" />
																							<path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM11.7 15.7L17.7 9.70001C18.1 9.30001 18.1 8.69999 17.7 8.29999C17.3 7.89999 16.7 7.89999 16.3 8.29999L11 13.6L7.70001 10.3C7.30001 9.89999 6.69999 9.89999 6.29999 10.3C5.89999 10.7 5.89999 11.3 6.29999 11.7L10.3 15.7C10.5 15.9 10.8 16 11 16C11.2 16 11.5 15.9 11.7 15.7Z" fill="black" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->
																				</button>
																			</a>
																		</span>
																	</td>
																</tr>
														<?php
															}
														}
														?>

														<!-- ///Postergadas -->
														<?php
														if ($status == null || $status == 4) {

															$operacao_Postegadas = new operacoes();
															$operacao_Postegadas = $operacao_Postegadas->GetOperacoesSaindasDia();
															foreach ($operacao_Postegadas as $row) {
														?>

																<tr>
																	<td>
																		<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $row["razao"]; ?></a>
																		<span class="text-muted fw-bold text-muted d-block fs-7"><?php echo $row["cnpj"]; ?></span>
																	</td>

																	<td>
																		<a href="operacao.php?id_postergacao=<?php echo $row['id_postergacao'] ?>" class="text-dark fw-bolder text-hover-primary fs-6">0000<?php echo $row["id_postergacao"]; ?></a>
																	</td>
																	<td>
																		<div class="fs-6 text-gray-800 fw-bolder"><?php echo date('d-m-Y', strtotime($row["postergacao_data"])); ?></div>
																	</td>
																	<td>
																		<div class="fs-6 text-gray-800 fw-bolder">R$ <?php echo number_format($row['total_detalhe_valorOriginal'], 2, ',', '.'); ?></div>
																	</td>
																	<td>
																		<span class="badge badge-light-danger"> Postergação </span>
																	</td>
																	<td>
																		<span>
																			<a onclick="SaidasPostergadas('<?php echo $row['id_postergacao'] ?>','<?php echo number_format($row['total_detalhe_valorOriginal'], 2, '.', ''); ?>')">
																				<button data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Informar Pagamento" class="btn btn-active-icon-primary btn-active-text-primary" style="margin:0; padding:0;" id="efetuar-antecipadas">
																					<!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr016.svg-->
																					<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																							<path opacity="0.3" d="M10.3 14.3L11 13.6L7.70002 10.3C7.30002 9.9 6.7 9.9 6.3 10.3C5.9 10.7 5.9 11.3 6.3 11.7L10.3 15.7C9.9 15.3 9.9 14.7 10.3 14.3Z" fill="black" />
																							<path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM11.7 15.7L17.7 9.70001C18.1 9.30001 18.1 8.69999 17.7 8.29999C17.3 7.89999 16.7 7.89999 16.3 8.29999L11 13.6L7.70001 10.3C7.30001 9.89999 6.69999 9.89999 6.29999 10.3C5.89999 10.7 5.89999 11.3 6.29999 11.7L10.3 15.7C10.5 15.9 10.8 16 11 16C11.2 16 11.5 15.9 11.7 15.7Z" fill="black" />
																						</svg>
																					</span>
																					<!--end::Svg Icon-->
																				</button>
																			</a>
																		</span>
																	</td>
																</tr>
														<?php }
														}
														?>



													</tbody>
													<!--end::Table body-->
												</table>
												<!--end::Table-->
											</div>
											<!--end::Table container-->
										</div>
									</div>
								</div>
							</div>



						</div>
						<!--end::Row-->
						<!--begin::Row-->

						<!--end::Row-->
					</div>
					<!--end::Post-->
				</div>
				<!--end::Container-->
				<!--begin::Footer-->
				<?php include("footer.php"); ?>
				<!--end::Footer-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>



	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<span class="svg-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
				<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
			</svg>
		</span>
	</div>
	<script>
		var hostUrl = "../assets/";
	</script>
	<script src="../assets/plugins/global/plugins.bundle.js"></script>
	<script src="../assets/js/scripts.bundle.js"></script>
	<script src="../assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
	<script src="../assets/js/custom/widgets.js"></script>
	<script src="../assets/js/custom/apps/chat/chat.js"></script>
	<script src="../assets/js/custom/modals/create-app.js"></script>
	<script src="../assets/js/custom/modals/upgrade-plan.js"></script>
	<script>
		function SaidasPostergadas(id_postergacao, valor) {

			var saldo = '<?php echo number_format($valormontante + $totalpago_query['total_pago'] - $total_operado - $total_postergadoValue, 2, '.', ''); ?>';
			if (parseFloat(valor) > parseFloat(saldo)) {
				Swal.fire({
					title: "Oops...",
					text: "Saldo Indisponível!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					cancelButtonText: 'Cancelar',
					confirmButtonText: "Recusar Operação!"
				}).then((result) => {
					if (result.isConfirmed) {
						let timerInterval;

						Swal.fire({
							title: "Aguarde...!",
							html: "Processando dados <b></b>",
							timer: 2000,
							timerProgressBar: true,
							didOpen: () => {
								Swal.showLoading();
								const timer = Swal.getPopup().querySelector("b");
								timerInterval = setInterval(() => {
									timer.textContent = `${Swal.getTimerLeft()}`;
								}, 100);
							},
							willClose: () => {
								clearInterval(timerInterval);
							}
						}).then((result) => {
							// Realiza a requisição AJAX independentemente de como o SweetAlert foi fechado
							$.ajax({
								url: 'saidas.php',
								method: 'POST',
								data: {
									a: 'RecusarPostergadas',
									id: id_postergacao
								}, // Se precisar de dados adicionais
								success: function(response) {
									Swal.fire({
										position: "top-end",
										icon: "success",
										title: "Processo finalizado com sucesso!",
										showConfirmButton: false,
										timer: 1500
									}).then((result) => {
										setTimeout(() => {
											location.reload();
										}, 1500);
									});

								},
								error: function(xhr, status, error) {
									console.error('Erro na requisição AJAX:', error);
								}
							});

							/* Read more about handling dismissals below */
							if (result.dismiss === Swal.DismissReason.timer) {
								console.log("I was closed by the timer");
							}
						});

					}
				});
			} else {
				Swal.fire({
					title: "Confirmar está Operação?",
					icon: "warning",
					showDenyButton: true,
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					denyButtonColor: '#E1B108',
					cancelButtonColor: "#d33",
					cancelButtonText: "Fechar",
					confirmButtonText: "Sim, Confirmar",
					denyButtonText: "Cancelar Operação"
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: 'saidas.php',
							type: 'POST',
							data: {
								a: 'confirmarPostergadas',
								id_postergacao: id_postergacao
							},
							success: function(response) {
								// Handle success response here
								Swal.fire({
									position: "top-end",
									icon: "success",
									title: "Confirmada com Sucesso!",
									showConfirmButton: false,
									timer: 1500
								}).then((result) => {
									// Após o alerta ser fechado
									location.reload(); // Recarrega a página
								});

							},
							error: function(xhr, status, error) {
								// Handle error here
								console.error('Error:', error);
							}
						});
						window.document.reload();
					} else if (result.isDenied) {
						let timerInterval;

						Swal.fire({
							title: "Aguarde...!",
							html: "Processando dados <b></b>",
							timer: 2000,
							timerProgressBar: true,
							didOpen: () => {
								Swal.showLoading();
								const timer = Swal.getPopup().querySelector("b");
								timerInterval = setInterval(() => {
									timer.textContent = `${Swal.getTimerLeft()}`;
								}, 100);
							},
							willClose: () => {
								clearInterval(timerInterval);
							}
						}).then((result) => {
							// Realiza a requisição AJAX independentemente de como o SweetAlert foi fechado
							$.ajax({
								url: 'saidas.php',
								method: 'POST',
								data: {
									a: 'RecusarPostergadas',
									id: id_postergacao
								}, // Se precisar de dados adicionais
								success: function(response) {
									Swal.fire({
										position: "top-end",
										icon: "success",
										title: "Processo finalizado com sucesso!",
										showConfirmButton: false,
										timer: 1500
									}).then((result) => {
										setTimeout(() => {
											location.reload();
										}, 1500);
									});

								},
								error: function(xhr, status, error) {
									console.error('Erro na requisição AJAX:', error);
								}
							});

							/* Read more about handling dismissals below */
							if (result.dismiss === Swal.DismissReason.timer) {
								console.log("I was closed by the timer");
							}
						});
					}
				});
			}
		}

		function SaidasAntecipadas(id, valor) {

			var saldo = '<?php echo number_format($valormontante + $totalpago_query['total_pago'] - $total_operado - $total_postergadoValue, 2, '.', ''); ?>';
			if (parseFloat(valor) > parseFloat(saldo)) {

				Swal.fire({
					title: "Oops...",
					text: "Saldo Indisponível!",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					cancelButtonText: 'Cancelar',
					confirmButtonText: "Recusar Operação!"
				}).then((result) => {
					if (result.isConfirmed) {
						let timerInterval;

						Swal.fire({
							title: "Aguarde...!",
							html: "Processando dados <b></b>",
							timer: 2000,
							timerProgressBar: true,
							didOpen: () => {
								Swal.showLoading();
								const timer = Swal.getPopup().querySelector("b");
								timerInterval = setInterval(() => {
									timer.textContent = `${Swal.getTimerLeft()}`;
								}, 100);
							},
							willClose: () => {
								clearInterval(timerInterval);
							}
						}).then((result) => {
							// Realiza a requisição AJAX independentemente de como o SweetAlert foi fechado
							$.ajax({
								url: 'saidas.php',
								method: 'POST',
								data: {
									a: 'RecusarAntecipadas',
									id: id
								}, // Se precisar de dados adicionais
								success: function(response) {
									Swal.fire({
										position: "top-end",
										icon: "success",
										title: "Processo finalizado com sucesso!",
										showConfirmButton: false,
										timer: 1500
									}).then((result) => {
										// Recarregar a página após 1500 milissegundos (1.5 segundos)
										setTimeout(() => {
											location.reload();
										}, 1500);
									});

								},
								error: function(xhr, status, error) {
									console.error('Erro na requisição AJAX:', error);
								}
							});

							/* Read more about handling dismissals below */
							if (result.dismiss === Swal.DismissReason.timer) {
								console.log("I was closed by the timer");
							}
						});

					}

				});
			} else {
				Swal.fire({
					title: "Confirmar está Operação?",
					icon: "warning",
					showDenyButton: true,
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					denyButtonColor: '#E1B108',
					cancelButtonColor: "#d33",
					cancelButtonText: "Fechar",
					confirmButtonText: "Sim, Confirmar",
					denyButtonText: "Cancelar Operação"
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: 'saidas.php',
							type: 'POST',
							data: {
								a: 'confirmar',
								id: id
							},
							success: function(response) {
								// Handle success response here
								Swal.fire({
									position: "top-end",
									icon: "success",
									title: "Confirmada com Sucesso!",
									showConfirmButton: false,
									timer: 1500
								}).then((result) => {
									// Após o alerta ser fechado
									location.reload(); // Recarrega a página
								});

							},
							error: function(xhr, status, error) {
								// Handle error here
								console.error('Error:', error);
							}
						});
						window.document.reload();
					} else if (result.isDenied) {
						let timerInterval;

						Swal.fire({
							title: "Aguarde...!",
							html: "Processando dados <b></b>",
							timer: 2000,
							timerProgressBar: true,
							didOpen: () => {
								Swal.showLoading();
								const timer = Swal.getPopup().querySelector("b");
								timerInterval = setInterval(() => {
									timer.textContent = `${Swal.getTimerLeft()}`;
								}, 100);
							},
							willClose: () => {
								clearInterval(timerInterval);
							}
						}).then((result) => {
							// Realiza a requisição AJAX independentemente de como o SweetAlert foi fechado
							$.ajax({
								url: 'saidas.php',
								method: 'POST',
								data: {
									a: 'RecusarAntecipadas',
									id: id
								}, // Se precisar de dados adicionais
								success: function(response) {
									Swal.fire({
										position: "top-end",
										icon: "success",
										title: "Processo finalizado com sucesso!",
										showConfirmButton: false,
										timer: 1500
									}).then((result) => {
										// Recarregar a página após 1500 milissegundos (1.5 segundos)
										setTimeout(() => {
											location.reload();
										}, 1500);
									});

								},
								error: function(xhr, status, error) {
									console.error('Erro na requisição AJAX:', error);
								}
							});

							/* Read more about handling dismissals below */
							if (result.dismiss === Swal.DismissReason.timer) {
								console.log("I was closed by the timer");
							}
						});
					}
				});
			}
		}
		var mergeSortRight = (itemList, index = 0) => {
			if (index > itemList.length - 1) return;
			const item = itemList[index];
			const date = new Date($(item.children[2]).children().html());
			const nextDate = new Date($(itemList[index + 1].children[2]).children().html());
			if (date > nextDate) {
				$(item).insertAfter($(item).next());
				return mergeSortRight(Object.values($("#fluxo_table tbody tr")), index)
			}
			if (index == 0) {
				return mergeSortRight(Object.values($("#fluxo_table tbody tr")), ++index)
			}

			const previousDate = new Date($(itemList[index - 1].children[2]).children().html());
			console.log('over item ', index);
			console.log('DATE CURRENT IS', date);
			if (date < previousDate) {
				$(item).insertBefore($(item));
				return mergeSortRight(Object.values($("#fluxo_table tbody tr")), --index)
			}
			return mergeSortRight(Object.values($("#fluxo_table tbody tr")), ++index)

		}
		$(document).ready(mergeSortRight(Object.values($("#fluxo_table tbody tr"))))
		var elem = document.documentElement;

		function openFullscreen() {
			if (elem.requestFullscreen) {
				elem.requestFullscreen();
			} else if (elem.webkitRequestFullscreen) {
				/* Safari */
				elem.webkitRequestFullscreen();
			} else if (elem.msRequestFullscreen) {
				/* IE11 */
				elem.msRequestFullscreen();
			}
		}

		function closeFullscreen() {
			if (document.exitFullscreen) {
				document.exitFullscreen();
			} else if (document.webkitExitFullscreen) {
				/* Safari */
				document.webkitExitFullscreen();
			} else if (document.msExitFullscreen) {
				/* IE11 */
				document.msExitFullscreen();
			}
		}

		$(document).ready(function() {
			addToHomescreen();
		});
		if (navigator.userAgent.match(/Android/i)) {
			window.scrollTo(0, 1);
		}
	</script>
</body>

</html>