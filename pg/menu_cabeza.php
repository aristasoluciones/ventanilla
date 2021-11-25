<?php
 $datos_usuario =  $_SESSION['vUsuario'];
?>
<!-- Navbar -->
 <nav class="main-header navbar navbar-expand-md navbar-light navbar-light">
    <!-- Left navbar links -->
     <div class="container">
         <a href="<?= $web_root ?>" class="navbar-brand">
             <img src="../dist/img/propios/sectur-min.png" alt="STC" class="brand-image elevation-3" style="opacity: .8">
             <span class="brand-text font-weight-light">Plataforma CIET</span>
         </a>
         <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>
         <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
             <li class="nav-item">
                 <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                     <i class="fas fa-expand-arrows-alt"></i>
                 </a>
             </li>
             <li class="nav-item dropdown">
                 <a class="nav-link" data-toggle="dropdown" href="#">
                     <i class="far fa-user-circle"></i>
                 </a>
                 <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                     <span class="dropdown-header"><?= $datos_usuario['correo'] ?></span>
                     <div class="dropdown-divider"></div>
                     <a href="#" class="dropdown-item" id="btn-logout">
                         <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                     </a>
                     <div class="dropdown-divider"></div>
                 </div>
             </li>
         </ul>
     </div>
  </nav>
  <!-- /.navbar -->
