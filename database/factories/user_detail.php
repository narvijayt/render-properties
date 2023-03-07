<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\UserDetail::class, function (Faker\Generator $faker) {
	return [
		'user_id' => null,
		'register' => $faker->dateTime,
		'verify' => $faker->dateTime,
		'lock' => null,
		'dob' => $faker->date('Y-m-d'),
		'city' => $faker->city,
		'bio' => $faker->sentences(10, true),
		'state' => $faker->stateAbbr,
		'zip' => $faker->postcode,
		'created_at' => $faker->dateTime,
		'updated_at' => $faker->dateTime,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserDetail::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserDetail::class, 'with-user', function (Faker\Generator $faker) {
	return [
		'user_id' => function() {
			return factory(App\User::class)->create()->user_id;
		},
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserDetail::class, 'verified', function (Faker\Generator $faker) {
	return [
		'verify' => $faker->dateTime,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserDetail::class, 'unverified', function (Faker\Generator $faker) {
	return [
		'verify' => null,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserDetail::class, 'locked', function (Faker\Generator $faker) {
	return [
		'lock' => $faker->dateTime,
	];
});