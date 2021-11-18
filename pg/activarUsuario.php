<?php
    if(isset($_GET['datos'])){
        $getDatos = explode('Y',$_GET['datos']);
        $idUsuario = $getDatos[0];
        $identificador = $getDatos[1];
        $sinDatos = 0;
    }
    else{
        $sinDatos = 1;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Toast -->
  <link rel="stylesheet" href="../dist/css/toast/bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index.html" class="h1"><b>Admin</b>Tramites</a>
    </div>
    <div class="card-body">
        <?php
            if($sinDatos == 0){
        ?>
        <p class="login-box-msg">Usted solicito registrarse al sistema del 
          <b>Instituto de Bomberos del Estado de Chiapas</b>, 
          si usted no lleno el formulario de registro ignore esta pagina, de lo contrario de click en el siguiente botón.
        </p> 
        <div class="row">
          <div class="col-12">
            <button type="button" id="btnTerminaR" class="btn btn-primary btn-block">Terminar Registro</button>
            <input type="hidden" id="hiddenUsuario" value="<?=$idUsuario?>" />
            <input type="hidden" id="hiddenIden" value="<?=$identificador?>" />
          </div>
          <!-- /.col -->
        </div>
        <?php
            }
            else{
        ?> 
        <p class="login-box-msg">
          <b>Ocurrio un error con su validación pongase en contacto a este numero ########</b>
          
        </p> 
        <?php
            }
        ?>     
        
        <div class="row" id="cargaInicio"></div>
    </div>
    
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Toast -->
<script src="../dist/js/toast/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>


<!-- script ajax de inicio-->
<script src="../dist/js/propios/inicio.js"></script>
</body>
</html>