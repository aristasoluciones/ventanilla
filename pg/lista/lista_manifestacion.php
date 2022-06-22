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
                        case 1: $bagEstatus = "<small class='badge badge-primary'>".$item->etapa."</small>"; break;
                        case 2:$bagEstatus = "<small class='badge badge-warning'>".$item->etapa."</small>";break;
                        case 3: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 4: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 5: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 6: $bagEstatus = "<small class='badge badge-warning'>".$item->etapa."</small>"; break;
                        case 7: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 8: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 9:
                            switch ((int) $item->tipo_respuesta_etapa) {
                                case 1: $sufixEtapa = 'Finalizado por conciliación'; break;
                                case 2: $sufixEtapa = 'Finalizado por improcedencia'; break;
                                case 3: $sufixEtapa = 'Finalizado por resolucíon'; break;
                                default: $sufixEtapa = '';
                            }
                            $sufixEtapa = $sufixEtapa ? "<br>(".$sufixEtapa.")" : "";
                            $bagEstatus = "<small class='badge badge-success'>".$item->etapa.$sufixEtapa."</small>";
                            break;
                    }
                    ?>
                    <tr>
                        <td><?= $item->nombre_manifestacion ?></td>
                        <td><?= $item->folio ?></td>
                        <td><?= $item->anonima == '1' ? 'Anónima' : $item->nombre . " " . $item->apellidos; ?></td>
                        <td><?= $item->fecha_queja ?></td>
                        <td><?= $bagEstatus ?><br>
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
                                <?php if($item->finalizado && (int)$item->tipo_respuesta_etapa === 3) { ?>
                                    <a href="javascript:;"
                                       onclick="parent.open_modal_recurso_consideracion('<?= $item->id_solicitud_queja ?>')"
                                       class="btn btn-success"
                                       title="Recurso de reconsideración">
                                        <i class="fa fa-archive"></i>
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
