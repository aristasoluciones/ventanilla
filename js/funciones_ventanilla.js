var url_hostame = document.location.hostname
var web_root = url_hostame !=='ventanilla.test'
    ? 'https://' + url_hostame
    : 'http://'+ url_hostame
let url_subir     = web_root + '/php/ventanilla_subir.php';
let url_consulta  = web_root + '/php/ventanilla_consulta.php';
let url_eliminar  = web_root + '/php/ventanilla_eliminar.php';
let url_imprimir  = web_root + '/php/ventanilla_imprimir.php';
let cargar = "<div class='tab-loading'><div><center><h2 class='display-4'>Cargando Información <i class='fa fa-sync fa-spin'></i></h2></center></div></div>";
let guardar = "<div class='tab-loading'><div><center><h2 class='display-4'>Guardando Información <i class='fa fa-sync fa-spin'></i></h2></center></div></div>";
let actualizar = "<div class='tab-loading'><div><center><h2 class='display-4'>actualizando Información <i class='fa fa-sync fa-spin'></i></h2></center></div></div>";
let overlay = '<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>';
let dataTable_m;
let id_m;
let opcion_m;
let modalOk = 0;
let modalCatOk = 0;

function cargarMenu(pagina){
    $('#ContenidoGeneral .card').append(overlayTemplate);
    location.href= pagina
}
function logout() {
   $.post( web_root + '/php/logout.php')
    location.href = 'inicio'
}

function guardar_seguimiento () {
    var form = $(this).parents('form:first')
    var formData = new FormData(form[0])

    form.validate({
        errorElement: 'span',
        errorClass: 'text-danger',
        errorPlacement: function(error, element) {
            var parent_element =  element.parent(':first')
            if(element.attr("type") === "checkbox")
                error.insertAfter(parent_element)
            else
                error.insertAfter(element)
        },
        rules: {
            comentario: {
                required: true,
            },
        }
    })
    var isValid =  form.valid()
    if(!isValid)
        return

    $.ajax({
        url: url_subir,
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            $('#loading-send').removeClass('d-none')
            $('#btn-guardar-seguimiento').addClass('d-none')
        }
    }).done(function (data) {
        mostrar_mensaje(data.resp === 1 ? 'Exito' : 'Error',
            data.resp === 1 ? 'Datos actualizados' : 'Ocurrio un error al intentar actualizar la información',
            data.resp === 1 ? 'success' : 'danger')
        if(data.resp === 1) {
            window.location.reload()
        } else {
            $('#loading-send').addClass('d-none')
            $('#btn-guardar-seguimiento').removeClass('d-none')
        }
    })
}

function cargar_listado_manifestacion (pagina, tipo, estatus= 0) {
    $.ajax({
        beforeSend: function() {
            $("#content-lista").html(cargar)
        },
        type:    "post",
        url:      web_root + '/pg/lista/lista_manifestacion.php',
        data:    { tipo, pagina, estatus },
        success: function(data){
            console.log(data)
            $("#content-lista").html(data)
        }
    })
}

function open_modal_seguimiento (id) {
    if(id === 0) {
        $('#modal-default').modal('hide')
        return;
    }

    url    = web_root + '/pg/modal_seguimiento.php'
    $('div.modal-dialog').css({'max-width':'60%'})
    params = {'id':id}
    $.ajax({
        beforeSend: function() {
            $("#modal-content-default").trigger('create')
            $('#modal-default').modal('show')
            $("#modal-content-default").html(overlay)
        },
        type:    "post",
        url:     url,
        data:    params,
        success: function(data) {
            $("#modal-content-default").html(data)
        }
    })
}
function close_modal() {
    $("#modal-content-default").html()
    $('#modal-default').modal('hide')

}
function mostrar_mensaje(titulo, mensaje, color='danger'){
    $(this).Toasts('create', {
        title: titulo,
        body: mensaje,
        icon: 'fas fa-exclamation-triangle',
        autoremove: true,
        delay: 4000,
        close: false,
        autohide: true,
        class : 'bg-'+color
    });
}

$(document).on('click', '#btn-logout', logout);
$(document).on('click', '#btn-guardar-seguimiento', guardar_seguimiento);