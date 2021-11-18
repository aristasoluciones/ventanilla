let url_subir     = 'php/ventanilla_subir.php';
let url_consulta  = 'php/ventanilla_consulta.php';
let url_eliminar  = 'php/ventanilla_eliminar.php';
let url_imprimir  = 'php/ventanilla_imprimir.php';
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
   $.post('../php/logout.php')
    location.href = ''
}
function ventanilla_administrar_registro(id = 0){
    $.ajax({
        beforeSend: function(){
            $('#card_denuncia').append(overlayTemplate);
        },
        url: 'pg/ventanilla/denuncia_registro.php',
        type: "post",
        dataType: "html",
        data: {'id':id},
        success: function(resp){
            $('#card_denuncia').find('.overlay').remove();
            $("#ContenidoGeneral").html(resp);
        }
    });
}

function administrar_listado(tipo) {
    var options = {
        searching: true,
        processing: true,
        destroy: true,
        language: {
            url: '../plugins/datatables/i18n/es-mx.json'
        },
        ajax: {
            type:'post',
            url: '../php/ventanilla_consulta.php',
            data: { opcion: 1, tipo },
            dataType:'json',
            dataSrc : function (response) {
                return 'data' in response ? response.data : []
            }
        },
    }
    $('#listado').DataTable(options);
}

function open_modal_seguimiento (id) {
    if(id === 0) {
        $('#modal-default').modal('hide')
        return;
    }

    url    = '/pg/modal_seguimiento.php'
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

function limpiaForm(id){
   $('#card_denuncia_accion').append(overlayTemplate);
    ventanilla_administrar_registro(0);
}
function close_modal() {
    $("#modal-content-default").html()
    $('#modal-default').modal('hide')

}

$(document).on('click', '#btn-logout', logout);