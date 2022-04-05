<?php
require_once("../php/inicializandoDatosExterno.php");
$row = [];
if ($_POST['id'] > 0) {
    $id = $funciones->limpia($_POST['id']);
    $row = $conexion->fetch_array($querys->getSolicitud($id));
}
?>
<div class="modal-header">
    <h4 class="modal-title">Historial de seguimiento de la solicitud : <b><?php echo $row['folio'] ?> </b></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div id="list-historia" class="">
    </div>
    <div style="clear: both;"></div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
</div>
