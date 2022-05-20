<div class="row">
    <!-- listar actas firmadas -->
    <div class="col-md-12" x-show="listaActaFirmadaConciliacion.length">
        <label>Lista de actas disponibles para descargar</label><br>
        <div class="btn-group">
            <template x-for="(item, index) in listaActaFirmadaConciliacion">
                <a key="index" type="button" :href="path_file() + item.path_acta_firmada" class="btn btn-outline-info" target="_blank" title="Descargar acta">
                    <span x-text="item.nombre"></span> <i class="fa fa-download"></i>
                </a>
            </template>
        </div>
    </div>
    <div class="col-md-12" x-show="listaActaFirmadaResolucion.length">
        <label>Lista de actas disponibles para descargar</label><br>
        <div class="btn-group">
            <template x-for="(item, index) in listaActaFirmadaConciliacion">
                <a key="index" type="button" :href="path_file() + item.path_acta_firmada" class="btn btn-outline-info" target="_blank" title="Descargar acta">
                    <span x-text="item.nombre"></span> <i class="fa fa-download"></i>
                </a>
            </template>
        </div>
    </div>
</div>

