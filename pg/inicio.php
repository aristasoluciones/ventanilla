<?php
$data =  isset($_SESSION['vUsuario']) ? $_SESSION['vUsuario'] : [];
$strQuery = $querys->getListSolicitudByUsuario($data, 2);
$denuncias = $conexion->obtenerlista($strQuery);
$total_denuncias =  is_array($denuncias) ? count($denuncias) : 0;

$strQuery = $querys->getListSolicitudByUsuario($data, 1);
$quejas = $conexion->obtenerlista($strQuery);
$total_quejas =  is_array($quejas) ? count($quejas) : 0;

$strQuery = $querys->getListSolicitudByUsuario($data, 3);
$conciliacion = $conexion->obtenerlista($strQuery);
$total_conciliacion =  is_array($conciliacion) ? count($conciliacion) : 0;
?>
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Bienvenido <?= $vUsuario['nombre'] ?> </h5>
            </div>
        </div>
    </div>
</div><!--.page-content-header-->
<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <a class="small-box bg-info" href="<?= $web_root ?>/denuncia">
                    <div class="inner">
                        <h3><?= $total_denuncias ?></h3>
                        <p>Mis denuncias</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-file-alt"></i>
                    </div>
                </a>
            </div>
            <div class="col-4">
                <a class="small-box bg-info" href="<?= $web_root ?>/queja">
                    <div class="inner">
                        <h3><?= $total_quejas ?></h3>
                        <p>Mis Quejas</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-file-alt"></i>
                    </div>
                </a>
            </div>
            <div class="col-4">
                <a class="small-box bg-info" href="<?= $web_root ?>/conciliacion">
                    <div class="inner">
                        <h3><?= $total_conciliacion ?></h3>
                        <p>Mis Conciliaciones</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-file-alt"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->
