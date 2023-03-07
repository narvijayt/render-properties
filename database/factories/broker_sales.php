<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\BrokerSale::class, function (Faker\Generator $faker) {
	return [
		'broker_id' => null,
		'sales_year' => $faker->numberBetween(2000, 2017),
		'sales_month' => $faker->numberBetween(1, 12),
		'sales_total' => $faker->numberBetween(0, 15),
		'created_at' => $faker->dateTime,
		'updated_at' => $faker->dateTime,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\BrokerSale::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\BrokerSale::class, 'with-broker', function (Faker\Generator $faker) {
	return [
		'broker_id' => function() {
			return factory(App\Broker::class)->create()->broker_id;
		},
	];
});