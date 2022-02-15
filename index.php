<?php
@session_start();
ini_set('display_errors', '1');
if(isset($_SESSION["autentificado"])) {
    echo'<script languaje="javascript">
				location.href="inicio";
			</script>';
    exit(0);
}
$folio  =  $_POST['folio'] ?? '';
$correo = $_POST['correo'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CIET</title>
    <link href="dist/img/propios/escudoIcono.png" rel="icon" type="image/png"/>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Bstepper -->
    <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- Dropzone -->
    <link rel="stylesheet" href="plugins/dropzone/dropzone.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition bg-light">
<div class="container">
    <div class="py-5 text-center">
        <h2>Seguimiento en línea de quejas y denuncias de la secretaria de Turismo del Estado de Chiapas</h2>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card card-outline card-primary card-seguimiento">
                <div class="card-header">
                    <h3>Seguimiento de solicitud</h3>
                </div>
                <div class="card-body">
                    <p class="lead">Para la consulta de su denuncia ingrese únicamente el folio</p>
                    <p class="lead">Para el seguimiento de su solicitud de queja utilice la cuenta de correo proporcionado durante su registro y el folio</p>
                    <form id="formInicio" onsubmit="return false;">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txt_folio"><span class="text-danger"></span>Folio</label>
                                    <input class="form-control" name="text_folio" id="text_folio"
                                           value="<?= $folio ?>"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text_correo"><span class="text-danger"></span>Correo</label>
                                    <input type="text" name="text_correo" id="text_correo"  class="form-control"
                                           value="<?= $correo ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">Consultar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/dropzone/dropzone.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- script ajax de inicio-->
<script src="js/inicio.js"></script>
</body>
</html>
