<!-- vista previa dropzone -->
<div x-data="componenteRecursoRec()" id="zone-file-recurso" x-init="iniciar(<?= $id ?>)">
    <div class="row" x-show="!(id_solicitud_recurso > 0)">
        <div class="callout callout-info">
            <p>
                <?= nl2br($config['instruccion_pprr']->valor) ?>
            </p>
            <?php if ($path_instruccion) { ?>
                <a type="button" class="btn btn-success"
                   target="_blank"
                   title="Descargar guía"
                   href="<?= $path_instruccion ?>">
                    Descargar guía <i class="fa fa-download"></i>
                </a>
            <?php } ?>
        </div>
    </div>
    <form name="frm-configuracion" id="frm-configuracion" enctype="multipart/form-data" onsubmit="return false">
        <div class="form-row">
            <div class="col-md-4 dropzone-recurso" id="acta">
                <div class="form-group">
                    <label>Adjuntar escrito</label>
                    <div class="btn-group w-100">
                      <span class="btn btn-success col fileinput-button">
                        <i class="fas fa-file-upload"></i>
                        <span>Agregar</span>
                      </span>
                    </div>
                </div>
                <div class="table table-striped files" id="previews">
                    <div id="template-1" class="row">
                        <!-- This is used as the file preview template -->
                        <div class="col-md-12">
                            <span class="preview"><img data-dz-thumbnail /></span>
                        </div>
                        <div class="col-md-12">
                            <p class="name" data-dz-name></p>
                            <strong class="error text-danger" data-dz-errormessage></strong>
                        </div>
                        <div class="col-md-6">
                            <p class="size" data-dz-size></p>
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button data-dz-remove class="btn btn-danger delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <table class="table table-sm table-striped">
                    <thead>
                        <th colspan="2">Escrito presentado</th>
                    </thead>
                    <tbody>
                        <template x-for="(archivo, index) in archivos">
                        <tr>
                            <td x-text="archivo.title"></td>
                            <td>
                                <div class="btn btn-xs btn-group">
                                    <button @click="removeFileRecurso(archivo)"
                                            class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                    <button title="Vista previa"
                                            :data-target="'#ep_modal_' + index"
                                            data-toggle="modal"
                                            class="btn btn-xs btn-info"><i class="fas fa-eye"></i></button>
                                </div>
                                <div style="z-index: 1050" class="modal fade modal-vp" :id="'ep_modal_' + index"
                                     role="dialog">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Evidencia</h4>
                                                <button type="button"
                                                        class="close"
                                                        @click="$('.modal-vp').modal('hide');">&times;</button>
                                            </div>
                                            <div class="modal-body mx-auto w-100">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <template x-if="['pdf','jpg','png'].includes(archivo.path.split('.').slice(-1).toString())">
                                                        <iframe :src="path_file() + archivo.path"
                                                                class="embed-responsive-item">
                                                        </iframe>
                                                    </template>
                                                    <template x-if="['avi','mp4'].includes(archivo.path.split('.').slice(-1).toString())">
                                                        <video controls muted>
                                                            <source :src="path_file() + archivo.path" type="video/mp4">
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
        </div>
        <div class="form-row">
            <div class="col-md-4 dropzone-recurso" id="evidencia">
                <div class="form-group">
                    <label>Adjuntar evidencias</label>
                    <div class="btn-group w-100">
                      <span class="btn btn-success col fileinput-button">
                        <i class="fas fa-file-upload"></i>
                        <span>Agregar</span>
                      </span>
                    </div>
                </div>
                <div class="table table-striped files" id="previews">
                    <div id="template-2" class="row">
                        <!-- This is used as the file preview template -->
                        <div class="col-md-12">
                            <span class="preview"><img data-dz-thumbnail /></span>
                        </div>
                        <div class="col-md-12">
                            <p class="name" data-dz-name></p>
                            <strong class="error text-danger" data-dz-errormessage></strong>
                        </div>
                        <div class="col-md-6">
                            <p class="size" data-dz-size></p>
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button data-dz-remove class="btn btn-danger delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <table class="table table-sm table-striped">
                    <thead>
                        <th colspan="2">Evidencias presentadas</th>
                    </thead>
                    <tbody>
                        <template x-for="(evidencia, index) in evidencias">
                        <tr>
                            <td x-text="evidencia.title"></td>
                            <td>
                                <div class="btn btn-xs btn-group">
                                    <button @click="removeFileRecurso(evidencia)"
                                            class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                    <button title="Vista previa"
                                            :data-target="'#ev_modal_' + index"
                                            data-toggle="modal"
                                            class="btn btn-xs btn-info"><i class="fas fa-eye"></i></button>
                                </div>
                                <div style="z-index: 1050" class="modal fade modal-vp" :id="'ev_modal_' + index"
                                     role="dialog">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Evidencia</h4>
                                                <button type="button"
                                                        class="close"
                                                        @click="$('.modal-vp').modal('hide');">&times;</button>
                                            </div>
                                            <div class="modal-body mx-auto w-100">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <template x-if="['pdf','jpg','png'].includes(evidencia.path.split('.').slice(-1).toString())">
                                                        <iframe :src="path_file() + evidencia.path"
                                                                class="embed-responsive-item">
                                                        </iframe>
                                                    </template>
                                                    <template x-if="['avi','mp4'].includes(evidencia.path.split('.').slice(-1).toString())">
                                                        <video controls muted>
                                                            <source :src="path_file() + evidencia.path" type="video/mp4">
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
        </div>
        <div class="form-row">
            <div class="col-md-12">
                <div class='text-center' x-show="loading"><i class='fas fa-1x fa-sync fa-spin'></i></div>
                <button class="btn btn-info" @click="enviarRecurso"
                x-show="totalFiles && !loading">Enviar</button>
            </div>
        </div>
    </form>
</div>