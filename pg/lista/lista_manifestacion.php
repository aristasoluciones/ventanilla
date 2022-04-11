<?php
require_once("../../php/inicializandoDatosExterno.php");
$pagina = isset($_POST['pagina']) ? $funciones->limpia($_POST['pagina']) : 1;
$tipo =  $funciones->limpia($_POST['tipo']);
$finalizado =  $funciones->limpia($_POST['finalizado']);

$limite = 10;
$cantenlaces = 7;
$inicio = ($pagina - 1) * $limite;

$total   = @$conexion->consultaregistro($querys->getTotalSolicitud($tipo, $finalizado));
$results = @$conexion->obtenerlista($querys->getListSolicitud($inicio, $limite, $tipo, $finalizado));
$items = !is_array($results) ? [] :  $results;
$lista_estatus = [1=>'Por validar', 2=>'Validado y en seguimiento', 3=>'Improcedencia', 4=>'Finalizado'];
?>
<div class="col-md-12">
    <div class="card card-success border-info">
        <div class="card-header">
            <div class="card-tools">
            </div>
            <!-- /.card-tools -->
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <?php if((int)$finalizado === 1) { ?>
                        <th>Tipo de manifestación</th>
                    <?php }?>
                    <th>Folio</th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item) {
                    switch ((int)$item->id_etapa_queja) {
                        case 1: $bag_estatus = "<small class='badge badge-primary'>".$item->etapa."</small>"; break;
                        case 2:$bag_estatus = "<small class='badge badge-warning'>".$item->etapa."</small>";break;
                        case 3: $bag_estatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 4: $bag_estatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 5: $bag_estatus = "<small class='badge badge-success'>".$item->etapa."</small>"; break;
                        case 6: $bag_estatus = "<small class='badge badge-success'>".$item->etapa."</small>"; break;
                        case 7: $bag_estatus = "<small class='badge badge-warning'>".$item->etapa."</small>"; break;
                        case 8: $bag_estatus = "<small class='badge badge-success'>".$item->etapa."</small>"; break;
                    }
                    ?>
                    <tr>
                        <?php if((int)$finalizado == 1) { ?>
                            <td><?= $item->nombre_manifestacion ?></td>
                        <?php }?>
                        <td><?= $item->folio ?></td>
                        <td><?= $item->anonima == '1' ? 'Anónima' : $item->nombre . " " . $item->apellidos; ?></td>
                        <td><?= $item->fecha_queja ?></td>
                        <td><?= $bag_estatus ?><br>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="javascript:;"
                                   onclick="parent.ventanilla_seguimiento('<?= $item->id_solicitud_queja ?>')"
                                   class="btn btn-info"
                                   title="Ver detalles">
                                    <i class="fa fa-search"></i>
                                </a>
                                <a href="javascript:;"
                                   onclick="parent.open_modal_historia_seguimiento('<?= $item->id_solicitud_queja ?>')"
                                   class="btn btn-warning"
                                   title="Historial seguimiento">
                                    <i class="fa fa-history"></i>
                                </a>
                            </div>

                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
