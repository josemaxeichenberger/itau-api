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
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<base href="">
	<title>LawSmart</title>
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

	<link href="../assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
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

										<div class="card card-xl-stretch mb-xl-8">
											<!--begin::Body-->
											<div class="card-body p-0">
												<!--begin::Header-->
												<div class="px-9 pt-7 card-rounded h-275px w-100 bg-primary">
													<!--begin::Heading-->
													<div class="d-flex flex-stack">
														<h3 class="m-0 text-white fw-bolder fs-3">Maiores Riscos</h3>
													</div>

													<?php
													// $total_postergado = mysqli_fetch_assoc(mysqli_query($lawsmt, "select sum(postergacoesDetalhes.valorOriginal) as valor from operacoes
													// inner join postergacoesDetalhes on operacoes.id = postergacoesDetalhes.id_operacao
													// where operacoes.status = 5"));
													$total_postergado = new operacoes();
													$total_postergado = $total_postergado->Total_PostergadoValor();


													// $total_antecipado = mysqli_fetch_assoc(mysqli_query($lawsmt, "select distinct sum(antecipadasDetalhes.valorOriginal) as valor from antecipadas
													// left join antecipadasDetalhes on antecipadasDetalhes.antecipada = antecipadas.id
													// inner join operacoes on operacoes.id = antecipadasDetalhes.operacao
													//   and operacoes.status = 5
													// "));
													$total_antecipado = new operacoes();
													$total_antecipado = $total_antecipado->Total_AntecipadoAncora();
													// $conta_opera = mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT count(*) as totaloperacoes FROM operacoes")) or die(mysql_error());
													$conta_opera = new operacoes();
													$conta_opera = $conta_opera->Total_Postergado();

													?>
													<div class="d-flex text-center flex-column text-white pt-8">
														<span class="fw-bold fs-7">Total operado</span>
														<span class="fw-bolder fs-2x pt-1">R$ <?php echo number_format($total_postergado['valor'] + $total_antecipado['valor'], 2, ',', '.'); ?></span>
													</div>
												</div>


												<?php

												$antecipadas = new antecipadas();
												$antecipadas = $antecipadas->Antecipadas();
												foreach ($antecipadas as $ant) {
													$fornecedores = new fornecedores();
													$fornecedores->setId($ant['fornecedor']);
													$fornecedores = $fornecedores->SelectID();
													$taa = new antecipadas();
													$taa->setFornecedor($ant['fornecedor']);
													$taa = $taa->TotalAntecipadasFornecedor();
												?>

													<div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -90px">
														<div class="d-flex align-items-center mb-6">
															<div class="symbol symbol-45px w-40px me-5">
																<span class="symbol-label bg-lighten">
																	<span class="svg-icon svg-icon-1">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z" fill="black" />
																			<path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z" fill="black" />
																		</svg>
																	</span>
																</span>
															</div>
															<div class="d-flex align-items-center flex-wrap w-100">
																<div class="mb-1 pe-3 flex-grow-1">
																	<a href="fornecedor.php?id=<?php echo $fornecedores['id']; ?>" class="fs-5 text-gray-800 text-hover-primary fw-bolder"><?php echo substr($fornecedores["razao"], 0, 18); ?>...</a>
																</div>
																<div class="d-flex align-items-center">
																	<div class="fw-bolder fs-5 text-gray-800 pe-1">R$ <?php if ($taa['valor'] > 0) {
																															echo number_format($taa['valor'], 2, ',', '.');
																														} else {
																															echo '0,00';
																														} ?></div>
																	<span class="svg-icon svg-icon-5 svg-icon-success ms-1">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
																			<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
																		</svg>
																	</span>
																</div>
															</div>
														</div>
													</div>
													<div style="clear: both;">&nbsp;</div>
												<?php } ?>
											</div>
											<!--end::Body-->
										</div>
										<!--end::Mixed Widget 1-->
									</div>

									<div class="col-xl-8">
										<div class="col-md-12">
											<div class="card card-xl-stretch mb-xl-8">
												<!--begin::Header-->
												<div class="card-header border-0 pt-5">
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bolder fs-3 mb-1">Movimentação</span>
														<span class="text-muted fw-bold fs-7">Avaliando operações aprovadas</span>
													</h3>
													<!--begin::Toolbar-->

												</div>
												<!--end::Header-->
												<!--begin::Body-->
												<div class="card-body">
													<!--begin::Chart-->
													<canvas id="grafico_movimentacao" style="height: 400px;"></canvas>
													<!--end::Chart-->
												</div>
												<!--end::Body-->
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 mt-5 mt-lg-0">
												<!--begin::Mixed Widget 13-->
												<div>
													<a href="#" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
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
															// $totaloperado = new antecipadas();
															// $totaloperado = $totaloperado->SumValor_Total_Antecipadas();
															// $totaljuros = new antecipadas();
															// $totaljuros = $totaljuros->SumJuros_Total_Antecipadas();
															// $totaltaxas = new antecipadas();
															// $total_postergado = new operacoes();
															// $total_postergado = $total_postergado->Total_AntecipadoAncora();
															// $total_antecipado = new antecipadas();
															// $total_antecipado = $total_antecipado->Total_AntecipadoAncora();
															?>
															<div class="text-white fw-bolder fs-2 mb-2 mt-5">R$ <?php echo number_format($total_postergado['valor'] + $total_antecipado['valor'], 2, ',', '.'); //if($total_antecipado['valor'] > 0){ echo number_format($total_antecipado['valor'] + $total_postergado['valor'], 2, ',', '.');}else{ echo '0,00';} 
																												?></div>
															<div class="fw-bold text-white">Em Operação</div>
														</div>
														<!--end::Body-->
													</a>
												</div>
												<!--end::Mixed Widget 13-->
											</div>
											<div class="col-md-6 mb-5 mb-lg-0">
												<div>
													<a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
														<!--begin::Body-->
														<div class="card-body">
															<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
															<span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																	<rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"></rect>
																	<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black"></rect>
																	<rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"></rect>
																	<rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"></rect>
																</svg>
															</span>
															<?php
															$montantepositivo = new movimentacao();
															$montantepositivo = $montantepositivo->Get_MontantePositivo();
															$montantenegativo = new movimentacao();
															$montantenegativo = $montantenegativo->Get_MontanteNegativo();
															$totaloperado_query = new antecipadas();
															$totaloperado_query = $totaloperado_query->Total_Operado();
															$total_operado = 0;
															foreach ($totaloperado_query as $row) {
																$total_operado += $row['juros'];
															}
															$totaltaxas_query = new antecipadas();
															$totaltaxas_query = $totaltaxas_query->Total_Taxas();
															$total_taxas = 0;
															foreach ($totaltaxas_query as $row) {
																$total_taxas += $row['taxas'];
															}
															$totaldespesas = new movimentacao();
															$totaldespesas = $totaldespesas->Get_Total_Despesas();
															$total_postergado_query = new operacoes();
															$total_postergado_query = $total_postergado_query->Total_Postergado();
															$total_postergado = 0;
															foreach ($total_postergado_query as $row) {
																$total_postergado += $row['juros'] + $row['taxas'];
															}
															$valormontante = ($montantepositivo["aportes"] - $montantenegativo["retiradas"]);
															$TT = $valormontante - $totaldespesas['despesa'] + $total_postergado + $total_taxas + $total_operado;
															?>
															<?php  ?>
															<div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">R$ <?php if ($TT > 0) {
																														echo number_format($TT, 2, ',', '.');
																													} else {
																														echo "0,00";
																													} ?></div>
															<div class="fw-bold text-gray-400">Evolução</div>
														</div>
														<!--end::Body-->
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>

						</div>



						<div class="row gy-5 g-xl-8">
							<!--begin::Col-->
							<div class="col-xl-12">
								<div class="col-xl-12">
									<div class="card mb-5 mb-xl-8">
										<div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bolder fs-3 mb-1">Duplicatas Disponíveis</span>
												<span class="text-muted mt-1 fw-bold fs-7">Abaixo listamos as todas as duplicatas disponiveis no sistema.</span>
											</h3>

										</div>
										<div class="card-body py-3">

											<div class="card card-p-0 card-flush">
												<div class="card-header align-items-center py-5 gap-2 gap-md-5">
													<div class="card-title">
														<!--begin::Search-->
														<div class="d-flex align-items-center position-relative my-1">
															<span class="svg-icon svg-icon-1 position-absolute ms-4">...</span>
															<input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Filtre na tabela" />
														</div>
														<!--end::Search-->
														<!--begin::Export buttons-->
														<div id="kt_datatable_example_1_export" class="d-none"></div>
														<!--end::Export buttons-->
													</div>
													<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
														<!--begin::Export dropdown-->
														<button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
															Exportar
														</button>
														<!--begin::Menu-->
														<div id="kt_datatable_example_1_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true">
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="#" class="menu-link px-3" data-kt-export="copy">
																	Copiar
																</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="#" class="menu-link px-3" data-kt-export="excel">
																	Excel
																</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="#" class="menu-link px-3" data-kt-export="csv">
																	CSV
																</a>
															</div>
															<!--end::Menu item-->
															<!--begin::Menu item-->
															<div class="menu-item px-3">
																<a href="#" class="menu-link px-3" data-kt-export="pdf">
																	PDF
																</a>
															</div>
															<!--end::Menu item-->
														</div>
														<!--end::Menu-->
														<!--end::Export dropdown-->
													</div>
												</div>
											</div>
											<div class="table-responsive">
												<!--begin::Table-->
												<table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable_example_1">
													<!--begin::Table head-->
													<thead>
														<tr class="fw-bolder text-muted">
															<th class="min-w-200px">Razao Social</th>
															<th class="min-w-80px">Tipo</th>
															<th class="min-w-100px">Nota</th>
															<th class="min-w-100px">Data</th>
															<th class="min-w-120px">Valor (R$)</th>
															<th class="min-w-60px">Limite Tomado (R$)</th>
															<th class="min-w-80px">Tarifa %</th>
															<th class="min-w-120px">Status</th>
															<th class="min-w-120px">Data de Registro</th>

														</tr>
													</thead>
													<tbody>
														<?php
														$hoje = date("Y-m-d");
														$hoje_mais_10_dias = date("Y-m-d", strtotime($hoje . " +7 days"));
														$operacoes = new operacoes();
														$operacoes->setVencimento($hoje_mais_10_dias);
														$operacoes = $operacoes->Get_OperacoesVencomentoMaior();
														foreach ($operacoes as $ope) {
															$fornecedor = new fornecedores();
															$fornecedor->setCnpj($ope['cnpj']);
															$fornecedor = $fornecedor->SelectCnpj();
														?>
															<tr>
																<td>
																	<a href="fornecedor.php?id=<?php echo $fornecedor['id']; ?>" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $fornecedor["razao"]; ?></a>
																</td>
																<td>
																	<?php echo $fornecedor["tipo"]; ?>
																</td>
																<td>
																	<?php echo $ope["nota"]; ?>
																</td>
																<td>
																	<span style="display: none;"><?php echo date('Ymd', strtotime($ope["vencimento"])); ?></span>
																	<?php echo date('d/m/Y', strtotime($ope["vencimento"])); ?>
																</td>
																<td class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $ope["valor"]; ?></td>
																<td>
																	<?php echo $fornecedor["limite"]; ?>
																</td>
																<td>
																	<?php echo $fornecedor["juros"]; ?>
																</td>
																<td>
																	<?php if ($ope['status'] == '0') { ?>
																		<span class="badge badge-light-success">Disponível</span>
																	<?php } else { ?>
																		<span class="badge badge-light-danger">Operada</span>
																	<?php } ?>
																</td>
																<td class="text-dark fw-bolder text-hover-primary fs-6"> <?php echo date('d/m/Y H:i:s', strtotime($ope['created_at'])) ?></td>

															</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
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
	<script src="../assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="../assets/js/chart.js"></script>
	<script>
		"use strict";
		const ctx = document.getElementById('grafico_movimentacao');
		<?php
		$rows = array();
		$total_operacoes_mes = new operacoes();
		$total_operacoes_mes = $total_operacoes_mes->total_operacoes_mes_postergacoesDetalhes();

		foreach ($total_operacoes_mes as $r) {
			$rows = [$r['mes'] => $r['valor_total']];
		}
		?>
		const agrupadoMensal = <?php echo json_encode($rows); ?>
		// echo var_dump($total_operacoes_mes);
		console.log('AGRUPADOS MENSAL >>>', agrupadoMensal)

		// for (let i = 0; i<=11; i++) {

		// }
		const data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
		// const data = 
		Object.keys(agrupadoMensal).forEach((key, index) => {
			const month = key - 1
			// console.log('TOTAL VALUE IS', value)
			data[month] = agrupadoMensal[key]
		})

		// let data = []
		new Chart(ctx, {
			type: 'line',
			data: {
				labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
				datasets: [{
					label: 'Volume de transações',
					data,
					borderWidth: 1
				}]
			},
			options: {
				// scales: {
				// y: {
				// 	beginAtZero: true
				// }
				// }
				responsive: true,
				maintainAspectRatio: false
			}
		});
		// Class definition
		var KTDatatablesButtons = function() {
			// Shared variables
			var table;
			var datatable;

			// Private functions
			var initDatatable = function() {
				// Set date data order
				const tableRows = table.querySelectorAll('tbody tr');

				// tableRows.forEach(row => {
				// 	const dateRow = row.querySelectorAll('td');
				// 	if (dateRow.length > 3) { // Verifica se existe uma quarta coluna
				// 		const rawDate = dateRow[3].innerHTML.trim();
				// 		const realDate = moment(rawDate, "DD/MM/YYYY, LT");
				// 		if (realDate.isValid()) { // Verifica se a data é válida
				// 			dateRow[3].setAttribute('data-order', realDate.format());
				// 		} else {
				// 			console.warn(`Data inválida encontrada: ${rawDate}`);
				// 		}
				// 	} else {
				// 		console.warn('Linha com menos de 4 colunas encontrada:', row);
				// 	}
				// });


				// Init datatable --- more info on datatables: https://datatables.net/manual/
				datatable = $(table).DataTable({
					"info": false,
					order: [[3, 'asc']],
					'pageLength': 50,
				});
			}

			// Hook export buttons
			var exportButtons = () => {
				const documentTitle = 'Operações disponiveis - LAWSMART';
				var buttons = new $.fn.dataTable.Buttons(table, {
					buttons: [{
							extend: 'copyHtml5',
							title: documentTitle
						},
						{
							extend: 'excelHtml5',
							title: documentTitle
						},
						{
							extend: 'csvHtml5',
							title: documentTitle
						},
						{
							extend: 'pdfHtml5',
							title: documentTitle
						}
					]
				}).container().appendTo($('#kt_datatable_example_1_export'));

				// Hook dropdown menu click event to datatable export buttons
				const exportButtons = document.querySelectorAll('#kt_datatable_example_1_export_menu [data-kt-export]');
				exportButtons.forEach(exportButton => {
					exportButton.addEventListener('click', e => {
						e.preventDefault();

						// Get clicked export value
						const exportValue = e.target.getAttribute('data-kt-export');
						const target = document.querySelector('.dt-buttons .buttons-' + exportValue);

						// Trigger click event on hidden datatable export buttons
						target.click();
					});
				});
			}

			// Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
			var handleSearchDatatable = () => {
				const filterSearch = document.querySelector('[data-kt-filter="search"]');
				filterSearch.addEventListener('keyup', function(e) {
					datatable.search(e.target.value).draw();
				});
			}

			// Public methods
			return {
				init: function() {
					table = document.querySelector('#kt_datatable_example_1');

					if (!table) {
						return;
					}

					initDatatable();
					exportButtons();
					handleSearchDatatable();
				}
			};
		}();

		// On document ready
		KTUtil.onDOMContentLoaded(function() {
			KTDatatablesButtons.init();
		});

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