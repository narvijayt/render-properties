<div id="map" style="height: 200px;"></div>
@push('scripts-footer')
    <script>
        window.mapsConfig = {
        	center: {
        		lat: {{ $markers[0]['lat'] }},
                lng: {{ $markers[0]['lng'] }}
            },
        	markers: [
                    @foreach($markers as $marker)
		        { lat: {{ $marker['lat'] }}, lng: {{ $marker['lng'] }} }
                @endforeach
	        ]
        }
    </script>
     <script src="{{asset('js/page-scripts/user/google-maps.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('google.maps.api_key') }}&callback=initMap" async defer></script>
   
@endpush