<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
	static $password;
	static $cityziplatlongs = [
	    ["New York City", "NY", 10001, 40.8282129, -73.9321059],
        ["San Francisco", "CA", 94016, 37.71, -122.45],
        ["Charlotte", "NC", 28214, 35.2833293, -80.9760556],
        ["Miami", "FL", 33137, 25.8207159, -80.19653],
        ["Seattle", "WA", 98119, 47.6384586, -122.3674079]
    ];
	$current = $cityziplatlongs[rand(0,4)];
	return [
		'username' 			=> $faker->userName,
		'email' 			=> $faker->unique()->safeEmail,
		'password' 			=> $password ?: $password = bcrypt('secret'),
		'remember_token' 	=> str_random(10),
		'active' 			=> true,
		'first_name' 		=> $faker->firstName,
		'last_name' 		=> $faker->lastName,
		'user_avatar_id' 	=> null,
		'user_type' 		=> null,
		'city' 				=> $current[0],
		'state' 			=> $current[1],
		'zip' 				=> $current[2],
		'register_ts' 		=> $faker->dateTime,
		'verify_ts' 		=> $faker->dateTime,
		'lock_ts' 			=> null,
		'bio' 				=> $faker->sentences(10, true),
		'prof_license' 		=> null,
		'firm_name' 		=> null,
		'years_of_exp' 		=> rand(1,45),
        'latitude'          => $current[3],
        'longitude'         => $current[4],
		'monthly_sales'		=> $faker->numberBetween(1, 30),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\User::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\User::class, 'active', function (Faker\Generator $faker) {
	return [
		'active' => true,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\User::class, 'inactive', function (Faker\Generator $faker) {
	return [
		'active' => false,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\User::class, 'type-realtor', function (Faker\Generator $faker) {
	return [
		'user_type' => App\Enums\UserAccountType::REALTOR,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\User::class, 'type-broker', function (Faker\Generator $faker) {
	return [
		'user_type' => App\Enums\UserAccountType::BROKER,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\User::class, 'type-random', function (Faker\Generator $faker) {
	return (mt_rand(0, 1)) ? [
		'user_type' => App\Enums\UserAccountType::REALTOR,
	] : [
		'user_type' => App\Enums\UserAccountType::BROKER,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserDetail::class, 'verified', function (Faker\Generator $faker) {
	return [
		'verify_ts' => $faker->dateTime,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserDetail::class, 'unverified', function (Faker\Generator $faker) {
	return [
		'verify_ts' => null,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserDetail::class, 'locked', function (Faker\Generator $faker) {
	return [
		'lock_ts' => $faker->dateTime,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserDetail::class, 'unlocked', function (Faker\Generator $faker) {
	return [
		'lock_ts' => null,
	];
});
