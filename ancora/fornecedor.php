<?php
include("../controle_sessao.php");
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== 'ancora') {
	header("Location: ../pagina_de_acesso_nao_autorizado.php");
	exit();
}
date_default_timezone_set('America/Sao_Paulo');

function my_autoload($pClassName)
{
	include('../Class' . "/" . $pClassName . ".class.php");
}

spl_autoload_register("my_autoload");

function calcularValores($operacoes, $jurosMensais)
{
	$resultados = [];
	$dthj = new DateTime(); // Data atual

	foreach ($operacoes as $op) {
		$valor = (float) $op['valor'];
		$jurosMensais = (float) $jurosMensais;

		// Calcular a data de vencimento
		$parts = explode('-', $op['vencimento']);
		$vencimento = new DateTime("{$parts[0]}-{$parts[1]}-{$parts[2]}");

		// Calcular dias adicionais para final de semana
		$diasAd = 1;
		$diaSem = (int) $vencimento->format('w'); // Dia da semana
		if ($diaSem == 0) {
			$diasAd += 2; // Se domingo, adicionar 2 dias
		} elseif ($diaSem == 5 || $diaSem == 6) {
			$diasAd += 3; // Se sexta ou sábado, adicionar 3 dias
		}

		// Calcular o número de dias entre hoje e a data de vencimento
		$intervalo = $vencimento->diff($dthj);
		$dias = $intervalo->format('%a') + $diasAd; // Número de dias

		// Calcular juros ao dia com base no número de dias do mês atual
		$diasMes = (int) $dthj->format('t'); // Número de dias do mês atual
		$jurosDia = round($jurosMensais / $diasMes, 2); // Mantendo quatro casas decimais para precisão


		// Calcular o valor do desconto
		$valorDesconto = round(($valor * ($jurosDia / 100) * $dias), 2);

		// Armazenar resultados
		$resultado = [
			'nota_fiscal' => $op['nota'],
			'vencimento' => $vencimento->format('d/m/Y'),
			'valor' => number_format($valor, 2, ',', '.'), // Formatando como moeda
			'juros_mes' => number_format($jurosMensais, 2, ',', '.') . '%',
			'dias' => $dias,
			'juros_dia' => number_format($jurosDia, 4, ',', '.'),
			'valor_desconto' => $valorDesconto
		];

		$resultados[] = $resultado;
	}

	return $resultados;
}




$id = htmlspecialchars($_GET["id"]);
$fornecedor  = new fornecedores();
$fornecedor->setId($id);
$fornecedor = $fornecedor->SelectId();

$ASQL = new operacoes();
$ASQL->setCnpj($fornecedor['cnpj']);
$ASQL = $ASQL->Total_UsadoLimite();

$totalUsado = $ASQL['totalUsado'];
$limite = $fornecedor['limite'];
$porcentagemUsada = 0;
if ($limite > 0) {
	// Calcula a porcentagem usada
	$porcentagemUsada = number_format(($totalUsado / $limite) * 100, 2);
}


// Exibe o resultado


?>
<!DOCTYPE html>
<html lang="en">
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
						<!--begin::Ro			w-->
						<div class="row g-5 g-xl-8">
							<div class="col-xl-12">
								<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
									<!--begin::Card header-->
									<div class="card-header cursor-pointer">
										<!--begin::Card title-->
										<div class="card-title m-0">
											<h3 class="fw-bolder m-0">Detalhes do Cliente</h3>
										</div>
										<!--end::Card title-->
										<!--begin::Action-->
										<a href="#" onClick="abre_dados(<?php echo $fornecedor['id'] ?>);" class="btn btn-primary align-self-center">Editar Dados</a>
										<!--end::Action-->
									</div>
									<!--begin::Card header-->
									<!--begin::Card body-->
									<div class="card-body p-9">
										<!--begin::Row-->
										<div class="row mb-7">
											<!--begin::Label-->
											<label class="col-lg-4 fw-bold text-muted">Tipo de Registro:</label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8">
												<span class="fw-bolder fs-6 text-gray-800"><?php echo $fornecedor["tipo"]; ?></span>
											</div>
											<!--end::Col-->
										</div>

										<div class="row mb-7">
											<!--begin::Label-->
											<label class="col-lg-4 fw-bold text-muted">Razão Social:</label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8">
												<span class="fw-bolder fs-6 text-gray-800"><?php echo $fornecedor["razao"]; ?></span>
											</div>
											<!--end::Col-->
										</div>
										<!--end::Row-->
										<!--begin::Input group-->
										<div class="row mb-7">
											<!--begin::Label-->
											<label class="col-lg-4 fw-bold text-muted">CNPJ</label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8 fv-row">
												<span class="fw-bold text-gray-800 fs-6"><?php echo $fornecedor["cnpj"]; ?></span>
											</div>
											<!--end::Col-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="row mb-7">
											<!--begin::Label-->
											<label class="col-lg-4 fw-bold text-muted">Telefone
												<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Phone number must be active" aria-label="Phone number must be active"></i></label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8 d-flex align-items-center">
												<span class="fw-bolder fs-6 text-gray-800 me-2"><?php echo $fornecedor["telefone"]; ?></span>
												<span class="badge badge-success">Verified</span>
											</div>
											<!--end::Col-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="row mb-7">
											<!--begin::Label-->
											<label class="col-lg-4 fw-bold text-muted">E-mail</label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8">
												<a href="#" class="fw-bold fs-6 text-gray-800 text-hover-primary"><?php echo $fornecedor["email"]; ?></a>
											</div>
											<!--end::Col-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="row mb-7">
											<!--begin::Label-->
											<label class="col-lg-4 fw-bold text-muted">Endereço
												<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Country of origination" aria-label="Country of origination"></i></label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8">
												<span class="fw-bolder fs-6 text-gray-800"><?php echo $fornecedor["rua"]; ?>, <?php echo $fornecedor["numero"]; ?>, <?php echo $fornecedor["bairro"]; ?>, <?php echo $fornecedor["cidade"]; ?> - <?php echo $fornecedor["estado"]; ?> / <?php echo $fornecedor["cep"]; ?></span>
											</div>
											<!--end::Col-->
										</div>
										<!--end::Input group-->
										<!--begin::Input group-->
										<div class="row mb-7">
											<!--begin::Label-->
											<label class="col-lg-4 fw-bold text-muted">Representante</label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8">
												<span class="fw-bolder fs-6 text-gray-800"><?php echo $fornecedor["representante"]; ?> <small><?php echo $fornecedor["cpf"]; ?></small></span>
											</div>
											<!--end::Col-->
										</div>

										<div class="row mb-7">
											<!--begin::Label-->
											<label class="col-lg-4 fw-bold text-muted">Taxas:</label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8">
												<span class="fw-bolder fs-6 text-gray-800">Juros: <?php echo $fornecedor["juros"]; ?> | TAC: <?php echo $fornecedor["tac"]; ?> | Boleto: <?php echo $fornecedor["boleto"]; ?> | TED: <?php echo $fornecedor["ted"]; ?></span>
											</div>
											<!--end::Col-->
										</div>
										<div class="row mb-7">
											<!--begin::Label-->
											<label class="col-lg-4 fw-bold text-muted">Dados Bancários:</label>
											<!--end::Label-->
											<!--begin::Col-->
											<div class="col-lg-8">
												<span class="fw-bolder fs-6 text-gray-800">Banco: <?php echo $fornecedor["banco"]; ?> | Agência: <?php echo $fornecedor["agencia"]; ?> | Conta: <?php echo $fornecedor["conta"]; ?></span>
											</div>
											<!--end::Col-->
										</div>
										<div class="row mb-7">
											<!-- Button trigger modal -->
											<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
												Enviar E-mail
											</button>

											<!-- Modal -->
											<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Selecione o E-mail desejado.</h5>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<select class="form-select" id="EmailType">
																<option selected>Selecione</option>
																<option value="1">E-mail Boas Vindas</option>
																<option value="2">Email de Duplicatas Disponíveis</option>
																<!-- <option value="3">E-mail de Assinatura da Operação</option>
																				<option value="4">E-mail de Resumo da Operação</option> -->
															</select>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
															<button type="button" class="btn btn-primary" onclick="SendMail(<?php echo $fornecedor['id']; ?>)">Enviar</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!--end::Input group-->
									<!--begin::Notice-->
									<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
										<!--begin::Icon-->
										<!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
										<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
												<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black"></rect>
												<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black"></rect>
											</svg>
										</span>
										<!--end::Svg Icon-->
										<!--end::Icon-->
										<!--begin::Wrapper-->
										<div class="d-flex flex-stack flex-grow-1">
											<!--begin::Content-->
											<div class="fw-bold">
												<h4 class="text-gray-900 fw-bolder">Atenção</h4>
												<div class="fs-6 text-gray-700">Cliente já utilizou mais de <?php echo $porcentagemUsada; ?>% do limite disponível.</div>
											</div>
											<!--end::Content-->
										</div>

										<!--end::Wrapper-->
									</div>
									<!--end::Notice-->
								</div>
							</div>
						</div>


						<div class="row g-5 g-xl-8">
							<div class="col-xl-12">


								<div class="row g-5 g-xl-8">
									<div class="col-xl-6">
										<!--begin::Statistics Widget 5-->
										<a href="operacoes.php" class="card bg-body hoverable card-xl-stretch mb-xl-8">
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
												$totaloperado = new antecipadas();
												$totaloperado->setFornecedor($fornecedor["id"]);
												$totaloperado = $totaloperado->TotalAntecipadasFornecedor();
												if ($totaloperado["valor"] !== null) {
													$valormontante = ($totaloperado["valor"]);
												} else {
													$valormontante = 0.00;
												}
												?>
												<div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">R$ <?php echo number_format($valormontante, 2, ',', '.'); ?></div>
												<div class="fw-bold text-gray-400">Operado</div>
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

												<div class="text-white fw-bolder fs-2 mb-2 mt-5">R$ <?php echo number_format($fornecedor['limite'], 2, ',', '.'); ?></div>
												<div class="fw-bold text-white">Limite Total, Disponível (R$ <?php echo number_format($fornecedor['limite'] - $valormontante, 2, ',', '.'); ?> )</div>
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
												<span class="card-label fw-bolder fs-3 mb-1">Últimas Operações Realizadas</span>
												<span class="text-muted mt-1 fw-bold fs-7">Abaixo listamos as últimas operações realizadas.</span>
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
															<th class="min-w-200px">Fornecedor</th>
															<th class="min-w-100px">Transação Id</th>
															<th class="min-w-120px">Data</th>
															<th class="min-w-80px">Valor</th>
															<th class="min-w-80px">Assinado</th>
															<th class="min-w-120px">Status</th>
														</tr>
													</thead>
													<tbody>

														<?php
														$antecipadas = new antecipadas();
														$antecipadas->setFornecedor($fornecedor['id']);
														$antecipadas = $antecipadas->AntecipadasFornecedor();

														foreach ($antecipadas as $row) {
															//	$quantidade = mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT count(*) as totaldupli FROM antecipadas as a, antecipadasDetalhes as ad WHERE a.fornecedor = '{$_SESSION["id"]}' AND ad.antecipada = '{$row['id']}'")) or die(mysqli_error());
															///	$fornecedor = mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT * FROM fornecedores WHERE id = '{$row['fornecedor']}'")) or die(mysqli_error());
															$fornecedor = new fornecedores();
															$fornecedor->setId($row['fornecedor']);
															$fornecedor = $fornecedor->SelectID();

														?>
															<tr>
																<td>
																	<a href="fornecedor.php?id=<?php echo $fornecedor['id']; ?>" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $fornecedor["razao"]; ?></a>
																	<span class="text-muted fw-bold text-muted d-block fs-7"><?php echo $fornecedor["cnpj"]; ?></span>
																</td>
																<td>
																	<a href="operacao.php?id=<?php echo $row['id']; ?>" class="text-dark fw-bolder text-hover-primary fs-6">0000<?php echo $row["id"]; ?></a>
																</td>

																<td>
																	<div class="fs-6 text-gray-800 fw-bolder"><?php echo date('d/m/Y', strtotime($row["data"])); ?></div>
																	<span class="text-muted fw-bold text-muted d-block fs-7">link para nota</span>
																</td>
																<td>
																	<div class="fs-6 text-gray-800 fw-bolder">R$ <?php echo number_format($row['valorOriginal'], 2, ',', '.'); ?></div>
																</td>
																<td>
																	<span class="badge badge-light-danger">Não Assinado</span>
																	<a href="<?php echo 'contratos/contrato_' . $fornecedor['cnpj'] . '_' . $row["id"] . '.pdf'; ?>" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
																		<!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
																		<span class="svg-icon svg-icon-3">
																			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																				<path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
																				<path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
																			</svg>
																		</span>
																		<!--end::Svg Icon-->
																	</a>
																</td>
																<td>
																	<span class="badge badge-light-warning">Não Paga</span>
																	<a href="index.php?a=paga&ope=<?php echo $row['id']; ?>" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
																		<span class="svg-icon svg-icon-2">
																			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																				<path opacity="0.3" d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" fill="black"></path>
																				<path d="M20 8L14 2V6C14 7.10457 14.8954 8 16 8H20Z" fill="black"></path>
																				<path d="M10.3629 14.0084L8.92108 12.6429C8.57518 12.3153 8.03352 12.3153 7.68761 12.6429C7.31405 12.9967 7.31405 13.5915 7.68761 13.9453L10.2254 16.3488C10.6111 16.714 11.215 16.714 11.6007 16.3488L16.3124 11.8865C16.6859 11.5327 16.6859 10.9379 16.3124 10.5841C15.9665 10.2565 15.4248 10.2565 15.0789 10.5841L11.4631 14.0084C11.1546 14.3006 10.6715 14.3006 10.3629 14.0084Z" fill="black"></path>
																			</svg>
																		</span>
																	</a>
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
														<div id="kt_datatable_example_2_export" class="d-none"></div>
														<!--end::Export buttons-->
													</div>
													<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
														<!--begin::Export dropdown-->
														<button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
															Exportar
														</button>
														<!--begin::Menu-->
														<div id="kt_datatable_example_2_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true">
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
												<table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable_example_2">
													<!--begin::Table head-->
													<thead>
														<tr class="fw-bolder text-muted">
															<th class="min-w-200px">Razao Social</th>
															<th class="min-w-100px">Nota</th>
															<th class="min-w-100px">Data</th>
															<th class="min-w-120px">Valor (R$)</th>
															<th class="min-w-60px">Limite Tomado (R$)</th>
															<th class="min-w-80px">Tarifa %</th>
															<th class="min-w-80px">Dias</th>
															<th class="min-w-80px">Descontos</th>
															<th class="min-w-120px">Status</th>
														</tr>
													</thead>
													<tbody>
														<?php


														$operacoes = new operacoes();
														$operacoes->setCnpj($fornecedor['cnpj']);
														$operacoes = $operacoes->Get_Operacoes_By_Cnpj_order_by_Vencimento();
														$wsind = 0;
														foreach ($operacoes as $ope) {

															// Exemplo de uso
															$operacoes = [
																[
																	'nota' => $ope["nota"],
																	'valor' => $ope["valor"],
																	'vencimento' => $ope["vencimento"]
																]
															];

															$jurosMensais = $fornecedor["juros"]; // Taxa de juros mensal em percentual

															$resultado = calcularValores($operacoes, $jurosMensais);

															
															$desconto = floatval(str_replace(',', '', $resultado[0]["valor_desconto"]));
															$valorOp = floatval(str_replace(',', '', $ope["valor"]));
															if ($resultado[0]["dias"] >= 7 && $desconto < $valorOp) {
																$valorOriginalTotal += $ope["valor"];
																$descontoTotal += $resultado[0]["valor_desconto"];
																$wsind++;
														?>
																<tr>
																	<td>
																		<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $fornecedor["razao"]; ?></a>
																	</td>
																	<td>
																		<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $ope["nota"]; ?></a>
																	</td>
																	<td>
																		<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php if ($ope["vencimento"] !== '0000-00-00') {
																																							echo date('d/m/Y', strtotime($ope["vencimento"]));
																																						} else {
																																							echo '00-00-0000';
																																						} ?></a>
																	</td>
																	<td class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo number_format($ope["valor"], 2, ',', '.'); ?></td>
																	<td>
																		<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $fornecedor["limite"]; ?></a>
																	</td>
																	<td>
																		<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $fornecedor["juros"]; ?></a>
																	</td>
																	<td>
																		<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $resultado[0]["dias"]; ?></a>
																	</td>
																	<td>
																		<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo number_format($resultado[0]["valor_desconto"], 2, ',', '.'); ?></a>
																	</td>
																	<td>
																		<?php if ($ope['status'] == '0') { ?>
																			<span class="badge badge-light-success">Disponível</span>
																		<?php } else { ?>
																			<span class="badge badge-light-danger">Operada</span>
																		<?php } ?>
																	</td>

																</tr>
														<?php }
														} ?>
													</tbody>
													<tfoot>
														<?php
														$taxas = ($fornecedor['boleto'] * $wsind) + $fornecedor['tac'] + $fornecedor['ted'];
														$Total = round($valorOriginalTotal - ($descontoTotal + $taxas), 2);
														?>
														<tr>

															<td>
																<span class="text-muted fw-bold d-block fs-7"></span>
																<span class="text-dark fw-bolder d-block fs-5"></span>
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
																<span class="text-dark fw-bolder d-block fs-5"><?php echo number_format($valorOriginalTotal, 2, ',', '.') ?></span>
															</td>
															<td>
																<span class="text-muted fw-bold d-block fs-7"></span>
																<span class="text-dark fw-bolder d-block fs-5"></span>
															</td>
															<td>
																<span class="text-muted fw-bold d-block fs-7">desconto taxas</span>
																<span class="text-dark fw-bolder d-block fs-5"><?php echo $taxas; ?></span>
															</td>
															<td>
																<span class="text-muted fw-bold d-block fs-7"></span>
																<span class="text-dark fw-bolder d-block fs-5"></span>
															</td>
															<td>
																<span class="text-muted fw-bold d-block fs-7">desconto juros</span>
																<span class="text-dark fw-bolder d-block fs-5"><?php echo number_format($descontoTotal, 2, ',', '.') ?></span>
															</td>

															<td>
																<span class="text-muted fw-bold d-block fs-7">valor antecipação</span>
																<span class="text-dark fw-bolder d-block fs-5"><?php echo number_format($Total, 2, ',', '.') ?></span>
															</td>

														</tr>
													</tfoot>
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
	<script src="../assets/js/custom/modals/upgrade-plan.js"></script>
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


		// Class definition
		var KTDatatablesButtons2 = function() {
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
				}).container().appendTo($('#kt_datatable_example_2_export'));

				// Hook dropdown menu click event to datatable export buttons
				const exportButtons = document.querySelectorAll('#kt_datatable_example_2_export_menu [data-kt-export]');
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
					table = document.querySelector('#kt_datatable_example_2');

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
			KTDatatablesButtons2.init();
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
										//e.preventDefault(),
										// n &&
										// n.validate().then(function(e) {

										//	if (e == 'Valid') {

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


										//	} else {
										//		Swal.fire({
										//			text: "Desculpe, parece que foram detectados alguns erros. Tente novamente.",
										//			icon: "error",
										//			buttonsStyling: !1,
										//			confirmButtonText: "Ok!",
										//			customClass: {
										//				confirmButton: "btn btn-primary"
										//			},
										//		});
										//	}




										//});
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


		function SendMail(id_fornrcedor) {
			var id_fornrcedor;
			var EmailType = $('#EmailType').val();
			if (EmailType !== 'Selecione') {
				var url = "sendMail.php";
				var operacao = "<?php echo $idOp; ?>";
				$.ajax({
					url: url, // URL to send the request
					method: "POST", // HTTP method to use (GET, POST, PUT, DELETE, etc.)
					data: {
						id_fornecedor: id_fornrcedor,
						type: EmailType,
						operacao: operacao
					},
					success: function(response) { // Callback function to handle a successful request
						Swal.fire({
							position: "top-end",
							icon: "success",
							title: "E-mail enviado com suscesso!",
							showConfirmButton: false,
							timer: 1500
						});
						$('#exampleModal').modal('toggle');
						console.log(response);
					},
					error: function(xhr, status, error) { // Callback function to handle errors
						// Code to execute when there's an error with the request
						console.log("Error: " + error); // Log the error to the console
						$("#result").html("Error occurred: " + error); // Display the error message on the page
					}
				});



			} else {
				Swal.fire({
					title: "Selecione o E-mail desejado.",
					showClass: {
						popup: `
					animate__animated
					animate__fadeInUp
					animate__faster
    				`
					},
					hideClass: {
						popup: `
					animate__animated
					animate__fadeOutDown
					animate__faster
					`
					}
				});
			}

		}
	</script>
</body>

</html>