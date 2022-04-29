<?php
require_once("../../php/inicializandoDatosExterno.php");
$historias = [];
if ($_POST['id'] > 0) {
    $id = $funciones->limpia($_POST['id']);
    $historias= $conexion->obtenerlista($querys->getListHistoriaSolicitud($id));
    $historias = !is_array($historias) ? [] :  $historias;
    foreach ($historias as $key => $value) {
        switch((int)$value->tipo_usuario) {
            case 1: break;
            case 2:
                $usuario_do = $conexion->fetch_objet($querys->getUsuarioPrestadorDoSeguimiento($value->id_solicitud_queja_seguimiento));
                $historias[$key]->nombre_usuario = $usuario_do->nombre." ".$usuario_do->apellidos;
                break;
        }
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Etapa</th>
                <th>Comentarios</th>
                <th>Usuario</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($historias as $historia) { ?>
                <tr>
                    <td><?= $historia->fecha ?></td>
                    <td><?= $historia->etapa ?></td>
                    <td><?= $historia->comentario_etapa ?></td>
                    <td><?php echo !$historia->id_usuario ? 'Turista o Visitante' : $historia->nombre_usuario ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
