<?php
$data =  isset($_SESSION['vUsuario']) ? $_SESSION['vUsuario'] : [];
$strQuery = $querys->getTotalSolicitud(2);
$denuncias = $conexion->fetch_array($strQuery);
$total_denuncias =  $denuncias['total'];

$strQuery = $querys->getTotalSolicitud(1);
$quejas = $conexion->fetch_array($strQuery);
$total_quejas =  $quejas['total'];
?>
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Bienvenido <?= $vUsuario['nombre']. " ". $vUsuario['apellidos'] ?> </h5>
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
        </div>
    </div>
</div>
<!-- /.content -->
