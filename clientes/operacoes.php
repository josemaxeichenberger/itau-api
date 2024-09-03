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
<html lang="pt-br">
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

						<div class="row g-6 g-xl-9">
							<div class="col-lg-6 col-xxl-6">
								<!--begin::Card-->
								<div class="card h-100">
									<!--begin::Card body-->
									<div class="card-body p-9">
										<?php
										$conta_opera = new operacoes();
										$conta_opera->setCnpj($_SESSION["cnpj"]);
										$conta_opera = $conta_opera->CountCnpjCliente();
										?>
										<div class="fs-2hx fw-bolder"><?php echo $conta_opera['totaloperacoes']; ?></div>
										<div class="fs-4 fw-bold text-gray-400 mb-7">Operações Importadas</div>
										<!--end::Heading-->
										<!--begin::Wrapper-->
										<div class="d-flex flex-wrap">
											<!--begin::Chart-->
											<div class="d-flex flex-center h-100px w-100px me-9 mb-5">
												<canvas id="kt_project_list_chart"></canvas>
											</div>
											<!--end::Chart-->
											<!--begin::Labels-->
											<div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
												<!--begin::Label-->
												<div class="d-flex fs-6 fw-bold align-items-center mb-3">
													<div class="bullet bg-primary me-3"></div>
													<div class="text-gray-400">Duplicatas Ativas</div>
													<?php
													$duplicatas = new operacoes();
													$duplicatas->setCnpj($_SESSION["cnpj"]);
													$duplicatas = $duplicatas->CountCnpjClientePostergadas();
													?>
													<div class="ms-auto fw-bolder text-gray-700"><?php echo $conta_opera['totaloperacoes'] - $duplicatas['totaldupli']; ?></div>
												</div>
												<!--end::Label-->
												<!--begin::Label-->
												<div class="d-flex fs-6 fw-bold align-items-center mb-3">
													<div class="bullet bg-success me-3"></div>
													<div class="text-gray-400">Postergadas</div>
													<div class="ms-auto fw-bolder text-gray-700"><?php echo $duplicatas['totaldupli']; ?></div>
												</div>
												<!--end::Label-->
												<!--begin::Label-->
												<div class="d-flex fs-6 fw-bold align-items-center">
													<div class="bullet bg-gray-300 me-3"></div>
													<div class="text-gray-400">Recusadas</div>
													<div class="ms-auto fw-bolder text-gray-700">0</div>
												</div>
												<!--end::Label-->
											</div>
											<!--end::Labels-->
										</div>
										<!--end::Wrapper-->
									</div>
									<!--end::Card body-->
								</div>
								<!--end::Card-->
							</div>
							<div class="col-lg-6 col-xxl-6">
								<!--begin::Budget-->
								<div class="card h-100">
									<div class="card-body p-9">
										<?php
									$totaloperado = new operacoes();
									$totaloperado->setCnpj($_SESSION['cnpj']);
									$totaloperado = $totaloperado->SelectPostegacoesCNPJ();
									$valorOperado= 0.00;
									foreach($totaloperado as $row){
										$valorOperado +=$row['valorOriginal'];
									}	
										
										?>
										<div class="fs-2hx fw-bolder">R$ <?php echo number_format($valorOperado, 2, ',', '.'); ?></div>
										<div class="fs-4 fw-bold text-gray-400 mb-7">Valor Operado</div>
										<?php
										$totaloperado2 = new operacoes();
										$totaloperado2->setCnpj($_SESSION["cnpj"]);
										$totaloperado2->setStatus(0);
										$totaloperado2 = $totaloperado2->ValorTotalOperadoCnpj();
										if (is_null($totaloperado2['valor'])) {
											$totaloperado2['valor'] = 0;
										}
										?>
										<div class="fs-6 d-flex justify-content-between mb-4">
											<div class="fw-bold">Ativo</div>
											<div class="d-flex fw-bolder">
												<!--begin::Svg Icon | path: icons/duotune/arrows/arr007.svg-->
												<span class="svg-icon svg-icon-3 me-1 svg-icon-success">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path d="M13.4 10L5.3 18.1C4.9 18.5 4.9 19.1 5.3 19.5C5.7 19.9 6.29999 19.9 6.69999 19.5L14.8 11.4L13.4 10Z" fill="black" />
														<path opacity="0.3" d="M19.8 16.3L8.5 5H18.8C19.4 5 19.8 5.4 19.8 6V16.3Z" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->R$ <?php echo number_format($totaloperado2['valor'], 2, ',', '.'); ?>
											</div>
										</div>
										<div class="separator separator-dashed"></div>
										<div class="fs-6 d-flex justify-content-between my-4">
											<div class="fw-bold">Custos de Taxas</div>
											<?php
											$totaloperado3 = new operacoes();
											$totaloperado3->setCnpj($_SESSION["cnpj"]);
											$totaloperado3 = $totaloperado3->Total_PostergadoCliente();
											if (is_null($totaloperado3['taxas'])) {
												$totaloperado3['taxas'] = 0;
											}
											if (is_null($totaloperado3['juros'])) {
												$totaloperado3['juros'] = 0;
											}
											?>
											<div class="d-flex fw-bolder">
												<!--begin::Svg Icon | path: icons/duotune/arrows/arr006.svg-->
												<span class="svg-icon svg-icon-3 me-1 svg-icon-danger">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path d="M13.4 14.8L5.3 6.69999C4.9 6.29999 4.9 5.7 5.3 5.3C5.7 4.9 6.29999 4.9 6.69999 5.3L14.8 13.4L13.4 14.8Z" fill="black" />
														<path opacity="0.3" d="M19.8 8.5L8.5 19.8H18.8C19.4 19.8 19.8 19.4 19.8 18.8V8.5Z" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->R$ <?php echo number_format($totaloperado3['taxas'], 2, ',', '.'); ?>
											</div>
										</div>
										<div class="separator separator-dashed"></div>
										<div class="fs-6 d-flex justify-content-between mt-4">
											<div class="fw-bold">Custos de Juros</div>
										
											<div class="d-flex fw-bolder">
												<!--begin::Svg Icon | path: icons/duotune/arrows/arr007.svg-->
												<span class="svg-icon svg-icon-3 me-1 svg-icon-success">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path d="M13.4 10L5.3 18.1C4.9 18.5 4.9 19.1 5.3 19.5C5.7 19.9 6.29999 19.9 6.69999 19.5L14.8 11.4L13.4 10Z" fill="black" />
														<path opacity="0.3" d="M19.8 16.3L8.5 5H18.8C19.4 5 19.8 5.4 19.8 6V16.3Z" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->R$ <?php echo number_format($totaloperado3['juros'], 2, ',', '.'); ?>
											</div>
										</div>
									</div>
								</div>
								<!--end::Budget-->
							</div>

						</div>
						<!--end::Stats-->
						<!--begin::Toolbar-->
						<div class="d-flex flex-wrap flex-stack my-5">
							<!--begin::Heading-->
							<h2 class="fs-2 fw-bold my-2">Operações
								<span class="fs-6 text-gray-400 ms-1">Ordenados por Status</span>
							</h2>
							<!--end::Heading-->
							<!--begin::Controls-->
							<div class="d-flex flex-wrap my-1">
								<!--begin::Select wrapper-->
								<div class="m-0">
									<!--begin::Select-->
									<!-- <select name="status" data-control="select2" data-hide-search="true" class="form-select form-select-sm form-select-transparent fw-bolder w-125px">
											<option value="Active" selected="selected">Ativas</option>
											<option value="Approved">Completadas</option>
											<option value="Declined">Canceladas</option>
										</select> -->
									<!--end::Select-->
								</div>
								<!--end::Select wrapper-->
							</div>
							<!--end::Controls-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Row-->
						<div class="row g-6 g-xl-9">

							<?php
							$postergacoes = new operacoes();
							$postergacoes->setCnpj($_SESSION['cnpj']);
							$postergacoes = $postergacoes->SelectPostegacoesCNPJ();
							foreach ($postergacoes as $row) {
							?>
								<div class="col-md-6 col-xl-4">
									<div class="card border-hover-primary">

										<div class="card-body p-9">
											<div class="fs-3 fw-bolder text-dark"><?php echo $row['qtd']; ?> duplicatas</div>
											<p class="text-gray-400 fw-bold fs-5 mt-1 mb-7">LS-00<?php echo $row['id_postergacao']; ?></p>
											<div class="d-flex flex-wrap mb-5">
												<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
													<div class="fs-6 text-gray-800 fw-bolder"><?php $data = new DateTime($row['data']);
																								echo $data->format('d-m-Y'); ?></div>
													<div class="fw-bold text-gray-400">Aprovada</div>
												</div>
												<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
													<div class="fs-6 text-gray-800 fw-bolder">R$ <?php echo number_format($row['valorOriginal'], 2, ',', '.'); ?></div>
													<div class="fw-bold text-gray-400">Valor Operado</div>
												</div>
												<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
													<div class="fs-6 text-gray-800 fw-bolder">R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></div>
													<div class="fw-bold text-gray-400">Valor Final</div>
												</div>
												<?php
												if ($row["status"] == 5) {
												?>
													<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
														<div class="fs-6 text-gray-800 fw-bolder">Assinado</div>
													</div>
												<?php
												} else {
												?>
													<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
														<div class="fs-6 text-gray-800 fw-bolder">Não assinado</div>
														<!-- <div class="fw-bold"><a href="contrato.php" target="_blank" class="btn btn-success text-white">Assinar</a></div> -->
													</div>
												<?php
												}
												?>
											</div>
											<?php
											if ($row["confirmada"] == '1') {
											?>
												<div class="h-10px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="Essa operação já confirmada e paga.">
													<div class="bg-success rounded h-10px" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											<?php } else { ?>
												<div class="h-10px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="Essa operação não foi confirmada.">
													<div class="bg-danger rounded h-10px" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>


					</div>
					<!--end::Post-->
				</div>
				<?php include("footer.php"); ?>
			</div>
		</div>
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
	<script src="../jquery.mask.js"></script>
	<script>
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
											representante: {
												validators: {
													notEmpty: {
														message: "Representante é obrigatório"
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
															cpf: $("#cpf").val(),
															telefone: $("#telefone").val(),
															email: $("#email").val(),
															rua: $("#rua").val(),
															numero: $("#numero").val(),
															bairro: $("#bairro").val(),
															cidade: $("#cidade").val(),
															estado: $("#estado").val()

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

		<?php
		if ($_SESSION["updated"] == 0) { ?>
			$(document).ready(function() {
				abre_dados(<?php echo $v['id'] ?>);
			});
		<?php }

		?>
	</script>
</body>

</html>