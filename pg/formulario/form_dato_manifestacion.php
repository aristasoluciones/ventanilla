    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label><span class="text-danger"></span>Prestador de servicio</label>
                <select :disabled="!prevencionPendiente || !prevencionVigente"
                        data-rule-required="true"
                        x-ref="select_establecimiento"
                        class="form-control"
                        x-model="current_manifestacion.id_establecimiento_hecho">
                    <template x-for = "(item, index) in lista_establecimiento">
                        <option x-text="item.valor" :value="item.id"></option>
                    </template>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label><span class="text-danger"></span>Lugar de los hechos</label>
                <select :disabled="!prevencionPendiente || !prevencionVigente"
                        data-rule-required="true"
                        x-ref="select_municipio_hecho"
                        class="form-control">
                    <template x-for = "(item, index) in lista_municipio_hecho">
                        <option x-text="item.valor" :value="item.id"></option>
                    </template>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label><span class="text-danger"></span>Localidad de los hechos</label>
                <select :disabled="!prevencionPendiente || !prevencionVigente"
                        data-rule-required="true"
                        x-ref="select_localidad_hecho"
                        class="form-control">
                    <template x-for = "(item, index) in lista_localidad_hecho">
                        <option x-text="item.valor" :value="item.id"></option>
                    </template>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span>Fecha de los hechos</label>
                <input  type="date"
                        :readonly="!prevencionPendiente || !prevencionVigente"
                        class="form-control"
                        x-model="current_manifestacion.fecha_queja_fm"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span>Referencia del lugar</label>
                <textarea  :readonly="!prevencionPendiente || !prevencionVigente"
                           class="form-control"
                           x-model="current_manifestacion.referencia_hecho"></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span>Descripción de los hechos</label>
                <textarea  :readonly="!prevencionPendiente || !prevencionVigente"
                           class="form-control"
                           x-model="current_manifestacion.descripcion_hecho"></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span>Propuesta de solución</label>
                <textarea   :readonly="!prevencionPendiente || !prevencionVigente"
                            class="form-control"
                            x-model="current_manifestacion.propuesta_solucion"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <label for=""><em class="text-danger"></em>Georreferencia</label>
            <div id="georeferencia" style="height: 400px"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center" x-show="loading">
            <div class='text-center'><i class='fas fa-1x fa-sync fa-spin'></i></div>
        </div>
        <div class="col-md-12">
            <div class="btn-group">
                <button @click="actualizarEnviar"
                        x-show="prevencionPendiente && prevencionVigente"
                        class="btn btn-success">
                    Guardar cambios y enviar <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</form>