<?php
require_once("../php/inicializandoDatosExterno.php");
$row = [];
$id = $funciones->limpia($_POST['id']);

if ($id > 0) {
    $row = $conexion->fetch_array($querys->getSolicitud($id));
}
$tabConciliacion = false;
$tabResolucion = false;
if ($row) {
    $seguimientos = json_decode($row['pila_seguimiento'], true);
    $idSeguimientos = array_column($seguimientos, 'id_etapa_queja');
    switch ((int)$row['tipo']) {
        case 1:
            $tabConciliacion = in_array(4, $idSeguimientos);
            $tabResolucion = in_array(8, $idSeguimientos);
            break;
    }
}
$url = $row['tipo'] == '1' ? 'ventanilla.queja' : 'ventanilla.denuncia';
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <a href="<?= $url ?>" title="Regresar a bandeja" class="btn btn-outline-info">Regresar</a>
                <h1 class="m-0">Seguimiento</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="javascript: parent.cargarMenu('inicio')">Inicio</a></li>
                    <li class="breadcrumb-item active">Seguimiento solicitud</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <?php if ($row) { ?>
                <div class="col-md-12" x-data="ComponenteSeguimiento()" x-init="await inicializar(<?= $id ?>)">
                    <div class="card card-success">
                        <div class="card-header width-border">
                            <h3 class="card-title">Seguimiento de solicitud</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="miTapsPropiedades" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="dato_general_1"
                                       data-toggle="pill" href="#dtab_1" role="tab"
                                       aria-controls="Stab_1" aria-selected="true">
                                        Datos generales
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="dato_denuncia_2"
                                       data-toggle="pill" href="#dtab_2" role="tab"
                                       aria-controls="Stab_2" aria-selected="false">
                                        Información de los hechos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="dato_denuncia_3"
                                       data-toggle="pill" href="#dtab_3" role="tab"
                                       aria-controls="Stab_3" aria-selected="false">
                                        Evidencias presentadas
                                    </a>
                                </li>
                                <?php if ($tabConciliacion) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dato_denuncia_5"
                                           data-toggle="pill" href="#dtab_5" role="tab"
                                           aria-controls="Stab_5" aria-selected="false">
                                            Cierre por Conciliacíon
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if ($tabResolucion) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dato_denuncia_7"
                                           data-toggle="pill" href="#dtab_7" role="tab"
                                           aria-controls="stab_7" aria-selected="false">
                                            Cierre por Resolución
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="dtab_1"
                                     role="tabpanel" aria-labelledby="dtab_1" disabled>
                                    <div class="container p-2">
                                        <?php include_once('formulario/form_dato_manifestante.php'); ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="dtab_2"
                                     role="tabpanel" aria-labelledby="dtab_2" disabled>
                                    <div class="container p-2">
                                        <?php include_once('formulario/form_dato_manifestacion.php'); ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="dtab_3"
                                     role="tabpanel" aria-labelledby="dtab_3" disabled>
                                    <div class="container p-2">
                                        <?php include_once('formulario/form_validacion_aceptacion_manifestacion.php'); ?>
                                    </div>
                                </div>
                                <?php if ($tabConciliacion) { ?>
                                    <div class="tab-pane fade" id="dtab_5"
                                         role="tabpanel" aria-labelledby="dtab_5" disabled>
                                        <div class="container p-2">
                                            <?php include_once('formulario/form_finalizacion.php'); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($tabResolucion) { ?>
                                    <div class="tab-pane fade" id="dtab_7"
                                         role="tabpanel" aria-labelledby="dtab_7" disabled>
                                        <div class="container p-2">
                                            <?php include_once('formulario/form_finalizacion.php'); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-md-12">
                    <p class="text-danger">Registro no encontrado.</p>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- /.content -->
<script>
    function ComponenteSeguimiento() {
        return {
            path_site: '',
            path_file: function () {
                switch (document.location.hostname) {
                    case 'ventanilla.test':
                        return 'http://turismo.test'
                    case 'turista.plataformasecturchiapas.com':
                    case 'turista.plataformasecturchiapas.mx':
                        return 'https://plataformasecturchiapas.mx/turismo'
                    default :
                        return ''
                }
            },
            div_mapa: null,
            lista_pais: [],
            lista_municipio_hecho: [],
            lista_localidad_hecho: [],
            lista_establecimiento: [],
            current_manifestacion: {
                evidencia: [],
                finalizado: 0,
                seguimiento_corriente: null,
                pila_seguimiento: null,
            },
            loading: false,
            loading_download_acta: false,
            evidencia: [],
            dropzones: [],
            get enPrevencion() {
                return [2].includes(parseInt(this.current_manifestacion.id_etapa_queja))
            },
            get prevencionPendiente() {
                var flag = false
                if ([2].includes(parseInt(this.current_manifestacion.id_etapa_queja))) {
                    var seguimiento_corriente = JSON.parse(this.current_manifestacion.seguimiento_corriente)
                    var subsanado = parseInt(seguimiento_corriente.subsanado)
                    flag = subsanado !== 1
                }
                return flag
            },
            get prevencionVigente() {
                var flag = false
                if ([2].includes(parseInt(this.current_manifestacion.id_etapa_queja))) {
                    var seguimiento_corriente = JSON.parse(this.current_manifestacion.seguimiento_corriente)
                    var fecha_corriente = moment().format('YYYY-MM-DD')
                    var fecha_vencimiento = moment(seguimiento_corriente.fecha).add(3, 'days').format('YYYY-MM-DD')
                    flag = fecha_vencimiento >= fecha_corriente
                }
                return flag
            },

            get listaActaFirmadaAdmisionSolicitud () {
                let seguimiento = this.getListaSeguimientoFiltrado([1])
                return this.pilaActaFirmada(seguimiento)
            },
            get listaActaFirmadaCierreInstruccion () {
                let seguimiento = this.getListaSeguimientoFiltrado([7])
                return this.pilaActaFirmada(seguimiento)
            },

            get listaActaFirmadaResolucion () {
                let seguimiento = this.getListaSeguimientoFiltrado([8])
                return this.pilaActaFirmada(seguimiento)
            },

            get listaActaFirmadaConciliacion () {
                let seguimiento = this.getListaSeguimientoFiltrado([4])
                return this.pilaActaFirmada(seguimiento)
            },

            pilaActaFirmada (seguimiento) {
                let pila_acta = []

                if (!seguimiento.length)
                    return pila_acta

                if (!this.isJSON(seguimiento[0].seguimiento))
                    return pila_acta

                let seguimiento_json = JSON.parse(seguimiento[0].seguimiento)

                if (!seguimiento_json.hasOwnProperty('pila_acta'))
                    return pila_acta

                if (!seguimiento_json.pila_acta.length)
                    return pila_acta

                let lista_acta = seguimiento_json.pila_acta
                pila_acta =  lista_acta.filter( (item) => (typeof item.path_acta_firmada !== 'undefined'))

                pila_acta.forEach((item) => {
                    let nombre = "Acta"
                    switch (parseInt(item.tipo)) {
                        case 1:
                            nombre = 'Acta de admisión  de pruebas'
                            switch (parseInt(seguimiento[0].id_etapa_queja)) {
                                case 1: nombre = 'Acta admisión de solicitud'
                                    break;
                                case 4: nombre = 'Acta conciliación'
                                    break;
                                case 7: nombre = 'Acta de cierre de instrucción'
                                    break;
                                case 8: nombre = 'Acta de resolución'
                                    break;
                            }
                            break
                        case 2: nombre = 'Acta de desechamiento de pruebas'
                            break
                        case 3: nombre = 'Acta de prevención'
                            break
                    }
                    item.nombre = nombre
                })

                return pila_acta
            },

            getListaSeguimiento () {
                let pila = []
                if(this.current_manifestacion.pila_seguimiento !== null) {
                    pila =  JSON.parse(this.current_manifestacion.pila_seguimiento)
                }
                return pila
            },

            getListaSeguimientoFiltrado (etapa) {
                let pila =  this.getListaSeguimiento()
                return pila.filter((item) =>  {
                    return etapa.includes(parseInt(item.id_etapa_queja))
                })
            },

            async inicializar(param) {

                $(this.$refs.select_localidad_hecho).on('change.select2', (event) => {
                    this.current_manifestacion.id_localidad_hecho = parseInt(event.target.value)
                })
                $(this.$refs.select_pais).on('change.select2', (event) => {
                    this.current_manifestacion.id_pais = parseInt(event.target.value)
                })
                $(this.$refs.select_municipio_hecho).on('change.select2', async (event) => {
                    this.current_manifestacion.id_municipio_hecho = parseInt(event.target.value)
                    await this.loadLocalidad(parseInt(event.target.value))
                    $(this.$refs.select_localidad_hecho).val(this.current_manifestacion.id_localidad_hecho).trigger('change.select2')
                })
                $(this.$refs.select_establecimiento).on('change.select2', (event) => {
                    this.current_manifestacion.id_establecimiento_hecho = parseInt(event.target.value)
                })

                await this.loadCatalogo(2)
                await this.loadCatalogo(3)
                await this.loadCatalogo(4)

                const peticion = await fetch(this.path_site + '/php/ventanilla_consulta.php', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ opcion: 1, id: param  })
                })
                const response = await peticion.json()
                this.current_manifestacion =  response.data;
                this.current_manifestacion.evidencia = response.data.evidencia === null
                    ? []
                    : JSON.parse(response.data.evidencia)

                this.initMapa()

                $(this.$refs.select_municipio_hecho).val(response.data.id_municipio_hecho).trigger('change.select2')
                $(this.$refs.select_pais).val(response.data.id_pais).trigger('change.select2')
                $(this.$refs.select_establecimiento).val(response.data.id_establecimiento_hecho).trigger('change.select2')

                var fileinput_button = $('.fileinput-button')
                if (fileinput_button.length > 0) {
                    fileinput_button.each((i, el) => {
                        const tipo = $(el).data('tipo')
                        let accepted_files = ''
                        let max_size = ''
                        switch (tipo) {
                            case 'imagen':
                                accepted_files = 'image/*'
                                max_size = 5
                                break;
                            case 'video':
                                accepted_files = 'video/*'
                                max_size = 20
                                break;
                            case 'doc':
                                accepted_files = '.pdf, imagen/*'
                                max_size = 5
                                break;
                        }
                        var zone = document.getElementById('table-evidencia-' + tipo)
                        let dropzoneItem = new Dropzone(zone, {
                            clickable: el,
                            dictDefaultMessage: 'Arrastre y suelte los archivos aquí',
                            dictFileTooBig: 'El archivo excede el tamaño permitido, Tamaño máximo: {{maxFilesize}}MB.',
                            dictInvalidFileType: 'Tipo de archivo no permitido',
                            dictMaxFilesExceeded: 'Has excedido el máximo numero de archivos permitidos',
                            dictRemoveFile: 'Eliminar',
                            url: '/php/ventanilla_subir.php',
                            autoProcessQueue: true,
                            autoDiscover: false,
                            acceptedFiles: accepted_files,
                            uploadMultiple: false,
                            parallelUploads: 1,
                            maxFiles: 1,
                            paramName: 'file',
                            addRemoveLinks: true,
                            maxFilesize: 20,
                        })
                        dropzoneItem.on('error', (file, response) => {
                            dropzoneItem.removeFile(file)
                            mostrar_mensaje('Alerta', response, 'danger')
                        })
                        dropzoneItem.on('sending', (file, xhr, formData) => {
                            formData.append('opcion', 1)
                            formData.append('tipo', tipo)
                            formData.append('id', this.current_manifestacion.id_solicitud_queja)
                            document.querySelector("#total-progress-" + tipo).style.opacity = "1"
                        })
                        dropzoneItem.on('success', (file, response) => {
                            this.current_manifestacion.evidencia = response
                        })
                        dropzoneItem.on("totaluploadprogress", function (progress) {
                            document.querySelector("#total-progress-" + tipo + " .progress-bar").style.width = progress + "%"
                        })
                        dropzoneItem.on("queuecomplete", () => {
                            document.querySelector("#total-progress-" + tipo + " .progress-bar").style.opacity = "0"
                            dropzoneItem.removeAllFiles();
                        })
                        this.dropzones.push(dropzoneItem)
                    })
                }
            },
            async loadCatalogo(opcion) {
                const peticion = await fetch(this.path_site + '/php/ventanilla_consulta.php', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({opcion}),
                })
                const response = await peticion.json()
                switch (opcion) {
                    case 2:
                        this.lista_pais = response.items
                        $(this.$refs.select_pais).select2({
                            placeholder: 'Seleccionar',
                            search: true,
                            width: '100%',
                            allowClear: true
                        })
                        break;
                    case 3:
                        this.lista_municipio_hecho = response.items
                        $(this.$refs.select_municipio_hecho).select2({
                            placeholder: 'Seleccionar',
                            search: true,
                            width: '100%',
                            allowClear: true
                        })
                        break;
                    case 4:
                        this.lista_establecimiento = response.items
                        $(this.$refs.select_establecimiento).select2({
                            placeholder: 'Seleccionar',
                            search: true,
                            width: '100%',
                            allowClear: true
                        })
                        break;
                }

            },

            async loadLocalidad(id) {
                let peticion = await fetch(this.path_site + '/php/ventanilla_consulta.php', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({opcion: 5, id_municipio: id}),
                })
                let response = await peticion.json()
                this.lista_localidad_hecho = response.items
                $(this.$refs.select_localidad_hecho).select2({
                    placeholder: 'Seleccionar',
                    search: true,
                    width: '100%',
                    allowClear: true
                })
            },

            async actualizarEnviar() {
                const confirmacion = await Swal.fire({
                    title: '¿Esta seguro de realizar este proceso?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    denyButtonText: `No`,
                })
                if (confirmacion.isDenied || confirmacion.isDismissed)
                    return
                var form = $('#form-solicitud')
                form.validate({
                    errorElement: 'span',
                    errorClass: 'text-danger text-inline',
                    errorPlacement: function (error, element) {
                        var parent_element = element.parent(':first')
                        if (element.attr("type") === "checkbox"
                            || element.prop("tagName") === "SELECT")
                            error.insertAfter(parent_element)
                        else if (element.attr('name') === 'id_tipo_queja') {
                            error.appendTo('#error-tipo-tramite')
                        } else error.insertAfter(element)
                    },
                    onfocusout: false,
                    invalidHandler: function (form, validator) {
                        var errors = validator.numberOfInvalids();
                        if (errors) {
                            validator.errorList[0].element.focus();
                        }
                    },
                })
                if (!form.valid())
                    return

                this.loading = true
                const peticion = await fetch(this.path_site + '/php/ventanilla_subir.php', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({opcion: 2, manifestacion: this.current_manifestacion})
                })
                const response = await peticion.json()
                this.loading = false
                if (response.resp === 1) {
                    mostrar_mensaje('Exito', 'Se han actualizado correctamente la información', 'success')
                    this.current_manifestacion = {
                        ...response.data,
                    }
                    this.current_manifestacion.evidencia = response.data.evidencia === null
                        ? []
                        : JSON.parse(response.data.evidencia)
                    $(this.$refs.select_municipio_hecho).val(response.data.id_municipio_hecho).trigger('change.select2')
                    $(this.$refs.select_pais).val(response.data.id_pais).trigger('change.select2')
                    $(this.$refs.select_establecimiento).val(response.data.id_establecimiento_hecho).trigger('change.select2')
                }
            },
            removeFile(file) {
                $.ajax({
                    url: url_eliminar,
                    type: "POST",
                    data: {
                        opcion: 1,
                        file: file,
                        id: this.current_manifestacion.id_solicitud_queja,
                    },
                    success: (response) => {
                        this.current_manifestacion.evidencia = response
                    }
                })
            },

            initMapa() {
                var coordenada_inicial = null
                var opcionesMapa = {
                    zoom: 16,
                    zoomControl: true,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                if ($('#georeferencia').length > 0) {
                    coordenada_inicial = {lat: 16.7313638, lng: -92.6774193}
                    this.div_mapa = new google.maps.Map(document.getElementById("georeferencia"), opcionesMapa);
                }
                this.setMarcador(coordenada_inicial)
            },

            setMarcador(coordenadas) {
                var $this = this
                let marcadorS = new google.maps.Marker({
                    map: $this.div_mapa,
                    draggable: true,
                    position: coordenadas,
                    visible: true
                });
                $this.div_mapa.setCenter(coordenadas);
                google.maps.event.addListener($this.div_mapa, 'drag', function () {
                    var centro = $this.div_mapa.getCenter();
                    marcadorS.setPosition(centro);
                });
                google.maps.event.addListener($this.div_mapa, 'dragend', function () {
                    var centro = $this.div_mapa.getCenter();
                    marcadorS.setPosition(centro);
                    $this.setLatLngToCampo({lat: marcadorS.getPosition().lat(), lng: marcadorS.getPosition().lng()})
                });
                google.maps.event.addListener(marcadorS, 'dragend', function (event) {
                    $this.setLatLngToCampo({lat: event.latLng.lat(), lng: event.latLng.lng()})
                });
            },

            setLatLngToCampo(coordenada) {
                var lat = coordenada.lat;
                var lng = coordenada.lng
                this.current_manifestacion.coordenada_lugar_hecho = lat + ',' + lng
            },

            showPdfInNewTab(base64Data, fileName) {
                let pdfWindow = window.open("");
                pdfWindow.document.write("<html<head><title>"+fileName+"</title><style>body{margin: 0px;}iframe{border-width: 0px;}</style></head>");
                pdfWindow.document.write("<body><embed width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(base64Data) + "#scrollable=0'></embed></body></html>");
            },

            dowloadFile (base64Data, prefixName) {
                var name_file = prefixName + this.current_manifestacion.folio.replace('/', '_') + '.pdf';
                var $a = $("<a>");
                $a.attr("href",'data:application/pdf;base64,'+ base64Data);
                $("body").append($a);
                $a.attr("download", name_file);
                $a[0].click();
                $a.remove();
            },

            isJSON(text) {
                if (typeof text !== "string") {
                    return false;
                }
                try {
                    var json = JSON.parse(text);
                    return (typeof json === 'object');
                } catch (error) {
                    return false;
                }
            },
        }
    }
</script>
