<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Realtor::class, function (Faker\Generator $faker) {
	return [
		'user_id' => null,
		'career_start' => $faker->dateTime,
		'years_exp' => $faker->numberBetween(1, 15),
		'active' => $faker->randomElement([true,false]),
		'created_at' => $faker->dateTime,
		'updated_at' => $faker->dateTime,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Realtor::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Realtor::class, 'with-user', function (Faker\Generator $faker) {
	return [
		'user_id' => function() {
			return factory(App\User::class)->create()->user_id;
		},
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Realtor::class, 'active', function (Faker\Generator $faker) {
	return [
		'active' => true,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Realtor::class, 'inactive', function (Faker\Generator $faker) {
	return [
		'active' => false,
	];
});