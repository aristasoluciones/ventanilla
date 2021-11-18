<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="inicio" class="brand-link">
      <img src="dist/img/propios/escudoIconoP.png" alt="SECTUR Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">secTUR</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=($dUsuario["foto"]=='' || $dUsuario["foto"] == null)?'dist/img/propios/boss_manB.png':$dUsuario["foto"];?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="personal" class="d-block"><?=$dUsuario["nombre"];?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <?Php
                $modulosArray = array();
                $obtener_menu_padre = $conexion->obtenerlista($querys->permisosmenuusuario($dUsuario["id_usuario"]));
                foreach($obtener_menu_padre as $menu_padre){
                    if($menu_padre->archivo == NULL || $menu_padre->archivo == "#" || $menu_padre->archivo == ""){
                        $menu_padre->archivo = '#';
                    }
                    array_push($modulosArray,$menu_padre->archivo);
                    $modulos = explode(',',$menu_padre->modulos);
                    if(isset($_GET['cat'])){
                      $menuActivo = $_GET['cat'];
                    }
                    else{
                      $menuActivo = $carpeta.$modulo;
                    }
                    if(is_array($modulos)){
                        if(in_array($menuActivo,$modulos)) $activo = 'active';
                        else $activo = ($menu_padre->archivo == $menuActivo)?'active':'';
                    }
                    else $activo = ($menu_padre->archivo == $menuActivo)?'active':'';
                    $obtener_submenu = $conexion->obtenerlista($querys->permisosubmenuusuario($dUsuario["id_usuario"],$menu_padre->id_permiso));
                    $conteohijoarchivo = @$conexion->consultaregistro($querys->Conteopermisosubmenuusuariomodulo($dUsuario["id_usuario"], $menu_padre->id_permiso));
                    if($activo == 'active' && $conteohijoarchivo != 0) $activaSubnmenu = 'menu-is-opening menu-open';
                    else $activaSubnmenu ='';
            ?>
            <li class="nav-item <?=($conteohijoarchivo != 0)?'menu '.$activo. ' ' . $activaSubnmenu:'';?>">
                <a href="<?=$menu_padre->archivo;?>" class="nav-link <?=$activo;?>">
                    <i class="nav-icon <?=$menu_padre->icono;?>"></i>
                    <p>
                        <?=$menu_padre->nombre;?>
                        <?php
                            if($conteohijoarchivo != 0){
                        ?>
                        <i class="right fas fa-angle-left"></i>
                        <?php
                            }
                        ?>
                    </p>
                </a>
                <?php
                    if($conteohijoarchivo != 0){
                ?>
                <ul class="nav nav-treeview">
                    <?php
                        foreach($obtener_submenu as $menu_hijo){
                            array_push($modulosArray,$menu_hijo->archivo);
                            if(isset($_GET['cat'])){
                              $menuActivo = $modulo ."?cat=" . $_GET['cat'];
                            }
                            else{
                              $menuActivo = $modulo;
                            }
                            if($menu_hijo->archivo === $menuActivo) $activoHijo = "active";
                            else $activoHijo = '';
                            $conteohijoarchivoSub = @$conexion->consultaregistro($querys->Conteopermisosubmenuusuariomodulo($dUsuario["id_usuario"], $menu_hijo->id_permiso));
                            if($conteohijoarchivoSub == 0){
                    ?>
                    <li class="nav-item">
                        <a href="<?= $menu_hijo->archivo; ?>" class="nav-link <?=$activoHijo;?>">
                            <i class="<?= $menu_hijo->icono; ?> nav-icon"></i>
                            <p><?= $menu_hijo->nombre; ?></p>
                        </a>
                    </li>
                    <?Php
                        }
                    }
                    ?>
                </ul>
                <?php
                    }
                ?>
            </li>
            <?php
                }
            ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
