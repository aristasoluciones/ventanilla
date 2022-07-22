<?php
require_once("../php/inicializandoDatosExterno.php");
$row = [];
if ($_POST['id'] > 0) {
    $id = $funciones->limpia($_POST['id']);
}
$configs = $conexion->obtenerlista($querys->getConfiguracionWeb(4));
$configs = !is_array($configs) ? [] : $configs;
$config = [];
foreach($configs as $conf) {
    $conf->valor =  strip_tags($conf->valor);
    $config[$conf->campo] = $conf;
}
$path_instruccion = isset($config['instruccion_pprr'])
    ? $funciones->webRootFile().$config['instruccion_pprr']->archivo
    : '';
?>
<div class="modal-header">
    <h4 class="modal-title">Presentar Recurso de Reconsideración</b></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <?php include('formulario/form_recurso_reconsideracion.php'); ?>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
</div>

<script>
    function componenteRecursoRec () {
        return  {
            path_site: function () {
                switch (document.location.hostname) {
                    case 'turismo.test':
                    case 'ventanilla.test':
                    case 'turista.plataformasecturchiapas.mx':
                    case 'prestadores.plataformasecturchiapas.com':
                    case 'prestadores.plataformasecturchiapas.mx': return ''
                    default : return '/turismo'
                }
            },
            path_file: function () {
                switch (document.location.hostname) {
                    case 'ventanilla.test': return 'http://turismo.test'
                    case 'turismo.test': return ''
                    case 'turista.plataformasecturchiapas.mx':
                    case 'prestadores.plataformasecturchiapas.com':
                    case 'prestadores.plataformasecturchiapas.mx': return 'https://plataformasecturchiapas.mx/turismo'
                    default : return '/turismo'
                }
            },
            helper_ventanilla: null,
            resolver_prevencion: null,
            id_solicitud: null,
            parent_id: null,
            id_solicitud_recurso: null,
            pila_seguimiento: [],
            current_recurso: {
                etapa_actual_completo: { class:null, nombre: null}
            },
            dropzones_recurso: [],
            totalFiles: 0,
            loading: false,
            archivos: [],
            evidencias: [],
            escritos: [],

            inicializarRecurso (data) {
                this.current_recurso    = Object.assign( this.current_recurso, { ...data });
                this.pila_seguimiento   = this.helper_ventanilla.isJSON(this.current_recurso.seguimiento)
                    ? JSON.parse(this.current_recurso.seguimiento) : [];

                let current_etapa = this.pila_seguimiento.find((el) => parseInt(el.id) === parseInt(this.current_recurso.etapa));
                if (current_etapa !== null) {
                    this.current_recurso.etapa_actual_completo = {...current_etapa};
                    if (parseInt(this.current_recurso.etapa_actual_completo.id) === 2 && this.current_recurso.etapa_actual_completo.subsanado) {
                        this.current_recurso.etapa_actual_completo.class = 'bg-info';
                        this.current_recurso.etapa_actual_completo.nombre = 'En Prevención(Subsanado)';
                    }
                }
            },

            async iniciar (id) {
                this.id_solicitud = id;
                // es un solo RR que se puede presentar.
                var path = this.path_site();
                const peticion = await fetch(path + '/php/ventanilla_consulta.php',
                {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({opcion: 8, id: id})
                });

                const response = await peticion.json()
                if (response.data !== null) {
                    this.id_solicitud_recurso = response.data.id_solicitud_queja_recurso;
                    this.parent_id = response.data.id_solicitud_queja_recurso;
                    this.inicializarRecurso(response.data);
                    this.setFiles(response);
                }
            },

            init () {
                Dropzone.autoDiscover = false;
                let parent_zone =  document.querySelector('#zone-file-recurso');
                let dropzones_recurso =  parent_zone.querySelectorAll('.dropzone-recurso');
                dropzones_recurso.forEach((item, index) => {
                    const previewNode = item.querySelector("#template-" + (index + 1));
                    //previewNode.id = ''
                    const previewsContainer = item.querySelector('#previews');
                    const elementClickable = item.querySelector('.fileinput-button');
                    const previewTemplate = previewNode.parentNode.innerHTML;
                    previewNode.parentNode.removeChild(previewNode);
                    const myDropzone = new Dropzone(item, {
                        url: window.location.pathname, // Set the url
                        thumbnailWidth: 80,
                        thumbnailHeight: 80,
                        parallelUploads: 20,
                        previewTemplate: previewTemplate,
                        chunking: true,
                        paramName:item.id,
                        retryChunks: true,
                        parallelChunkUploads: true,
                        previewsContainer: previewsContainer, // Define the container to display the previews
                        clickable: elementClickable, // Define the element that should be used as click trigger to select files.
                    });
                    myDropzone.on('queuecomplete', () => this.calcularTotal());
                    myDropzone.on('removedfile', (file) =>{
                        if (file.previewElement != null && file.previewElement.parentNode != null) {
                            file.previewElement.parentNode.removeChild(file.previewElement);
                        }
                        this.calcularTotal();
                        return myDropzone._updateMaxFilesReachedClass();
                    });
                    this.dropzones_recurso.push(myDropzone);
                });
                this.helper_ventanilla = new  helperVentanilla();
            },

            async enviarRecurso () {
                var formData = new FormData();
                this.dropzones_recurso.forEach(dropzone => {
                    let  { paramName }  = dropzone.options;
                    dropzone.files.forEach((file) => {
                        formData.append(paramName + '[]', file)
                    })
                });
                formData.append('opcion', 3);
                formData.append('id_solicitud', this.id_solicitud);

                if (this.id_solicitud_recurso !== null && this.id_solicitud_recurso > 0)
                    formData.append('id', this.id_solicitud_recurso);

                const path = this.path_site();
                this.loading = true;
                const peticion =  await fetch(path + '/php/ventanilla_subir.php', {
                    method: 'post',
                    body:formData,
                });
                const response = await peticion.json();
                this.loading = false;

                if (response.resp === 0) {
                    mostrar_mensaje('Error', 'Ocurrio un error al guardar, intente nuevamente.');
                    return;
                }
                this.id_solicitud_recurso = response.data.id_solicitud_queja_recurso;
                this.inicializarRecurso(response.data);
                this.setFiles(response);
                mostrar_mensaje('Exito', 'Se ha enviado el recurso de reconsideración.', 'success');
                this.dropzones_recurso.forEach(dropzone => {
                   dropzone.removeAllFiles(true);
                });

            },

            calcularTotal () {
                let total = 0;
                this.dropzones_recurso.forEach(dropzone => {
                    dropzone.files.forEach(() => {
                        total +=1;
                    })
                });
                this.totalFiles = total;
            },

            setFiles (response) {
                this.evidencias = !response.data.hasOwnProperty('evidencia')
                    ? []
                    : JSON.parse(response.data.evidencia);
                this.escritos = !response.data.hasOwnProperty('archivo')
                    ? []
                    : JSON.parse(response.data.archivo);
            },

            prevencionVigente () {
                let flag = false
                if ([2].includes(parseInt(this.current_recurso.etapa))) {
                    console.log(this.pila_seguimiento);
                    let seguimiento_corriente = this.pila_seguimiento.find((item) => parseInt(item.id) === 2)
                    let fecha_corriente   =  moment().format('YYYY-MM-DD')
                    let fecha_vencimiento  = moment(seguimiento_corriente.fecha).add(3, 'days').format('YYYY-MM-DD')
                    flag = fecha_vencimiento >= fecha_corriente && !seguimiento_corriente.subsanado
                }
                return flag
            },

            enPrevencion() {
                return [2].includes(parseInt(this.current_recurso.etapa));
            },

            listadoActas () {
                let actas_disponibles = [];
                this.pila_seguimiento.forEach((item) => {
                    if (item.actas !== null) {
                        item.actas.forEach((item2) =>{
                            switch (parseInt(item2.tipo)) {
                                case 1:
                                    item2.title = 'Acuerdo de admisión';
                                    if (parseInt(item.id) === 3)
                                        item2.title = 'Auto de resolución';
                                    break;
                                case 2: item2.title = 'Auto de desechamiento'; break;
                                case 3: item2.title = 'Auto de prevención'; break;
                            }
                            actas_disponibles.push(item2);
                        })
                    }
                });
                this.archivos = actas_disponibles;
                return actas_disponibles;
            },
        }
    }
</script>