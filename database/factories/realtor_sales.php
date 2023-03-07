<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\RealtorSale::class, function (Faker\Generator $faker) {
	return [
		'realtor_id' => null,
		'sales_year' => $faker->numberBetween(2000, 2017),
		'sales_month' => $faker->numberBetween(1, 12),
		'sales_total' => $faker->numberBetween(0, 15),
		'created_at' => $faker->dateTime,
		'updated_at' => $faker->dateTime,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\RealtorSale::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\RealtorSale::class, 'with-realtor', function (Faker\Generator $faker) {
	return [
		'realtor_id' => function() {
			return factory(App\Realtor::class)->create()->realtor_id;
		},
	];
});