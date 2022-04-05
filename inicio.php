<?php
require('php/inicializandoDatos.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CIET | Inicio</title>
    <link href="dist/img/propios/escudoIcono.png" rel="icon" type="image/png"/>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <!-- libreria para incluir mas js -->
    <script>
        var head_conf = {screens: [640, 1024, 1280, 1680]};
    </script>
    <script src="js/head.min.js"></script>
</head>
<body class="hold-transition layout-top-nav">
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content-default">
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="wrapper">
    <?php include_once('pg/menu_cabeza.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="ContenidoGeneral">
        <?php
        if (file_exists('pg/' . $modulo . '.php')) {
            if ($permiso != 0) {
                require('pg/' . $modulo . '.php');
            } else {
                require('pg/400.php');
            }
        } else {
            require('pg/error.php');
        }
        ?>
    </div>

    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; <?= date('Y') ?><a href="https://adminlte.io"></a></strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline">
            <b>Version</b> 1.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->
<!-- cargador de js -->
<script src="js/funciones.js"></script>
</body>
</html>
