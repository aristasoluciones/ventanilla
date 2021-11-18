// Inicio de sesion
var cargandoInicio = "<img src='dist/img/propios/cargando.gif' width='100%'/>";
var cargandoInicioPag = "<img src='../dist/img/propios/cargando.gif' width='100%'/>";
var urlSubir = "php/subir.php";
var urlSubirPag = "../php/subir.php";
var urlConsultas = "php/consultas.php";
var urlInicioS = "php/inicio_sesion.php";
Dropzone.autoDiscover = false

$("#formInicio").submit(function(event){
    event.preventDefault();
    var urlPag = 'php/inicio_sesion.php';
	var formData = new FormData($(this)[0]);
    $.ajax({
        beforeSend: function(){
            $("#cargaInicio").html(cargandoInicio);            
        },
        data: formData,
        type:    "post",
        url:     urlPag,
        dataType: 'json',        
        processData : false,
        contentType : false,
        cache       : false,
        success: function(data){
            $("#cargaInicio").empty();
            switch(data.resp){
                case 1:
                    location.href = "inicio";
                break;
                case 2:
                    $(this).Toasts('create', {
                        title: 'Error de Acceso',
                        subtitle: 'Error',
                        body: 'Datos de acceso no encontrado.',
                        icon: 'fas fa-exclamation-triangle',
                        autoremove: true,
                        delay: 4000,
                        close: false,
                        autohide: true,
                        class : 'bg-danger'
                    });
                break;
                case 3:
                    $(this).Toasts('create', {
                        title: 'Error de Acceso',
                        subtitle: 'Error',
                        body: 'Contraseña Incorrecta.',
                        icon: 'fas fa-exclamation-triangle',
                        autoremove: true,
                        delay: 4000,
                        close: false,
                        autohide: true,
                        class : 'bg-danger'
                    });
                break;
            }
        }
    });
});

$("#formRegistro").submit(function(e){
    e.preventDefault();    
    if($("#txtPass").val() !== $("#txtPassR").val()){
        $(this).Toasts('create', {
            title: 'Vuelva a Intentarlo',
            subtitle: 'Error',
            body: 'Las Contraseñas no coinciden.',
            icon: 'fas fa-exclamation-triangle',
            autoremove: true,
            delay: 4000,
            close: false,
            autohide: true,
            class : 'bg-danger'
        });
        return;
    }
    if(!$('#agreeTerms').is(":checked")){
        $(this).Toasts('create', {
            title: 'Vuelva a Intentarlo',
            body: 'Debe de aceptar los terminos de uso.',
            icon: 'fas fa-exclamation-triangle',
            autoremove: true,
            delay: 4000,
            close: false,
            autohide: true,
            class : 'bg-info'
        });
        return;
    }
    var formData = new FormData($(this)[0]);
    formData.append('opcion',1);    
    $.ajax({
        beforeSend: function(){
            $("#cargaInicio").html(cargandoInicio);
        },
        data: formData,
        type:    "post",
        url:     urlSubir,
        dataType: 'json',        
        processData : false,
        contentType : false,
        cache       : false,
        success: function(data){
            $("#cargaInicio").empty();
            switch(data.resp){
                case 0:
                    $(this).Toasts('create', {
                        title: 'Vuelva a Intentarlo',
                        body: 'Ocurrio un error al intentar registrarse.',
                        icon: 'fas fa-exclamation-triangle',
                        autoremove: true,
                        delay: 4000,
                        close: false,
                        autohide: true,
                        class : 'bg-danger'
                    });
                    return; 
                break;
                case 1:
                    //$('#formRegistro')[0].reset();
                    $('#textoCorreo').html(formData.get('txtEmail'));
                    $('#modal-default').modal('show');
                break;
                case 2:
                    $(this).Toasts('create', {
                        title: 'Vuelva a Intentarlo',
                        body: 'El correo ya esta registrado en nuestra base de datos.',
                        icon: 'fas fa-exclamation-triangle',
                        autoremove: true,
                        delay: 4000,
                        close: false,
                        autohide: true,
                        class : 'bg-info'
                    });
                    return; 
                break;
            }            
        }
    }); 
});

$('#btnTerminaR').on('click',function(e){
    e.preventDefault();
    let formData = new FormData();
    formData.append('id_usuario',$('#hiddenUsuario').val());
    formData.append('identificador',$('#hiddenIden').val());
    formData.append('opcion',2);
    $.ajax({
        beforeSend: function(){
            $("#cargaInicio").html(cargandoInicioPag);
        },
        data: formData,
        type:    "post",
        url:     urlSubirPag,
        dataType: 'json',        
        processData : false,
        contentType : false,
        cache       : false,
        success: function(data){
            $("#cargaInicio").empty();
            switch(data.resp){
                case 0:
                    $(this).Toasts('create', {
                        title: 'Vuelva a Intentarlo',
                        body: 'Ocurrio un error al intentar registrarse.',
                        icon: 'fas fa-exclamation-triangle',
                        autoremove: true,
                        delay: 4000,
                        close: false,
                        autohide: true,
                        class : 'bg-danger'
                    });
                    return; 
                break;
                case 1:
                    location.href = "../inicio";
                break;
                case 2:
                    $(this).Toasts('create', {
                        title: 'Datos ya usados',
                        body: 'Los datos de activación ya fueron usados.',
                        icon: 'fas fa-exclamation-triangle',
                        autoremove: true,
                        delay: 4000,
                        close: false,
                        autohide: true,
                        class : 'bg-info'
                    });
                    return; 
                break;
            }            
        }
    });
});
$('#btnAceptarRegistro').on('click',function(e){
    location.href = "http://institutodebomberos.chiapas.gob.mx/";
});

document.addEventListener('DOMContentLoaded', function () {

    $(document).on('click', '#anonima', function () {
        $('.field-anomima').toggle($('#anonima').is(':checked') ? 1 : 0)
    })
    var dropzone_item = document.querySelectorAll('.dropzone')
    if (typeof dropzone_item !== undefined && dropzone_item !== null) {
        dropzone_item.forEach(function (elem) {
            new Dropzone(elem, {
                url:urlSubir,
            })
        })
    }

    var stepper = document.querySelector('.form-wizard')
    if (typeof stepper !== undefined && stepper  !== null) {
        $form = $(stepper).find('form')
        $form.each(function () {
            var $this = $(this)
            var flag_anonima = () => !$('#anonima').is(':checked')
            $this.validate({
                errorElement: 'span',
                errorClass: 'text-danger text-inline',
                rules: {
                    tipo_tramite: {
                        required: true,
                    },
                    nacionalidad: {
                        required: flag_anonima,
                    },
                    nombre: {
                       required: flag_anonima,
                    },
                    apellidos: {
                       required: flag_anonima,
                    },
                    sexo: {
                       required: flag_anonima,
                    },
                    telefono: {
                        required:flag_anonima,
                    },
                    fecha_nacimiento: {
                        required: flag_anonima,
                    },
                    correo: {
                        required: flag_anonima,
                    },
                    confirmar_correo: {
                        required: flag_anonima,
                    },
                    pais: {
                        required: flag_anonima,
                    },
                    codigo_postal: {
                        required: flag_anonima,
                    },
                    estado: {
                        required: flag_anonima,
                    },
                    municipio: {
                        required: flag_anonima,
                    },
                    calle: {
                        required: flag_anonima,
                    },
                    manejo_dato: {
                        required: true,
                    },
                    aviso_privacidad: {
                        required: true,
                    }
                }
            })
        })
        var wizardStepper = new Stepper(stepper, {
            linear: false,
        })
        $(stepper)
            .find('.btn-next')
            .on('click', function (e) {
                var isValid = $(this).parents('form:first').valid()
                if(isValid)
                    wizardStepper.next()
                else
                    e.preventDefault()
            })
        $(stepper)
            .find('.btn-prev')
            .on('click', function () {
                wizardStepper.previous()
            })

        $(stepper)
            .find('.btn-submit')
            .on('click', function () {
                alert('Submitted..!!')
            })
    }
})



/************ FIN INICIO DE SESION ***************/
