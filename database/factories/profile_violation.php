<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\UserProfileViolation::class, function (Faker\Generator $faker) {
	return [
		'reported_by_id' => null,
		'subject_id' => null,
		'report' => $faker->paragraph,
		'resolved' => $faker->boolean(),
		'resolved_by_id' => null,
		'created_at' => $faker->dateTime,
		'updated_at' => $faker->dateTime,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserProfileViolation::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserProfileViolation::class, 'with-users', function (Faker\Generator $faker) {
	return [
		'reported_by_id' => function() {
			return factory(App\User::class)->create()->user_id;
		},
		'subject_id' => function() {
			return factory(App\User::class)->create()->user_id;
		},
		'resolved_by_id' => function() {
			return factory(App\User::class)->create()->user_id;
		},
	];
});