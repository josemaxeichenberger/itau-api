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

$fornecedor = new fornecedores();
$fornecedor->setCnpj($_SESSION['cnpj']);
$fornecedor = $fornecedor->SelectCnpj();
?>
<!DOCTYPE html>
<html lang="pt-br">
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
										<div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">R$ <?php echo number_format($fornecedor['limite'], 2, ',', '.'); ?></div>
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
										?>
										<div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5">R$ <?php echo number_format($fornecedor['limite'] - $totaloperado['valor'], 2, ',', '.'); ?></div>
										<div class="fw-bold text-gray-100">DISPONÍVEL PARA POSTERGAÇÃO</div>
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
										<div class="text-white fw-bolder fs-2 mb-2 mt-5"><?php echo $fornecedor['juros']; ?>%</div>
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
														<th class="min-w-120px">Vencimento Original</th>
														<th class="min-w-120px">Parcela</th>
														<th class="min-w-120px">Valor</th>
														<th class="min-w-120px">Status</th>
														<th class="min-w-120px">Data Operação</th>
														<th class="min-w-120px">Novo Vencimento</th>
														<th class="min-w-120px">Taxas+Juros</th>
														<th class="min-w-120px">Valor Final</th>
														<th class="min-w-120px">Boleto</th>
													</tr>
												</thead>
												<tbody>

													<?php

													$operacoes =  new operacoes();
													$operacoes->setCnpj($_SESSION['cnpj']);
													$operacoes->setVencimento(date('Y-m-d'));
													$operacoes = $operacoes->SelectOpe_BolClientes();


													foreach ($operacoes as $row) {

														if ($row['status'] == 6) { // 6 postergada
															$notaOriginal = new operacoes();
															$notaOriginal->setNota($row['nota']);
															$notaOriginal = $notaOriginal->BuscaNotaPostergadaOriginal();
															$postergacoesDetalhes = new postergacoesDetalhes();
															$postergacoesDetalhes->setId_postergada($notaOriginal['id']);
															$postergacoesDetalhes = $postergacoesDetalhes->SelectNota();
														}

													?>
														<tr>
															<td>
																<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $row['nota']; ?></a>
															</td>
															<td>
																<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php
																																				if ($row['status'] == 6) { // 6 postergada

																																					echo date('d-m-Y', strtotime($notaOriginal['vencimento']));
																																				} else {
																																					date('d-m-Y', strtotime($row['vencimento']));
																																				}

																																				?></a>
															</td>
															<td>
																<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo substr($row['nota'], -1); ?></a>
															</td>
															<td class="text-dark fw-bolder text-hover-primary fs-6">

																<?php
																if ($row['status'] == 6) { // 6 postergada
																	$notaOriginal = new operacoes();
																	$notaOriginal->setNota($row['nota']);
																	$notaOriginal = $notaOriginal->BuscaNotaPostergadaOriginal();
																	$postergacoesDetalhes = new postergacoesDetalhes();
																	$postergacoesDetalhes->setId_postergada($notaOriginal['id']);
																	$postergacoesDetalhes = $postergacoesDetalhes->SelectNota();
																
																	echo $postergacoesDetalhes['valorOriginal'];
																} else {


																	
																	echo	$valor = $row['valor'];
																}
																?>
															</td>
															<td>
																<?php if ($row['status'] == '0') { ?>
																	<span class="badge badge-light-success">Disponível</span>
																<?php } else { ?>
																	<span class="badge badge-light-danger">Operada</span>
																<?php } ?>
															</td>
															<?php
															if ($row['status'] == 6) { // 6 postergada
																$notaOriginal = new operacoes();
																$notaOriginal->setNota($row['nota']);
																$notaOriginal = $notaOriginal->BuscaNotaPostergadaOriginal();
																$postergacoesDetalhes = new postergacoesDetalhes();
																$postergacoesDetalhes->setId_postergada($notaOriginal['id']);
																$postergacoesDetalhes = $postergacoesDetalhes->SelectNota();
																$descontoJuros = ($postergacoesDetalhes['juros'] + $postergacoesDetalhes['taxas']);
																$valor = $postergacoesDetalhes['valor'];
															} else {


																$buscadesconto = new antecipadasDetalhes();
																$buscadesconto->setOperacao($row['id']);
																$buscadesconto = $buscadesconto->buscadesconto();
																if ($buscadesconto) {
																	$descontoJuros = $buscadesconto['descontoJuros'];
																	$valor = $buscadesconto['valor'];
																} else {
																	$descontoJuros = 0;
																	$valor = $row['valor'];
																}
															}
															?>
															<td>
																<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo date('d-m-Y', strtotime($row['dataOPE'])); ?></a>
															</td>
															<td class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php
																																	if ($row['status'] == 6) { // 6 postergada

																																		echo date('d-m-Y', strtotime($row['vencimento']));
																																	} else {
																																		echo '00/00/0000';
																																	}


																																	?></td>
															<td class="text-dark fw-bolder text-hover-primary fs-6"><?php echo number_format($descontoJuros, 2, ',', '.'); ?></td>
															<td class="text-dark fw-bolder text-hover-primary fs-6"><?php echo number_format($valor, 2, ',', '.'); ?></td>
															<td>
																<?php if ($row['id_boleto'] && $row['status_boleto'] != 9) { ?>
																	<a href="imprime_boleto.php?id=<?php echo $row['id_boleto'] ?>">
																		<button data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Imprimir Boleto" class="btn btn-active-icon-primary btn-active-text-primary" style="margin:0; padding:0;" id="efetuar-antecipadas">
																			<span class="svg-icon svg-icon-muted svg-icon-1hx">
																				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.6 404.3">
																					<path class="svg-fill" d="M378.8 88.8h-55.1v75.8c0 10.5-8.5 18.9-19 18.9h-200c-10.5 0-19-8.5-19-18.9V88.8h-55c-10.5 0-18.9 8.5-19 18.9v186c0 10.5 8.5 18.9 18.9 19h348.1c10.5 0 18.9-8.5 19-19V107.8c.1-10.5-8.4-19-18.9-19z" />
																					<path class="svg-stroke" d="M409.6 226V107.8c0-17-13.8-30.8-30.8-30.8h-43.2V30.8c0-17-13.8-30.8-30.8-30.8H149.2c-8.2 0-16 3.2-21.8 9L83 53.6c-5.8 5.8-9 13.6-9 21.7V77H30.8C13.8 77 0 90.8 0 107.8v185.9c0 17 13.8 30.8 30.8 30.8h281.1v49c0 3.9-3.2 7.1-7.1 7.1h-200c-3.9 0-7.1-3.2-7.1-7.1v-13.9c0-6.5-5.3-11.8-11.8-11.8-6.5 0-11.8 5.3-11.8 11.8v13.9c0 17 13.8 30.8 30.8 30.8h200c17 0 30.8-13.8 30.8-30.8v-49h43.2c17 0 30.8-13.8 30.8-30.8v-67.5c-.1-.1-.1-.2-.1-.2zM97.7 75.3c0-1.9.7-3.7 2.1-5l44.4-44.5c1.3-1.3 3.1-2.1 5-2.1h155.6c3.9 0 7.1 3.2 7.1 7.1v133.8c0 3.9-3.2 7.1-7.1 7.1h-200c-3.9 0-7.1-3.2-7.1-7.1V75.3zm281.1 225.5h-348c-3.9 0-7.1-3.2-7.1-7.1v-55.9h50.2c6.5 0 11.8-5.3 11.8-11.8 0-6.5-5.3-11.8-11.8-11.8H23.7V107.8c0-3.9 3.2-7.1 7.1-7.1H74v64c0 17 13.8 30.8 30.8 30.8h200c17 0 30.8-13.8 30.8-30.8v-64h43.2c3.9 0 7.1 3.2 7.1 7.1v106.4h-50.2c-6.5 0-11.8 5.3-11.8 11.8 0 6.5 5.3 11.8 11.8 11.8h50.2v55.9c0 3.9-3.2 7.1-7.1 7.1z" />
																				</svg>
																			</span>
																		</button>
																	</a>
																<?php } ?>
															</td>
														</tr>
													<?php }
													?>
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