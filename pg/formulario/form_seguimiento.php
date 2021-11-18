<?php
$web_root = $funciones->webRoot();
?>
<div>
    <form id="form-seguimiento" name="form-seguimiento" enctype="multipart/form-data" method="post" action="#"
          target="enviar_form">
        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="fecha_audiencia"><span class="text-danger"></span>Mensaje Recibido</label>
                    <template class="form-control" name="mensaje_recibido" id="mensaje_recibido"><</template>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="fecha_audiencia"><span class="text-danger"></span>Tipo de audiencia</label>
                    <select class="form-control" name="tipo_audiencia" id="tipo_audiencia">
                        <option value="presencial">Presencial</option>
                        <option value="linea">En linea</option>
                        <option value="mixto">Mixto</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <input type="hidden" name="opcion" value="4"/>
            <input type="hidden" name="id" id="id" value="<?= $id ?>">
            <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
    </form>
</div>
