<div class="row"
     x-show="controlActaFinal">
    <div class="col-md-12 text-center"
         x-show="loading_download_acta">
        <div class='text-center'><i class='fas fa-1x fa-sync fa-spin'></i></div>
    </div>
    <div class="col-md-12"
         x-show="!loading_download_acta">
        <div class="form-group" >
            <div class="btn-group">
                <button
                        @click="descargarActaFinal()"
                        class="btn btn-success">
                    Descargar acta <i class="fa fa-download"></i>
                </button>
                <button
                        @click="descargarActaFinal(1)"
                        class="btn btn-warning">
                    Vista previa <i class="fa fa-search-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>

