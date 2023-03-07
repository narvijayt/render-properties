<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Conversation::class, function (Faker\Generator $faker) {
	return [
		'user_id' => null,
		'conversation_title' => $faker->sentence(8, true),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Conversation::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Conversation::class, 'with-user', function (Faker\Generator $faker) {
	return [
		'user_id' => function() {
			return factory(App\User::class)->create()->user_id;
		},
	];
});
