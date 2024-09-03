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

$id = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : null;
$id_postergacao = isset($_GET["id_postergacao"]) ? htmlspecialchars($_GET["id_postergacao"]) : null;
$idOp = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : htmlspecialchars($_GET["id_postergacao"]);
$acao = isset($_GET['a']) ? htmlspecialchars($_GET['a']) : null;
if ($acao == 'confirmar') {
	$id = mysqli_escape_string($lawsmt, $_GET['id_confirmar']);

	// echo "SELECT * FROM operacoes WHERE id = '{$id}'";
	$query = mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT * FROM operacoes WHERE id = '{$id}'"));
	// echo "QUERY IS".$query;

	if ($query['confirmada'] == '1') {
		$status = 0;
	} else {
		$status = 1;
	}
	$query = mysqli_query($lawsmt, "UPDATE operacoes SET confirmada = '{$status}' WHERE id = '{$id}'");
	echo "<script>alert('Operação confirmada com sucesso.');</script>";
}
// echo "ID POSTERGACAO IS".strlen($id_postergacao);
if (is_null($id_postergacao)) {

	$operacao  = new antecipadas();
	$operacao->setId($id);
	$operacao = $operacao->Select();
	if ($operacao) {
		$fornecedor  = new fornecedores();
		$fornecedor->setId($operacao['fornecedor']);
		$fornecedor = $fornecedor->SelectID();
	}
} else {
	$operacao  = new operacoes();
	$operacao = $operacao->Get_Operaco($id_postergacao);
	$operacao = $operacao[0];
	$fornecedor  = new fornecedores();
	$fornecedor->setCnpj($operacao['cnpj']);
	$fornecedor = $fornecedor->SelectCnpj();
}
// echo "FOUND OPERAÇÃO".$operacao;

if ($operacao == false) {
	$operacao = new operacoes();
	$operacao->setId($id);
	$operacao = $operacao->Get_OperacoAndId();
	// mysqli_fetch_assoc(mysqli_query($lawsmt, "select operacoes.*, postergacoesDetalhes.valorOriginal as valorOriginal, sum(postergacoesDetalhes.juros) as descontoJuros, sum(postergacoesDetalhes.taxas) as descontoTaxas from operacoes
	// left join postergacoesDetalhes on operacoes.id in (postergacoesDetalhes.id_operacao, postergacoesDetalhes.id_postergada, postergacoesDetalhes.id_postergada) WHERE operacoes.id = '{$id}'"));
	//$fornecedor  = mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT * FROM fornecedores WHERE cnpj like {$operacao['cnpj']} limit 1"));	
	$fornecedor  = new fornecedores();
	$fornecedor->setCnpj($operacao['cnpj']);
	$fornecedor = $fornecedor->SelectCnpj();
}
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

	<link href="../assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
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


								<div class="row g-5 g-xl-8">
									<div class="col-xl-4">

										<div class="card card-xl-stretch mb-xl-8">
											<!--begin::Body-->
											<div class="card-body p-0">
												<!--begin::Header-->
												<div class="px-9 pt-7 card-rounded h-275px w-100 bg-primary">
													<!--begin::Heading-->
													<div class="d-flex flex-stack">
														<h3 class="m-0 text-white fw-bolder fs-3">Operação 000<?php echo $idOp; ?></h3>

													</div>
													<div class="d-flex text-center flex-column text-white pt-8">
														<span class="fw-bold fs-7">Valor da Operação</span>
														<span class="fw-bolder fs-2x pt-1">R$ <?php if ($operacao['valor'] != null) {
																									echo number_format($operacao['valor'], 2, ',', '.');
																								} else {
																									echo '0,00';
																								} ?></span>
													</div>
												</div>



												<div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -90px">
													<div class="d-flex align-items-center mb-6">
														<div class="symbol symbol-45px w-40px me-5">
															<span class="symbol-label bg-lighten">
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z" fill="black" />
																		<path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z" fill="black" />
																	</svg>
																</span>
															</span>
														</div>
														<div class="d-flex align-items-center flex-wrap w-100">
															<div class="mb-1 pe-3 flex-grow-1">
																<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bolder">Valor Operado</a>
															</div>
															<div class="d-flex align-items-center">
																<div class="fw-bolder fs-5 text-gray-800 pe-1">R$ <?php if ($operacao['valorOriginal'] != null) {
																														echo number_format($operacao['valorOriginal'], 2, ',', '.');
																													} else {
																														echo '0,00';
																													} ?></div>
																<span class="svg-icon svg-icon-5 svg-icon-success ms-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
																		<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
																	</svg>
																</span>
															</div>
														</div>
													</div>
												</div>
												<div style="clear: both;">&nbsp;</div>

												<div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -90px">
													<div class="d-flex align-items-center mb-6">
														<div class="symbol symbol-45px w-40px me-5">
															<span class="symbol-label bg-lighten">
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z" fill="black" />
																		<path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z" fill="black" />
																	</svg>
																</span>
															</span>
														</div>
														<div class="d-flex align-items-center flex-wrap w-100">
															<div class="mb-1 pe-3 flex-grow-1">
																<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bolder">Juros</a>
															</div>
															<div class="d-flex align-items-center">
																<div class="fw-bolder fs-5 text-gray-800 pe-1">R$ <?php if ($operacao['descontoJuros'] != null) {
																														echo number_format($operacao['descontoJuros'], 2, ',', '.');
																													} else {
																														echo '0,00';
																													} ?></div>
																<span class="svg-icon svg-icon-5 svg-icon-success ms-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
																		<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
																	</svg>
																</span>
															</div>
														</div>
													</div>
												</div>
												<div style="clear: both;">&nbsp;</div>

												<div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -90px">
													<div class="d-flex align-items-center mb-6">
														<div class="symbol symbol-45px w-40px me-5">
															<span class="symbol-label bg-lighten">
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z" fill="black" />
																		<path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z" fill="black" />
																	</svg>
																</span>
															</span>
														</div>
														<div class="d-flex align-items-center flex-wrap w-100">
															<div class="mb-1 pe-3 flex-grow-1">
																<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bolder">Taxas</a>
															</div>
															<div class="d-flex align-items-center">
																<div class="fw-bolder fs-5 text-gray-800 pe-1">R$ <?php if ($operacao['descontoTaxas'] != null) {
																														echo number_format($operacao['descontoTaxas'], 2, ',', '.');
																													} else {
																														echo '0,00';
																													} ?></div>
																<span class="svg-icon svg-icon-5 svg-icon-success ms-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
																		<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
																	</svg>
																</span>
															</div>
														</div>
													</div>
												</div>
												<div style="clear: both;">&nbsp;</div>

												<div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -90px">
													<div class="d-flex align-items-center mb-6">
														<div class="symbol symbol-45px w-40px me-5">
															<span class="symbol-label bg-lighten">
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M18.4 5.59998C21.9 9.09998 21.9 14.8 18.4 18.3C14.9 21.8 9.2 21.8 5.7 18.3L18.4 5.59998Z" fill="black" />
																		<path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM19.9 11H13V8.8999C14.9 8.6999 16.7 8.00005 18.1 6.80005C19.1 8.00005 19.7 9.4 19.9 11ZM11 19.8999C9.7 19.6999 8.39999 19.2 7.39999 18.5C8.49999 17.7 9.7 17.2001 11 17.1001V19.8999ZM5.89999 6.90002C7.39999 8.10002 9.2 8.8 11 9V11.1001H4.10001C4.30001 9.4001 4.89999 8.00002 5.89999 6.90002ZM7.39999 5.5C8.49999 4.7 9.7 4.19998 11 4.09998V7C9.7 6.8 8.39999 6.3 7.39999 5.5ZM13 17.1001C14.3 17.3001 15.6 17.8 16.6 18.5C15.5 19.3 14.3 19.7999 13 19.8999V17.1001ZM13 4.09998C14.3 4.29998 15.6 4.8 16.6 5.5C15.5 6.3 14.3 6.80002 13 6.90002V4.09998ZM4.10001 13H11V15.1001C9.1 15.3001 7.29999 16 5.89999 17.2C4.89999 16 4.30001 14.6 4.10001 13ZM18.1 17.1001C16.6 15.9001 14.8 15.2 13 15V12.8999H19.9C19.7 14.5999 19.1 16.0001 18.1 17.1001Z" fill="black" />
																	</svg>
																</span>
															</span>
														</div>
														<div class="d-flex align-items-center flex-wrap w-100">
															<div class="mb-1 pe-3 flex-grow-1">
																<a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bolder">Quantidade de Duplicatas</a>
															</div>
															<div class="d-flex align-items-center">
																<div class="fw-bolder fs-5 text-gray-800 pe-1">
																	<?php
																	if (isset($_GET['id'])) {
																		$quantidade = new antecipadasDetalhes();
																		$quantidade->setId($id);
																		$quantidade = $quantidade->Select_antecipadasDetalhes();
																		if ($quantidade) {
																			echo $quantidade["totaldupli"];
																		} else {
																			echo "0";
																		}
																	}
																	if (isset($_GET['id_postergacao'])) {
																		$quantidade = new postergacoesDetalhes();
																		$quantidade->setId_postergacao($id_postergacao);
																		$quantidade = $quantidade->CountOp();
																		if ($quantidade) {
																			echo $quantidade["totaldupli"];
																		} else {
																			echo "0";
																		}
																	}
																	?>
																</div>
																<span class="svg-icon svg-icon-5 svg-icon-success ms-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
																		<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
																	</svg>
																</span>
															</div>
														</div>
													</div>
												</div>
												<div style="clear: both;">&nbsp;</div>

											</div>
											<!--end::Body-->
										</div>
										<!--end::Mixed Widget 1-->
									</div>

									<div class="col-xl-8">
										<div class="row g-5 g-xl-8">
											<div class="col-xl-12">
												<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
													<!--begin::Card header-->
													<div class="card-header cursor-pointer">
														<!--begin::Card title-->
														<div class="card-title m-0">
															<h3 class="fw-bolder m-0">Detalhes do Fornecedor</h3>
														</div>
														<!--end::Card title-->
														<!--begin::Action-->

														<!--end::Action-->
													</div>
													<!--begin::Card header-->
													<!--begin::Card body-->
													<div class="card-body p-9">
														<!--begin::Row-->
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
																				<!-- <option value="1">E-mail Boas Vindas</option>
																				<option value="2">Email de Duplicatas Disponíveis</option> -->
																				<option value="3">E-mail de Assinatura da Operação</option>
																				<option value="4">E-mail de Resumo da Operação</option>
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

												</div>
											</div>
										</div>
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
														$totaloperado = new antecipadas();
														$totaloperado->setFornecedor($fornecedor['id']);
														$totaloperado = $totaloperado->TotalAntecipadasFornecedor();
														$totaloperado_postergacao = new postergacoesDetalhes();
														$totaloperado_postergacao->setId_operacao($operacao['id']);
														$totaloperado_postergacao = $totaloperado_postergacao->Select_totaloperado_postergacao();
														$valormontante = ($totaloperado["valor"] + $totaloperado_postergacao['valor']);
														?>
														<div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">R$ <?php if ($operacao['valorOriginal'] !== null) {
																													echo number_format($operacao['valorOriginal'], 2, ',', '.');
																												} else {
																													echo '0,00';
																												}; ?></div>
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
									<div class="col-xl-12">
										<div class="col-xl-12">
											<div class="card mb-5 mb-xl-8">
												<div class="card-header border-0 pt-5">
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bolder fs-3 mb-1">Duplicatas desta Operação</span>
														<span class="text-muted mt-1 fw-bold fs-7">Abaixo listamos as todas as duplicatas inseridas nesta Operação.</span>
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
																	<th class="min-w-100px">Vencimento</th>
																	<th class="min-w-120px">Valor Original</th>
																	<th class="min-w-60px">Desconto/Custo Prorrogação</th>
																	<th class="min-w-80px">Valor Final</th>
																	<th class="min-w-80px">Status</th>
																	<th class="min-w-80px">Boleto</th>
																</tr>
															</thead>
															<tbody>
																<?php
																if (is_null($id_postergacao)) {
																	// fetch antecipação detail
																	$operacoes = new antecipadasDetalhes();
																	$operacoes->setId($id);
																	$operacoes = $operacoes->antecipadasDetalhesDuplicatas();

																	$NumR =  count($operacoes);
																	if ($NumR > 0) {
																		if (is_null($id_postergacao)) {

																			$operacoe = new operacoes();
																			$operacoe = $operacoe->Get_NotaOperaco($id);
																			if ($operacoe) {
																				$is_postergacao = true;
																			} else {
																				$is_postergacao = false;
																			}
																		}
																	}

																	$total_rows = count($operacoes);
																	foreach ($operacoes as $ope) {
																		if ($is_postergacao == true) {

																			$ape = new operacoes();
																			$ape  = $ape->Get_NotaOperacao_boletoPostergado($ope['operacao']);

																			$valor_original = $ape['valorOriginal'];
																			$desconto_total = $ape['juros'] + $ape['taxas'];
																			$valor_final = $valor_original + $desconto_total;
																			$data_vencimento = $ope['vencimento'];
																		} else {

																			$ape = new operacoes();
																			$ape = $ape->Get_NotaOperacao_boletAntecipado($ope['operacao']);
																			//  mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT *, boletos.status as status_boleto, boletos.id as id_boleto FROM operacoes left join boletos on boletos.operacao = operacoes.id inner join antecipadasDetalhes on antecipadasDetalhes.operacao = operacoes.id WHERE operacoes.id = '{$ope['operacao']}'"));
																			$valor_original = $ope['valorOriginal'];
																			$desconto_juros = $ope['descontoJuros'];
																			$desconto_taxas = ($ope['descontoTaxas'] / $total_rows);
																			$desconto_total = $desconto_taxas + $desconto_juros;
																			$valor_final = $valor_original - $desconto_total;
																			$data_vencimento = $ope['vencimento'];
																		}
																?>
																		<tr>
																			<td>
																				<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $fornecedor["razao"]; ?></a>
																			</td>
																			<td>
																				<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $ape["nota"]; ?></a>
																			</td>
																			<td>
																				<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo date('d/m/Y', strtotime($data_vencimento)); ?></a>
																			</td>
																			<td class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo number_format($valor_original, 2, ',', '.'); ?></td>
																			<td>
																				<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo number_format($desconto_total, 2, ',', '.'); ?></a>
																			</td>
																			<td>
																				<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo number_format($valor_final, 2, ',', '.'); ?></a>
																			</td>
																			<td> </td>
																			<td>
																				<?php
																				if ($ope['id'] && $ape['status_boleto'] != '9') {
																				?>
																					<a target="_blank" href="imprime_boleto.php?id=<?php echo $ape['id_boleto']; ?>">
																						<button data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Imprimir Boleto" class="btn btn-active-icon-primary btn-active-text-primary" style="margin:0; padding:0;" id="efetuar-antecipadas">
																							<span class="svg-icon svg-icon-muted svg-icon-1hx">
																								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.6 404.3">
																									<path class="svg-fill" d="M378.8 88.8h-55.1v75.8c0 10.5-8.5 18.9-19 18.9h-200c-10.5 0-19-8.5-19-18.9V88.8h-55c-10.5 0-18.9 8.5-19 18.9v186c0 10.5 8.5 18.9 18.9 19h348.1c10.5 0 18.9-8.5 19-19V107.8c.1-10.5-8.4-19-18.9-19z" />
																									<path class="svg-stroke" d="M409.6 226V107.8c0-17-13.8-30.8-30.8-30.8h-43.2V30.8c0-17-13.8-30.8-30.8-30.8H149.2c-8.2 0-16 3.2-21.8 9L83 53.6c-5.8 5.8-9 13.6-9 21.7V77H30.8C13.8 77 0 90.8 0 107.8v185.9c0 17 13.8 30.8 30.8 30.8h281.1v49c0 3.9-3.2 7.1-7.1 7.1h-200c-3.9 0-7.1-3.2-7.1-7.1v-13.9c0-6.5-5.3-11.8-11.8-11.8-6.5 0-11.8 5.3-11.8 11.8v13.9c0 17 13.8 30.8 30.8 30.8h200c17 0 30.8-13.8 30.8-30.8v-49h43.2c17 0 30.8-13.8 30.8-30.8v-67.5c-.1-.1-.1-.2-.1-.2zM97.7 75.3c0-1.9.7-3.7 2.1-5l44.4-44.5c1.3-1.3 3.1-2.1 5-2.1h155.6c3.9 0 7.1 3.2 7.1 7.1v133.8c0 3.9-3.2 7.1-7.1 7.1h-200c-3.9 0-7.1-3.2-7.1-7.1V75.3zm281.1 225.5h-348c-3.9 0-7.1-3.2-7.1-7.1v-55.9h50.2c6.5 0 11.8-5.3 11.8-11.8 0-6.5-5.3-11.8-11.8-11.8H23.7V107.8c0-3.9 3.2-7.1 7.1-7.1H74v64c0 17 13.8 30.8 30.8 30.8h200c17 0 30.8-13.8 30.8-30.8v-64h43.2c3.9 0 7.1 3.2 7.1 7.1v106.4h-50.2c-6.5 0-11.8 5.3-11.8 11.8 0 6.5 5.3 11.8 11.8 11.8h50.2v55.9c0 3.9-3.2 7.1-7.1 7.1z" />
																								</svg>
																							</span>
																						</button>
																					</a>
																				<?php
																				}
																				?>
																			</td>

																		</tr>
																	<?php }
																} else {
																	// echo "SELECT * FROM postergacoesDetalhes WHERE id_postergacao = '{$id_postergacao}' ORDER BY postergacoesDetalhes.id_postergacao ASC";
																	//$operacoes = mysqli_query($lawsmt, "SELECT * FROM postergacoesDetalhes WHERE id_postergacao = '{$id_postergacao}' ORDER BY postergacoesDetalhes.id_postergacao ASC");

																	$operacoes = new postergacoesDetalhes();
																	$operacoes->setId_operacao($id_postergacao);
																	$operacoes = $operacoes->Detales_postergacao();
																	foreach ($operacoes as $ope) {
																		//$ape = mysqli_fetch_assoc(mysqli_query($lawsmt, "SELECT operacoes.vencimento as vencimento, operacoes.nota as nota, operacoes.status as status, operacoes.confirmada as confirmada, operacoes.id as id, boletos.id as boleto_id from operacoes inner join boletos on operacoes.id = boletos.operacao where operacoes.id = {$ope['id_operacao']}"));

																		$ape = new postergacoesDetalhes();
																		$ape->setId_operacao($ope['id_operacao']);
																		$ape = $ape->Get_Operacao_Vencimento();
																		// var_dump($ope['id_operacao']);
																		// var_dump($ape);

																		$valor_original = $ope['valorOriginal'];
																		$desconto_juros = $ope['juros'];
																		$desconto_taxas = $ope['taxas'];
																		$desconto_total = $desconto_taxas + $desconto_juros;
																		$valor_final = $valor_original + $desconto_total;

																	?>
																		<tr>
																			<td>
																				<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $fornecedor["razao"]; ?></a>
																			</td>
																			<td>
																				<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $ape["nota"]; ?></a>
																			</td>
																			<td>
																				<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo date('d/m/Y', strtotime($ape["vencimento"])); ?></a>
																			</td>
																			<td class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo number_format($valor_original, 2, ',', '.'); ?></td>
																			<td>
																				<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo number_format($desconto_total, 2, ',', '.'); ?></a>
																			</td>
																			<td>
																				<a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo number_format($valor_final, 2, ',', '.'); ?></a>
																			</td>
																			<td>
																				<?php
																				if ($ape['status'] == 5 && $ape['confirmada'] == 0) {
																				?>
																					<a href="operacao.php?id_postergacao=<?php echo $id_postergacao; ?>&id_confirmar=<?php echo $ape['id'] ?>&a=confirmar">
																						<button data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Informar Pagamento" class="btn btn-active-icon-primary btn-active-text-primary" style="margin:0; padding:0;" id="efetuar-antecipadas">
																							<!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr016.svg-->
																							<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																									<path opacity="0.3" d="M10.3 14.3L11 13.6L7.70002 10.3C7.30002 9.9 6.7 9.9 6.3 10.3C5.9 10.7 5.9 11.3 6.3 11.7L10.3 15.7C9.9 15.3 9.9 14.7 10.3 14.3Z" fill="black" />
																									<path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM11.7 15.7L17.7 9.70001C18.1 9.30001 18.1 8.69999 17.7 8.29999C17.3 7.89999 16.7 7.89999 16.3 8.29999L11 13.6L7.70001 10.3C7.30001 9.89999 6.69999 9.89999 6.29999 10.3C5.89999 10.7 5.89999 11.3 6.29999 11.7L10.3 15.7C10.5 15.9 10.8 16 11 16C11.2 16 11.5 15.9 11.7 15.7Z" fill="black" />
																								</svg>
																							</span>
																							<!--end::Svg Icon-->
																						</button>
																					</a>
																				<?php } else {
																					echo "<span class='badge badge-light-success'>Confirmada</span>";
																				} ?>
																			</td>
																			<td>
																				<?php
																				?>
																				<a target="_blank" href="imprime_boleto.php?id=<?php echo $ape['boleto_id']; ?>">
																					<button data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="right" title="Imprimir Boleto" class="btn btn-active-icon-primary btn-active-text-primary" style="margin:0; padding:0;" id="efetuar-antecipadas">
																						<span class="svg-icon svg-icon-muted svg-icon-1hx">
																							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.6 404.3">
																								<path class="svg-fill" d="M378.8 88.8h-55.1v75.8c0 10.5-8.5 18.9-19 18.9h-200c-10.5 0-19-8.5-19-18.9V88.8h-55c-10.5 0-18.9 8.5-19 18.9v186c0 10.5 8.5 18.9 18.9 19h348.1c10.5 0 18.9-8.5 19-19V107.8c.1-10.5-8.4-19-18.9-19z" />
																								<path class="svg-stroke" d="M409.6 226V107.8c0-17-13.8-30.8-30.8-30.8h-43.2V30.8c0-17-13.8-30.8-30.8-30.8H149.2c-8.2 0-16 3.2-21.8 9L83 53.6c-5.8 5.8-9 13.6-9 21.7V77H30.8C13.8 77 0 90.8 0 107.8v185.9c0 17 13.8 30.8 30.8 30.8h281.1v49c0 3.9-3.2 7.1-7.1 7.1h-200c-3.9 0-7.1-3.2-7.1-7.1v-13.9c0-6.5-5.3-11.8-11.8-11.8-6.5 0-11.8 5.3-11.8 11.8v13.9c0 17 13.8 30.8 30.8 30.8h200c17 0 30.8-13.8 30.8-30.8v-49h43.2c17 0 30.8-13.8 30.8-30.8v-67.5c-.1-.1-.1-.2-.1-.2zM97.7 75.3c0-1.9.7-3.7 2.1-5l44.4-44.5c1.3-1.3 3.1-2.1 5-2.1h155.6c3.9 0 7.1 3.2 7.1 7.1v133.8c0 3.9-3.2 7.1-7.1 7.1h-200c-3.9 0-7.1-3.2-7.1-7.1V75.3zm281.1 225.5h-348c-3.9 0-7.1-3.2-7.1-7.1v-55.9h50.2c6.5 0 11.8-5.3 11.8-11.8 0-6.5-5.3-11.8-11.8-11.8H23.7V107.8c0-3.9 3.2-7.1 7.1-7.1H74v64c0 17 13.8 30.8 30.8 30.8h200c17 0 30.8-13.8 30.8-30.8v-64h43.2c3.9 0 7.1 3.2 7.1 7.1v106.4h-50.2c-6.5 0-11.8 5.3-11.8 11.8 0 6.5 5.3 11.8 11.8 11.8h50.2v55.9c0 3.9-3.2 7.1-7.1 7.1z" />
																							</svg>
																						</span>
																					</button>
																				</a>
																				<?php
																				?>
																			</td>
																		</tr>
																<?php }
																} ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
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
	<script src="../assets/plugins/custom/datatables/datatables.bundle.js"></script>
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
					const realDate = moment(dateRow[2].innerHTML, "DD/MM/YYYY, LT").format(); // select date from 4th column in table
					dateRow[2].setAttribute('data-order', realDate);
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

		function SendMail(id_fornrcedor) {
			var id_fornrcedor;
			var EmailType = $('#EmailType').val();
			if (EmailType !== 'Selecione') {
				var url = "sendMail.php";
				var operacao = "<?php echo $idOp;?>";
				$.ajax({
					url: url, // URL to send the request
					method: "POST", // HTTP method to use (GET, POST, PUT, DELETE, etc.)
					data:{
						id_fornecedor:id_fornrcedor,
						type:EmailType,
						operacao:operacao
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