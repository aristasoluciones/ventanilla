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
    $id_seguimientos = array_column($seguimientos, 'id_etapa_queja');
    switch ((int)$row['tipo']) {
        case 1:
            $tabConciliacion = in_array(4, $id_seguimientos);
            $tabResolucion = in_array(7, $id_seguimientos);
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
                <div class="col-md-12" x-data="ComponenteSeguimiento()" x-init="inicializar(<?= $id ?>)">
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
                                        Información general
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
            tipo_respuesta_etapa: null,
            tipo_aceptacion_pp: null,
            texto_aceptacion_pp: null,
            current_manifestacion: {
                evidencia: [],
                evidencia_prestador: [],
                texto_acuerdo: null,
                texto_motivo_improcedencia: null,
                texto_conciliacion_resolucion: null,
                finalizado: 0,
                seguimiento_corriente: null,
                pila_seguimiento: null,
            },
            loading: false,
            loading_ap_prestador: false,
            loading_conciliacion: false,
            loading_download_acta: false,
            evidencia: [],
            texto_acta: null,
            dropzones: [],
            get controlActaAceptacion() {
                var valor = false;
                if (this.current_manifestacion.pila_seguimiento !== null) {
                    var pila_seguimiento = JSON.parse(this.current_manifestacion.pila_seguimiento)
                    var pila_seguimiento_filtrado = pila_seguimiento.filter((item) => {
                        return item.id_etapa_queja === 3
                    })
                    valor = pila_seguimiento_filtrado.length > 0
                }
                return valor;
            },
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
            get textoPrevencion() {
                var seguimiento_corriente = JSON.parse(this.current_manifestacion.seguimiento_corriente)
                return this.prevencionPendiente
                    ? seguimiento_corriente.seguimiento
                    : ''
            },
            get controlActaFinal() {
                var valor = false;
                if (this.current_manifestacion.pila_seguimiento !== null) {
                    const pila_seguimiento = JSON.parse(this.current_manifestacion.pila_seguimiento)
                    const pila_seguimiento_filtrado = pila_seguimiento.filter((item) => {
                        return [7].includes(parseInt(item.id_etapa_queja))
                    })
                    const existe_etapa = pila_seguimiento_filtrado.length
                    if (existe_etapa && this.current_manifestacion.id_etapa_queja != pila_seguimiento_filtrado[0].id_etapa_queja) {
                        const seguimiento_json = JSON.parse(pila_seguimiento_filtrado[0].seguimiento)
                        valor = typeof seguimiento_json.acta_generada !== 'undefined' && seguimiento_json.acta_generada
                    }
                }
                return valor;
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

                this.loadCatalogo(2)
                this.loadCatalogo(3)
                this.loadCatalogo(4)

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
            async descargarActaFinal(preview = 0) {
                this.loading_download_acta = true
                var etapa = parseInt(this.current_manifestacion.tipo) === 1
                    ? 7
                    : 0;
                const peticion = await fetch(this.path_site + '/php/ventanilla_consulta.php', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        opcion: 7,
                        etapa,
                        manifestacion: this.current_manifestacion
                    })
                })
                const response = await peticion.json()
                this.loading_download_acta = false
                if (response.resp === 0) {
                    mensaje_ventanilla('Error!.', 'Hubo un error al descargar')
                    return
                }
                (preview) ? this.showPdfInNewTab(response.file, 'ACT_FINAL.pdf')
                    : this.dowloadFile(response.file, 'ACTA_FINAL_')
            },
            async descargarActaAdmision(preview = 0) {
                var etapa = parseInt(this.current_manifestacion.tipo) === 1
                    ? 3
                    : 0;
                this.loading_download_acta = true
                fetch(this.path_site + '/php/ventanilla_consulta.php', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({opcion: 6, manifestacion: this.current_manifestacion, etapa})
                }).then(response => response.json())
                    .then((response) => {
                        this.loading_download_acta = false
                        if (response.resp === 0) {
                            mensaje_ventanilla('Campo requerido', 'Hubo un error al descargar')
                            return
                        }
                        if (preview) {
                            this.showPdfInNewTab(response.file, 'vista_previa.pdf')
                            return
                        }
                        var name_file = 'ACTA_ADMISION_' + this.current_manifestacion.folio.replace('/', '_') + '.pdf'
                        var $a = $("<a>");
                        $a.attr("href", 'data:application/pdf;base64,' + response.file);
                        $("body").append($a);
                        $a.attr("download", name_file);
                        $a[0].click();
                        $a.remove();
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
                        texto_acuerdo: null,
                        texto_motivo_improcedencia: null,
                        texto_conciliacion_resolucion: null
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
                pdfWindow.document.write("<html<head><title>" + fileName + "</title><style>body{margin: 0px;}iframe{border-width: 0px;}</style></head>");
                pdfWindow.document.write("<body><embed width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(base64Data) + "#toolbar=0&navpanes=0&scrollbar=0'></embed></body></html>");
            },
            dowloadFile(base64Data, prefixName) {
                var name_file = prefixName + this.current_manifestacion.folio.replace('/', '_') + '.pdf';
                var $a = $("<a>");
                $a.attr("href", 'data:application/pdf;base64,' + base64Data);
                $("body").append($a);
                $a.attr("download", name_file);
                $a[0].click();
                $a.remove();
            }
        }
    }
</script>
