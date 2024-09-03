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
error_reporting(E_ALL);
ini_set('display_errors', '1');

$status = isset($_GET["status"]) ? htmlspecialchars($_GET["status"]) : null;
$inicio = isset($_GET["inicio"]) ? htmlspecialchars($_GET["inicio"]) : null;
$termino = isset($_GET["termino"]) ? htmlspecialchars($_GET["termino"]) : null;

// 
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
	<link rel="shortcut icon" href="../assets/misc/LSC-icone.png" />

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
						<div class="row gy-5 g-xl-8 d-flex align-items-center mt-lg-0 mb-10 mb-lg-15">
							<!--begin::Col-->
							<div class="col-xl-8 d-flex align-items-center">
								<h1 class="fs-2hx text-white">Bem vindo,
									<br /><?php echo $_SESSION["razao"]; ?>.
								</h1>

							</div>
							<h3 class="text-white">Client_id: <span id="client_id" data-original-text="<?php echo $_SESSION["client_id"]; ?>"><?php echo $_SESSION["client_id"]; ?></span>
								<button onclick="copyText('client_id')" class="btn btn-success"><i class="fa fa-solid fa-copy"></i></button>
								<button onclick="toggleMask('client_id')" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" style="width: 20px;" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
										<path fill="#CCC" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
									</svg></button>
							</h3>
							<h3 class="text-white">Secret_id: <span id="secret_id" data-original-text="<?php echo $_SESSION["secret_id"]; ?>"><?php echo $_SESSION["secret_id"]; ?></span>
								<button onclick="copyText('secret_id')" class="btn btn-success"><i class="fa fa-solid fa-copy"></i></button>
								<button onclick="toggleMask('secret_id')" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" style="width: 20px;" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
										<path fill="#CCC" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
									</svg></button>
							</h3>
							<!--end::Col-->
							<!--begin::Col-->
							<div class="col-xl-4">
								<div class="d-flex flex-stack ps-lg-20">

									<a href="index.php" class="btn btn-icon btn-outline btn-nav active h-50px w-50px h-lg-70px w-lg-70px ms-2">
										<!--begin::Svg Icon | path: icons/duotune/technology/teh008.svg-->
										<span class="svg-icon svg-icon-1 svg-icon-lg-2hx">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M11 6.5C11 9 9 11 6.5 11C4 11 2 9 2 6.5C2 4 4 2 6.5 2C9 2 11 4 11 6.5ZM17.5 2C15 2 13 4 13 6.5C13 9 15 11 17.5 11C20 11 22 9 22 6.5C22 4 20 2 17.5 2ZM6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13ZM17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13Z" fill="black" />
												<path d="M17.5 16C17.5 16 17.4 16 17.5 16L16.7 15.3C16.1 14.7 15.7 13.9 15.6 13.1C15.5 12.4 15.5 11.6 15.6 10.8C15.7 9.99999 16.1 9.19998 16.7 8.59998L17.4 7.90002H17.5C18.3 7.90002 19 7.20002 19 6.40002C19 5.60002 18.3 4.90002 17.5 4.90002C16.7 4.90002 16 5.60002 16 6.40002V6.5L15.3 7.20001C14.7 7.80001 13.9 8.19999 13.1 8.29999C12.4 8.39999 11.6 8.39999 10.8 8.29999C9.99999 8.19999 9.20001 7.80001 8.60001 7.20001L7.89999 6.5V6.40002C7.89999 5.60002 7.19999 4.90002 6.39999 4.90002C5.59999 4.90002 4.89999 5.60002 4.89999 6.40002C4.89999 7.20002 5.59999 7.90002 6.39999 7.90002H6.5L7.20001 8.59998C7.80001 9.19998 8.19999 9.99999 8.29999 10.8C8.39999 11.5 8.39999 12.3 8.29999 13.1C8.19999 13.9 7.80001 14.7 7.20001 15.3L6.5 16H6.39999C5.59999 16 4.89999 16.7 4.89999 17.5C4.89999 18.3 5.59999 19 6.39999 19C7.19999 19 7.89999 18.3 7.89999 17.5V17.4L8.60001 16.7C9.20001 16.1 9.99999 15.7 10.8 15.6C11.5 15.5 12.3 15.5 13.1 15.6C13.9 15.7 14.7 16.1 15.3 16.7L16 17.4V17.5C16 18.3 16.7 19 17.5 19C18.3 19 19 18.3 19 17.5C19 16.7 18.3 16 17.5 16Z" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon-->
									</a>
									<a href="operacoes.php" class="btn btn-icon btn-outline btn-nav h-50px w-50px h-lg-70px w-lg-70px ms-2">
										<!--begin::Svg Icon | path: icons/duotune/art/art002.svg-->
										<span class="svg-icon svg-icon-1 svg-icon-lg-2hx">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
												<path opacity="0.3" d="M8.9 21L7.19999 22.6999C6.79999 23.0999 6.2 23.0999 5.8 22.6999L4.1 21H8.9ZM4 16.0999L2.3 17.8C1.9 18.2 1.9 18.7999 2.3 19.1999L4 20.9V16.0999ZM19.3 9.1999L15.8 5.6999C15.4 5.2999 14.8 5.2999 14.4 5.6999L9 11.0999V21L19.3 10.6999C19.7 10.2999 19.7 9.5999 19.3 9.1999Z" fill="black" />
												<path d="M21 15V20C21 20.6 20.6 21 20 21H11.8L18.8 14H20C20.6 14 21 14.4 21 15ZM10 21V4C10 3.4 9.6 3 9 3H4C3.4 3 3 3.4 3 4V21C3 21.6 3.4 22 4 22H9C9.6 22 10 21.6 10 21ZM7.5 18.5C7.5 19.1 7.1 19.5 6.5 19.5C5.9 19.5 5.5 19.1 5.5 18.5C5.5 17.9 5.9 17.5 6.5 17.5C7.1 17.5 7.5 17.9 7.5 18.5Z" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon-->
									</a>
									<a href="fornecedores.php" class="btn btn-icon btn-outline btn-nav h-50px w-50px h-lg-70px w-lg-70px ms-2">
										<!--begin::Svg Icon | path: icons/duotune/abstract/abs042.svg-->
										<span class="svg-icon svg-icon-1 svg-icon-lg-2hx">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M18 21.6C16.6 20.4 9.1 20.3 6.3 21.2C5.7 21.4 5.1 21.2 4.7 20.8L2 18C4.2 15.8 10.8 15.1 15.8 15.8C16.2 18.3 17 20.5 18 21.6ZM18.8 2.8C18.4 2.4 17.8 2.20001 17.2 2.40001C14.4 3.30001 6.9 3.2 5.5 2C6.8 3.3 7.4 5.5 7.7 7.7C9 7.9 10.3 8 11.7 8C15.8 8 19.8 7.2 21.5 5.5L18.8 2.8Z" fill="black" />
												<path opacity="0.3" d="M21.2 17.3C21.4 17.9 21.2 18.5 20.8 18.9L18 21.6C15.8 19.4 15.1 12.8 15.8 7.8C18.3 7.4 20.4 6.70001 21.5 5.60001C20.4 7.00001 20.2 14.5 21.2 17.3ZM8 11.7C8 9 7.7 4.2 5.5 2L2.8 4.8C2.4 5.2 2.2 5.80001 2.4 6.40001C2.7 7.40001 3.00001 9.2 3.10001 11.7C3.10001 15.5 2.40001 17.6 2.10001 18C3.20001 16.9 5.3 16.2 7.8 15.8C8 14.2 8 12.7 8 11.7Z" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon-->
									</a>
								</div>
							</div>
							<!--end::Col-->
						</div>

						<div class="row g-5 g-xl-8">
							<div class="col-xl-6">
								<!--begin::Charts Widget 4-->
								<div class="card card-xl-stretch mb-5 mb-xl-8">
									<!--begin::Header-->
									<div class="card-header border-0 pt-5">
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bolder fs-3 mb-1">Evolução de Negócio (clientes + fornecedores)</span>
											<span class="text-muted fw-bold fs-7">Avaliando valor aplicado em comparação a CDI</span>
										</h3>
										<!--begin::Toolbar-->

										<!--end::Toolbar-->
									</div>
									<!--end::Header-->
									<!--begin::Body-->
									<div class="card-body">
										<!--begin::Chart-->
										<canvas id="grafico_evolucao" style="height: 350px"></canvas>
										<!--end::Chart-->
									</div>
									<!--end::Body-->
								</div>
								<!--end::Charts Widget 4-->
							</div>
							<div class="col-xl-6">
								<div class="row g-5 g-xl-8">
									<div class="col-md-12">
										<div class="card card-xl-stretch mb-xl-8">
											<!--begin::Header-->
											<div class="card-header border-0 pt-5">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label fw-bolder fs-3 mb-1">Liquidez</span>
													<span class="text-muted fw-bold fs-7">Avaliando operações aprovadas</span>
												</h3>
												<!--begin::Toolbar-->

											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body">
												<!--begin::Chart-->
												<canvas id="grafico_liquidez" style="height: 350px"></canvas>
												<!--end::Chart-->
											</div>
											<!--end::Body-->
										</div>
									</div>
								</div>

								<div class="row g-5 g-xl-8">
									<div class="col-xl-6">
										<!--begin::Statistics Widget 5-->
										<a href="#" class="card bg-body hoverable card-xl-stretch mt-5 mt-md-0 mb-xl-8">
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
												$mes_aplicado = new movimentacao();
												$mes_aplicado = $mes_aplicado->Get_Mes_Aplicado();
												$total_antecipado = new antecipadas();
												$total_antecipado = $total_antecipado->Total_Antecipado();
												$valormontante = ($montantepositivo["aportes"] - $montantenegativo["retiradas"]);
												?>
												<div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">R$ <?php echo number_format($valormontante, 2, ',', '.'); ?></div>
												<div class="fw-bold text-gray-400"><small>Valor Aplicado (Prazo médio <strong>90 dias</strong>)</small></div>
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
												$total_operado_antecipadas = new antecipadas();
												$res = $total_operado_antecipadas->Total_Operado();
												$total_operado = 0;
												foreach ($res as  $value) {
													$total_operado += $value['juros'];
												}


												$totaltaxas_query = new antecipadas();
												$totaltaxas_query = $totaltaxas_query->Total_Taxas();


												$total_taxas = 0;
												foreach ($totaltaxas_query as $row) {
													$total_taxas += $row['taxas'];
												}

												$totaldespesas = new movimentacao();
												$totaldespesas = $totaldespesas->Get_Total_Despesas();

												$total_postergado_operacoes = new operacoes();
												$total_postergado_operacoes = $total_postergado_operacoes->Total_Postergado();
												$total_postergado = 0;
												foreach ($total_postergado_operacoes as $row) {
													$total_postergado += ($row['taxas'] + $row['juros']);
												}

												$total_lucro = $total_operado + $total_taxas - $totaldespesas['despesa'] + $total_postergado;
												?>
												<div class="text-white fw-bolder fs-2 mb-2 mt-5">R$ <?php echo number_format($valormontante - $totaldespesas['despesa'] + $total_postergado + $total_taxas + $total_operado, 2, ',', '.'); ?></div>
												<div class="fw-bold text-white"><small>Valor Atualizado</small></div>
											</div>
											<!--end::Body-->
										</a>
										<!--end::Statistics Widget 5-->
									</div>
								</div>
							</div>

						</div>

						<div class="row g-5 g-xl-8">
							<div class="col-xl-4">
								<!--begin::Statistics Widget 4-->
								<div class="card card-xl-stretch mb-xl-8">
									<!--begin::Body-->
									<div class="card-body p-0">
										<div class="d-flex flex-stack card-p flex-grow-1">
											<span class="symbol symbol-50px me-2">
												<span class="symbol-label bg-light-info">
													<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm002.svg-->
													<span class="svg-icon svg-icon-2x svg-icon-info">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path d="M21 10H13V11C13 11.6 12.6 12 12 12C11.4 12 11 11.6 11 11V10H3C2.4 10 2 10.4 2 11V13H22V11C22 10.4 21.6 10 21 10Z" fill="black" />
															<path opacity="0.3" d="M12 12C11.4 12 11 11.6 11 11V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V11C13 11.6 12.6 12 12 12Z" fill="black" />
															<path opacity="0.3" d="M18.1 21H5.9C5.4 21 4.9 20.6 4.8 20.1L3 13H21L19.2 20.1C19.1 20.6 18.6 21 18.1 21ZM13 18V15C13 14.4 12.6 14 12 14C11.4 14 11 14.4 11 15V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18ZM17 18V15C17 14.4 16.6 14 16 14C15.4 14 15 14.4 15 15V18C15 18.6 15.4 19 16 19C16.6 19 17 18.6 17 18ZM9 18V15C9 14.4 8.6 14 8 14C7.4 14 7 14.4 7 15V18C7 18.6 7.4 19 8 19C8.6 19 9 18.6 9 18Z" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
												</span>
											</span>
											<div class="d-flex flex-column text-end">
												<span class="text-muted fw-bold mt-1">Fluxo Disponível</span>
												<?php

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
												<span class="text-dark fw-bolder fs-2">R$ <?php echo number_format($valormontante + $totalpago_query['total_pago'] - $total_operado - $total_postergadoValue, 2, ',', '.'); ?></span>
												<span class="text-muted fw-bold mt-1">para fornecedores e clientes</span>
											</div>
										</div>
									</div>
									<!--end::Body-->
								</div>
								<!--end::Statistics Widget 4-->
							</div>
							<div class="col-xl-4">
								<!--begin::Statistics Widget 4-->
								<div class="card card-xl-stretch mb-xl-8">
									<!--begin::Body-->
									<div class="card-body p-0">
										<div class="d-flex flex-stack card-p flex-grow-1">
											<span class="symbol symbol-50px me-2">
												<span class="symbol-label bg-light-success">
													<!--begin::Svg Icon | path: icons/duotune/finance/fin001.svg-->
													<span class="svg-icon svg-icon-2x svg-icon-success">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path d="M20 19.725V18.725C20 18.125 19.6 17.725 19 17.725H5C4.4 17.725 4 18.125 4 18.725V19.725H3C2.4 19.725 2 20.125 2 20.725V21.725H22V20.725C22 20.125 21.6 19.725 21 19.725H20Z" fill="black" />
															<path opacity="0.3" d="M22 6.725V7.725C22 8.325 21.6 8.725 21 8.725H18C18.6 8.725 19 9.125 19 9.725C19 10.325 18.6 10.725 18 10.725V15.725C18.6 15.725 19 16.125 19 16.725V17.725H15V16.725C15 16.125 15.4 15.725 16 15.725V10.725C15.4 10.725 15 10.325 15 9.725C15 9.125 15.4 8.725 16 8.725H13C13.6 8.725 14 9.125 14 9.725C14 10.325 13.6 10.725 13 10.725V15.725C13.6 15.725 14 16.125 14 16.725V17.725H10V16.725C10 16.125 10.4 15.725 11 15.725V10.725C10.4 10.725 10 10.325 10 9.725C10 9.125 10.4 8.725 11 8.725H8C8.6 8.725 9 9.125 9 9.725C9 10.325 8.6 10.725 8 10.725V15.725C8.6 15.725 9 16.125 9 16.725V17.725H5V16.725C5 16.125 5.4 15.725 6 15.725V10.725C5.4 10.725 5 10.325 5 9.725C5 9.125 5.4 8.725 6 8.725H3C2.4 8.725 2 8.325 2 7.725V6.725L11 2.225C11.6 1.925 12.4 1.925 13.1 2.225L22 6.725ZM12 3.725C11.2 3.725 10.5 4.425 10.5 5.225C10.5 6.025 11.2 6.725 12 6.725C12.8 6.725 13.5 6.025 13.5 5.225C13.5 4.425 12.8 3.725 12 3.725Z" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
												</span>
											</span>
											<div class="d-flex flex-column text-end">
												<span class="text-muted fw-bold mt-1">Postergado no Mês</span>
												<?php
												$totaloperado = new operacoes();
												$totaloperado->ValorTotalOperado();
												$conta_opera = new  operacoes();
												$conta_opera = $conta_opera->Count();
												$total_postergado_mes = new operacoes();
												$total_postergado_mes = $total_postergado_mes->Total_PostergadoMes();

												if ($total_postergado_mes['total_titulos'] > 0) {
													$formatado = number_format($total_postergado_mes["valor"], 2, ',', '.');
												} else {
													$formatado =  '0,00'; // Ou qualquer valor padrão desejado
												}
												?>
												<span class="text-dark fw-bolder fs-2">R$ <?php echo $formatado; ?></span>
												<span class="text-muted fw-bold mt-1">Em <?php echo $total_postergado_mes["total_titulos"] ?> títulos</span>
											</div>
										</div>
									</div>
									<!--end::Body-->
								</div>
								<!--end::Statistics Widget 4-->
							</div>
							<div class="col-xl-4">
								<!--begin::Statistics Widget 4-->
								<div class="card card-xl-stretch mb-5 mb-xl-8">
									<!--begin::Body-->
									<div class="card-body p-0">
										<div class="d-flex flex-stack card-p flex-grow-1">
											<span class="symbol symbol-50px me-2">
												<span class="symbol-label bg-light-primary">
													<!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
													<span class="svg-icon svg-icon-2x svg-icon-primary">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="black" />
															<path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
												</span>
											</span>
											<div class="d-flex flex-column text-end">
												<span class="text-muted fw-bold mt-1">Antecipado no mês</span>
												<?php
												$totaloperado_mes = new antecipadas();
												$totaloperado_mes = $totaloperado_mes->Total_OperadoMes();
												$ant = new antecipadas();
												$ant->setId($totaloperado_mes['antecipada']);
												$ant = $ant->Select();
												if (isset($totaloperado_mes['valor'])) {
													$totaloperado_mesV = $totaloperado_mes['valor'];
												} else {
													$totaloperado_mesV = 0.00;
												}
												$conta_opera_mes = new antecipadas();
												$conta_opera_mes = $conta_opera_mes->CountConfirmadas();
												?>
												<span class="text-dark fw-bolder fs-2">R$ <?php echo number_format($totaloperado_mesV, 2, ',', '.'); ?></span>
												<span class="text-muted fw-bold mt-1">Em <?php echo $conta_opera_mes['antecipadas']; ?> títulos</span>
											</div>
										</div>
									</div>
									<!--end::Body-->
								</div>
								<!--end::Statistics Widget 4-->
							</div>
						</div>

						<div class="row gy-5 g-xl-8">
							<!--begin::Col-->
							<div class="col-xl-12">
								<div class="col-xl-12">
									<div class="card mb-5 mb-xl-8">
										<div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bolder fs-3 mb-1">Últimas Operações Realizadas</span>
												<span class="text-muted mt-1 fw-bold fs-7">Abaixo listamos as últimas operações realizadas.</span>
											</h3>

										</div>
										<div class="card-body py-3">
											<form name="filtro" method="get" style="width: 100%;" action="index.php">
												<div class="row">
													<div class="col-md-3">
														<select name="status" class="form-control">
															<option value="">Todas</option>
															<option value="4" <?php //if($status == "4") { echo "selected"; } 
																				?>>Assinado</option>
															<option value="1" <?php //if($status == "1") { echo "selected"; } 
																				?>>Não Assinado</option>
														</select>
													</div>

													<div class="col-md-2">
														<input type="date" name="inicio" class="form-control" value="<?php echo $inicio; ?>">
													</div>
													<div class="col-md-2">
														<input type="date" name="termino" class="form-control" value="<?php echo $termino; ?>">
													</div>
													<div class="col-md-1 col-sm-2">
														<input type="submit" name="envio" class="form-control" value="Filtrar">
													</div>
													<div class="card-toolbar flex-row-fluid justify-content-end col-md-2">
														<button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
															Exportar
														</button>
														<div id="kt_datatable_example_1_export" class="d-none"></div>

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
													</div>
												</div>
											</form>
											<!-- <div class="card card-p-0 card-flush">
												<div class="card-header align-items-center py-5 gap-2 gap-md-5">
													<div class="card-title">
													
													 <div class="d-flex align-items-center position-relative my-1">
														<span class="svg-icon svg-icon-1 position-absolute ms-4">...</span>
														<input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Filtre na tabela" />
													</div> 
													
													
														<div id="kt_datatable_example_1_export" class="d-none"></div>
													
														</div>
														<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
													
															<button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
																Exportar
															</button>
															<div id="kt_datatable_example_1_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true">
																<div class="menu-item px-3">
																<a href="#" class="menu-link px-3" data-kt-export="copy">
																Copiar
																</a>
																</div>
																<div class="menu-item px-3">
																<a href="#" class="menu-link px-3" data-kt-export="excel">
																Excel
																</a>
																</div>
																
																<div class="menu-item px-3">
																<a href="#" class="menu-link px-3" data-kt-export="csv">
																CSV
																</a>
																</div>
																
																<div class="menu-item px-3">
																<a href="#" class="menu-link px-3" data-kt-export="pdf">
																PDF
																</a>
																</div>
																
															</div>
														
														</div>
											  		</div>
											</div> -->
											<div class="table-responsive">
												<!--begin::Table-->
												<table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable_example_1">
													<!--begin::Table head-->
													<thead>
														<tr class="fw-bolder text-muted">
															<th class="min-w-200px">Fornecedor/Cliente</th>
															<th class="min-w-100px">Transação Id</th>
															<th class="min-w-80px">Tipo</th>
															<th class="min-w-120px">Data</th>
															<th class="min-w-80px">Valor</th>
															<th class="min-w-80px">Assinado</th>
															<th class="min-w-120px">Status</th>
															<!-- <th class="min-w-120px">Pago</pth> -->
														</tr>
													</thead>
													<tbody>

														<?php
														$vertice = array();
														$list = array();

														$multiple_ids = new operacoes();
														$multiple_ids = $multiple_ids->UltimasOperacoesRealizadas_ancora($status, $inicio, $termino);
														foreach ($multiple_ids as $multiple_row) {

															$vertice[$multiple_row['id']] = explode(',', $multiple_row['multiple_ids']);
															for ($i = 0; $i < count($vertice[$multiple_row['id']]); $i++) {
																array_push($list, $vertice[$multiple_row['id']][$i]);
															}
														}
														foreach ($vertice as $key => $value) {
															$values = implode(',', $value);

															$antecipadas_agrupadas =  new operacoes();
															$antecipadas_agrupadas = $antecipadas_agrupadas->Antecipadas_Agrupadas($value);

															foreach ($antecipadas_agrupadas as $row) {
																$fornecedor = new fornecedores();
																$fornecedor->setCnpj($row['cnpj']);
																$fornecedor = $fornecedor->SelectCnpj();
																$postergacoesDetalhes = new postergacoes();
																$postergacoesDetalhes->setId($key);
																$postergacoesDetalhes = $postergacoesDetalhes->SelectId();

																$valorRow = floatval($row['valor']) - ($postergacoesDetalhes['juros'] + $postergacoesDetalhes['taxas']);
														?>
																<tr>
																	<td>
																		<a href="fornecedor.php?id=<?php echo $fornecedor['id']; ?>" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $fornecedor["razao"]; ?></a>
																		<span class="text-muted fw-bold text-muted d-block fs-7"><?php echo $fornecedor["cnpj"]; ?></span>
																	</td>

																	<td>
																		<a href="operacao.php?id_postergacao=<?php echo $key; ?>" class="text-dark fw-bolder text-hover-primary fs-6">0000<?php echo $key; ?></a>
																	</td>
																	<td>
																		<a href="" class="text-dark fw-bolder text-hover-primary fs-6"><?php if ($row['status'] == 4) {
																																		?>
																				<span class="badge badge-light-success">
																					<?php
																																			echo "Antecipação";
																					?>
																				</span>
																			<?php
																																		} else {
																			?>
																				<span class="badge badge-light-danger">
																				<?php
																																			echo "Postergação";
																																		} ?>
																				</span>
																		</a>
																	</td>
																	<td>
																		<div class="fs-6 text-gray-800 fw-bolder"><?php
																													if ($row['tipo'] != 'cliente') {
																														echo date('d/m/Y', strtotime($row["dataOPE"]));
																													} else {
																														echo date('d/m/Y', strtotime($row["vencimento"]));
																													}
																													?></div>
																		<span class="text-muted fw-bold text-muted d-block fs-7">link para nota</span>
																	</td>
																	<td>
																		<div class="fs-6 text-gray-800 fw-bolder">R$ <?php echo number_format($valorRow, 2, ',', '.'); ?></div>
																	</td>
																	<td>
																		<?php
																		if ($row['status'] == 5) {
																		?>
																			<span class="badge badge-light-success">Assinado</span>
																		<?php
																		} else {
																		?>
																			<span class="badge badge-light-danger">Não Assinado</span>
																		<?php
																		}
																		?>

																		<!-- <a href="contrato.php" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"> -->
																		<!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
																		<!-- <span class="svg-icon svg-icon-3">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
																			<path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
																		</svg>
																	</span> -->
																		<!--end::Svg Icon-->
																		</a>
																	</td>
																	<td>
																		<?php if ($row["confirmada"] == 1) { ?>
																			<span class="badge badge-light-success">Confirmada</span>
																		<?php } else { ?>
																			<span class="badge badge-light-warning">Não Confirmada</span>
																		<?php } ?>
																	</td>
																	<td>
																		<?php
																		// if ($row['statusReal'] == 5 && $row['confirmada'] == 0) {
																		?>
																		<!-- <a href="index.php?id=<?php //echo $row['id_oper'] 
																									?>&a=confirmar">
															  			<button data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Informar Pagamento" class="btn btn-active-icon-primary btn-active-text-primary" style="margin:0; padding:0;" id="efetuar-antecipadas">
															 				<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															 				  <path opacity="0.3" d="M10.3 14.3L11 13.6L7.70002 10.3C7.30002 9.9 6.7 9.9 6.3 10.3C5.9 10.7 5.9 11.3 6.3 11.7L10.3 15.7C9.9 15.3 9.9 14.7 10.3 14.3Z" fill="black"/>
															 				  <path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM11.7 15.7L17.7 9.70001C18.1 9.30001 18.1 8.69999 17.7 8.29999C17.3 7.89999 16.7 7.89999 16.3 8.29999L11 13.6L7.70001 10.3C7.30001 9.89999 6.69999 9.89999 6.29999 10.3C5.89999 10.7 5.89999 11.3 6.29999 11.7L10.3 15.7C10.5 15.9 10.8 16 11 16C11.2 16 11.5 15.9 11.7 15.7Z" fill="black"/>
															 				  </svg>
															  			  </span>
															  			</button>
																	</a> -->
																	<?php } ?>
																	</td>
																</tr>
															<?php
														}
														// }


														$antecipadas_query = new operacoes();
														$antecipadas = $antecipadas_query->getAntecipadasQuery($status, $inicio, $termino);
														foreach ($antecipadas as $row) {
															// $quantidade = mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT count(*) as totaldupli FROM antecipadas as a, antecipadasDetalhes as ad WHERE a.fornecedor = '{$_SESSION["id"]}' AND ad.antecipada = '{$row['id']}'")) or die(mysqli_error());
															$ant = new antecipadas();
															$ant->setId($row['antec_id']);
															$ant = $ant->Select();
															$fornecedor = new fornecedores();
															$fornecedor->setCnpj($row['cnpj']);
															$fornecedor = $fornecedor->SelectCnpj();
															if (in_array($row['id_oper'], $list) == 1) {
																echo "<tr id='{$row['id_oper']}' style='display: none'>";
															} else {
																echo "<tr>";
															}
															?>
																<td>
																	<a href="fornecedor.php?id=<?php echo $fornecedor['id'];
																								?>" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $fornecedor["razao"];
																																										?></a>
																	<span class="text-muted fw-bold text-muted d-block fs-7"><?php echo $fornecedor["cnpj"];
																																?></span>
																</td>

																<td>
																	<a href="operacao.php?id=<?php echo $row['id'];
																								?>" class="text-dark fw-bolder text-hover-primary fs-6">0000<?php echo $row["id"];
																																							?></a>
																</td>
																<td>
																	<a href="" class="text-dark fw-bolder text-hover-primary fs-6"><?php
																																	if ($row['statusReal'] == 4 || $row['real_antec_id']) {
																																	?>
																			<span class="badge badge-light-success">
																				<?php
																																		echo "Antecipação";
																				?>
																			</span>
																		<?php
																																	} else {
																		?>
																			<span class="badge badge-light-danger">
																			<?php
																																		echo "Postergação";
																																	}
																			?>
																			</span>
																	</a>
																</td>
																<td>
																	<div class="fs-6 text-gray-800 fw-bolder"><?php
																												if ($row['tipo'] != 'cliente') {
																													echo date('d/m/Y', strtotime($row["dataOPE"]));
																												} else {
																													echo date('d/m/Y', strtotime($row["vencimento"]));
																												}
																												?></div>
																	<span class="text-muted fw-bold text-muted d-block fs-7">link para nota</span>
																</td>
																<td>
																	<div class="fs-6 text-gray-800 fw-bolder">R$<?php echo number_format($ant['valor'], 2, ',', '.');
																												?></div>
																</td>
																<td>
																	<?php
																	if ($row['statusReal'] == 5) {
																	?>
																		<span class="badge badge-light-success">Assinado</span>
																	<?php
																	} else {
																	?>
																		<span class="badge badge-light-danger">Não Assinado</span>
																	<?php
																	}
																	?>

																	<!-- <a href="contrato.php" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"> -->
																	<!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
																	<!-- <span class="svg-icon svg-icon-3">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																			<path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
																			<path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
																		</svg>
																	</span> -->
																	<!--end::Svg Icon-->
																	</a>
																</td>
																<td>
																	<?php if ($row["confirmada"] == 1 || $row["confirmada_sec"] == 1) {
																	?>
																		<span class="badge badge-light-success">Confirmada</span>
																	<?php } else {
																	?>
																		<span class="badge badge-light-warning">Não Confirmada</span>
																	<?php }
																	?>
																</td>

																</tr>
															<?php }
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
				<?php
				$montante_aplicado_query = new movimentacao();
				$result_montante_aplicado = $montante_aplicado_query->Get_MontanteAplicado();
				$array_moves = [];
				foreach ($result_montante_aplicado as $rm) {

					$array_moves = [$rm['data'] => $rm['valor']];
				}

				$rentabilidade = new cdi();
				$rentabilidade = $rentabilidade->Rentabilidade();
				$total_operacoes_mes = new operacoes();
				$total_operacoes_mes = $total_operacoes_mes->Total_Operacoes_Mes();

				$rows = array();
				$rows_month_law_smart = array();
				if ($total_operacoes_mes != false) {
					foreach ($total_operacoes_mes as $rm) {
						$rows_month_law_smart[$rm['mes']] = $rm['valor_taxas'] + $rm['valor_juros'];
					}
				}
				foreach ($rentabilidade as $r) {
					$rows[$r['mes']] = $r['valor'];
				}

				$titulos_a_pagar_query = new boletos();
				$titulos_a_pagar = $titulos_a_pagar_query->Titulos_a_Pagar();

				$titulos_a_pagar_array = array();
				foreach ($titulos_a_pagar as $rm) {
					// var_dump($rm);
					// $array_moves = [$rm['data'] => $rm['valor']];
					$titulos_a_pagar_array = [$rm['mes'] => $rm['total']];
				}


				$titulos_pagos = new boletos();
				$titulos_pagos = $titulos_pagos->Titulos_Pagos();
				$titulos_pagos_array = array();
				foreach ($titulos_pagos as $rm) {
					$titulos_pagos_array[$rm['mes']] = $titulos_pagos_array[$rm['mes']] + $rm['total'];
				}

				?>
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


		// const margin = {top: 60, right: 230, bottom: 50, left: 50},
		// 	width = 660 - margin.left - margin.right,
		// 	height = 400 - margin.top - margin.bottom;

		// // append the svg object to the body of the page
		// const svg = d3.select("#grafico_evolucao")
		// .append("svg")
		// 	.attr("width", width + margin.left + margin.right)
		// 	.attr("height", height + margin.top + margin.bottom)
		// .append("g")
		// 	.attr("transform",
		// 		`translate(${margin.left}, ${margin.top})`);
		const ctx = document.getElementById('grafico_evolucao');
		const ctx_liquidez = document.getElementById('grafico_liquidez');
		const aplicado = <?php echo $valormontante ?>;



		const data_liquidez_set = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
		const data_liquidez_set_pagar = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

		const contadorAPagar = <?php echo json_encode($titulos_a_pagar_array); ?>;

		console.log('contador a pagar is', contadorAPagar)
		Object.keys(contadorAPagar).forEach((key, index) => {
			const idx = key - 1
			const quantia_titulos = contadorAPagar[key]
			data_liquidez_set_pagar[idx - 1] = data_liquidez_set_pagar[idx - 1] + contadorAPagar[key];
		})


		const contadorPagos = <?php echo json_encode($titulos_pagos_array); ?>;
		console.log('contador pagos is', contadorPagos)
		const listaPagosAgrupada = Object.keys(contadorPagos).map((key, index) => {
			const localObj = {};

			if (localObj[key] != null) {
				localObj[key] += contadorPagos[key];
			} else {
				localObj[key] = contadorPagos[key];
			}

			return localObj
		})

		console.log('pagos contador', listaPagosAgrupada)
		console.log('data_liquidez_set', data_liquidez_set)
		if (listaPagosAgrupada.length > 0) {
			listaPagosAgrupada.forEach((item, index) => {
				const idx = Object.keys(item)[0]
				const quantia_titulos = Object.values(item)[0]

				// const idx = key -1;
				let tempValue = data_liquidez_set[idx - 1];
				// console.log('first tempvalue', tempValue);

				// if (tempValue == 0) {
				// 	return;
				// }

				if (tempValue == 0 || tempValue == null) {
					tempValue = 1
				}
				console.log('OVER IDX', idx)
				console.log('OVER quantia titulos', quantia_titulos)
				data_liquidez_set[idx - 1] = ((quantia_titulos / tempValue) * 100);
				if (data_liquidez_set[idx - 1] > 100) {
					data_liquidez_set[idx - 1] = 100
				}
			})
		}


		console.log('SET DATA LIQUIDEZ', data_liquidez_set)
		const agrupadoAplicado = <?php echo json_encode($array_moves); ?>;

		console.log('total agrupado aplicado', agrupadoAplicado);
		const agrupadoMensal = <?php echo json_encode($rows); ?>;
		const agrupadoMensal_lawsmart = <?php echo json_encode($rows_month_law_smart); ?>;

		console.log('agrupado mensal law smart is', agrupadoMensal_lawsmart);
		// echo var_dump($total_operacoes_mes);
		// console.log('AGRUPADOS MENSAL >>>', agrupadoMensal)

		// for (let i = 0; i<=11; i++) {

		// }

		const data_cdi = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
		const data_lawsmart = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

		$.get('mod_cdi.php', function(data, status) {
			// Executa quando a solicitação é bem-sucedida
			console.log(data);

			// Supondo que a resposta do servidor seja um array JSON
			const valores = JSON.parse(data);

			// Atualizando o array data_cdi com os valores obtidos
			valores.forEach(function(objeto) {
				const mes = parseInt(objeto.mes);
				const index = mes - 1; // Convertendo o mês para um índice de array (considerando que os meses começam de 1)
				console.log("Mês:", mes, "Índice:", index);
				data_cdi[index] = parseFloat(objeto.valor); // Convertendo para número de ponto flutuante
			});


			// Preenchendo o restante dos meses com zeros
			for (let i = 0; i < 12; i++) {
				if (data_cdi[i] === undefined) {
					data_cdi[i] = 0;
				}
			}

			// Alerta para notificar que os dados foram carregados com sucesso
			// alert("Dados carregados com sucesso!");
		}).fail(function(xhr, status, error) {
			// Executa se houver um erro na solicitação
			console.error(xhr.responseText);
			// alert("Erro ao carregar dados: " + xhr.responseText);
		});

	// Loop through each key in agrupadoMensal
Object.keys(agrupadoMensal).forEach((key, index) => {
    const month = key - 1;
    console.log('TOTAL VALUE IS', agrupadoMensal[key]);

    // Create the monthlyGrouped array with applied calculations
    const monthlyGrouped = Object.keys(agrupadoAplicado).map((localMonthApplied) => {
        if (localMonthApplied == 0) return null;
        
        const monthAppliedStr = localMonthApplied.toString();
        const monthApplied = new Date(monthAppliedStr);
        const dayApplied = monthApplied.getDate() > 28 ? 28 : monthApplied.getDate();
        const toCompare = new Date(`${key}-${dayApplied}-${new Date().getFullYear()}`).getTime();

        const monthsFromApplication = (((monthApplied.getTime() - toCompare) * -1) / 1000 / 60 / 60 / 24 / 30);

        if (monthsFromApplication < 0) {
            return null;
        }
        if (monthsFromApplication < 6) {
            return agrupadoMensal[key] - (agrupadoMensal[key] * 22.5 / 100);
        }
        if (monthsFromApplication < 13) {
            return agrupadoMensal[key] - (agrupadoMensal[key] * 20 / 100);
        }
        if (monthsFromApplication < 25) {
            return agrupadoMensal[key] - (agrupadoMensal[key] * 17.5 / 100);
        }
        return agrupadoMensal[key] - (agrupadoMensal[key] * 15 / 100);
    }).filter(current => current != null);

    // If monthlyGrouped is empty, handle it
    if (monthlyGrouped.length === 0) {
        data_cdi[month] = 0;  // Set some default or zero value
    } else {
        const percentageAtMonthList = monthlyGrouped.reduce((acc, cur) => acc + cur, 0); // Provide initial value
        const percentageAtMonth = percentageAtMonthList / monthlyGrouped.length;
        data_cdi[month] = percentageAtMonth;
    }
});

		Object.keys(agrupadoMensal_lawsmart).forEach((key, index) => {
			const month = key - 1
			console.log('TOTAL VALUE IS AGRUPADO MENSAL', agrupadoMensal_lawsmart[key])
			console.log('TOTAL VALUE IS aplicado', aplicado)
			data_lawsmart[month] = (agrupadoMensal_lawsmart[key] / aplicado) * 100
		})
		// console.log('data law smart is', data_lawsmart)
		const data = [{
				label: 'Rentabilidade CDI',
				data: data_cdi,
				//   borderColor: Utils.CHART_COLORS.red,

				yAxisID: 'y',
			},
			{
				label: 'Rentabilidade LAW_SMART',
				data: data_lawsmart,
				//   borderColor: Utils.CHART_COLORS.blue,

				yAxisID: 'y',
			}
		]

		const data_liquidez = [{
			label: 'Liquidez',
			data: data_liquidez_set,
			//   borderColor: Utils.CHART_COLORS.red,      
			yAxisID: 'y',
		}]

		new Chart(ctx_liquidez, {
			type: 'line',
			data: {
				labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
				datasets: data_liquidez
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
		})

		// let data = []
		new Chart(ctx, {
			type: 'line',
			data: {
				labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
				datasets: data
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

				tableRows.forEach(row => {
					const dateRow = row.querySelectorAll('td');
					const realDate = moment(dateRow[2].innerHTML, "DD MMM YYYY, LT").format(); // select date from 4th column in table
					dateRow[3].setAttribute('data-order', realDate);
				});

				// Init datatable --- more info on datatables: https://datatables.net/manual/
				datatable = $(table).DataTable({
					"info": false,
					'order': [],
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
	<script>
		function copyText(elementId) {
			var text = document.getElementById(elementId).innerText;
			navigator.clipboard.writeText(text).then(function() {
				console.log('Text copied to clipboard');
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Copiado",
					showConfirmButton: false,
					timer: 1500
				});
			}, function(err) {
				console.error('Error in copying text: ', err);
			});
		}

		function toggleMask(elementId) {
			var element = document.getElementById(elementId);
			if (element.classList.contains('masked')) {
				// Se o texto estiver mascarado, mostrar o texto original
				var originalText = element.getAttribute('data-original-text');
				element.innerText = originalText;
				element.classList.remove('masked');
			} else {
				// Se o texto estiver visível, mascarar o texto
				var text = element.innerText;
				var maskedText = '';
				for (var i = 0; i < text.length; i++) {
					maskedText += '*'; // Substitui cada caractere por *
				}
				element.innerText = maskedText;
				element.classList.add('masked');
			}
		}

	</script>
</body>

</html>