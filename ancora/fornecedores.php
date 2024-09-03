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
	<link href="../assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<link href="../assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
	<link href="../assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

	<link rel="apple-touch-icon" sizes="180x180" href="../assets/media/misc/LSC-icone.png">
	<link rel="stylesheet" type="text/css" href="../addtohomescreen.css">
	<script src="../addtohomescreen.js"></script>

</head>



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
									<div class="col-xl-6">
										<!--begin::Statistics Widget 5-->
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
												$montantepositivo  = new movimentacao();
												$montantepositivo  = $montantepositivo->Get_MontantePositivo();
												//= mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT SUM(valor) as aportes FROM movimentacao WHERE tipo = 'aporte'")) or die(mysqli_error());
												$montantenegativo = new movimentacao();
												$montantenegativo = $montantenegativo->Get_MontanteNegativo();
												//= mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT SUM(valor) as retiradas FROM movimentacao WHERE tipo = 'retirada'")) or die(mysqli_error());
												$totaloperado = new antecipadas();
												$totaloperado = $totaloperado->SumValor_Total_Antecipadas();

												//= mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT SUM(valor) as valor FROM antecipadas")) or die(mysql_error());
												$valormontante = ($montantepositivo["aportes"] - $montantenegativo["retiradas"] - $totaloperado["valor"]);

												?>
												<div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">R$ <?php if ($valormontante > 0) {
																											echo number_format($valormontante, 2, ',', '.');
																										} else {
																											echo "0,00";
																										} ?></div>
												<div class="fw-bold text-gray-400">EM caixa</div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Statistics Widget 5-->
									</div>


									<div class="col-xl-6">
										<!--begin::Statistics Widget 5-->
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

												$conta_opera = new operacoes();
												$conta_opera = $conta_opera->Count();
												//= mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT count(*) as totaloperacoes FROM operacoes")) or die(mysql_error());
												?>
												<div class="text-white fw-bolder fs-2 mb-2 mt-5">R$ <?php if ($totaloperado['valor'] > 0) {
																										echo number_format($totaloperado['valor'], 2, ',', '.');
																									} else {
																										echo '0,00';
																									} ?></div>
												<div class="fw-bold text-white">Em Operação</div>
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
									<div class="card mb-5 mb-xl-8">
										<div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bolder fs-3 mb-1">Clientes Habilitados</span>
												<span class="text-muted mt-1 fw-bold fs-7">Abaixo listamos as todos fornecedores disponiveis no sistema.</span>
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
															<th class="min-w-80px">Tipo</th>
															<th class="min-w-200px">Cliente</th>
															<th class="min-w-100px">CNPJ</th>
															<th class="min-w-120px">Limite</th>
															<th class="min-w-60px">Juros</th>
															<th class="min-w-80px">Valor Operado</th>
															<th class="min-w-50px">Data de Registro</th>
															<th class="min-w-120px">Status</th>
															<th class="min-w-100px text-end"></th>
														</tr>
													</thead>
													<tbody>
														<?php
														$fornecedores = new fornecedores();
														$fornecedores = $fornecedores->Select();
														// mysqli_query($lawsmt, "SELECT * FROM fornecedores");
														foreach ($fornecedores as $row) {
															$totaloperado = new antecipadas();
															$totaloperado->setFornecedor($row['id']);
															$totaloperado = $totaloperado->SumValorOriginal_Total_Antecipadas();

															//mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT SUM(valorOriginal) as valor FROM antecipadas WHERE fornecedor = '{$row['id']}'"));
														?>
															<tr>
																<td>
																	<a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $row['tipo']; ?></a>
																</td>
																<td>
																	<a href="fornecedor.php?id=<?php echo $row['id']; ?>" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $row['razao']; ?></a>
																	<a href="mailto:<?php echo $row['email']; ?>" class="text-dark text-hover-primary d-block mb-1 fs-8"><?php echo $row['email']; ?></a>
																</td>
																<td>
																	<a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $row['cnpj']; ?></a>
																</td>
																<td>
																	<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $row['limite']; ?></a>
																</td>
																<td>
																	<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $row['juros']; ?></a>
																</td>
																<td class="text-dark fw-bolder text-hover-primary fs-6">R$ <?php if ($totaloperado['valor'] > 0) {
																																echo number_format($totaloperado['valor'], 2, ',', '.');
																															} else {
																																echo "0,00";
																															} ?></td>
																<td class="text-dark fw-bolder text-hover-primary fs-6"> <?php echo date('d/m/Y H:i:s', strtotime($row['created_at'])) ?></td>

																<td>
																	<?php if ($row['status'] == 1) { ?>
																		<span class="badge badge-light-success">Liberado</span>
																	<?php }
																	if ($row['status'] == 0) { ?>
																		<span class="badge badge-light-danger">Bloqueado</span>
																	<?php } ?>
																</td>
																<td>
																	<div class="d-flex justify-content-end flex-shrink-0">
																		<span onClick="abre_dados(<?php echo $row['id'] ?>);" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">

																			<span class="svg-icon svg-icon-3">
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																					<path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="black"></path>
																					<path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="black"></path>
																				</svg>
																			</span>

																		</span>
																		<span onClick="Status('<?php echo $row['id'] ?>','<?php echo $row['status'] ?>');" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
																			<span class="svg-icon svg-icon-3">

																				<?php if ($row['status'] == 1) { ?>
																					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
																						<path fill="black" opacity="0.8" d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.2s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z" />
																					</svg>
																			</span>
																		<?php }
																				if ($row['status'] == 0) { ?>
																			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
																				<path fill="black" opacity="0.8" d="M323.8 477.2c-38.2 10.9-78.1-11.2-89-49.4l-5.7-20c-3.7-13-10.4-25-19.5-35l-51.3-56.4c-8.9-9.8-8.2-25 1.6-33.9s25-8.2 33.9 1.6l51.3 56.4c14.1 15.5 24.4 34 30.1 54.1l5.7 20c3.6 12.7 16.9 20.1 29.7 16.5s20.1-16.9 16.5-29.7l-5.7-20c-5.7-19.9-14.7-38.7-26.6-55.5c-5.2-7.3-5.8-16.9-1.7-24.9s12.3-13 21.3-13L448 288c8.8 0 16-7.2 16-16c0-6.8-4.3-12.7-10.4-15c-7.4-2.8-13-9-14.9-16.7s.1-15.8 5.3-21.7c2.5-2.8 4-6.5 4-10.6c0-7.8-5.6-14.3-13-15.7c-8.2-1.6-15.1-7.3-18-15.2s-1.6-16.7 3.6-23.3c2.1-2.7 3.4-6.1 3.4-9.9c0-6.7-4.2-12.6-10.2-14.9c-11.5-4.5-17.7-16.9-14.4-28.8c.4-1.3 .6-2.8 .6-4.3c0-8.8-7.2-16-16-16H286.5c-12.6 0-25 3.7-35.5 10.7l-61.7 41.1c-11 7.4-25.9 4.4-33.3-6.7s-4.4-25.9 6.7-33.3l61.7-41.1c18.4-12.3 40-18.8 62.1-18.8H384c34.7 0 62.9 27.6 64 62c14.6 11.7 24 29.7 24 50c0 4.5-.5 8.8-1.3 13c15.4 11.7 25.3 30.2 25.3 51c0 6.5-1 12.8-2.8 18.7C504.8 238.3 512 254.3 512 272c0 35.3-28.6 64-64 64l-92.3 0c4.7 10.4 8.7 21.2 11.8 32.2l5.7 20c10.9 38.2-11.2 78.1-49.4 89zM32 384c-17.7 0-32-14.3-32-32V128c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H32z" />
																			</svg> <?php } ?>


																		</span>
																	</div>
																</td>
															</tr>
														<?php } ?>
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




	<div class="modal fade" id="modal_dados" tabindex="-1" aria-labelledby="modal_dados" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content" id="conteudo_dados">

			</div>
		</div>
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
	<script src="../assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="jquery.mask.js"></script>
	<script>
		"use strict";

		// Class definition
		var KTDatatablesButtons = function() {
			// Shared variables
			var table;
			var datatable;

			// Private functions
			var initDatatable = function() {
				// Set date data order
				const tableRows = table.querySelectorAll('tbody tr');

				tableRows.forEach(row => {
					const dateRow = row.querySelectorAll('td');
					const realDate = moment(dateRow[2].innerHTML, "DD MMM YYYY, LT").format(); // select date from 4th column in table
					dateRow[3].setAttribute('data-order', realDate);
				});

				// Init datatable --- more info on datatables: https://datatables.net/manual/
				datatable = $(table).DataTable({
					"info": false,
					'order': [],
					'pageLength': 30,
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

		function isValidCPF(cpf) {

			cpf = cpf.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos

			if (cpf === '' || cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
				return false;
			}

			let soma = 0;
			for (let i = 0; i < 9; i++) {
				soma += parseInt(cpf.charAt(i)) * (10 - i);
			}

			let resto = (soma * 10) % 11;
			if (resto === 10 || resto === 11) {
				resto = 0;
			}

			if (resto !== parseInt(cpf.charAt(9))) {
				return false;
			}

			soma = 0;
			for (let i = 0; i < 10; i++) {
				soma += parseInt(cpf.charAt(i)) * (11 - i);
			}

			resto = (soma * 10) % 11;
			if (resto === 10 || resto === 11) {
				resto = 0;
			}

			return resto === parseInt(cpf.charAt(10));
		}

		function Status(id, status) {
			var msg = '';
			var statusSet = '';
			if (status == 1) {
				statusSet = 0;
				msg = 'Deseja realmente Inativar o fornecedor?';
			}
			if (status == 0) {
				statusSet = 1;
				msg = 'Deseja realmente Ativar o fornecedor?';
			}
			Swal.fire({
				title: msg,
				showDenyButton: true,
				showCancelButton: false,
				confirmButtonText: "Sim",
				denyButtonText: "Não"
			}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					$.ajax({
						type: 'POST',
						url: 'mod.php',
						data: {
							id: id,
							status: statusSet
						},
						// dataType: 'json',
						success: function(response) {
							Swal.fire("Salvo com sucesso!", "Confirmado", "success");
							setTimeout(function() {
								location.reload();
							}, 1000);
						},
						error: function(xhr, status, error) {
							Swal.fire("As alterações não foram salvas", "Erro", "info");
						}
					});

				} else if (result.isDenied) {
					Swal.fire("As alterações não foram salvas", "Cancelado", "info");
				}
			});
		}

		function abre_dados(id) {


			$('#conteudo_dados').hide();
			$('#modal_dados').modal('show');

			$.ajax({
				type: 'POST',
				data: 'id=' + id,
				url: "dados.php",
				success: function(msg) {

					$('#conteudo_dados').html(msg);
					$('#conteudo_dados').fadeIn();
					$('.money2').mask("#.##0,00", {
						reverse: true
					});
					$('#telefone').mask('(00) 00000-0000');
					$('#bancoF').mask('000');
					$('#contaF').mask('000000000000');
					$('#agenciaF').mask('00000000');
					$('#cpf').mask('000.000.000-00', {
						reverse: true
					});

					"use strict";
					var KTModalNewCard = (function() {
						var t, e, n, r, o, i;
						return {
							init: function() {
								(i = document.querySelector("#modal_dados")) &&
								((o = new bootstrap.Modal(i)),
									(r = document.querySelector("#kt_modal_new_card_form")),
									(t = document.getElementById("kt_modal_new_card_submit")),
									(e = document.getElementById("kt_modal_new_card_cancel")),

									(n = FormValidation.formValidation(r, {
										fields: {
											representante_nome: {
												validators: {
													notEmpty: {
														message: "Nome do Representante é obrigatório"
													}
												}
											},
											representante_sobrenome: {
												validators: {
													notEmpty: {
														message: "Sobrenome do Representante é obrigatório"
													}
												}
											},
											cpf: {
												validators: {
													notEmpty: {
														message: "CPF é obrigatório"
													},
													callback: {
														message: 'CPF inválido',
														callback: function(value, validator) {
															var cpf = value;

															return isValidCPF(cpf.value);

														}
													}
												}
											},
											telefone: {
												validators: {
													notEmpty: {
														message: "Telefone é obrigatório"
													}
												}
											},
											email: {
												validators: {
													notEmpty: {
														message: "E-mail é obrigatório"
													},
													emailAddress: {
														message: "E-mail inválido"
													}
												}
											},
											rua: {
												validators: {
													notEmpty: {
														message: "Rua é obrigatório"
													}
												}
											},
											numero: {
												validators: {
													notEmpty: {
														message: "Numero é obrigatório"
													}
												}
											},
											bairro: {
												validators: {
													notEmpty: {
														message: "Bairro é obrigatório"
													}
												}
											},
											cidade: {
												validators: {
													notEmpty: {
														message: "Cidade é obrigatório"
													}
												}
											},
											estado: {
												validators: {
													notEmpty: {
														message: "Estado é obrigatório"
													}
												}
											},
											limite: {
												validators: {
													notEmpty: {
														message: "Limite é obrigatório"
													}
												}
											},
											juros: {
												validators: {
													notEmpty: {
														message: "Juros é obrigatório"
													}
												}
											},
											boleto: {
												validators: {
													notEmpty: {
														message: "Boleto é obrigatório"
													}
												}
											},
											tac: {
												validators: {
													notEmpty: {
														message: "TAC é obrigatório"
													}
												}
											},
											ted: {
												validators: {
													notEmpty: {
														message: "TED é obrigatório"
													}
												}
											},
										},
										plugins: {
											trigger: new FormValidation.plugins.Trigger(),
											bootstrap: new FormValidation.plugins.Bootstrap5({
												rowSelector: ".fv-row",
												eleInvalidClass: "",
												eleValidClass: ""
											})
										},
									})),
									t.addEventListener("click", function(e) {
										e.preventDefault(),
											n &&
											n.validate().then(function(e) {

												if (e == 'Valid') {

													t.setAttribute("data-kt-indicator", "on");
													t.disabled = !0;

													$.ajax({
														type: "POST",
														url: "alterarDados.php",
														data: {
															id: $("#idF").val(),
															representante: $("#representante").val(),
															representante2: $("#representante2").val(),
															cpf: $("#cpf").val(),
															telefone: $("#telefone").val(),
															email: $("#email").val(),
															rua: $("#rua").val(),
															numero: $("#numero").val(),
															bairro: $("#bairro").val(),
															cidade: $("#cidade").val(),
															estado: $("#estado").val(),
															limite: $("#limite").val(),
															juros: $("#juros").val(),
															boleto: $("#boleto").val(),
															tac: $("#tac").val(),
															ted: $("#ted").val(),
															banco: $('#bancoF').val(),
															agencia: $('#agenciaF').val(),
															conta: $('#contaF').val()
														},
														success: function(response) {
															// Handle the successful response here
															Swal.fire({
																text: "Salvo com sucesso",
																icon: "success",
																buttonsStyling: !1,
																confirmButtonText: "Ok!",
																customClass: {
																	confirmButton: "btn btn-primary"
																}
															}).then(
																function(t) {
																	// $('#modal_dados').modal('hide');
																	// $('.modal-backdrop').removeClass('show');
																	// t.isConfirmed && o.hide();
																	// $('#conteudo_dados').hide();
																	// t.removeAttribute("data-kt-indicator");
																	// t.disabled = !1;
																	window.location.reload();
																}
															);


														},
														error: function(error) {
															t.removeAttribute("data-kt-indicator");
															t.disabled = !1
															// Handle errors here
															Swal.fire({
																text: "Desculpe, parece que foram detectados alguns erros. Tente novamente.",
																icon: "error",
																buttonsStyling: !1,
																confirmButtonText: "Ok!",
																customClass: {
																	confirmButton: "btn btn-primary"
																},
															});

														}
													});


												} else {
													Swal.fire({
														text: "Desculpe, parece que foram detectados alguns erros. Tente novamente.",
														icon: "error",
														buttonsStyling: !1,
														confirmButtonText: "Ok!",
														customClass: {
															confirmButton: "btn btn-primary"
														},
													});
												}




											});
									}),
									e.addEventListener("click", function(t) {
										t.preventDefault(),
											Swal.fire({
												text: "Tem certeza de que deseja cancelar?",
												icon: "warning",
												showCancelButton: !0,
												buttonsStyling: !1,
												confirmButtonText: "Sim, cancele!",
												cancelButtonText: "Não",
												customClass: {
													confirmButton: "btn btn-primary",
													cancelButton: "btn btn-active-light"
												},
											}).then(function(t) {
												t.value ?
													($('#conteudo_dados').hide(),
														$('#modal_dados').modal('hide'), $('.modal-backdrop').removeClass('show')) :
													"cancel" === t.dismiss && Swal.fire({
														text: "Seu formulário não foi cancelado!",
														icon: "error",
														buttonsStyling: !1,
														confirmButtonText: "Ok!",
														customClass: {
															confirmButton: "btn btn-primary"
														}
													});
											});
									}));
							},
						};
					})();
					KTUtil.onDOMContentLoaded(function() {
						KTModalNewCard.init();
					});


				}
			});

		}

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

		function isValidEmail(email) {
			// Regular expression for basic email validation
			const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			return emailRegex.test(email);
		}

		// Example usage:
		// const userEmail = "test@example.com";
		// if (isValidEmail(userEmail)) {
		// 	console.log("Valid email address");
		// } else {
		// 	console.log("Invalid email address");
		// }
	</script>
</body>

</html>