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
            current_recurso: {
                etapa_actual_completo: { class:null, nombre: null},
                pila_seguimiento: [],
            },
            id_solicitud: null,
            id_solicitud_recurso: null,
            dropzones_recurso: [],
            totalFiles: 0,
            loading: false,
            archivos: [],
            evidencias: [],

            inicializarRecurso (data) {
                this.current_recurso    = Object.assign( this.current_recurso, { ...data });
                this.pila_seguimiento   = this.helper_ventanilla.isJSON(this.current_recurso.seguimiento)
                    ? JSON.parse(this.current_recurso.seguimiento) : [];

                let current_etapa = this.pila_seguimiento.find((el) => parseInt(el.id) === parseInt(this.current_recurso.etapa));
                if (current_etapa !== null)
                    this.current_recurso.etapa_actual_completo = { ...current_etapa };
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
                    myDropzone.on('queuecomplete', () => this.calcularTotal())
                    myDropzone.on('removedfile', (file) =>{
                        if (file.previewElement != null && file.previewElement.parentNode != null) {
                            file.previewElement.parentNode.removeChild(file.previewElement);
                        }
                        this.calcularTotal();
                        return myDropzone._updateMaxFilesReachedClass();
                    });
                    this.dropzones_recurso.push(myDropzone);
                })
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
                this.setFiles(response);
                mostrar_mensaje('Exito', 'Se ha enviado el recurso de reconsideración.', 'success');
                this.dropzones_recurso.forEach(dropzone => {
                   dropzone.removeAllFiles(true);
                });


            },

            async removeFileRecurso(file) {
                const confirmacion = await Swal.fire({
                    title: '¿Esta seguro de realizar esta accioón?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    denyButtonText: `No`,
                })
                if (confirmacion.isDenied || confirmacion.isDismissed)
                    return

                const path = this.path_site();
                const peticion =  await fetch(path + '/php/ventanilla_eliminar.php', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        opcion: 2,
                        file: file,
                        id: this.id_solicitud_recurso })
                });
                const response = await peticion.json()
                if (response.resp === 0 ) {
                    mostrar_mensaje('Error','Ocurrio un error al eliminar');
                    return;
                }
                this.id_solicitud_recurso = response.data.id_solicitud_recurso ?? null;

                this.id_solicitud_recurso = response.data.hasOwnProperty('id_solicitud_queja_recurso')
                    ? response.data.id_solicitud_queja_recurso
                    : null;
                this.setFiles(response);

                mostrar_mensaje('Exito','Se ha eliminado correctamente', 'success');
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
                this.archivos = !response.data.hasOwnProperty('archivo')
                    ? []
                    : JSON.parse(response.data.archivo);
            }
        }
    }
</script>