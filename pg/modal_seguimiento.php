<?php
require_once("../php/inicializandoDatosExterno.php");
$row = [];
$id = $funciones->limpia($_POST['id']);
if ($id > 0) {
    $row = $conexion->fetch_objet($querys->getSolicitud($id));
}
// aca deberiamos consultar el eltimo registro de su historial
?>
<form name="frm-seguimiento" id="frm-seguimiento" enctype="multipart/form-data">
    <div class="overlay d-none" id="loading-send"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
    <div class="modal-header">
        <h4 class="modal-title"><b>Seguimiento de solicitud <?= $row->folio ?></b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <?php
            switch($row->id_etapa_queja) {
             case 1:
                 $opcion = 2;
                 include_once ("formulario/form_seguimiento.php");
             break;
            }
        ?>
        <div style="clear: both;"></div>
    </div>
    <div class="modal-footer justify-content-between">
        <input type="hidden" id="id" name="id" value="<?= $id ?>">
        <input type="hidden" id="opcion" name="opcion" value="<?= $opcion ?>">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <input type="button" class="btn btn-primary" id="btn-guardar-seguimiento" value="Guardar" />
    </div>
</form>
