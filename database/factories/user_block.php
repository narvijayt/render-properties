<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\UserBlock::class, function (Faker\Generator $faker) {
	return [
		'user_id' => null,
		'blocked_user_id' => null,
		'reason' => $faker->sentence,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserBlock::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserBlock::class, 'with-users', function (Faker\Generator $faker) {
	return [
		'user_id' => function() {
			return factory(App\User::class)->create()->user_id;
		},
		'blocked_user_id' => function() {
			return factory(App\User::class)->create()->user_id;
		},
	];
});