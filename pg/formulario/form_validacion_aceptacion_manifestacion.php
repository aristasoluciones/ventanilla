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
                        <div class="row text-sm">
                            <div class="col-12">
                                <span x-text="archivo.title"></span>
                            </div>
                            <div class="col-12" :id="'accordion_' + index" x-show="typeof current_manifestacion.evidencia.imagen[index].comment_prestador !== 'undefined' || typeof current_manifestacion.evidencia.imagen[index].comment !== 'undefined'">
                                <div class="card card-outline card-info">
                                    <div class="card-header p-0">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" :data-target="'#imgcollapse_' + index" aria-expanded="true" :aria-controls="'#imgcollapse_' + index">
                                                Comentarios
                                            </button>
                                        </h5>
                                    </div>
                                    <div :id="'imgcollapse_' + index" class="collapse" aria-labelledby="headingOne" :data-parent="'#accordion_' + index">
                                    <div class="card-body">
                                        <dl>
                                            <dt x-show="typeof current_manifestacion.evidencia.imagen[index].comment_prestador !== 'undefined'">Prestador de servicios</dt>
                                            <dd x-show="typeof current_manifestacion.evidencia.imagen[index].comment_prestador !== 'undefined'" x-text="current_manifestacion.evidencia.imagen[index].comment_prestador"></dd>

                                            <dt x-show="typeof current_manifestacion.evidencia.imagen[index].comment !== 'undefined'">Funcionario</dt>
                                            <dd x-show="typeof current_manifestacion.evidencia.imagen[index].comment !== 'undefined'" x-text="current_manifestacion.evidencia.imagen[index].comment"></dd>
                                        </dl>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="btn btn-xs btn-group">
                            <button title="Vista previa"
                                    :data-target="'#et_modal_img_' + index"
                                    data-toggle="modal"
                                    class="btn btn-xs btn-info"><i class="fas fa-eye"></i></button>
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
                        <td>
                            <div class="row text-sm">
                                <div class="col-12">
                                    <span x-text="archivo.title"></span>
                                </div>
                                <div class="col-12" :id="'doc_accordion_' + index" x-show="typeof current_manifestacion.evidencia.doc[index].comment_prestador !== 'undefined' || typeof current_manifestacion.evidencia.doc[index].comment !== 'undefined'">
                                    <div class="card card-outline card-info">
                                        <div class="card-header p-0">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" :data-target="'#doc_collapse_' + index" aria-expanded="true" :aria-controls="'#doc_collapse_' + index">
                                                    Comentarios
                                                </button>
                                            </h5>
                                        </div>
                                        <div :id="'doc_collapse_' + index" class="collapse" :data-parent="'#doc_accordion_' + index">
                                            <div class="card-body">
                                                <dl>
                                                    <dt x-show="typeof current_manifestacion.evidencia.doc[index].comment_prestador !== 'undefined'">Prestador de servicios</dt>
                                                    <dd x-show="typeof current_manifestacion.evidencia.doc[index].comment_prestador !== 'undefined'" x-text="current_manifestacion.evidencia.doc[index].comment_prestador"></dd>

                                                    <dt x-show="typeof current_manifestacion.evidencia.doc[index].comment !== 'undefined'">Funcionario</dt>
                                                    <dd x-show="typeof current_manifestacion.evidencia.doc[index].comment !== 'undefined'" x-text="current_manifestacion.evidencia.doc[index].comment"></dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="btn btn-xs btn-group">
                                <button title="Vista previa"
                                        :data-target="'#et_modal_doc_' + index"
                                        data-toggle="modal"
                                        class="btn btn-xs btn-info"><i class="fas fa-eye"></i></button>
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
                        <td>
                            <div class="row text-sm">
                                <div class="col-12">
                                    <span x-text="archivo.title"></span>
                                </div>
                                <div class="col-12" :id="'video_accordion_' + index" x-show="typeof current_manifestacion.evidencia.video[index].comment_prestador !== 'undefined' || typeof current_manifestacion.evidencia.video[index].comment !== 'undefined'">
                                    <div class="card card-outline card-info">
                                        <div class="card-header p-0">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" :data-target="'#video_collapse_' + index" aria-expanded="true" :aria-controls="'#video_collapse_' + index">
                                                    Comentarios
                                                </button>
                                            </h5>
                                        </div>
                                        <div :id="'video_collapse_' + index" class="collapse" aria-labelledby="headingOne" :data-parent="'#video_accordion_' + index">
                                            <div class="card-body">
                                                <dl>
                                                    <dt x-show="typeof current_manifestacion.evidencia.video[index].comment_prestador !== 'undefined'">Prestador de servicios</dt>
                                                    <dd x-show="typeof current_manifestacion.evidencia.video[index].comment_prestador !== 'undefined'" x-text="current_manifestacion.evidencia.video[index].comment_prestador"></dd>

                                                    <dt x-show="typeof current_manifestacion.evidencia.video[index].comment !== 'undefined'">Funcionario</dt>
                                                    <dd x-show="typeof current_manifestacion.evidencia.video[index].comment !== 'undefined'" x-text="current_manifestacion.evidencia.video[index].comment"></dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="btn btn-xs btn-group">
                                <button title="Vista previa"
                                        :data-target="'#et_modal_video_' + index"
                                        data-toggle="modal"
                                        class="btn btn-xs btn-info"><i class="fas fa-eye"></i></button>
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
<div class="row">
    <div class="col-md-12"
         x-ref="ref_focus_prevencion"
         x-show="listaActaFirmadaAdmisionSolicitud.length">
        <label>Autos disponibles para descargar</label><br>
        <div class="btn-group">
            <template x-for="(item, index) in listaActaFirmadaAdmisionSolicitud">
                <a key="index" type="button" :href="path_file() + item.path_acta_firmada" class="btn btn-outline-info" target="_blank" title="Descargar acta">
                    <span x-text="item.nombre"></span> <i class="fa fa-download"></i>
                </a>
            </template>
        </div>
    </div>
</div>
<div class="row pt-4" x-show="prevencionPendiente && prevencionVigente">
    <div class="col-md-12">
        <div class="form-group clearfix">
            <div class="icheck-success">
                <input type="checkbox"
                       value="1"
                       name="resolver_prevencion"
                       x-model="resolver_prevencion"
                       id="check_resolver_prevencion">
                <label for="check_resolver_prevencion">Resolver prevención</label>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-center"
         x-show="loading">
        <div class='text-center'><i class='fas fa-1x fa-sync fa-spin'></i></div>
    </div>
    <div class="col-md-12"
         x-show="resolver_prevencion">
        <div class="btn-group"
             x-show="!loading">
            <button @click="actualizarEnviar"
                    class="btn btn-success">
                Guardar cambios y enviar <i class="fa fa-save"></i>
            </button>
        </div>
    </div>
</div>


