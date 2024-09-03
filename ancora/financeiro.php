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

								<div class="col-xl-12">
									<div class="col-xl-12">
										<div class="card mb-5 mb-xl-8">
											<div class="card-header border-0 pt-5">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label fw-bolder fs-3 mb-1">Administração financeira</span>
													<span class="text-muted mt-1 fw-bold fs-7">Controle seu caixa e capital por aqui.</span>
												</h3>

											</div>

										</div>
									</div>
								</div>

							</div>

						</div>



						<div class="row gy-5 g-xl-8">
							<!--begin::Col-->
							<div class="col-xl-6">
								<div class="col-xl-12">
									<div class="card mb-5 mb-xl-8">
										<div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bolder fs-3 mb-1">Cadastre sua Movimentação</span>
												<span class="text-muted mt-1 fw-bold fs-7">Não esqueça de cadastrar o tipo</span>
											</h3>

										</div>
										<div class="card-body py-3">
											<?php
											$acao = '';
											if (isset($_GET["acao"])) {
												$acao = $_GET["acao"];
											}
											switch ($acao) {
												case "": ?>

													<form method="post" action="?acao=cadastrar_fim" enctype="multipart/form-data">

														<div class="form-group d-flex flex-column mb-8">
															<label class="fs-6 fw-bold mb-2" for="tipo">Tipo</label>
															<select class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Selecione um tipo" name="tipo" data-select2-id="select2-data-16-ckn6" tabindex="-1" aria-hidden="true" name="tipo" data-live-search="true" id="tipo">
																<option value="">Selecione</option>
																<option value="aporte">Aporte</option>
																<option value="despesa">Despesa</option>
																<option value="retirada">Retirada</option>
															</select>
														</div>

														<div class="form-group d-flex flex-column mb-8">
															<label class="fs-6 fw-bold mb-2" for="titulo">Titulo</label>
															<input type="text" class="form-control form-control-solid" name="titulo" id="titulo">
														</div>
														<div class="form-group d-flex flex-column mb-8">
															<label class="fs-6 fw-bold mb-2" for="valor">Valor R$</label>
															<input type="text" class="form-control form-control-solid money2" name="valor" id="valor">
														</div>
														<div class="form-group d-flex flex-column mb-8">
															<label class="fs-6 fw-bold mb-2" for="data">Data</label>
															<input type="date" class="form-control form-control-solid" name="data" id="data">
														</div>
														<div class="form-group d-flex flex-column mb-8">
															<button type="submit" class="btn btn-danger">Salvar</button>
														</div>


													</form>

												<?php break;
												case "cadastrar_fim":

													$tipo    = 	isset($_POST['tipo']) ? htmlspecialchars($_POST['tipo']) : null;
													$titulo  = 	isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : null;
													$data    = 	isset($_POST['tipo']) ? htmlspecialchars($_POST['data']) : null;
													$valor   = 	isset($_POST['valor']) ? htmlspecialchars($_POST['valor']) : null;
													// Remove the thousand separator and replace the decimal separator
													$valor = str_replace('.', '', $valor); // Remove dots
													$valor = str_replace(',', '.', $valor); // Replace commas with dots

													// Convert the string to a float
													$number_float = (float) $valor;

													// Now you can use number_format() with the float value
													$formatted_number = number_format($number_float, 2, ',', '');
													$movimentacao = new movimentacao();
													$movimentacao->setTipo($tipo);
													$movimentacao->setTitulo($titulo);
													$movimentacao->setData($data);
													$movimentacao->setValor($number_float);
													$movimentacao->setStatus('');
													$movimentacao = $movimentacao->Insert();

												?>
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bolder fs-3 mb-1 text-info">Registrado com sucesso</span><br>
														<a href="financeiro"><span class="text-muted mt-1 fw-bold fs-7">Cadastrar mais um</span></a>
													</h3>

											<?php break;
											} //FIM SWITCH 
											?>

										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-6">
								<div class="col-xl-12">
									<div class="card mb-5 mb-xl-8">
										<div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bolder fs-3 mb-1">Movimentação cadastradas</span>
												<span class="text-muted mt-1 fw-bold fs-7">Abaixo listamos as movimentações cadastradas.</span>
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
															<th class="">Tipo</th>
															<th class="min-w-200px">Titulo</th>
															<th class="min-w-50px">Data</th>
															<th class="min-w-50px">Valor</th>
															<th class="min-w-5px text-end"></th>
														</tr>
													</thead>
													<tbody>
														<?php
														$movimentacao = new movimentacao();
														$movimentacao = $movimentacao->Select();
														foreach ($movimentacao as $row) {

														?>
															<tr id="R<?php echo $row['id']; ?>">
																<td>
																	<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $row['tipo']; ?></a>
																</td>
																<td>
																	<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $row['titulo']; ?></a>
																</td>
																<td>
																	<a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php $data = new DateTime($row['data']);
																																	echo $data->format('d/m/Y'); ?></a>
																</td>
																<td class="text-dark fw-bolder text-hover-primary fs-6">R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></td>

																<td>
																	<div class="d-flex justify-content-end flex-shrink-0">
																		<a onclick="ConfirmaE(<?php echo $row['id']; ?>)" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
																			<!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
																			<span class="svg-icon svg-icon-3">
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																					<path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="black"></path>
																					<path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="black"></path>
																				</svg>
																			</span>
																			<!--end::Svg Icon-->
																		</a>

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
	<script src="jquery.mask.js"></script>
	<script>
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
			$('.money2').mask("#.##0,00", {
				reverse: true
			});
			addToHomescreen();
		});
		if (navigator.userAgent.match(/Android/i)) {
			window.scrollTo(0, 1);
		}

		function ConfirmaE(id) {
			const swalWithBootstrapButtons = Swal.mixin({
				customClass: {
					confirmButton: "btn btn-success",
					cancelButton: "btn btn-danger"
				},
				buttonsStyling: false
			});
			swalWithBootstrapButtons.fire({
				title: "Deseja Realmente Excluir?",
				text: "",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Sim",
				cancelButtonText: "Não",
				reverseButtons: true
			}).then((result) => {
				if (result.isConfirmed) {

					window.location.href = 'financeiro.php?a=excluir&id=' + id;
				} else if (
					/* Read more about handling dismissals below */
					result.dismiss === Swal.DismissReason.cancel
				) {
					swalWithBootstrapButtons.fire({
						title: "Cancelado",
						text: "Exclusão Cancelada!",
						icon: "error"
					});
				}
			});
		}

	
	</script>
	<?php 
	
	if (isset($_GET['a']) == 'excluir') {
		$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
		$movimentacao = new movimentacao();
		$movimentacao->setId($id);
		$movimentacao->Delete();
	
		?><script>
			var Rid = "<?php echo $id?>";
			$('#R'+Rid).remove();			
		Swal.fire({
			position: "top-end",
			icon: "success",
			title: "Movimentação excluída com sucesso.",
			showConfirmButton: false,
			timer: 2500
		}); </script>
		<?php
	}
	?>
</body>

</html>