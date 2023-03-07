<?php
namespace App\Services\Geo;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

/**
 * Used to create and measure latitude and longitude points across the app to measure distances from
 * Class GeolocationService
 * @package App\Services\Geo
 */
class GeolocationService{
    /**
     * Takes in a address and returns Latitude and longitude
     *
     * @param $streetAddress
     * @param $city
     * @param $state
     * @param $zip
     * @return object
     */
    public function fullAddress($streetAddress, $city, $state, $zip){
        return $this->toLatLong("${streetAddress}, ${city}, ${state} ${zip}");
    }

    /**
     * Takes in a city state and zip and returns Latitude and longitude
     *
     * @param $city
     * @param $state
     * @param $zip
     * @return object
     */
    public function cityStateZip($city, $state, $zip){
        return $this->toLatLong("${city}, ${state} ${zip}");
    }

    /**
     * Takes in a zip code and returns latitude and longitude
     *
     * @param $zip
     * @return object
     */
    public function zip($zip){
        return $this->toLatLong($zip);
    }

	/**
	 * Query based on a free form address
	 *
	 * @param $location
	 * @return object
	 */
    public function query($location)
	{
		return $this->toLatLong($location);
	}

    /**
     *
     * @param $address
     * @return object
     */
    private function toLatLong($address)
    {
		$slug = str_slug($address);

		$cacheTime = 60 * 24 * 29; // 29 days
		$location = Cache::remember($slug, $cacheTime, function() use ($address) {
			/** @var \GuzzleHttp\Client $client */
			$client = app()->make(Client::class);

			$res = $client->get($this->createUrl($address));
			$response = json_decode($res->getBody());

			if ($res->getStatusCode() !== Response::HTTP_OK && $response->status !== 'OK') {
				throw new Exception('Unable to Geocode Address');
			}

			return (
				isset($response->results[0])
					? $response->results[0]->geometry->location
					: (object) [ 'lat' => 0, 'lng' => 0 ]
			);
		});

        return (
			(object) [
				'lat' => $location->lat,
				'long' => $location->lng,
			]
		);
    }

	/**
	 * Create a url to query google geocoding api
	 *
	 * @param $location
	 * @return string
	 */
    protected function createUrl($location) {
		$address = urlencode($location);

		$url = "https://maps.google.com/maps/api/geocode/json";
		$url .= "?address=".(string)$address;
		$url .= "&sensor=false";
		$url .= "&key=".config("services.googlemaps.api_key");

		return $url;
	}
}

