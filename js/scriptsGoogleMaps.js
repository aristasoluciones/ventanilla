//google.maps.event.addDomListener(window,'load',drawMap);
var marcador;
var marcadorU;
var opcionesMapa = {
    //draggableCursor:"crosshair",
    zoom: 16,
    zoomControl: true,
    mapTypeId:  google.maps.MapTypeId.ROADMAP
}
var mapa;

var markers = [];

function marcador_map(coordenadas){
    let marcadorU;    
    let mapa = new google.maps.Map(document.getElementById('mapa_canvasU'), opcionesMapa);
    marcadorU = new google.maps.Marker({
        map: mapa,
        draggable: false,
        position:coordenadas,
        visible: true
    });
    mapa.setCenter(coordenadas);
            
    /*google.maps.event.addListener(marcador, 'click', function(event){
        marcador_map(event.latLng);                 
        $('#txtLatitud').val(event.latLng.lat());
        $('#txtLongitud').val(event.latLng.lng());
    });*/

     // Create the search box and link it to the UI element.
     //var input = document.getElementById('buscarLugar');
     //var searchBox = new google.maps.places.SearchBox(input);
     //mapa.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
     
     // Bias the SearchBox results towards current map's viewport.
     //mapa.addListener('bounds_changed', function() {
     //   searchBox.setBounds(mapa.getBounds());
     // });

    google.maps.event.addListener(mapa, 'drag', function() {
        var c = mapa.getCenter();
        marcadorU.setPosition(c);
        $('#latitudU').val(c.lat());
        $('#longitudU').val(c.lng());
    });
    
    google.maps.event.addListener(mapa, 'dragend', function() {
        var c = mapa.getCenter();
        marcadorU.setPosition(c);
        $('#latitudU').val(c.lat());
        $('#longitudU').val(c.lng());
    });

    google.maps.event.addListener(mapa, 'idle', function() {
        var c = mapa.getCenter();
        marcadorU.setPosition(c);
        $('#latitudU').val(c.lat());
        $('#longitudU').val(c.lng());
    });
    
    // Aplicamos las restricciones
    //  mapa._restricter = new TRestricter(mapa);
    //map._restricter.zoomLevels(14, 17);
    //(DireccionSur,<),(DireccionNorte,Direccion >)
    //  mapa._restricter.restrict(new google.maps.LatLng(16.693914241546522,-93.24517250061035),new google.maps.LatLng(16.816208207908115,-93.01437377929687));           
}

function marcador_map2(coordenadas){
    
    mapa = new google.maps.Map(document.getElementById('mapa_canvasT'), opcionesMapa);
    marcador = new google.maps.Marker({
        map: mapa,
        draggable: false,
        position:coordenadas,
        visible: true
    });
    mapa.setCenter(coordenadas);
            
    /*google.maps.event.addListener(marcador, 'click', function(event){
        marcador_map(event.latLng);                 
        $('#txtLatitud').val(event.latLng.lat());
        $('#txtLongitud').val(event.latLng.lng());
    });*/

     // Create the search box and link it to the UI element.
     //var input = document.getElementById('buscarLugar');
     //var searchBox = new google.maps.places.SearchBox(input);
     //mapa.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
     
     // Bias the SearchBox results towards current map's viewport.
     //mapa.addListener('bounds_changed', function() {
     //   searchBox.setBounds(mapa.getBounds());
     // });

    google.maps.event.addListener(mapa, 'drag', function() {
        var c = mapa.getCenter();
        marcador.setPosition(c);
        $('#latitudT').val(c.lat());
        $('#longitudT').val(c.lng());
    });
    
    google.maps.event.addListener(mapa, 'dragend', function() {
        var c = mapa.getCenter();
        marcador.setPosition(c);
        $('#latitudT').val(c.lat());
        $('#longitudT').val(c.lng());
    });

    google.maps.event.addListener(mapa, 'idle', function() {
        var c = mapa.getCenter();
        marcador.setPosition(c);
        $('#latitudT').val(c.lat());
        $('#longitudT').val(c.lng());
    });
    
    // Aplicamos las restricciones
    //  mapa._restricter = new TRestricter(mapa);
    //map._restricter.zoomLevels(14, 17);
    //(DireccionSur,<),(DireccionNorte,Direccion >)
    //  mapa._restricter.restrict(new google.maps.LatLng(16.693914241546522,-93.24517250061035),new google.maps.LatLng(16.816208207908115,-93.01437377929687));           
}

function drawMap(){
    navigator.geolocation.getCurrentPosition(function(posicion){
        var geolocalizacion = new google.maps.LatLng(posicion.coords.latitude, posicion.coords.longitude);
      
        marcador_map(geolocalizacion);
        //calcRoute(geolocalizacion,mapa);  
        $('#latitud').val(posicion.coords.latitude);
        $('#longitud').val(posicion.coords.longitude);
        });
}


function drawmapcoords(latitud, longitud){
    var geolocalizacion = new google.maps.LatLng(latitud, longitud);    
    marcador_map(geolocalizacion);
    //calcRoute(geolocalizacion,mapa);
}

function drawmapcoords2(latitud, longitud){
    var geolocalizacion = new google.maps.LatLng(latitud, longitud);    
    marcador_map2(geolocalizacion);
    //calcRoute(geolocalizacion,mapa);
}

function buscar_mapa(estado, municipio=''){
    console.log('llego aquí...');
    var valor_estado    = $('#'+estado+' option:selected').text();
    var valor_municipio = $('#'+municipio+' option:selected').text();
    var address         = valor_municipio + ', ' +valor_estado;
    console.log('Valor del Address => ' + address);
        //alert(address);
    var geoCoder = new google.maps.Geocoder(address);
        var request = {address:address};
        geoCoder.geocode(request, function(result, status){     
            var latlng = new google.maps.LatLng(result[0].geometry.location.lat(), result[0].geometry.location.lng());      
            //var marker = new google.maps.Marker({position:latlng,map:map,title:'title'});
            $('#latitud').val(result[0].geometry.location.lat());
            $('#longitud').val(result[0].geometry.location.lng());  
            marcador_map(latlng);
        })
}

function buscar_mapa2(estado) {
    console.log('llego aquí...');
    var valor_estado = $('#' + estado).val();
    //var valor_municipio = $('#' + municipio + ' option:selected').text();
    var address = valor_estado;
    console.log('Valor del Address => ' + address);
    //alert(address);
    var geoCoder = new google.maps.Geocoder(address);
    var request = {
        address: address
    };
    geoCoder.geocode(request, function (result, status) {
        var latlng = new google.maps.LatLng(result[0].geometry.location.lat(), result[0].geometry.location.lng());
        //var marker = new google.maps.Marker({position:latlng,map:map,title:'title'});
        $('#latitud').val(result[0].geometry.location.lat());
        $('#longitud').val(result[0].geometry.location.lng());
        marcador_map(latlng);
    })
}

function geocodePosition(latitud, longitud, id) {
    var geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(latitud, longitud);  

    geocoder.geocode({
      latLng: latlng
    }, function(responses) {
      if (responses && responses.length > 0) {
        //updateMarkerAddress(responses[0].formatted_address);
        document.getElementById(id).value = responses[0].formatted_address;
      }
    });
  }