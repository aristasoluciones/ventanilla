<?php
$id =  isset($_SESSION['vUsuario']) ? $_SESSION['vUsuario']['id_turista'] : -1;
$strQuery = $querys->getListSolicitudByUsuario($id, 1);
$denuncias = $conexion->obtenerlista($strQuery);
$total_denuncias =  is_array($denuncias) ? count($denuncias) : 0;

$strQuery = $querys->getListSolicitudByUsuario($id, 2);
$quejas = $conexion->obtenerlista($strQuery);
$total_quejas =  is_array($quejas) ? count($quejas) : 0;

$strQuery = $querys->getListSolicitudByUsuario($id, 3);
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
                <a class="small-box bg-info" href="/denuncia">
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
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $total_quejas ?></h3>
                        <p>Mis Quejas</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-file-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $total_conciliacion ?></h3>
                        <p>Mis Conciliaciones</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->
