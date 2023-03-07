<?php

return [
	'maps' => [
		'api_key' => env('GOOGLE_MAPS_API_KEY'),
	],
	'analytics' => [
		'key' => env('GOOGLE_ANALYTICS_KEY', 'UA-XXXXX-X'),
	],
	'tagmanager'=> [
	   'key' => env('GOOGLE_TAG_MANAGER', 'GTM-XXXXXXX'),
	    ]
];
