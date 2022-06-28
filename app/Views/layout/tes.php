<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Laporan Downtime</title>
    <!-- Favicon-->
    <link rel="icon" href="<?= base_url('favicon.ico')?>" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url()?>/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url()?>/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo base_url()?>/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo base_url()?>/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    
    <!-- Morris Chart Css-->
    <link href="<?php echo base_url()?>/plugins/morrisjs/morris.css" rel="stylesheet" />

     <!-- JQuery DataTable Css -->
     <link href="<?php echo base_url()?>/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="<?php echo base_url()?>/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url()?>/css/themes/all-themes.css" rel="stylesheet" />

    
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <!-- DataTables CSS CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" >
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    
   
</head>

<body class="theme-red">    
    <!-- Page Loader -->
    <!-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div> -->
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.html">LAPORAN DOWNTIME</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">

                    <li> <a href="<?= base_url('logout')?>"><i class="material-icons">input</i></a></li>
                   
                   
                </ul>
            </div>
            
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
            
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= session()->get('name'); ?></div>
                    <!-- <div class="email">john.doe@example.com</div> -->
                    
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <?php 
                        if(session()->get('role') == 1)
                        {
                    ?>

                    <li class="active">
                        <a href="<?= base_url('gl/dashboard')?>">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('gl/dashboard/create_laporan')?>">
                            <i class="material-icons">text_fields</i>
                            <span>Buat Laporan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('gl/dashboard/index_dashboard_permintaan')?>">
                            <i class="material-icons">text_fields</i>
                            <span>Buat Permintaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('gl/dashboard/index_dashboard_pengembalian')?>">
                            <i class="material-icons">text_fields</i>
                            <span>Buat Pengembalian</span>
                        </a>
                    </li>
                    <?php
                        }else if(session()->get('role') == 3)
                        {
                    ?>
                    <li class="active">
                        <a href="<?= base_url('spv/dashboard')?>">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('spv/index_dashboard_permintaan')?>">
                            <i class="material-icons">text_fields</i>
                            <span>Permintaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('spv/index_dashboard_pengembalian')?>">
                            <i class="material-icons">text_fields</i>
                            <span>Pengembalian</span>
                        </a>
                    </li>

                    <?php
                        }else if(session()->get('role') == 2)
                        {
                    ?>
                    <li class="active">
                        <a href="<?= base_url('staff/dashboard')?>">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>


                    <li >
                        <a href="<?= base_url('staff/index_master_barang')?>">
                            <i class="material-icons">home</i>
                            <span>Master Barang</span>
                        </a>
                    </li>

                    <li >
                        <a href="<?= base_url('staff/index_master_jenis_barang')?>">
                            <i class="material-icons">home</i>
                            <span>Master Jenis Barang</span>
                        </a>
                    </li>

                    <li >
                        <a href="<?= base_url('staff/index_stock_barang')?>">
                            <i class="material-icons">home</i>
                            <span>Stock Barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('staff/index_dashboard_permintaan')?>">
                            <i class="material-icons">text_fields</i>
                            <span>Permintaan Barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('staff/index_dashboard_pengeluaran')?>">
                            <i class="material-icons">text_fields</i>
                            <span>Pengeluaran Barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('staff/index_dashboard_pengembalian')?>">
                            <i class="material-icons">text_fields</i>
                            <span>Pengembalian Barang</span>
                        </a>
                    </li>
                    

                    <?php
                        }
                    ?>
                   
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2022 - <a href="javascript:void(0);">LAPORAN DOWNTIME</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
      
    </section>

   <!-- section content -->
   <?php echo $this->renderSection('content') ?>


    <!-- Jquery Core Js -->
    <script src="<?php echo base_url()?>/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url()?>/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo base_url()?>/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url()?>/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url()?>/plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo base_url()?>/plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="<?php echo base_url()?>/plugins/raphael/raphael.min.js"></script>
    <script src="<?php echo base_url()?>/plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="<?php echo base_url()?>/plugins/chartjs/Chart.bundle.js"></script>

        <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo base_url('/plugins/jquery-datatable/jquery.dataTables.js')?>"></script>
    <script src="<?php echo base_url('/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')?>"></script>
    <script src="<?php echo base_url()?>/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url()?>/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo base_url()?>/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo base_url()?>/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo base_url()?>/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo base_url()?>/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?php echo base_url()?>/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="<?php echo base_url()?>/plugins/flot-charts/jquery.flot.js"></script>
    <script src="<?php echo base_url()?>/plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="<?php echo base_url()?>/plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url()?>/plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="<?php echo base_url()?>/plugins/flot-charts/jquery.flot.time.js"></script>


    <!-- Sparkline Chart Plugin Js -->
    <script src="<?php echo base_url()?>/plugins/jquery-sparkline/jquery.sparkline.js"></script>

    

    <!-- Custom Js -->
    <script src="<?php echo base_url()?>/js/pages/tables/jquery-datatable.js"></script>
    <script src="<?php echo base_url()?>/js/admin.js"></script>
    <script src="<?php echo base_url()?>/js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="<?php echo base_url()?>/js/demo.js"></script>

    

    <!-- JQuery Steps Plugin Js -->
    <script src="<?php echo base_url()?>/plugins/jquery-steps/jquery.steps.js"></script>


      <!-- jQuery CDN -->
      <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Bootstrap 4.5 CDN  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTable CDN js -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
     
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

    
</body>

</html>
