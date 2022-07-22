<div :class="clase" x-show=" archivos != 'undefined'">
    <p x-show="archivos.length <= 0"
       class="text-center text-danger text-bold">Sin archivos</p>
    <h5 x-show="archivos.length > 0 "
        class="text-left text-bold" x-text="titulo"></h5>
    <table class="table table-sm">
        <tbody>
        <template x-for="(archivo, index) in archivos">
            <tr>
                <td>
                    <span x-text="archivo.title"></span><br>
                    <div class="input-group"
                         x-show="typeof archivos[index].comment !== 'undefined'">
                                <textarea
                                        class="form-control"
                                        x-model="archivos[index].comment"></textarea>
                        <button x-show="typeof archivos[index].comment !== 'undefined'"
                                class="btn btn-xs btn-danger"
                                @click="delete archivos[index].comment"
                                title="Eliminar comentario">
                            <i class="fa fa-remove"></i>
                        </button>
                    </div>
                </td>
                <td x-show="validar">
                    <div class="custom-control custom-switch">
                        <input type="checkbox"
                               :checked="archivo.validado === true"
                               @click="archivos[index].validado = event.target.checked"
                               class="custom-control-input" :id="'fileCustomSwitch_' + index">
                        <label class="custom-control-label" :for="'fileCustomSwitch_' + index"></label>
                    </div>
                </td>
                <td>
                    <div class="btn btn-xs btn-group">
                        <a class="btn btn-xs btn-info"
                           :data-target="'#' + sufix_modal  + '_modal_' + index"
                           data-toggle="modal">
                            <i class="fa fa-eye"></i>
                        </a>
                        <button x-show="typeof archivos[index].comment === 'undefined' && comentar"
                                class="btn btn-xs btn-warning"
                                @click="archivos[index] = {...archivos[index], comment:null}"
                                title="Agregar comentario a evidencia">
                            <i class="far fa-commenting"></i>
                        </button>
                    </div>
                    <div class="modal fade modal-ag" :id="sufix_modal + '_modal_' + index" role="dialog">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" x-text="titulo"></h4>
                                    <button type="button"
                                            class="close"
                                            @click="$('.modal-ag').modal('hide');">&times;
                                    </button>
                                </div>
                                <div class="modal-body mx-auto w-100">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <template
                                                x-if="['pdf','jpg','png'].includes(archivo.path.split('.').slice(-1).toString())">
                                            <iframe :src="path_file + archivo.path.replace('/turismo','')"
                                                    class="embed-responsive-item">
                                            </iframe>
                                        </template>
                                        <template
                                                x-if="['avi','mp4'].includes(archivo.path.split('.').slice(-1).toString())">
                                            <video controls muted>
                                                <source :src="path_file + archivo.path" type="video/mp4">
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