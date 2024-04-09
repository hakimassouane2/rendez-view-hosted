(function($){
    "use strict";
      $.fn.ovaevent_map = function( paramObject ){

          if( typeof google == 'undefined' ) return false;

          if( typeof google_map == 'undefined' || google_map ==  false ) return false;

         paramObject = $.extend( { lat: -33.8688, lng: 151.2195, zoom: 17 }, paramObject );


          if( isNaN(paramObject.lat) ){
            paramObject.lat = -33.8688;
          }
            
         
          if( isNaN(paramObject.lng) ){
            paramObject.lng = 151.2195;
          }

          var map_canvas = this[0].id;
         
          var map = new google.maps.Map(document.getElementById(map_canvas), {
            center: {
              lat: paramObject.lat,
              lng: paramObject.lng
            },
            zoom: paramObject.zoom,
            scrollwheel: true,
            draggable: true,
          });




          var input = document.getElementById('pac-input');

          var autocomplete = new google.maps.places.Autocomplete(input);
          autocomplete.bindTo('bounds', map);

          map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

          var infowindow = new google.maps.InfoWindow();
          var infowindowContent = document.getElementById('infowindow-content');
          infowindow.setContent(infowindowContent);
          var marker = new google.maps.Marker({
            map: map,
            position: map.getCenter()
          });
          marker.addListener('click', function() {
            infowindow.open(map, marker);
          });




          autocomplete.addListener('place_changed', function() {
            infowindow.close();
            var place = autocomplete.getPlace();
            if (!place.geometry) {
              return;
            }

            if (place.geometry.viewport) {
              map.fitBounds(place.geometry.viewport);
            } else {
              map.setCenter(place.geometry.location);
              map.setZoom(17);
            }

            // Set the position of the marker using the place ID and location.
            marker.setPlace({
              placeId: place.place_id,
              location: place.geometry.location
            });
            marker.setVisible(true);

            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = place.formatted_address;

            $(".ovaevent_map #map_name").val(place.name);
            $(".ovaevent_map #map_address").val(place.formatted_address);

            var location_map = String(place.geometry.location);
            var lacation_input = location_map.replace("(","").replace(")","").replace(" ", "").split(",");

            $(".ovaevent_map #map_lat").val(lacation_input[0]);
            $(".ovaevent_map #map_lng").val(lacation_input[1]);

            infowindow.open(map, marker);

            
          });


      }
      
})(jQuery);