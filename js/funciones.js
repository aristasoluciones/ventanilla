head.js("plugins/jquery/jquery.min.js","plugins/bootstrap/js/bootstrap.bundle.min.js",
"plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js","plugins/select2/js/select2.full.min.js",
"plugins/datatables/jquery.dataTables.min.js","plugins/datatables-bs4/js/dataTables.bootstrap4.min.js",
"plugins/datatables-responsive/js/dataTables.responsive.min.js","plugins/datatables-responsive/js/responsive.bootstrap4.min.js",
"plugins/datatables-buttons/js/dataTables.buttons.min.js","plugins/datatables-buttons/js/buttons.bootstrap4.min.js",
"plugins/jszip/jszip.min.js","plugins/pdfmake/pdfmake.min.js","plugins/pdfmake/vfs_fonts.js",
"plugins/datatables-buttons/js/buttons.html5.min.js","plugins/datatables-buttons/js/buttons.print.min.js",
"https://maps.googleapis.com/maps/api/js?key=AIzaSyA2mxFO0scrEjufcAxxBwnoqNFMQmxfM4k&libraries=drawing,visualization,geometry",
"js/scriptsGoogleMaps.js","plugins/jquery-mousewheel/jquery.mousewheel.js","dist/js/adminlte.js",
"plugins/raphael/raphael.min.js","plugins/jquery-mapael/jquery.mapael.min.js","plugins/jquery-mapael/maps/usa_states.min.js",
"plugins/sweetalert2/sweetalert2.min.js",
"plugins/dropzone/dropzone.js",
"plugins/moment/moment.min.js",
"plugins/chart.js/Chart.min.js", "plugins/jquery-validation/jquery.validate.min.js",  "plugins/jquery-validation/localization/messages_es.min.js", function(){
});
var random_hash =  (Math.random() + 1).toString(36).substring(4)
head.js("js/funcion_ventanilla_helper.js", "js/funciones_ventanilla.js?" + random_hash, "js/scriptsGoogleMaps.js")
head.js("plugins/alpinejs/alpine.min.js")