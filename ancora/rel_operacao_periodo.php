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
	<link rel="shortcut icon" href="../assets/agricopel/misc/LSC-icone.png" />

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
						
							
						</div>

					

						<div class="row gy-5 g-xl-8">
							<!--begin::Col-->
							<div class="col-xl-12">
								<div class="col-xl-12">
									<div class="card mb-5 mb-xl-8">
										<div class="card-header border-0 pt-5">
											<h3 class="card-title align-items-start flex-column">
												<span class="card-label fw-bolder fs-3 mb-1">Relatório de Operações por período </span>
												<span class="text-muted mt-1 fw-bold fs-7"></span>
											</h3>

										</div>
                                        <div id="kt_datatable_example_1_export" class="d-none"></div>

										<div class="card-body py-3">
											<form name="filtro" method="get" style="width: 100%;" action="rel_operacao_periodo.php">
												<div class="row">
													<div class="col-md-3">
														<select name="status" class="form-control" id="Fstatus">
															<option value="">Todas</option>
															<option value="4" <?php //if($status == "4") { echo "selected"; } 
																				?>>Assinado</option>
															<option value="1" <?php //if($status == "1") { echo "selected"; } 
																				?>>Não Assinado</option>
														</select>
													</div>

													<div class="col-md-2">
														<input type="date" name="inicio" id="Finicio" class="form-control" value="<?php echo $inicio; ?>">
													</div>
													<div class="col-md-2">
														<input type="date" name="termino" id="Ftermino" class="form-control" value="<?php echo $termino; ?>">
													</div>
													<div class="col-md-1 col-sm-2">
														<input type="submit" name="envio" class="form-control" value="Filtrar">
													</div>
													<div class="card-toolbar flex-row-fluid justify-content-end col-md-2">
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
																<a href="#" class="menu-link px-3" onclick="PDF()">
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
															<th class="min-w-80px">Valor Original</th>
															<th class="min-w-80px">Valor Juros Cobrados</th>
															<th class="min-w-80px">Valor Taxas Cobradas</th>
															<th class="min-w-80px">Valor Liquido </th>
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
																		<div class="fs-6 text-gray-800 fw-bolder">R$ <?php echo number_format($row['valor'], 2, ',', '.'); ?></div>
																	</td>
                                                                    <td>
																		<div class="fs-6 text-gray-800 fw-bolder">R$ <?php echo number_format($juros, 2, ',', '.'); ?></div>
																	</td>
                                                                    <td>
																		<div class="fs-6 text-gray-800 fw-bolder">R$ <?php echo number_format($postergacoesDetalhes['taxas'], 2, ',', '.'); ?></div>
																	</td>
																	<td>
																		<div class="fs-6 text-gray-800 fw-bolder">R$ <?php echo number_format($valorRow, 2, ',', '.'); ?></div>
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
																	<div class="fs-6 text-gray-800 fw-bolder">R$<?php echo number_format($ant['valorOriginal'], 2, ',', '.');
																												?></div>
																</td>
                                                                <td>
																	<div class="fs-6 text-gray-800 fw-bolder">R$<?php echo number_format($ant['descontoJuros'], 2, ',', '.');
																												?></div>
																</td>
                                                                <td>
																	<div class="fs-6 text-gray-800 fw-bolder">R$<?php echo number_format($ant['descontoTaxas'], 2, ',', '.');
																												?></div>
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

			

			// Public methods
			return {
				init: function() {
					table = document.querySelector('#kt_datatable_example_1');

					if (!table) {
						return;
					}

					initDatatable();
					exportButtons();
					// handleSearchDatatable();
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
function PDF(){
	let status = $('#Fstatus').val();
	let inicio = $('#Finicio').val();
	let termino = $('#Ftermino').val();
	var url = 'rel_operacoes.php?status=' + status+'&inicio='+inicio+'&termino='+termino;
	window.open(url , '_blank');
}
	</script>
</body>

</html>