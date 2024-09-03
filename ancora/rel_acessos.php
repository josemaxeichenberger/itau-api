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

date_default_timezone_set('America/Sao_Paulo');

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
                        <!--begin::Row-->





                        <div class="row gy-5 g-xl-8">
                            <!--begin::Col-->
                            <div class="col-xl-12">
                                <div class="col-xl-12">
                                    <div class="card mb-5 mb-xl-8">
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Relatório de acessos a plataforma</span>
                                                <!-- <span class="text-muted mt-1 fw-bold fs-7">Abaixo listamos as todos fornecedores disponiveis no sistema.</span> -->
                                            </h3>

                                        </div>
                                        <div class="card-body py-3">

                                            <div class="card card-p-0 card-flush">
                                                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                                    <div class="card-title">



                                                        <div id="kt_datatable_example_1_export" class="d-none"></div>

                                                    </div>
                                                    <form name="filtro" method="get" style="width: 100%;" action="rel_acessos.php">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="d-flex align-items-center position-relative my-1">
                                                                    <span class="svg-icon svg-icon-1 position-absolute ms-4">...</span>
                                                                    <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Filtre na tabela" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select name="status" class="form-control">
                                                                    <option value="">Selecione</option>
                                                                    <option value="1" <?php if ($_GET['status'] == 1) {
                                                                                            echo 'selected';
                                                                                        } ?>>Quem Acessou e completou cadastro</option>
                                                                    <option value="2" <?php if ($_GET['status'] == 2) {
                                                                                            echo 'selected';
                                                                                        } ?>>Quem acessou e não fez nada</option>
                                                                    <option value="3" <?php if ($_GET['status'] == 3) {
                                                                                            echo 'selected';
                                                                                        } ?>>Quem não acessou</option>
                                                                    <option value="4" <?php if ($_GET['status'] == 4) {
                                                                                            echo 'selected';
                                                                                        } ?>>E-mail inconsistentes</option>
                                                                </select>
                                                            </div>
                                                            <!-- 
                                                            <div class="col-md-2">
                                                                <input type="date" name="inicio" class="form-control" value="">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="date" name="termino" class="form-control" value="">
                                                            </div> -->
                                                            <div class="col-md-1 col-sm-2">
                                                                <input type="submit" name="envio" class="form-control" value="Filtrar">
                                                            </div>
                                                            <div class="col-md-2 col-sm-2">
                                                                <a href="rel_acessos?acao=" class="form-control btn btn-light-primary">Limpar</a>
                                                            </div>
                                                            <div class="card-toolbar flex-row-fluid justify-content-end col-md-2">
                                                                <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                                    Exportar
                                                                </button>
                                                                <!--begin::Menu-->
                                                                <div id="kt_datatable_example_1_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4" data-kt-menu="true" style="">
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
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="kt_datatable_example_1">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <tr class="fw-bolder text-muted">
                                                            <th class="min-w-80px">Tipo</th>
                                                            <th class="min-w-200px">Cliente</th>
                                                            <th class="min-w-100px">CNPJ</th>
                                                            <th class="min-w-120px">Data</th>


                                                            <th class="min-w-120px">Status</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        if (isset($_GET['envio'])) {
                                                            $ACAO =  $_GET['envio'];

                                                            $status = $_GET['status'];

                                                            if ($status == 1) {
                                                                $acessos = new acessos();
                                                                $res = $acessos->SelectUltimoAcesso();
                                                                foreach ($res as $row) {
                                                                    $cleaned_value = preg_replace('/[^0-9]/', '', $row['cpf_cnpj']);
                                                                    $fornecedores = new fornecedores();
                                                                    $fornecedores->setCnpj($cleaned_value);
                                                                    $fornecedor = $fornecedores->SelectCnpj();
                                                                    if ($fornecedor) {
                                                                        if ($fornecedor['updated'] == 1) {
                                                        ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $fornecedor['tipo']; ?></a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="fornecedor.php?id=<?php echo $fornecedor['id']; ?>" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $fornecedor['razao']; ?></a>
                                                                                    <a href="mailto:<?php echo $fornecedor['email']; ?>" class="text-dark text-hover-primary d-block mb-1 fs-8"><?php echo $fornecedor['email']; ?></a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $fornecedor['cnpj']; ?></a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo date('d/m/Y H:i:s', strtotime($row['data_hora'])); ?></a>
                                                                                </td>

                                                                                <td>
                                                                                    <?php if ($fornecedor['status'] == 1) { ?>
                                                                                        <span class="badge badge-light-success">Liberado</span>
                                                                                    <?php }
                                                                                    if ($fornecedor['status'] == 0) { ?>
                                                                                        <span class="badge badge-light-danger">Bloqueado</span>
                                                                                    <?php } ?>
                                                                                </td>

                                                                            </tr>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">Âncora</a>
                                                                            </td>
                                                                            <td>
                                                                                <a href="fornecedor.php?id=<?php echo $row['id_user']; ?>" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">FAKINI</a>
                                                                                <a href="mailto:<?php echo $row['email_user']; ?>" class="text-dark text-hover-primary d-block mb-1 fs-8"><?php echo $row['email_user']; ?></a>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo    preg_replace('/[.-\/\s]/', '', $row['cpf_cnpj']); ?></a>
                                                                            </td>
                                                                            <td>
                                                                                <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo date('d/m/Y H:i:s', strtotime($row['data_hora'])); ?></a>
                                                                            </td>

                                                                            <td>
                                                                                <span class="badge badge-light-success">Liberado</span>
                                                                            </td>

                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            if ($status == 2) {
                                                                $acessos = new acessos();
                                                                $res = $acessos->SelectUltimoAcesso();
                                                                foreach ($res as $row) {

                                                                    $cleaned_value = preg_replace('/[^0-9]/', '', $row['cpf_cnpj']);
                                                                    $cleaned_value = trim($cleaned_value);
                                                                    $fornecedores = new fornecedores();
                                                                    $fornecedores->setCnpj($cleaned_value);
                                                                    $fornecedor = $fornecedores->SelectCnpj();

                                                                    $antecipadas = new antecipadas();
                                                                    $antecipadas->setFornecedor($fornecedor['id']);
                                                                    $res = $antecipadas->AntecipadasFornecedor();
                                                                    if($fornecedor){
                                                                    if (!$res) {
                                                                        ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $fornecedor['tipo']; ?></a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="fornecedor.php?id=<?php echo $fornecedor['id']; ?>" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $fornecedor['razao']; ?></a>
                                                                                    <a href="mailto:<?php echo $fornecedor['email']; ?>" class="text-dark text-hover-primary d-block mb-1 fs-8"><?php echo $fornecedor['email']; ?></a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $fornecedor['cnpj']; ?></a>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo date('d/m/Y H:i:s', strtotime($row['data_hora'])); ?></a>
                                                                                </td>

                                                                                <td>
                                                                                    <?php if ($fornecedor['status'] == 1) { ?>
                                                                                        <span class="badge badge-light-success">Liberado</span>
                                                                                    <?php }
                                                                                    if ($fornecedor['status'] == 0) { ?>
                                                                                        <span class="badge badge-light-danger">Bloqueado</span>
                                                                                    <?php } ?>
                                                                                </td>

                                                                            </tr>
                                                                    <?php
                                                                    }}
                                                                }
                                                            }
                                                            if ($status == 3) {

                                                                $fornecedor = new fornecedores();
                                                                $res = $fornecedor->NotAcess();
                                                                foreach ($res as $row) {
                                                                    $cleaned_value = preg_replace('/[^0-9]/', '', $row['cpf_cnpj']);
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $row['tipo']; ?></a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="fornecedor.php?id=<?php echo $row['id']; ?>" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $row['razao']; ?></a>
                                                                            <a href="mailto:<?php echo $row['email']; ?>" class="text-dark text-hover-primary d-block mb-1 fs-8"><?php echo $row['email']; ?></a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $row['cnpj']; ?></a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"> <span class="badge badge-light-danger">Nunca Acessou</span></a>
                                                                        </td>

                                                                        <td>
                                                                            <?php if ($row['status'] == 1) { ?>
                                                                                <span class="badge badge-light-success">Liberado</span>
                                                                            <?php }
                                                                            if ($row['status'] == 0) { ?>
                                                                                <span class="badge badge-light-danger">Bloqueado</span>
                                                                            <?php } ?>
                                                                        </td>

                                                                    </tr>
                                                                <?php
                                                                }
                                                            }
                                                            if ($status == 4) {

                                                                $fornecedor = new fornecedores();
                                                                $res = $fornecedor->InconsitentesEmail();
                                                                foreach ($res as $row) {
                                                                    $cleaned_value = preg_replace('/[^0-9]/', '', $row['cpf_cnpj']);
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $row['tipo']; ?></a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="fornecedor.php?id=<?php echo $row['id']; ?>" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"><?php echo $row['razao']; ?></a>
                                                                            <a href="mailto:<?php echo $row['email']; ?>" class="text-dark text-hover-primary d-block mb-1 fs-8"><?php echo $row['email']; ?></a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $row['cnpj']; ?></a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"> <span class="badge badge-light-danger">Nunca Acessou</span></a>
                                                                        </td>

                                                                        <td>
                                                                            <?php if ($row['status'] == 1) { ?>
                                                                                <span class="badge badge-light-success">Liberado</span>
                                                                            <?php }
                                                                            if ($row['status'] == 0) { ?>
                                                                                <span class="badge badge-light-danger">Bloqueado</span>
                                                                            <?php } ?>
                                                                        </td>

                                                                    </tr>
                                                        <?php
                                                                }
                                                            }
                                                        } ?>
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
                    dateRow[2].setAttribute('data-order', realDate);
                });

                // Init datatable --- more info on datatables: https://datatables.net/manual/
                datatable = $(table).DataTable({
                    "info": true,
                    'order': [],
                    'pageLength': 30,

                });
            }

            // Hook export buttons
            var exportButtons = () => {
                const documentTitle = 'Relatório de acessos a plataforma';
                var buttons = new $.fn.dataTable.Buttons(table, {
                    buttons: [{
                            extend: 'copyHtml5',
                            title: documentTitle,
                            exportOptions: {
                                modifier: {
                                    page: 'all'
                                }
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            title: documentTitle,
                            exportOptions: {
                                modifier: {
                                    page: 'all'
                                }
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            title: documentTitle,
                            exportOptions: {
                                modifier: {
                                    page: 'all'
                                }
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            title: documentTitle,
                            exportOptions: {
                                modifier: {
                                    page: 'all'
                                }
                            }
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

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTDatatablesButtons.init();
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

        function Status(id, status) {
            var msg = '';
            var statusSet = '';
            if (status == 1) {
                statusSet = 0;
                msg = 'Deseja realmente Inativar o fornecedor?';
            }
            if (status == 0) {
                statusSet = 1;
                msg = 'Deseja realmente Ativar o fornecedor?';
            }
            Swal.fire({
                title: msg,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Sim",
                denyButtonText: "Não"
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'mod.php',
                        data: {
                            id: id,
                            status: statusSet
                        },
                        // dataType: 'json',
                        success: function(response) {
                            Swal.fire("Salvo com sucesso!", "Confirmado", "success");
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire("As alterações não foram salvas", "Erro", "info");
                        }
                    });

                } else if (result.isDenied) {
                    Swal.fire("As alterações não foram salvas", "Cancelado", "info");
                }
            });
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

        function isValidEmail(email) {
            // Regular expression for basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Example usage:
        // const userEmail = "test@example.com";
        // if (isValidEmail(userEmail)) {
        // 	console.log("Valid email address");
        // } else {
        // 	console.log("Invalid email address");
        // }
    </script>
</body>

</html>