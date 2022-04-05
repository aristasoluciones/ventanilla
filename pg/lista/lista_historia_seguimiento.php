<?php
require_once("../../php/inicializandoDatosExterno.php");
$historias = [];
if ($_POST['id'] > 0) {
    $id = $funciones->limpia($_POST['id']);
    $historias= $conexion->obtenerlista($querys->getListHistoriaSolicitud($id));
}
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Etapa</th>
                    <th>Comentario</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($historias as $historia) { ?>
                <tr>
                    <td><?= $historia->fecha ?></td>
                    <td><?= $historia->etapa ?></td>
                    <td><?= $historia->comentario_etapa ?></td>
                    <td><?php echo !$historia->id_usuario ? 'Usuario web' : $historia->nombre_usuario ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
