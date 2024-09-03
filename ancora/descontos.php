<?php
include("../controle_sessao.php");
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'ancora') {
	header("Location: ../pagina_de_acesso_nao_autorizado.php");
	exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
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
		<link rel="stylesheet" type="text/css" href="../addtohomescreen.css">
		<script src="../addtohomescreen.js"></script>

	</head>
	<?php
		include("config.php");
		$acao = mysqli_escape_string($lawsmt, $_GET['a']);
		if($acao == 'alterarDados') {
			$id = mysqli_escape_string($lawsmt, $_GET['id']);

			$representante = mysqli_escape_string($lawsmt, ($_POST['representante']));
			$cpf = mysqli_escape_string($lawsmt, ($_POST['cpf']));
			$telefone = mysqli_escape_string($lawsmt, $_POST['telefone']);
			$email = mysqli_escape_string($lawsmt, $_POST['email']);
			$rua = mysqli_escape_string($lawsmt, ($_POST['rua']));
			$numero = mysqli_escape_string($lawsmt, $_POST['numero']);
			$bairro = mysqli_escape_string($lawsmt, ($_POST['bairro']));
			$cidade = mysqli_escape_string($lawsmt, ($_POST['cidade']));
			$estado = mysqli_escape_string($lawsmt, $_POST['estado']);

			$query = mysqli_query($lawsmt, "UPDATE fornecedores SET representante = '{$representante}', cpf = '{$cpf}', telefone = '{$telefone}', email = '{$email}', rua = '{$rua}', numero = '{$numero}', bairro = '{$bairro}', cidade = '{$cidade}', estado = '{$estado}' WHERE id = '{$id}'");
			echo "<script>alert('Dados alterados com sucesso.');</script>";
		}
	?>
	<body id="kt_body" style="background-image: url('assets/media/misc/page-bg.jpg')" class="page-bg header-fixed header-tablet-and-mobile-fixed aside-enabled">
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
									<br /><?=$_SESSION['razao']?></h1>
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
										
										<a onClick="abre_dados(<?php echo $v['id'] ?>);" class="btn btn-icon btn-outline btn-nav h-50px w-50px h-lg-70px w-lg-70px ms-2">
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
																	<span class="text-muted fw-bold d-block fs-7">valor original</span>
																	<span class="text-dark fw-bolder d-block fs-5">R$ 0.00</span>
																</td>
																<td>
																	<span class="text-muted fw-bold d-block fs-7">vencimento</span>
																	<span class="text-dark fw-bolder d-block fs-5">--/--/----</span>
																</td>
																<td>
																	<span class="text-muted fw-bold d-block fs-7">desconto juros</span>
																	<span class="text-dark fw-bolder d-block fs-5">R$ 0.00</span>
																</td>
																<td>
																	<span class="text-muted fw-bold d-block fs-7">desconto taxas</span>
																	<span class="text-dark fw-bolder d-block fs-5">R$ 0.00</span>
																</td>
																<td>
																	<span class="text-muted fw-bold d-block fs-7">valor antecipação</span>
																	<span class="text-dark fw-bolder d-block fs-5">R$ 0.00*</span>
																</td>
																<td>
																	<span class="d-block fs-7">&nbsp;</span>
																</td>
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
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									<h5 class="modal-title" id="antecipadas-titulo">Efetuando Antecipações…</h5>

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
									<button type="button" class="btn btn-light fecha-modal" data-bs-dismiss="modal">Fechar</button>
							</div>
					</div>
			</div>
		</div>
		<script>var hostUrl = "assets/";</script>
		<script src="sys.min.js"></script>
		<script src="../assets/plugins/global/plugins.bundle.js"></script>
		<script src="../assets/js/scripts.bundle.js"></script>
		<script src="../assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<script src="../assets/js/custom/widgets.js"></script>
		<script src="../assets/js/custom/apps/chat/chat.js"></script>
		<script src="../assets/js/custom/modals/create-app.js"></script>
		<script src="../assets/js/custom/modals/upgrade-plan.js"></script>
		<script>
			function abre_dados(id){
	
	
				$('#conteudo_dados').hide();
				$('#modal_dados').modal('show');

				$.ajax({
					type:'POST',
					data:'id='+id,
					url:"dados.php",
					success: function(msg){

						$('#conteudo_dados').html(msg);
						$('#conteudo_dados').fadeIn();


					}
				});

			}
			var elem = document.documentElement;
			function openFullscreen() {
			  if (elem.requestFullscreen) {
				elem.requestFullscreen();
			  } else if (elem.webkitRequestFullscreen) { /* Safari */
				elem.webkitRequestFullscreen();
			  } else if (elem.msRequestFullscreen) { /* IE11 */
				elem.msRequestFullscreen();
			  }
			}

			function closeFullscreen() {
			  if (document.exitFullscreen) {
				document.exitFullscreen();
			  } else if (document.webkitExitFullscreen) { /* Safari */
				document.webkitExitFullscreen();
			  } else if (document.msExitFullscreen) { /* IE11 */
				document.msExitFullscreen();
			  }
			}

			$(document).ready(function() {
			  addToHomescreen();
			});
			if(navigator.userAgent.match(/Android/i)){
				window.scrollTo(0,1);
			}
		</script>
		
	</body>
</html>