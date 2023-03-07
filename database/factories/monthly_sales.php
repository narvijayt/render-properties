<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\MonthlySale::class, function (Faker\Generator $faker) {
	return [
		'user_id' => null,
		'sales_year' => $faker->numberBetween(2000, 2017),
		'sales_month' => $faker->numberBetween(1, 12),
		'sales_total' => $faker->numberBetween(0, 15),
		'sales_value' => $faker->numberBetween(1000, 1000000) * 1.0,
		'created_at' => $faker->dateTime,
		'updated_at' => $faker->dateTime,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\MonthlySale::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\MonthlySale::class, 'with-user', function (Faker\Generator $faker) {
	return [
		'user_id' => function() {
			return factory(App\User::class)->create()->user_id;
		},
	];
});
