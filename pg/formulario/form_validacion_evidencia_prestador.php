<div class="row" x-show="current_manifestacion.evidencia_prestador.length <=0">
    <div class="col-md-12">
        <p class="text-center text-danger text-bold">No se adjuntaron evidencias</p>
    </div>
</div>
<div class="row" x-show="typeof current_manifestacion.evidencia_prestador != 'undefined'">
    <div class="col-12">
        <h5><strong>Evidencias presentadas por el prestador de servicio</strong></h5>
        <table class="table table-sm">
            <tbody>
                <template x-for="(archivo, index) in current_manifestacion.evidencia_prestador">
                    <tr>
                        <td>
                            <span x-text="archivo.title"></span><br>
                            <div class="input-group"
                                 x-show="typeof current_manifestacion.evidencia_prestador[index].comment !== 'undefined'">
                                <textarea
                                        class="form-control"
                                        x-model="current_manifestacion.evidencia_prestador[index].comment"></textarea>
                                    <button x-show="typeof current_manifestacion.evidencia_prestador[index].comment !== 'undefined'"
                                            class="btn btn-xs btn-danger"
                                            @click="delete current_manifestacion.evidencia_prestador[index].comment"
                                            title="Eliminar comentario">
                                        <i class="fa fa-remove"></i>
                                    </button>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                       :checked="archivo.validado === true"
                                       @click="current_manifestacion.evidencia_prestador[index].validado = event.target.checked"
                                       class="custom-control-input" :id="'fileCustomSwitch_' + index">
                                <label class="custom-control-label" :for="'fileCustomSwitch_' + index"></label>
                            </div>
                        </td>
                        <td>
                            <div class="btn btn-xs btn-group">
                                <a class="btn btn-xs btn-info"
                                   :data-target="'#ep_modal_' + index"
                                   data-toggle="modal">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <button x-show="typeof current_manifestacion.evidencia_prestador[index].comment === 'undefined'"
                                        class="btn btn-xs btn-warning"
                                        @click="current_manifestacion.evidencia_prestador[index] = {...current_manifestacion.evidencia_prestador[index], comment:null}"
                                        title="Agregar comentario a evidencia">
                                    <i class="far fa-commenting"></i>
                                </button>
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
                                                 <template x-if="['pdf','jpg','png'].includes(archivo.path.split('.').slice(-1).toString())">
                                                     <iframe :src="path_site + archivo.path.replace('/turismo','')"
                                                             class="embed-responsive-item">
                                                     </iframe>
                                                 </template>
                                                 <template x-if="['avi','mp4'].includes(archivo.path.split('.').slice(-1).toString())">
                                                     <video controls muted>
                                                         <source :src="path_site + archivo.path" type="video/mp4">
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
    <div class="col-12">
        <div class="form-group">
            <label>Razones por la cual el prestador no acepta la solicitud</label>
            <textarea
                readonly
                x-text = "razonNoAceptacion"
                class="form-control"
            ></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12"
         x-show="[5].includes(parseInt(current_manifestacion.id_etapa_queja))">
        <div class="form-group clearfix">
            <label class="">¿ Como desea proceder con las pruebas ?</label><br>
            <div class="icheck-success"
                 x-show="comprobarEvidenciaValidadaPrestador">
                <input type="radio"
                       value="1"
                       name="check_aceptacion_prueba"
                       x-model="tipo_aceptacion_pp"
                       id="check_validar_prueba">
                <label for="check_validar_prueba">Pruebas validas</label>
            </div>
            <div class="icheck-success"
                 x-show="comprobarEvidenciaPendientePrestador">
                <input type="radio"
                       value="2"
                       name="check_aceptacion_prueba"
                       x-model="tipo_aceptacion_pp"
                       id="check_rechazar_prueba">
                <label for="check_rechazar_prueba">Pruebas no validas</label>
            </div>

        </div>
    </div>
    <div class="col-md-12"
         x-show="[5].includes(parseInt(current_manifestacion.id_etapa_queja)) && tipo_aceptacion_pp !== null">
        <div class="form-group">
            <label x-text="labelAceptacionPP"></label>
            <textarea
                    x-ref="texto_aceptacion_pp"
            ></textarea>
        </div>
    </div>
    <div class="col-md-12 text-center" x-show="loading_ap_prestador">
        <div class='text-center'><i class='fas fa-1x fa-sync fa-spin'></i></div>
    </div>
    <div class="col-md-12">
        <div class="btn-group"
             x-show="!loading_ap_prestador
                     && [5].includes(parseInt(current_manifestacion.id_etapa_queja))
                     && tipo_aceptacion_pp !== null">
            <button @click="admisionPruebaPrestador()"
                    class="btn btn-success">
                Guardar y continuar <i class="fa fa-check"></i>
            </button>
            <button @click="admisionPruebaPrestador(1)"
                    class="btn btn-warning">
                Vista previa<i class="fa fa-search"></i>
            </button>
        </div>
        <div class="btn-group"
             x-show="!loading_ap_prestador && controlActaPP">
            <button
                    @click="descargarActaAdmisionPP()"
                    class="btn btn-success">
                Descargar acta <i class="fa fa-download"></i>
            </button>
            <button
                    @click="descargarActaAdmisionPP(1)"
                    class="btn btn-warning">
                Vista previa <i class="fa fa-search-plus"></i>
            </button>
        </div>
    </div>
</div>