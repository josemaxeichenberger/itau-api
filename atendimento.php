<?php
include("controle_sessao.php");
?>
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
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
		<link rel="shortcut icon" href="assets/media/misc/LSC-icone.png" />

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-title" content="LAW SMART">
		<link rel="shortcut icon" sizes="16x16" href="assets/media/misc/LSC-icone.png">
		<link rel="shortcut icon" sizes="196x196" href="assets/media/misc/LSC-icone.png">
		<link rel="apple-touch-icon-precomposed" href="assets/media/misc/LSC-icone.png">

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		
		<link rel="apple-touch-icon" sizes="180x180" href="assets/media/misc/LSC-icone.png">
		<link rel="stylesheet" type="text/css" href="addtohomescreen.css">
		<script src="addtohomescreen.js"></script>

	</head>
	<!--end::Head-->
	<!--begin::Body-->
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
							
							<div class="card mb-12">
								<!--begin::Hero body-->
								<div class="card-body flex-column p-5">
									<!--begin::Hero content-->
									<div class="d-flex align-items-center h-lg-300px p-5 p-lg-15">
										<!--begin::Wrapper-->
										<div class="d-flex flex-column align-items-start justift-content-center flex-equal me-5">
											<!--begin::Title-->
											<h1 class="fw-bolder fs-4 fs-lg-1 text-gray-800 mb-5 mb-lg-10">Como podemos ajudar você ?</h1>
											<!--end::Title-->
											<!--begin::Input group-->
											<div class="position-relative w-100">
												<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
												<span class="svg-icon svg-icon-2 svg-icon-primary position-absolute top-50 translate-middle ms-8">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
														<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->
												<input type="text" class="form-control fs-4 py-4 ps-14 text-gray-700 placeholder-gray-400 mw-500px" name="search" value="" placeholder="Ask a question" />
											</div>
											<!--end::Input group-->
										</div>
										<!--end::Wrapper-->
										<!--begin::Wrapper-->
										<div class="flex-equal d-flex justify-content-center align-items-end ms-5">
											<!--begin::Illustration-->
											<img src="assets/media/illustrations/sigma-1/20.png" alt="" class="mw-100 mh-125px mh-lg-275px mb-lg-n12" />
											<!--end::Illustration-->
										</div>
										<!--end::Wrapper-->
									</div>
									<!--end::Hero content-->
									<!--begin::Hero nav-->
									<div class="card-rounded bg-light d-flex flex-stack flex-wrap p-5">
										<!--begin::Nav-->
										<ul class="nav flex-wrap border-transparent fw-bolder">
											<!--begin::Nav item-->
											<li class="nav-item my-1">
												<a class="btn btn-color-gray-600 btn-active-white btn-active-color-primary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase active" href="">Dúvidas</a>
											</li>
											<!--end::Nav item-->
											<!--begin::Nav item-->
											<li class="nav-item my-1">
												<a class="btn btn-color-gray-600 btn-active-white btn-active-color-primary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase" href="">Tutoriais</a>
											</li>
							
											<li class="nav-item my-1">
												<a class="btn btn-color-gray-600 btn-active-white btn-active-color-primary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase" href="">Whatsapp</a>
											</li>
											<!--end::Nav item-->
										</ul>
										<!--end::Nav-->
										<!--begin::Action-->
										<a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_ticket" class="btn btn-primary fw-bolder fs-8 fs-lg-base">Criar um chamado</a>
										<!--end::Action-->
									</div>
									<!--end::Hero nav-->
								</div>
								<!--end::Hero body-->
							</div>
							<div class="row gy-0 mb-6 mb-xl-12">
								<!--begin::Col-->
								<div class="col-md-6">
									<!--begin::Card-->
									<div class="card card-md-stretch me-xl-3 mb-md-0 mb-6">
										<!--begin::Body-->
										<div class="card-body p-10 p-lg-15">
											<!--begin::Header-->
											<div class="d-flex flex-stack mb-7">
												<!--begin::Title-->
												<h1 class="fw-bolder text-dark">Principais Dúvidas</h1>
												<!--end::Title-->
												<!--begin::Section-->
												<div class="d-flex align-items-center">
												
													<span class="svg-icon svg-icon-2 svg-icon-primary">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
															<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													<!--end::Arrow-->
												</div>
												<!--end::Section-->
											</div>
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_3">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-bold cursor-pointer me-3 mb-0">Como funciona a taxa de juros ?</h3>
														<!--end::Title-->
														<!--begin::Label-->
														<span class="badge badge-light my-1 d-block">Aberto</span>
														<!--end::Label-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_1_3" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-bold fs-5">Isso é definido por cliente conforme sua operação dentro do Ancora</span>
														<!--end::Text-->
														<!--begin::Link-->
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_4">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-bold cursor-pointer me-3 mb-0">Qual a cor do cavalo  branco de napoleao ?</h3>
														<!--end::Title-->
														<!--begin::Label-->
														<span class="badge badge-light my-1 d-block">aberto</span>
														<!--end::Label-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_1_4" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-bold fs-5">Rosa com pintas vermelhas</span>
														<!--end::Text-->
														<!--begin::Link-->
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_6">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-bold cursor-pointer me-3 mb-0">Como funciona a taxa de juros ?</h3>
														<!--end::Title-->
														<!--begin::Label-->
														<span class="badge badge-light my-1 d-block">Aberto</span>
														<!--end::Label-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_1_6" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-bold fs-5">Isso é definido por cliente conforme sua operação dentro do Ancora</span>
														<!--end::Text-->
														<!--begin::Link-->
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_1_5">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-bold cursor-pointer me-3 mb-0">Qual a cor do cavalo  branco de napoleao ?</h3>
														<!--end::Title-->
														<!--begin::Label-->
														<span class="badge badge-light my-1 d-block">aberto</span>
														<!--end::Label-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_1_5" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-bold fs-5">Rosa com pintas vermelhas</span>
														<!--end::Text-->
														<!--begin::Link-->
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
										
										</div>
										<!--end::Body-->
									</div>
									<!--end::Card-->
								</div>
								<!--end::Col-->
								<!--begin::Col-->
								<div class="col-md-6">
									<!--begin::Card-->
									<div class="card card-md-stretch ms-xl-3">
										<!--begin::Body-->
										<div class="card-body p-10 p-lg-15">
											<!--begin::Header-->
											<div class="d-flex flex-stack mb-7">
												<!--begin::Title-->
												<h1 class="fw-bolder text-dark">FAQ</h1>
												<!--end::Title-->
												<!--begin::Section-->
												<div class="d-flex align-items-center">
												
													<!--begin::Link-->
													<!--begin::Arrow-->
													<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
													<span class="svg-icon svg-icon-2 svg-icon-primary">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
															<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													<!--end::Arrow-->
												</div>
												<!--end::Section-->
											</div>
											<!--end::Header-->
											<!--begin::Accordion-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_2_1">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-bold cursor-pointer me-3 mb-0">------?</h3>
														<!--end::Title-->
														<!--begin::Label-->
														<span class="badge badge-light my-1 d-none">---</span>
														<!--end::Label-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_2_1" class="collapse show fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-bold fs-5">--------------</span>
														<!--end::Text-->
														<!--begin::Link-->
														<a href="#" class="d-none"></a>
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_2_2">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-bold cursor-pointer me-3 mb-0">-----?</h3>
														<!--end::Title-->
														<!--begin::Label-->
														<span class="badge badge-light my-1 d-none">--</span>
														<!--end::Label-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_2_2" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-bold fs-5">----------</span>
														<!--end::Text-->
														<!--begin::Link-->
														<a href="#" class="d-none"></a>
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_2_3">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-bold cursor-pointer me-3 mb-0">---?</h3>
														<!--end::Title-->
														<!--begin::Label-->
														<span class="badge badge-light my-1 d-none">--</span>
														<!--end::Label-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_2_3" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-bold fs-5">---------</span>
														<!--end::Text-->
														<!--begin::Link-->
														<a href="#" class="d-none"></a>
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_2_4">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-bold cursor-pointer me-3 mb-0">----?</h3>
														<!--end::Title-->
														<!--begin::Label-->
														<span class="badge badge-light my-1 d-none">--</span>
														<!--end::Label-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_2_4" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-bold fs-5">------</span>
														<!--end::Text-->
														<!--begin::Link-->
														<a href="#" class="d-none"></a>
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
											<!--end::Body-->
											<!--begin::Section-->
											<div class="m-0">
												<!--begin::Heading-->
												<div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_support_2_5">
													<!--begin::Icon-->
													<div class="ms-n1 me-5">
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
														<span class="svg-icon toggle-on svg-icon-primary svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
														<!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
														<span class="svg-icon toggle-off svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Icon-->
													<!--begin::Section-->
													<div class="d-flex align-items-center flex-wrap">
														<!--begin::Title-->
														<h3 class="text-gray-800 fw-bold cursor-pointer me-3 mb-0">----?</h3>
														<!--end::Title-->
														<!--begin::Label-->
														<span class="badge badge-light my-1 d-none">--</span>
														<!--end::Label-->
													</div>
													<!--end::Section-->
												</div>
												<!--end::Heading-->
												<!--begin::Body-->
												<div id="kt_support_2_5" class="collapse fs-6 ms-10">
													<!--begin::Block-->
													<div class="mb-4">
														<!--begin::Text-->
														<span class="text-muted fw-bold fs-5">-----</span>
														<!--end::Text-->
														<!--begin::Link-->
														<a href="#" class="d-none"></a>
														<!--end::Link-->
													</div>
													<!--end::Block-->
												</div>
												<!--end::Content-->
											</div>
										</div>
										<!--end::Body-->
									</div>
									<!--end::Card-->
								</div>
								<!--end::Col-->
							</div>
							<div class="row gy-0 mb-6">
								<div class="card">
									<!--begin::Body-->
									<div class="card-body p-lg-17">
										<!--begin::Row-->
										
										<!--end::Row-->
										<!--begin::Row-->
										<div class="row g-5 mb-5 mb-lg-15">
											<!--begin::Col-->
											<div class="col-sm-6 pe-lg-10">
												<!--begin::Phone-->
												<div class="text-center bg-light card-rounded d-flex flex-column justify-content-center p-10 h-lg-100">
													<!--begin::Icon-->
													<!--SVG file not found: icons/duotune/finance/fin006.svgPhone.svg-->
													<!--end::Icon-->
													<!--begin::Subtitle-->
													<h1 class="text-dark fw-bolder my-5">Fale Conosco</h1>
													<!--end::Subtitle-->
													<!--begin::Number-->
													<div class="text-gray-700 fw-bold fs-2">55 (47) 55585-7538</div>
													<!--end::Number-->
												</div>
												<!--end::Phone-->
											</div>
											<!--end::Col-->
											<!--begin::Col-->
											<div class="col-sm-6 ps-lg-10">
												<!--begin::Address-->
												<div class="text-center bg-light card-rounded d-flex flex-column justify-content-center p-10 h-lg-100">
													<!--begin::Icon-->
													<!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
													<span class="svg-icon svg-icon-3tx svg-icon-primary">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" fill="black" />
															<path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													<!--end::Icon-->
													<!--begin::Subtitle-->
													<h1 class="text-dark fw-bolder my-5">Endereço</h1>
													<!--end::Subtitle-->
													<!--begin::Description-->
													<div class="text-gray-700 fs-3 fw-bold">xxxxxx</div>
													<!--end::Description-->
												</div>
												<!--end::Address-->
											</div>
											<!--end::Col-->
										</div>
										<!--end::Row-->
										<!--begin::Card-->
										<div class="card mb-4 bg-light text-center">
											<!--begin::Body-->
											<div class="card-body py-12">
												<!--begin::Icon-->
												<a href="#" class="mx-4">
													<img src="assets/media/svg/brand-logos/facebook-4.svg" class="h-30px my-2" alt="" />
												</a>
												<!--end::Icon-->
												<!--begin::Icon-->
												<a href="#" class="mx-4">
													<img src="assets/media/svg/brand-logos/instagram-2-1.svg" class="h-30px my-2" alt="" />
												</a>
												<!--end::Icon-->
												<!--begin::Icon-->
												<a href="#" class="mx-4">
													<img src="assets/media/svg/brand-logos/github.svg" class="h-30px my-2" alt="" />
												</a>
												<!--end::Icon-->
												<!--begin::Icon-->
												<a href="#" class="mx-4">
													<img src="assets/media/svg/brand-logos/behance.svg" class="h-30px my-2" alt="" />
												</a>
												<!--end::Icon-->
												<!--begin::Icon-->
												<a href="#" class="mx-4">
													<img src="assets/media/svg/brand-logos/pinterest-p.svg" class="h-30px my-2" alt="" />
												</a>
												<!--end::Icon-->
												<!--begin::Icon-->
												<a href="#" class="mx-4">
													<img src="assets/media/svg/brand-logos/twitter.svg" class="h-30px my-2" alt="" />
												</a>
												<!--end::Icon-->
												<!--begin::Icon-->
												<a href="#" class="mx-4">
													<img src="assets/media/svg/brand-logos/dribbble-icon-1.svg" class="h-30px my-2" alt="" />
												</a>
												<!--end::Icon-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Body-->
								</div>
							</div>
							
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
		<script>var hostUrl = "assets/";</script>
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<script src="assets/js/custom/widgets.js"></script>
		<script src="assets/js/custom/apps/chat/chat.js"></script>
		<script src="assets/js/custom/modals/create-app.js"></script>
		<script src="assets/js/custom/modals/upgrade-plan.js"></script>
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