       var map;
        function initMap() {
          var mapLayer = document.getElementById("map-layer");
          var centerCoordinates = new google.maps.LatLng(37.6, -95.665);
          var defaultOptions = { center: centerCoordinates, zoom: 4 }
          map = new google.maps.Map(mapLayer, defaultOptions);
        }
        function locate(){
          if ("geolocation" in navigator){
            navigator.geolocation.getCurrentPosition(function(position){ 
              var currentLatitude = position.coords.latitude;
              var currentLongitude = position.coords.longitude;
              var infoWindowHTML = "Latitude: " + currentLatitude + "<br>Longitude: " + currentLongitude;
              alert(currentLatitude);
              
              
              
              var infoWindow = new google.maps.InfoWindow({map: map, content: infoWindowHTML});
              var currentLocation = { lat: currentLatitude, lng: currentLongitude };
              infoWindow.setPosition(currentLocation);
             
            });
          }
        }
       