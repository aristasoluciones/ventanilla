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

/************ FIN INICIO DE SESION ***************/
