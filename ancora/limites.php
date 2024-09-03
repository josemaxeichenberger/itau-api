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
$fornecedor = new fornecedores();
$fornecedor->setId($_SESSION['cnpj']);
$fornecedor = $fornecedor->SelectCnpj();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<!--begin::Head-->
	<head><base href="">
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
	<!--end::Head-->
	<!--begin::Body-->
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
											<div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">R$ <?php if(isset($fornecedor['limite'])){echo number_format($fornecedor['limite'], 2, ',', '.');}else{ echo '0,00';} ?></div>
											<div class="fw-bold text-gray-400">LIMITE DISPONÍVEL</div>
										</div>
										<!--end::Body-->
									</a>
									<!--end::Statistics Widget 5-->
								</div>
								<div class="col-xl-4">
									<!--begin::Statistics Widget 5-->
									<a href="#" class="card bg-dark hoverable card-xl-stretch mb-xl-8">
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
											<?php
												$totaloperado = new antecipadas();
												$totaloperado->setFornecedor($_SESSION["id"]);
												$totaloperado = $totaloperado->SumValorOriginal_Total_Antecipadas();
												$VAL = 0;
												@$VAL = $fornecedor['limite'] - $totaloperado['valor'];
												//mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT SUM(valorOriginal) as valor FROM antecipadas WHERE fornecedor = '{$_SESSION["id"]}'")) or die(mysqli_error());
											?>
											<div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5">R$ <?php echo number_format($VAL, 2, ',', '.'); ?></div>
											<div class="fw-bold text-gray-100">DISPONÍVEL PARA ATENCIPAÇÃO</div>
										</div>
										<!--end::Body-->
									</a>
									<!--end::Statistics Widget 5-->
								</div>
								<div class="col-xl-4">
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
											<div class="text-white fw-bolder fs-2 mb-2 mt-5"><?php if(isset($fornecedor['taxaJuros'])){ echo $fornecedor['taxaJuros'];}else{ echo '0';}; ?>%</div>
											<div class="fw-bold text-white">Taxa de Juros</div>
										</div>
										<!--end::Body-->
									</a>
									<!--end::Statistics Widget 5-->
								</div>
								
							</div>
							
							
							
							
							
							<div class="row gy-5 g-xl-8">
								<!--begin::Col-->
								<div class="col-xl-12">
									<div class="card mb-5 mb-xl-8">
										<div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bolder fs-3 mb-1">Parcelas passiveis de antecipação</span>
												<span class="text-muted mt-1 fw-bold fs-7">Abaixo listamos todas parcelas possiveis de antecipação.</span>
											</h3>
											
										</div>
										<div class="card-body py-3">
											<!--begin::Table container-->
											<div class="table-responsive">
												<!--begin::Table-->
												<table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
													<!--begin::Table head-->
													<thead>
														<tr class="fw-bolder text-muted">
															
															<th class="min-w-140px">Nota</th>
															<th class="min-w-120px">Data Vencimento</th>
															<th class="min-w-120px">Parcela</th>
															<th class="min-w-120px">Valor Original</th>
															<th class="min-w-120px">Status</th>
															<th class="min-w-120px">Data Operação</th>
															<th class="min-w-120px">Taxas+Juros</th>
															<th class="min-w-120px">Valor Final</th>
														</tr>
													</thead>
													<tbody>
														
														<?php
															$operacoes = new operacoes();
															$operacoes->setCnpj($_SESSION['cnpj']);
															$operacoes = $operacoes->Get_Operacoes_By_Cnpj_order_by_Vencimento();
															//mysqli_query($lawsmt, "SELECT * FROM operacoes WHERE cnpj = '{$_SESSION['cnpj']}'");
															foreach($operacoes as $row) {
																
																
														?>
														<tr>
															<td>
																<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $row['nota']; ?></a>
															</td>
															<td>
																<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php $data = new DateTime($row['data']); echo $data->format('d/m/Y'); ?></a>
															</td>
															<td>
																<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo substr($row['nota'], -1); ?></a>
															</td>
															<td class="text-dark fw-bolder text-hover-primary fs-6"><?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
															<td>
																<?php if($row['status'] == '0') { ?>
																<span class="badge badge-light-success">Disponível</span>
																<?php } else { ?>
																<span class="badge badge-light-danger">Operada</span>
																<?php } ?>
															</td>
															<?php
																$buscadesconto = mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT * FROM antecipadasDetalhes WHERE operacao = '{$row['id']}'"));
															?>
															<td>
																<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php $data = new DateTime($buscadesconto['data']); echo $data->format('d/m/Y'); ?></a>
															</td>
															<td class="text-dark fw-bolder text-hover-primary fs-6"><?php echo number_format($buscadesconto['descontoJuros'], 2, ',', '.'); ?></td>
															<td class="text-dark fw-bolder text-hover-primary fs-6"><?php echo number_format($buscadesconto['valor'], 2, ',', '.'); ?></td>
															
														</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								
								
								
							</div>
							
							
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
		<script>var hostUrl = "../assets/";</script>
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