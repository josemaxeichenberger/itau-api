<div id="kt_header" class="header align-items-stretch" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
	<!--begin::Container-->
	<div class="header-container container-xxl d-flex align-items-center">
		<!--begin::Heaeder menu toggle-->
		<div class="d-flex topbar align-items-center d-lg-none ms-n2 me-3" title="Show aside menu">
			<div class="btn btn-icon btn-color-white-900 w-30px h-30px" id="kt_header_menu_mobile_toggle">
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
				<img alt="Logo" src="../assets/media/misc/LSC.png" class="d-none d-lg-block mh-80px" />
				<img alt="Logo" src="../assets/media/misc/LSC-icone.png" class="d-lg-none h-25px" />
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
					<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-icon-primary menu-state-bullet-primary menu-arrow-white-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
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
							<a class="menu-link py-3" href="desconto_de_ancora.php">
								<span class="menu-title">Desconto de Ancora</span>
							</a>
						</div>
						<div class="menu-item me-lg-1">
							<a class="menu-link py-3" href="fornecedores.php">
								<span class="menu-title">Clientes</span>
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
						<!-- <div class="btn btn-icon bg-white bg-opacity-25 bg-hover-opacity-50 btn-color-white-900 w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
							<span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
									<path fill="#fff" d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V288H216c-13.3 0-24 10.7-24 24s10.7 24 24 24H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zM384 336V288H494.1l-39-39c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l80 80c9.4 9.4 9.4 24.6 0 33.9l-80 80c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l39-39H384zm0-208H256V0L384 128z" />
								</svg> 
							</span>
						</div> -->
						<!--begin::Menu-->
						<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
							<!--begin::Heading-->
							<div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('../assets/media/misc/pattern-1.png')">
								<!--begin::Title-->
								<h3 class="text-white fw-bold px-9 mt-10 mb-6">Exportar Operações para XML

							</div>
							<form class="form-floating p-3" action="operacoesxml.php" method="GET">
								<div class="row">
									<div class="col-5">
										<input type="date" class="form-control-sm is-invalid" id="floatingInputInvalid" name="inicio" placeholder="Data Inicial" value="">

									</div>
									<div class="col-2 mt-2"> até</div>
									<div class="col-5">
										<input type="date" class="form-control-sm is-invalid" id="floatingInputInvalid" name="termino" placeholder="Data Final" value="">

									</div>
									<div class="col-12 mt-3 mb-3">
										<button type="submit" id="expoerfile" class="btn btn-sm w-100 btn-primary">Exportar Arquivo</button>
									</div>
								</div>
							</form>
						</div>
						<!--end::Menu-->
						<!--end::Menu wrapper-->
					</div>
					<!--end::Notifications-->
					<!--begin::User-->

					<!--end::User -->
					<!--begin::Aside mobile toggle-->

					<!--end::Aside mobile toggle-->
				</div>
				<!--end::Toolbar wrapper-->
			</div>
			<!--end::Topbar-->
			<!--begin::Topbar-->
			<div class="d-flex align-items-stretch flex-shrink-0">
				<!--begin::Toolbar wrapper-->
				<div class="topbar d-flex align-items-stretch flex-shrink-0">
					<!--begin::Chat-->

					<!--end::Chat-->
					<!--begin::Notifications-->
					<div class="d-flex align-items-center ms-3 ms-lg-5">
						<!--begin::Menu- wrapper-->
						<div class="btn btn-icon bg-white bg-opacity-25 bg-hover-opacity-50 btn-color-white-900 w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
							<!--begin::Svg Icon | path: icons/duotune/general/gen007.svg-->
							<span class="svg-icon svg-icon-1 position-relative">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
									<path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="black" />
									<path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="black" />
								</svg>
								<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationsSet">
									<span id="notificationsNumber"></span>
									<span class="visually-hidden">unread messages</span>
								</span>
							</span>
							<!--end::Svg Icon-->
						</div>
						<!--begin::Menu-->
						<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
							<!--begin::Heading-->
							<div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('../assets/media/misc/pattern-1.png')">
								<!--begin::Title-->
								<h3 class="text-white fw-bold px-9 mt-10 mb-6">Notificações
									<!-- <span class="fs-8 opacity-75 ps-3">24 novas</span> -->
								</h3>
								<!--end::Title-->
								<!--begin::Tabs-->
								<ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
									<li class="nav-item">
										<a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_1">Alertas</a>
									</li>

								</ul>
								<!--end::Tabs-->
							</div>
							<!--end::Heading-->
							<!--begin::Tab content-->
							<div class="tab-content">
								<!--begin::Tab panel-->
								<div class="scroll-y mh-325px my-5 px-8" id="iniNoti">
									<!--begin::Item-->
									

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
						<div class="btn btn-icon btn-color-white-900 w-30px h-30px w-30px h-30px w-md-40px h-md-40px" id="kt_aside_toggle">
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