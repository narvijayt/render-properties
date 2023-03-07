<?php
$defaultImg = ['/house_pictures/rbc-profile-house-1.png',
                         '/house_pictures/rbc-profile-house-2.png',
	                     '/house_pictures/rbc-profile-house-3.png',
                         '/house_pictures/rbc-profile-houses-4.png',
                         '/house_pictures/rbc-profile-houses-5.png',
                         '/house_pictures/rbc-profile-houses-6.png',
                         '/house_pictures/rbc-profile-houses-7.png',
                         '/house_pictures/rbc-profile-houses-8.png',
                         '/house_pictures/rbc-profile-houses-9.png',
                         '/house_pictures/rbc-profile-houses-10.png'];
                         
return [
	//'user_avatar_placeholder_path'	=> '/img/default-avatar.png',
	'user_avatar_placeholder_path'	=> '/img/default-avatar.png',
	'user_avatar_avatar' => $defaultImg,
	'user_avatar_path' 				=> 'uploads/user-avatars',
	'paths' => [
		'profile-pictures' => 'profile-pictures/',
	],
	'user_avatar_disk'				=> env('PROFILE_PHOTO_STORAGE_DISK', 'public'),
	'default_extension' => 'png',
	'thumbnail_sizes' => [
		'large' => [
			'width' => 1000,
			'height' => 1000,
		],
		'medium' => [
			'width' => 500,
			'height' => 500,
		],
		'small' => [
			'width' => 250,
			'height' => 250,
		],
		'x-small' => [
			'width' => 100,
			'height' => 100,
		],
	]
];
