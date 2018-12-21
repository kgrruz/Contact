$(document).on("ready",function(){

  var
      vectorSource = new ol.source.Vector(),
      vectorLayer = new ol.layer.Vector({
        source: vectorSource
      });

  var zoom = 5;
  var center = ol.proj.fromLonLat([-43.903, -19.903]);
  var rotation = 0;

      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          }),
          vectorLayer
        ],
        view: new ol.View({
          center: center,
          zoom: zoom,
          rotation: rotation
        })
      });

      navigator.geolocation.getCurrentPosition(function(pos) {
  const coords = ol.proj.fromLonLat([pos.coords.longitude, pos.coords.latitude]);
  map.getView().animate({center: coords, zoom: 15});
});


///GEOCODER

//Instantiate with some options and add the Control

var geocoder = new Geocoder('nominatim', {
  provider: 'photon',
  targetType: 'text-input',
  lang: 'pt-BR',
  placeholder: 'Procurar por...',
  limit: 10,
  keepOpen: true
});

map.addControl(geocoder);

geocoder.on('addresschosen', function (evt) {
  window.setTimeout(function () {

  }, 3000);
});



////END GEOCODER////

      var iconStyle = new ol.style.Style({
          image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
          anchor: [0.5, 46],
          anchorXUnits: 'fraction',
          anchorYUnits: 'pixels',
          opacity: 0.95,
          src: base_url+'images/marker-icon.png?module=contact&assets=assets/images/'
        })),
        text: new ol.style.Text({
        font: '12px Calibri,sans-serif',
        fill: new ol.style.Fill({ color: '#000' }),
        stroke: new ol.style.Stroke({
            color: '#fff', width: 2
        }),
        text: 'Minha localidade'
      })
      });



      function simpleReverseGeocoding(lon, lat) {

       fetch('https://nominatim.openstreetmap.org/reverse?format=json&polygon_geojson=1&lon=' + lon + '&lat=' + lat).then(function(response) {

         return response.json();

       }).then(function(json) {

         document.getElementById('click_address').innerHTML = json.display_name;

         $('#lat').val(lat);
         $('#lng').val(lon);

       });

     }


      function simpleGeocoding(address,city,country,neibor) {

        var query = '';

        if(address){ query += encodeURIComponent(address)+'+'; }
        if(neibor){ query += encodeURIComponent(neibor)+'+'; }

        if(city){ query += encodeURIComponent(city)+'+'; }
        if(country){ query += encodeURIComponent(country)+'+'; }



       fetch('https://nominatim.openstreetmap.org/?format=json&country='+country+'&city='+city).then(function(response) {

         return response.json();

       }).then(function(json) {

           $.each(json, function (key, val) {

          map.getView().animate({ zoom: 15, center: ol.proj.transform([parseFloat(val.lon),parseFloat(val.lat)], 'EPSG:4326','EPSG:3857')});

        });

       });

     }



      simpleGeocoding($('#adress').val(),$('#city').val(),$('#country').val(),$('#neibor').val());


      map.on('click', function(evt){

        var latLong = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
        var lat     = latLong[1];
        var long    = latLong[0];

        var feature = new ol.Feature(
        new ol.geom.Point(evt.coordinate)
      );

      feature.setStyle(iconStyle);
      vectorSource.clear();
      vectorSource.addFeature(feature);

        simpleReverseGeocoding(long, lat);

      });



});
