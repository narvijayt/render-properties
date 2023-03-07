var map

function initMap () {
	map = new google.maps.Map(document.getElementById('map'), {
		center: window.mapsConfig.center,
		zoom: 8,
		zoomControl: false,
		scaleControl: false,
		mapTypeControl: false,
		streetViewControl: false,
		rotateControl: false,
		fullscreenControl: false
	})

	markers = window.mapsConfig.markers.map(function(marker) {
		return new google.maps.Marker({
			position: marker,
			map: map
		})
	})
}
