<?php
require_once("../../php/inicializandoDatosExterno.php");
$pagina = isset($_POST['pagina']) ? $funciones->limpia($_POST['pagina']) : 1;
$tipo =  $funciones->limpia($_POST['tipo']);

$limite = 10;
$cantenlaces = 7;
$inicio = ($pagina - 1) * $limite;

$total   = @$conexion->consultaregistro($querys->getTotalSolicitud($tipo));
$results = @$conexion->obtenerlista($querys->getListSolicitud($inicio, $limite, $tipo));
$items = !is_array($results) ? [] :  $results;
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
                    <th>Tipo de solicitud</th>
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
                        <td><?= $item->nombre_manifestacion ?></td>
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
                                <?php if($item->finalizado) { ?>
                                    <a href="javascript:;"
                                       class="btn btn-success"
                                       title="Recurso de consideración">
                                        <i class="fa fa-box"></i>
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
