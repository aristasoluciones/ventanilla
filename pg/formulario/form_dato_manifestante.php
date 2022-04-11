<form class="needs-validation"
      id="form-solicitud"
      name="form-solicitud"
      onsubmit="return false">
    <div class="row">
        <div class="form-group col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span> Nacionalidad</label>
                <select :disabled="!prevencionPendiente || !prevencionVigente"
                        data-rule-required="true"
                        x-ref="select_pais"
                        class="form-control"
                        x-model="current_manifestacion.id_pais">
                    <template x-for = "(item, index) in lista_pais">
                        <option x-text="item.valor" :value="item.id"></option>
                    </template>
                </select>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span> Nombre</label>
                <input  :readonly="!prevencionPendiente || !prevencionVigente"
                        class="form-control"
                        data-rule-required="true"
                        x-model="current_manifestacion.nombre"/>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span> Apellidos</label>
                <input  :readonly="!prevencionPendiente || !prevencionVigente"
                        class="form-control"
                        x-model="current_manifestacion.apellidos"/>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span> Sexo</label>
                <input  :readonly="!prevencionPendiente || !prevencionVigente"
                        class="form-control"
                        x-model="current_manifestacion.nombre_genero"/>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span>Fecha de nacimiento</label>
                <input  :readonly="!prevencionPendiente || !prevencionVigente"
                        type="date"
                        class="form-control"
                        x-model="current_manifestacion.fecha_nacimiento_fm"/>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span>Correo electrónico</label>
                <input  readonly
                        class="form-control"
                        x-model="current_manifestacion.correo"/>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span>Telefono de contacto</label>
                <input  :readonly="!prevencionPendiente || !prevencionVigente"
                        class="form-control"
                        x-model="current_manifestacion.telefono"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"><h3>Domicilio</h3></div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span>Municipio</label>
                <input  :readonly="!prevencionPendiente || !prevencionVigente"
                        class="form-control"
                        x-model="current_manifestacion.municipio_turista"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span>Calle y número</label>
                <input  :readonly="!prevencionPendiente || !prevencionVigente"
                        class="form-control"
                        x-model="current_manifestacion.calle_numero_turista"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span>Colonia</label>
                <input  :readonly="!prevencionPendiente || !prevencionVigente"
                        class="form-control"
                        x-model="current_manifestacion.colonia_turista"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="nombre"><span class="text-danger"></span>Código postal</label>
                <input  :readonly="!prevencionPendiente || !prevencionVigente"
                        class="form-control"
                        x-model="current_manifestacion.cp_turista"/>
            </div>
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
