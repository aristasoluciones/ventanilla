<div class="row" x-show="current_manifestacion.evidencia.length <=0">
    <div class="col-md-12">
        <p class="text-center text-danger text-bold">No se adjuntaron evidencias</p>
    </div>
</div>
<div class="row pb-2">
    <div class="col-12">
        <h5><strong>Evidencias adjuntas</strong></h5>
    </div>
    <div class="col-md-4 col-sm-12">
        <table class="table table-sm" id="table-evidencia-imagen">
            <tbody>
            <tr>
                <td style="border-top: 0px;" colspan="2"><strong>Imagenes</strong></td>
            </tr>
            <tr x-show="prevencionPendiente && prevencionVigente">
                <td colspan="2">
                    <ul class="list-unstyled">
                        <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Tamaño maximo permitido hasta: 20MB.</li>
                        <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Tipos de archivo permitido: Video, PDF´s, Imagenes(JPG, PNG).</li>
                        <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Maximo 5 archivos.</li>
                    </ul>
                    <div class="form-group text-center">
                        <div class="btn-group w-50">
                            <span class="btn no-gutters btn-success col fileinput-button fileinput-imagen"
                                  data-tipo="imagen">
                                <i class="fas fa-file-upload"></i>
                                <span>Agregar</span>
                             </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="fileupload-process w-100">
                            <div id="total-progress-imagen" class="progress progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <template x-for="(archivo, index) in current_manifestacion.evidencia.imagen">
                <tr>
                    <td>
                        <span x-text="archivo.title"></span><br>
                        <div class="input-group" x-show="typeof current_manifestacion.evidencia.imagen[index].comment_prestador !== 'undefined'">
                                      <textarea
                                              class="form-control card-text"
                                              x-model="current_manifestacion.evidencia.imagen[index].comment_prestador"></textarea>
                            <button x-show="typeof current_manifestacion.evidencia.imagen[index].comment_prestador !== 'undefined'"
                                    class="btn btn-xs btn-danger"
                                    @click="delete current_manifestacion.evidencia.imagen[index].comment_prestador"
                                    title="Eliminar comentario">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                    </td>
                    <td>
                        <div class="btn btn-xs btn-group">
                            <button title="Vista previa"
                                    :data-target="'#et_modal_img_' + index"
                                    data-toggle="modal"
                                    class="btn btn-xs btn-info"><i class="fas fa-eye"></i></button>
                            <button x-show="prevencionPendiente && prevencionVigente"
                                    title="Eliminar"
                                    @click="removeFile(archivo)"
                                    class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                        </div>
                        <div class="modal fade" :id="'et_modal_img_' + index" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Imagen</h4>
                                        <button type="button"
                                                class="close"
                                                data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body mx-auto w-100">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe :src="path_file() + archivo.path"
                                                    class="embed-responsive-item">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
    <div class="col-md-4 col-sm-12">
        <table class="table table-sm"  id="table-evidencia-doc">
            <tbody>
                <tr>
                    <td style="border-top: 0px;" colspan="2"><strong>Documentos</strong></td>
                </tr>
                <tr x-show="prevencionPendiente && prevencionVigente">
                    <td colspan="2">
                        <ul class="list-unstyled">
                            <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Tamaño maximo permitido hasta: 20MB.</li>
                            <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Tipos de archivo permitido: Video, PDF´s, Imagenes(JPG, PNG).</li>
                            <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Maximo 5 archivos.</li>
                        </ul>
                        <div class="form-group text-center">
                            <div class="btn-group w-50">
                            <span class="btn no-gutters btn-success col fileinput-button fileinput-doc"
                                  data-tipo="doc">
                                <i class="fas fa-file-upload"></i>
                                <span>Agregar</span>
                             </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fileupload-process w-100">
                                <div id="total-progress-doc" class="progress progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <template x-for="(archivo, index) in current_manifestacion.evidencia.doc">
                    <tr>
                        <td x-text="archivo.title"></td>
                        <td>
                            <div class="btn btn-xs btn-group">
                                <button title="Vista previa"
                                        :data-target="'#et_modal_doc_' + index"
                                        data-toggle="modal"
                                        class="btn btn-xs btn-info"><i class="fas fa-eye"></i></button>
                                <button x-show="prevencionPendiente && prevencionVigente"
                                        title="Eliminar"
                                        @click="removeFile(archivo)"
                                        class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                            </div>
                            <div class="modal fade" :id="'et_modal_doc_' + index" role="dialog">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Documento</h4>
                                            <button type="button"
                                                    class="close"
                                                    data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body mx-auto w-100">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe :src="path_file() + archivo.path"
                                                        class="embed-responsive-item">
                                                </iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
    <div class="col-md-4 col-sm-12">
        <table class="table table-sm"  id="table-evidencia-video">
            <tbody>
                <tr>
                    <td style="border-top: 0px;" colspan="2"><strong>Videos</strong></td>
                </tr>
                <tr x-show="prevencionPendiente && prevencionVigente">
                    <td colspan="2">
                        <ul class="list-unstyled">
                            <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Tamaño maximo permitido hasta: 20MB.</li>
                            <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Tipos de archivo permitido: Video, PDF´s, Imagenes(JPG, PNG).</li>
                            <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Maximo 5 archivos.</li>
                        </ul>
                        <div class="form-group text-center">
                            <div class="btn-group w-50">
                            <span class="btn no-gutters btn-success col fileinput-button fileinput-video"
                                  data-tipo="video">
                                <i class="fas fa-file-upload"></i>
                                <span>Agregar</span>
                             </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fileupload-process w-100">
                                <div id="total-progress-video" class="progress progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <template x-for="(archivo, index) in current_manifestacion.evidencia.video">
                    <tr>
                        <td x-text="archivo.title"></td>
                        <td>
                            <div class="btn btn-xs btn-group">
                                <button title="Vista previa"
                                        :data-target="'#et_modal_video_' + index"
                                        data-toggle="modal"
                                        class="btn btn-xs btn-info"><i class="fas fa-eye"></i></button>
                                <button x-show="prevencionPendiente && prevencionVigente"
                                        title="Eliminar"
                                        @click="removeFile(archivo)"
                                        class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                            </div>
                            <div class="modal fade" :id="'et_modal_video_' + index" role="dialog">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Video</h4>
                                            <button type="button"
                                                    class="close"
                                                    data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body mx-auto w-100">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <video controls muted>
                                                    <source :src="path_file() + archivo.path" type="video/mp4">
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
<div class="row" x-show="prevencionPendiente && prevencionVigente">
    <p class="text-danger text-bold">Tiene una preveción pendiente que atender</p>
</div>
<div class="row" x-show="prevencionPendiente && !prevencionVigente">
    <p class="text-bold" style="color: darkorange">Estimado Turista o Visitante, el plazo para subsanar la omisión, ha vencido.</p>
</div>
<div class="row" x-show="prevencionPendiente">
    <div class="col-12">
        <div class="form-group">
            <label>Motivo de la prevencíon</label>
            <textarea readonly
                      class="form-control"
                      x-text="textoPrevencion"></textarea>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center" x-show="loading">
        <div class='text-center'><i class='fas fa-1x fa-sync fa-spin'></i></div>
    </div>
    <div class="col-md-12">
        <div class="btn-group" x-show="!loading">
            <button @click="actualizarEnviar"
                    x-show="prevencionPendiente && prevencionVigente"
                    class="btn btn-success">
                Guardar cambios y enviar <i class="fa fa-save"></i>
            </button>
        </div>
    </div>
</div>
<div class="row" x-show="controlActaAceptacion">
    <div class="col-md-12 text-center" x-show="loading_download_acta">
        <div class='text-center'><i class='fas fa-1x fa-sync fa-spin'></i></div>
    </div>
    <div class="col-md-12" x-show="!loading_download_acta">
        <div class="form-group" >
            <div class="btn-group">
                <button
                        @click="descargarActaAdmision()"
                        class="btn btn-success">
                    Descargar acta <i class="fa fa-download"></i>
                </button>
                <button
                        @click="descargarActaAdmision(1)"
                        class="btn btn-warning">
                    Vista previa <i class="fa fa-search-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>

