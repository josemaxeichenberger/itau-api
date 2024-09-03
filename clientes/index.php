<?php
include("../controle_sessao.php");
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'cliente') {
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
	<meta property="og:locale" content="pt-br" />
	<meta property="og:type" content="" />
	<meta property="og:title" content="" />
	<meta property="og:url" content="" />
	<meta property="og:site_name" content="" />
	<link rel="canonical" href="" />
	<link rel="shortcut icon" href="../assets/media/misc/LSC-icone.png" />

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
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
	<link rel="stylesheet" type="text/css" href="addtohomescreen.css">
	<script src="addtohomescreen.js"></script>
	<style type="text/css">
		.tooltip-inverse .tooltip-inner {
			background-color: #181C32;
			color: white;
		}

		.bs-tooltip-auto[data-popper-placement^=right] .tooltip-arrow::before,
		.bs-tooltip-end .tooltip-arrow::before {
			right: -1px;
			border-width: .4rem .4rem .4rem 0;
			border-right-color: #181C32;
		}
	</style>
</head>

<body id="kt_body" style="background-image: url('../assets/media/misc/page-bg.jpg')" class="page-bg header-fixed header-tablet-and-mobile-fixed aside-enabled">
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
								<h1 class="fs-2hx">Bem vindo,
									<br /><?php echo $_SESSION['razao'] ?>
								</h1>
							</div>
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
									<a href="limites.php" class="btn btn-icon btn-outline btn-nav h-50px w-50px h-lg-70px w-lg-70px ms-2">
										<!--begin::Svg Icon | path: icons/duotune/abstract/abs042.svg-->
										<span class="svg-icon svg-icon-1 svg-icon-lg-2hx">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M18 21.6C16.6 20.4 9.1 20.3 6.3 21.2C5.7 21.4 5.1 21.2 4.7 20.8L2 18C4.2 15.8 10.8 15.1 15.8 15.8C16.2 18.3 17 20.5 18 21.6ZM18.8 2.8C18.4 2.4 17.8 2.20001 17.2 2.40001C14.4 3.30001 6.9 3.2 5.5 2C6.8 3.3 7.4 5.5 7.7 7.7C9 7.9 10.3 8 11.7 8C15.8 8 19.8 7.2 21.5 5.5L18.8 2.8Z" fill="black" />
												<path opacity="0.3" d="M21.2 17.3C21.4 17.9 21.2 18.5 20.8 18.9L18 21.6C15.8 19.4 15.1 12.8 15.8 7.8C18.3 7.4 20.4 6.70001 21.5 5.60001C20.4 7.00001 20.2 14.5 21.2 17.3ZM8 11.7C8 9 7.7 4.2 5.5 2L2.8 4.8C2.4 5.2 2.2 5.80001 2.4 6.40001C2.7 7.40001 3.00001 9.2 3.10001 11.7C3.10001 15.5 2.40001 17.6 2.10001 18C3.20001 16.9 5.3 16.2 7.8 15.8C8 14.2 8 12.7 8 11.7Z" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon-->
									</a>

									<a onClick="abre_dados(<?php echo $_SESSION['id'] ?>);" id="perfil" class="btn btn-icon btn-outline btn-nav h-50px w-50px h-lg-70px w-lg-70px ms-2">
										<!--begin::Svg Icon | path: icons/duotune/abstract/abs036.svg-->
										<span class="svg-icon svg-icon-1 svg-icon-lg-2hx">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M22 12C22 12.2 22 12.5 22 12.7L19.5 10.2L16.9 12.8C16.9 12.5 17 12.3 17 12C17 9.5 15.2 7.50001 12.8 7.10001L10.2 4.5L12.7 2C17.9 2.4 22 6.7 22 12ZM11.2 16.9C8.80001 16.5 7 14.5 7 12C7 11.7 7.00001 11.5 7.10001 11.2L4.5 13.8L2 11.3C2 11.5 2 11.8 2 12C2 17.3 6.09999 21.6 11.3 22L13.8 19.5L11.2 16.9Z" fill="black" />
												<path opacity="0.3" d="M22 12.7C21.6 17.9 17.3 22 12 22C11.8 22 11.5 22 11.3 22L13.8 19.5L11.2 16.9C11.5 16.9 11.7 17 12 17C14.5 17 16.5 15.2 16.9 12.8L19.5 10.2L22 12.7ZM10.2 4.5L12.7 2C12.5 2 12.2 2 12 2C6.7 2 2.4 6.1 2 11.3L4.5 13.8L7.10001 11.2C7.50001 8.8 9.5 7 12 7C12.3 7 12.5 7.00001 12.8 7.10001L10.2 4.5Z" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon-->
									</a>
								</div>
							</div>
							<!--end::Col-->
						</div>

						<div class="row g-5 g-xl-8">
							<div class="col-xl-4">
								<!--begin::Statistics Widget 5-->
								<a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
									<!--begin::Body-->
									<div class="card-body">
										<!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
										<span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<rect x="8" y="9" width="3" height="10" rx="1.5" fill="black" />
												<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black" />
												<rect x="18" y="11" width="3" height="8" rx="1.5" fill="black" />
												<rect x="3" y="13" width="3" height="6" rx="1.5" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon-->
										<div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5" id="limiteDisponivel"></div>
										<div class="fw-bold text-gray-400">LIMITE DISPONÍVEL</div>
									</div>
									<!--end::Body-->
								</a>
								<!--end::Statistics Widget 5-->
							</div>
							<div class="col-xl-4">
								<!--begin::Statistics Widget 5-->
								<a href="operacoes.php" class="card bg-dark hoverable card-xl-stretch mb-xl-8">
									<!--begin::Body-->
									<div class="card-body">
										<!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm008.svg-->
										<span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="black" />
												<path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="black" />
												<path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon-->
										<div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5" id="disponivel"></div>
										<div class="fw-bold text-gray-100">DISPONÍVEL PARA ATENCIPAÇÃO</div>
									</div>
									<!--end::Body-->
								</a>
								<!--end::Statistics Widget 5-->
							</div>
							<div class="col-xl-4 mb-5 mb-sm-5 mb-md-5 mb-lg-0">
								<!--begin::Statistics Widget 5-->
								<a href="#" class="card bg-warning hoverable card-xl-stretch mb-xl-8">
									<!--begin::Body-->
									<div class="card-body">
										<!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
										<span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="black" />
												<path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon-->
										<div class="text-white fw-bolder fs-2 mb-2 mt-5" id="limiteTomado"></div>
										<div class="fw-bold text-white">Limite Tomado</div>
									</div>
									<!--end::Body-->
								</a>
								<!--end::Statistics Widget 5-->
							</div>

						</div>

						<div class="row gy-5 g-xl-8">
							<!--begin::Col-->
							<div class="col-xl-3">
								<!--begin::Card-->
								<a href="novaOperacao.php" class="card card-xl-stretch mb-5 mb-xl-8">
									<!--begin::Card body-->
									<div class="card-body d-flex flex-column flex-stack pb-0 px-0">
										<!--begin::Title-->
										<div class="text-dark fs-2 text-left mb-10 fw-bolder card-px">Nova Operação</div>
										<!--end::Title-->
										<!--begin::Illustration-->
										<div class="position-relative align-self-center">
											<img src="../assets/media/illustrations/custom/1.png" style="margin-bottom: -5px" class="mw-100 mx-auto h-200px card-rounded" />
										</div>
										<!--begin::Illustration-->
									</div>
									<!--end::Card body-->
								</a>
								<!--end::Card-->
							</div>
							<!--end::Col-->
							<!--begin::Col-->
							<div class="col-xl-3">
								<!--begin::Card-->
								<a href="operacoes.php" class="card card-xl-stretch mb-5 mb-xl-8">
									<!--begin::Card body-->
									<div class="card-body d-flex flex-column flex-stack pb-0 px-0">
										<!--begin::Title-->
										<div class="text-dark fs-2 text-left mb-10 fw-bolder card-px">Histórico de OperaçÕes</div>
										<!--end::Title-->
										<!--begin::Illustration-->
										<div class="position-relative align-self-center">
											<img src="../assets/media/illustrations/custom/2.png" class="mw-100 mx-auto h-200px card-rounded" />
										</div>
										<!--begin::Illustration-->
									</div>
									<!--end::Card body-->
								</a>
								<!--end::Card-->
							</div>
							<!--end::Col-->
							<!--begin::Col-->
							<div class="col-xl-3">
								<!--begin::Card-->
								<a href="limites.php" class="card card-xl-stretch mb-5 mb-xl-8">
									<!--begin::Card body-->
									<div class="card-body d-flex flex-column flex-stack pb-0 px-0">
										<!--begin::Title-->
										<div class="text-dark fs-2 text-left mb-10 fw-bolder card-px">Limites</div>
										<!--end::Title-->
										<!--begin::Illustration-->
										<div class="position-relative align-self-end">
											<img src="../assets/media/illustrations/custom/3.png" class="mw-100 mx-auto h-200px card-rounded" />
										</div>
										<!--begin::Illustration-->
									</div>
									<!--end::Card body-->
								</a>
								<!--end::Card-->
							</div>
							<!--end::Col-->
							<!--begin::Col-->
							<div class="col-xl-3">
								<!--begin::Card-->
								<a href="atendimento.php" class="card card-xl-stretch mb-5 mb-xl-8">
									<!--begin::Card body-->
									<div class="card-body d-flex flex-column flex-stack pb-0 px-0">
										<!--begin::Title-->
										<div class="text-dark fs-2 text-left mb-10 fw-bolder card-px">Atendimento</div>
										<!--end::Title-->
										<!--begin::Illustration-->
										<div class="position-relative align-self-center">
											<img src="../assets/media/illustrations/custom/4.png" class="mw-100 mx-auto h-200px card-rounded" />
										</div>
										<!--begin::Illustration-->
									</div>
									<!--end::Card body-->
								</a>
								<!--end::Card-->
							</div>
							<!--end::Col-->
						</div>



						<div class="row gy-5 g-xl-12">
							<!--begin::Col-->
							<div class="col-xl-12">
								<!--begin::Table Widget 6-->
								<div class="card card-xl-stretch mb-xl-8">
									<!--begin::Header-->
									<div class="card-header border-0 pt-5">
										<h3 class="card-title align-items-start flex-column">
											<span class="card-label fw-bolder fs-3 mb-1" id="fornecedor"></span>
											<span class="text-muted mt-1 fw-bold fs-7">Parcelas disponíveis</span>
										</h3>
									</div>
									<!--end::Header-->
									<!--begin::Body-->
									<div class="card-body py-3">
										<div class="tab-content">
											<!--begin::Tap pane-->
											<div class="tab-pane fade show active" id="kt_table_widget_6_tab_1">
												<!--begin::Table container-->
												<div class="table-responsive">
													<!--begin::Table-->
													<table class="table align-middle gs-0 gy-3">

														<!--begin::Table body-->
														<tbody id="table-operacoes">

														</tbody>
														<!--end::Table body-->
														<!--begin::Table footer-->
														<tfoot id="footer-operacoes" style="border-top:solid 2px #a1a5b7;">
															<tr>
																<td>
																	<span class="text-muted fw-bold d-block"></span>
																</td>
																<td>
																	<span class="text-muted fw-bold d-block fs-7"></span>
																	<span class="text-dark fw-bolder d-block fs-5"></span>
																</td>
																<td>
																	<span class="text-muted fw-bold d-block fs-7"></span>
																	<span class="text-dark fw-bolder d-block fs-5"></span>
																</td>
																<td>
																	<span class="text-muted fw-bold d-block fs-7">Valor Original</span>
																	<span class="text-dark fw-bolder d-block fs-5">R$ 0.00</span>
																</td>
																<td>
																	<span class="text-muted fw-bold d-block fs-7">vencimento</span>
																	<span class="text-dark fw-bolder d-block fs-5">20/01/2023</span>
																</td>
																<td>

																</td>
																<td>

																</td>
																<td>

																</td>
																<td>
																	<span class="d-block fs-7">&nbsp;</span>
																</td>
															</tr>
														</tfoot>
														<!--end::Table footer-->
													</table>
													<span class="text-muted fw-bold d-block fs-7">* valores válidos para a data de hoje, <span id="operacao-data"></span>. </span>
												</div>
												<!--end::Table-->
											</div>
											<!--end::Tap pane-->
										</div>
									</div>
									<!--end::Body-->
								</div>
								<!--end::Tables Widget 6-->
							</div>

							<!--<div class="col-xl-4">-->
							<!--begin::Mixed Widget 5-->
							<!--<div class="card card-xxl-stretch mb-xl-8">-->
							<!--begin::Beader-->
							<!--<div class="card-header border-0 py-5">-->
							<!--	<h3 class="card-title align-items-start flex-column">-->
							<!--		<span class="card-label fw-bolder fs-3 mb-1">Totais</span>-->
							<!--		<span class="text-muted fw-bold fs-7">Valores descontdos</span>-->
							<!--	</h3>-->

							<!--</div>-->
							<!--end::Header-->
							<!--begin::Body-->
							<!--<div class="card-body d-flex flex-column">-->

							<!--</div>-->
							<!--end::Item-->
							<!--</div>-->
							<!--end::Items-->
							<!--</div>-->
							<!--end::Body-->
							<!--</div>-->
							<!--end::Mixed Widget 5-->
							<!--</div>-->

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
	<!-- modal confirmação -->
	<button type="button" id="trigger-modal" style="display:none;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1"></button>
	<div class="modal fade" tabindex="-1" id="kt_modal_1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="antecipadas-titulo"></h5>

					<!--begin::Close-->
					<div class="btn btn-icon btn-sm btn-active-light-primary ms-2 fecha-modal" data-bs-dismiss="modal" aria-label="Close">
						<span class="svg-icon svg-icon-2x"></span>
					</div>
					<!--end::Close-->
				</div>

				<div class="modal-body">
					<div class="d-flex flex-column w-100 me-2">
						<div class="d-flex flex-stack mb-2">
							<span class="text-muted me-2 fs-7 fw-bold" id="antecipadas-efetuando"></span>
							<span class="text-muted me-2 fs-7 fw-bold" id="antecipadas-porcentagem"></span>
						</div>
						<div class="progress h-6px w-100">
							<div id="antecipadas-progressbar" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<div class="text-muted me-2 fs-7 fw-bold" id="antecipadas-modal-msg" style="padding-top:25px;">

					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-light fecha-modal" data-bs-dismiss="modal" onclick="Reload()">Fechar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal postergação -->
	<button type="button" id="trigger-modal-postergacao" style="display:none;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_2"></button>
	<div class="modal fade" tabindex="-1" id="kt_modal_2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Postergar de Operação…</h5>

					<!--begin::Close-->
					<div class="btn btn-icon btn-sm btn-active-light-primary ms-2 fecha-modal-postergacao" data-bs-dismiss="modal" aria-label="Close">
						<span class="svg-icon svg-icon-2x"></span>
					</div>
					<!--end::Close-->
				</div>

				<div class="modal-body">
					<label for="post-vencimento-datepicker" class="form-label">Nova Data de Vencimento</label>
					<div class="input-group mb-5">
						<span class="input-group-text">
							<!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/metronic/releases/2022-07-14-092914/core/html/src/media/icons/duotune/general/gen014.svg-->
							<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
									<path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
									<path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
								</svg></span>
							<!--end::Svg Icon-->
						</span>
						<input id="post-vencimento-datepicker" type="text" class="form-control" />
						<i class="fa fa-caret-down" style="position:relative; left:-30px; top:20px;"></i>
					</div>
					<div class="separator my-5"></div>
					<div class="table-responsive">
						<!--begin::Table-->
						<table class="table align-middle gs-0 gy-3">
							<!--begin::Table body-->
							<tbody id="table1">
								<td>
									<span class="text-muted fw-bold d-block fs-7">valor original</span>
									<span class="text-dark fw-bolder d-block fs-5" id="post-valor-original">R$ 0.00</span>
								</td>
								<td>
									<span class="text-muted fw-bold d-block fs-7">vencimento</span>
									<span class="text-dark fw-bolder d-block fs-5" id="post-vencimento-original">--/--/----</span>
								</td>
								<td>
									<span class="text-muted fw-bold d-block fs-7">juros/mês</span>
									<span class="text-dark fw-bolder d-block fs-5" id="post-juros-mes">&nbsp;</span>
								</td>
								<td>
									<span class="text-muted fw-bold d-block fs-7">acréscimo de dias</span>
									<span class="text-dark fw-bolder d-block fs-5" id="post-acrescimo-dias">&nbsp;</span>
								</td>
							</tbody>
							<!--end::Table body-->
						</table>
					</div>
					<div class="separator separator-content my-5">
						<i class="bi bi-arrow-down-up text-primary fs-base"></i>
					</div>
					<div class="table-responsive">
						<!--begin::Table-->
						<table class="table align-middle gs-0 gy-3">
							<!--begin::Table body-->
							<tbody id="table2">
								<td>
									<span class="text-muted fw-bold d-block fs-7">novo valor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
									<span class="text-dark fw-bolder d-block fs-5" id="post-valor-novo">R$ 0.00</span>
								</td>
								<td>
									<span class="text-muted fw-bold d-block fs-7">novo vencimento</span>
									<span class="text-dark fw-bolder d-block fs-5" id="post-vencimento-novo">--/--/----</span>
								</td>
								<td>
									<span class="text-muted fw-bold d-block fs-7">acréscimo juros</span>
									<span class="text-dark fw-bolder d-block fs-5" id="post-acrescimo-juros">R$ 0.00</span>
								</td>
								<td>
									<span class="text-muted fw-bold d-block fs-7">acréscimo taxas</span>
									<span class="text-dark fw-bolder d-block fs-5" id="post-acrescimo-taxas">R$ 0.00</span>
								</td>
							</tbody>
							<!--end::Table body-->
						</table>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-light fecha-modal-postergacao" data-bs-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary" id="proxima-modal-postergacao">Próxima</button>
					<button type="button" class="btn btn-primary" id="confirma-modal-postergacao">Confirmar</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		var hostUrl = "../assets/";
	</script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

	<script src="../assets/plugins/global/plugins.bundle.js"></script>
	<script src="../assets/js/scripts.bundle.js"></script>
	<script src="sys_cli.js"></script>
	<script src="../assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
	<script src="../assets/js/custom/widgets.js"></script>
	<script src="../assets/js/custom/apps/chat/chat.js"></script>
	<script src="../assets/js/custom/modals/create-app.js"></script>
	<script src="../assets/js/custom/modals/upgrade-plan.js"></script>
	<script src="../jquery.mask.js"></script>
	<script>
		<?php
		if ($_SESSION["EfetuarOperacao"] == false) { ?>
			$(document).ready(function() {

				$('.operacoes-check').click(function() {

					alert();
					if ($(this).prop('checked')) {
						// Desmarca o checkbox
						$(this).prop('checked', false);
					}
					abre_dados(<?php echo $_SESSION['id'] ?>);

				});
				// abre_dados(<?php echo $_SESSION['id'] ?>);
			});
		<?php }

		?>

		function validarUser() {
			<?php if ($_SESSION["EfetuarOperacao"] == false) { ?>
				// Desmarca o checkbox
				$('.operacoes-check').prop('checked', false);
				abre_dados(<?php echo $_SESSION['id'] ?>);
			<?php } ?>
		}

		function Reload() {
			location.reload();

		}

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

		function abre_dados() {
			var id = "<?php echo $_SESSION['id']; ?>";

			$('#conteudo_dados').hide();
			$('#modal_dados').modal('show');

			$.ajax({
				type: 'POST',
				data: 'id=' + id,
				url: "dados.php",
				success: function(msg) {

					$('#conteudo_dados').html(msg);
					$('#conteudo_dados').fadeIn();
					$('.money2').mask("#.##0.00", {
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
											banco: {
												validators: {
													notEmpty: {
														message: "Banco é obrigatório"
													}
												}
											},
											agencia: {
												validators: {
													notEmpty: {
														message: "Agencia é obrigatório"
													}
												}
											},
											conta: {
												validators: {
													notEmpty: {
														message: "Conta é obrigatório"
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
															console.log(response);
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
	</script>

</body>

</html>