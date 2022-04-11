<div class="row" x-show="current_manifestacion.evidencia.length <=0">
    <div class="col-md-12">
        <p class="text-center text-danger text-bold">No se adjuntaron evidencias</p>
    </div>
</div>
<div class="row pb-2">
    <div class="col-12">
        <h5><strong>Evidencias presentadas por el turista y/o visitante</strong></h5>
        <table class="table table-sm">
            <tbody>

                    <tr x-show="typeof current_manifestacion.evidencia.imagen != 'undefined'">
                        <td style="border-top: 0px;" colspan="2"><strong>Imagenes</strong></td>
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
                                </div>
                                <div class="modal fade" :id="'et_modal_img_' + index" role="dialog">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
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
                    <tr x-show="typeof current_manifestacion.evidencia.doc != 'undefined'">
                        <td style="border-top: 0px;" colspan="2"><strong>Documentos</strong></td>
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
                    <tr x-show="typeof current_manifestacion.evidencia.video != 'undefined'">
                        <td style="border-top: 0px;" colspan="2"><strong>Videos</strong></td>
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
<div class="row" x-show="controlActaAceptacion">
    <div class="col-md-12 text-center" x-show="loading_download_acta">
        <div class='text-center'><i class='fas fa-1x fa-sync fa-spin'></i></div>
    </div>
    <div class="col-md-12" x-show="!loading_download_acta">
        <div class="form-group" >
            <label>Acta de admisión de la solicitud</label><br>
            <div class="btn-group">
                <button
                        @click="descargarActaAdmision()"
                        class="btn btn-success">
                    Descargar<i class="fa fa-download"></i>
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
<div class="row">
    <div class="col-md-4" x-show="[3].includes(parseInt(current_manifestacion.id_etapa_queja))">
        <div class="form-group clearfix">
           <label class="">¿ Como desea proceder con esta solicitud ?</label><br>
           <div class="icheck-success">
               <input type="radio"
                      value="1"
                      x-model="tipo_aceptacion_etapa"
                      id="check_aceptar_manifestacion">
               <label for="check_aceptar_manifestacion">Aceptar y conciliar</label>
           </div>
            <div class="icheck-danger">
                <input type="radio"
                       value="2"
                       x-model="tipo_aceptacion_etapa"
                       id="check_no_aceptar">
                <label for="check_no_aceptar">No aceptar y presentar pruebas</label>
            </div>
        </div>
    </div>
</div>
<div class="row pt-3">
    <div class="col-12"
         x-show="tipo_aceptacion_etapa == 2 || parseInt(current_manifestacion.id_etapa_queja) >= 3">
        <h5><strong>Evidencias del prestador</strong></h5>
        <table class="table table-sm">
            <tbody>
                <template x-for="(file_prestador, index) in current_manifestacion.evidencia_prestador">
                    <tr>
                        <td x-text="file_prestador.title"></td>
                        <td>
                            <small x-show="file_prestador.validado" class='badge badge-success'>Validado</small>
                            <small x-show="!file_prestador.validado" class='badge'>No validado</small>
                        </td>
                        <td>
                            <div class="btn btn-xs btn-group">
                                <button x-show="!file_prestador.validado" @click="prestadorRemoveFile(file_prestador)"
                                        class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                <button title="Vista previa"
                                        :data-target="'#ep_modal_' + index"
                                        data-toggle="modal"
                                        class="btn btn-xs btn-info"><i class="fas fa-eye"></i></button>
                            </div>
                            <div class="modal fade" :id="'ep_modal_' + index" role="dialog">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Evidencia</h4>
                                            <button type="button"
                                                    class="close"
                                                    data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body mx-auto w-100">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <template x-if="['pdf','jpg','png'].includes(file_prestador.path.split('.').slice(-1).toString())">
                                                    <iframe :src="path_file() + file_prestador.path"
                                                            class="embed-responsive-item">
                                                    </iframe>
                                                </template>
                                                <template x-if="['avi','mp4'].includes(file_prestador.path.split('.').slice(-1).toString())">
                                                    <video controls muted>
                                                        <source :src="path_file() + file_prestador.path" type="video/mp4">
                                                    </video>
                                                </template>
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
    <div class="col-3"
         x-show="tipo_aceptacion_etapa == 2">
        <div class="form-group">
            <div class="btn-group w-100">
              <span class="btn btn-success col fileinput-button">
                <i class="fas fa-file-upload"></i>
                <span>Agregar</span>
              </span>
            </div>
            <div class="d-flex align-items-center">
                <div class="fileupload-process w-100">
                    <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                    </div>
                </div>
            </div>
            <ul class="list-unstyled">
                <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Tamaño maximo permitido hasta: 20MB.</li>
                <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Tipos de archivo permitido: Video, PDF´s, Imagenes(JPG, PNG).</li>
                <li class="text-bold small"><i class="fa fa-dot-circle small"></i> Maximo 5 archivos.</li>
            </ul>
        </div>
    </div>
    <div class="col-md-12" x-show="tipo_aceptacion_etapa == 2">
        <div class="form-group">
            <label>Describa la razon de no aceptación</label>
            <textarea
                    x-text="texto_refutacion"
                    x-ref="texto_refutacion"
            ></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center" x-show="loading">
        <div class='text-center'><i class='fas fa-1x fa-sync fa-spin'></i></div>
    </div>
    <div class="col-md-12">
        <div class="btn-group" x-show="!loading && tipo_aceptacion_etapa > 0">
            <button class="btn btn-success" @click="guardar">
                Guardar <i class="fa fa-check"></i>
            </button>
        </div>
    </div>
</div>
<div class="row" x-show="[7].includes(parseInt(current_manifestacion.id_etapa_queja))">
    <div class="col-md-12 text-center" x-show="loading_download_acta">
        <div class='text-center'><i class='fas fa-1x fa-sync fa-spin'></i></div>
    </div>
    <div class="col-md-12" x-show="!loading_download_acta">
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

