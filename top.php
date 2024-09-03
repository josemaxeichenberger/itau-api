<div id="kt_header" class="header align-items-stretch" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
	<!--begin::Container-->
	<div class="header-container container-xxl d-flex align-items-center">
		<!--begin::Heaeder menu toggle-->
		<div class="d-flex topbar align-items-center d-lg-none ms-n2 me-3" title="Show aside menu">
			<div class="btn btn-icon btn-color-gray-900 w-30px h-30px" id="kt_header_menu_mobile_toggle">
				<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
				<span class="svg-icon svg-icon-2">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
						<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
					</svg>
				</span>
				<!--end::Svg Icon-->
			</div>
		</div>
		<!--end::Heaeder menu toggle-->
		<!--begin::Header Logo-->
		<div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0">
			<a href="index.php">
				<img alt="Logo" src="assets/media/misc/LSC.png" class="d-none d-lg-block mh-80px" />
				<img alt="Logo" src="assets/media/misc/LSC-icone.png" class="d-lg-none h-25px" />
			</a>
		</div>
		<!--end::Header Logo-->
		<!--begin::Wrapper-->
		<div class="d-flex align-items-stretch justify-content-end flex-lg-grow-1">
			<!--begin::Navbar-->
			<div class="d-flex align-items-stretch" id="kt_header_nav">
				<!--begin::Menu wrapper-->
				<div class="header-menu align-items-stretch h-lg-75px" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
					<!--begin::Menu-->
					<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
						<div class="menu-item me-lg-1">
							<a class="menu-link active py-3" href="index.php">
								<span class="menu-title">Resumo</span>
							</a>
						</div>
						<div class="menu-item me-lg-1">
							<a class="menu-link py-3" href="operacoes.php">
								<span class="menu-title">Operações</span>
							</a>
						</div>
						<div class="menu-item me-lg-1">
							<a class="menu-link py-3" href="limites.php">
								<span class="menu-title">Limites</span>
							</a>
						</div>
						<div class="menu-item me-lg-1">
							<a class="menu-link py-3" onClick="abre_dados(<?php echo $_SESSION['id'] ?>);">
								<span class="menu-title">Meus Dados</span>
							</a>
						</div>


					</div>
					<!--end::Menu-->
				</div>
				<!--end::Menu wrapper-->
			</div>
			<!--end::Navbar-->
			<!--begin::Topbar-->
			<div class="d-flex align-items-stretch flex-shrink-0">
				<!--begin::Toolbar wrapper-->
				<div class="topbar d-flex align-items-stretch flex-shrink-0">
					<!--begin::Chat-->
					
					<!--end::Chat-->
					<!--begin::Notifications-->
					<div class="d-flex align-items-center ms-3 ms-lg-5">
						<!--begin::Menu- wrapper-->
						<div class="btn btn-icon bg-white bg-opacity-25 bg-hover-opacity-50 btn-color-gray-900 w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
							<!--begin::Svg Icon | path: icons/duotune/general/gen007.svg-->
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="black" />
									<path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="black" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</div>
						<!--begin::Menu-->
						<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
							<!--begin::Heading-->
							<div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('assets/media/misc/pattern-1.png')">
								<!--begin::Title-->
								<h3 class="text-white fw-bold px-9 mt-10 mb-6">Notificações
								<span class="fs-8 opacity-75 ps-3">24 novas</span></h3>
								<!--end::Title-->
								<!--begin::Tabs-->
								<ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
									<li class="nav-item">
										<a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_1">Alertas</a>
									</li>
									
									<li class="nav-item">
										<a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_3">Logs</a>
									</li>
								</ul>
								<!--end::Tabs-->
							</div>
							<!--end::Heading-->
							<!--begin::Tab content-->
							<div class="tab-content">
								<!--begin::Tab panel-->
								<div class="tab-pane fade active" id="kt_topbar_notifications_1" role="tabpanel">
									<!--begin::Items-->
									<div class="scroll-y mh-325px my-5 px-8">
										<!--begin::Item-->
										<div class="d-flex flex-stack py-4">
											<!--begin::Section-->
											<div class="d-flex align-items-center">
												<!--begin::Symbol-->
												<div class="symbol symbol-35px me-4">
													<span class="symbol-label bg-light-primary">
														<!--begin::Svg Icon | path: icons/duotune/technology/teh008.svg-->
														<span class="svg-icon svg-icon-2 svg-icon-primary">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path opacity="0.3" d="M11 6.5C11 9 9 11 6.5 11C4 11 2 9 2 6.5C2 4 4 2 6.5 2C9 2 11 4 11 6.5ZM17.5 2C15 2 13 4 13 6.5C13 9 15 11 17.5 11C20 11 22 9 22 6.5C22 4 20 2 17.5 2ZM6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13ZM17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13Z" fill="black" />
																<path d="M17.5 16C17.5 16 17.4 16 17.5 16L16.7 15.3C16.1 14.7 15.7 13.9 15.6 13.1C15.5 12.4 15.5 11.6 15.6 10.8C15.7 9.99999 16.1 9.19998 16.7 8.59998L17.4 7.90002H17.5C18.3 7.90002 19 7.20002 19 6.40002C19 5.60002 18.3 4.90002 17.5 4.90002C16.7 4.90002 16 5.60002 16 6.40002V6.5L15.3 7.20001C14.7 7.80001 13.9 8.19999 13.1 8.29999C12.4 8.39999 11.6 8.39999 10.8 8.29999C9.99999 8.19999 9.20001 7.80001 8.60001 7.20001L7.89999 6.5V6.40002C7.89999 5.60002 7.19999 4.90002 6.39999 4.90002C5.59999 4.90002 4.89999 5.60002 4.89999 6.40002C4.89999 7.20002 5.59999 7.90002 6.39999 7.90002H6.5L7.20001 8.59998C7.80001 9.19998 8.19999 9.99999 8.29999 10.8C8.39999 11.5 8.39999 12.3 8.29999 13.1C8.19999 13.9 7.80001 14.7 7.20001 15.3L6.5 16H6.39999C5.59999 16 4.89999 16.7 4.89999 17.5C4.89999 18.3 5.59999 19 6.39999 19C7.19999 19 7.89999 18.3 7.89999 17.5V17.4L8.60001 16.7C9.20001 16.1 9.99999 15.7 10.8 15.6C11.5 15.5 12.3 15.5 13.1 15.6C13.9 15.7 14.7 16.1 15.3 16.7L16 17.4V17.5C16 18.3 16.7 19 17.5 19C18.3 19 19 18.3 19 17.5C19 16.7 18.3 16 17.5 16Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</span>
												</div>
												<!--end::Symbol-->
												<!--begin::Title-->
												<div class="mb-0 me-2">
													<a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">mensagem 1</a>
													<div class="text-gray-400 fs-7">-----</div>
												</div>
												<!--end::Title-->
											</div>
											<!--end::Section-->
											<!--begin::Label-->
											<span class="badge badge-light fs-8">1 hr</span>
											<!--end::Label-->
										</div>
									</div>
									<!--end::Items-->
									<!--begin::View more-->
									<div class="py-3 text-center border-top">
										<a href="#" class="btn btn-color-gray-600 btn-active-color-primary">Veja tudo
										<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
										<span class="svg-icon svg-icon-5">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
												<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon--></a>
									</div>
									<!--end::View more-->
								</div>
								<!--end::Tab panel-->
								<!--begin::Tab panel-->
								
								<!--end::Tab panel-->
								<!--begin::Tab panel-->
								<div class="tab-pane fade" id="kt_topbar_notifications_3" role="tabpanel">
									<!--begin::Items-->
									<div class="scroll-y mh-325px my-5 px-8">
										<!--begin::Item-->
										<div class="d-flex flex-stack py-4">
											<!--begin::Section-->
											<div class="d-flex align-items-center me-2">
												<!--begin::Code-->
												<span class="w-70px badge badge-light-success me-4">---</span>
												<!--end::Code-->
												<!--begin::Title-->
												<a href="#" class="text-gray-800 text-hover-primary fw-bold">---</a>
												<!--end::Title-->
											</div>
											<!--end::Section-->
											<!--begin::Label-->
											<span class="badge badge-light fs-8">Agora</span>
											<!--end::Label-->
										</div>
									</div>
									<!--end::Items-->
									<!--begin::View more-->
									<div class="py-3 text-center border-top">
										<a href="../../demo12/dist/pages/profile/activity.html" class="btn btn-color-gray-600 btn-active-color-primary">Veja Tudo
										<!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
										<span class="svg-icon svg-icon-5">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
												<path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon--></a>
									</div>
									<!--end::View more-->
								</div>
								<!--end::Tab panel-->
							</div>
							<!--end::Tab content-->
						</div>
						<!--end::Menu-->
						<!--end::Menu wrapper-->
					</div>
					<!--end::Notifications-->
					<!--begin::User-->
					
					<!--end::User -->
					<!--begin::Aside mobile toggle-->
					<div class="d-flex align-items-center d-lg-none ms-4" title="Show header menu">
						<div class="btn btn-icon btn-color-gray-900 w-30px h-30px w-30px h-30px w-md-40px h-md-40px" id="kt_aside_toggle">
							<!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
							<span class="svg-icon svg-icon-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="black" />
									<path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="black" />
								</svg>
							</span>
							<!--end::Svg Icon-->
						</div>
					</div>
					<!--end::Aside mobile toggle-->
				</div>
				<!--end::Toolbar wrapper-->
			</div>
			<!--end::Topbar-->
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Container-->
</div>