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
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Folio</th>
                    <th>Nombre</th>
                    <th>Fecha de los hechos</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item) {
                    $bagRecurso = "";
                    switch ((int)$item->id_etapa_queja) {
                        case 1: $bagEstatus = "<small class='badge badge-primary'>".$item->etapa."</small>"; break;
                        case 2:
                        case 6:
                        case 11:
                        case 14:
                                $seguimientoCorriente =  json_decode($item->seguimiento_corriente, true);
                                $bagEstatus = "<small class='badge badge-warning'>".$item->etapa."</small>";
                                if ((int)$seguimientoCorriente['subsanado'] === 1) {
                                    $bagEstatus = "<small class='badge badge-primary'>".$item->etapa." (Resuelto)</small>";
                                }
                                break;
                        case 3: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 4: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 5: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 7: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 8: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;

                        case 10: $bagEstatus = "<small class='badge badge-primary'>".$item->etapa."</small>"; break;
                        case 12: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 13: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 15: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 16: $bagEstatus = "<small class='badge badge-info'>".$item->etapa."</small>"; break;
                        case 9:
                        case 17:
                            switch ((int) $item->tipo_respuesta_etapa) {
                                case 1: $sufixEtapa = 'Finalizado por conciliación'; break;
                                case 2: $sufixEtapa = 'Finalizado por improcedencia'; break;
                                case 3: $sufixEtapa = 'Finalizado por resolucíon'; break;
                                default: $sufixEtapa = '';
                            }
                            $sufixEtapa = $sufixEtapa ? "<br>(".$sufixEtapa.")" : "";
                            $bagEstatus = "<small class='badge badge-success'>".$item->etapa.$sufixEtapa."</small>";
                            if (($item->finalizado && (int)$item->tipo_respuesta_etapa === 3)) {
                                if ((date('Y-m-d') <= $item->fecha_vencimiento_etapa) || $item->existe_recurso) {
                                    $bagRecurso = "<a href='javascript:;' title='Presentar recurso de reconsideración' onclick='parent.open_modal_recurso_reconsideracion(" . $item->id_solicitud_queja . ")'>";
                                    $bagRecurso .= $item->existe_recurso
                                        ? "<small class='badge badge-primary'>Recurso de reconsideración existente</small>"
                                        : "<small class='badge badge-warning'>Haga click , para presentar recurso de reconsideración</small>";
                                    $bagRecurso .= "</a>";
                                } else {
                                    $bagRecurso = "<small class='badge badge-secondary'>Plazo vencido para recurso de reconsideración</small>";
                                }
                            }
                            break;
                    }
                    ?>
                    <tr>
                        <td><?= $item->nombre_manifestacion ?></td>
                        <td><?= $item->fecha_registro ?></td>
                        <td><?= $item->folio ?></td>
                        <td><?= $item->anonima == '1' ? 'Anónima' : $item->nombre . " " . $item->apellidos; ?></td>
                        <td><?= $item->fecha_queja ?></td>
                        <td><?= $bagEstatus ?><br><?= $bagRecurso ?>
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
