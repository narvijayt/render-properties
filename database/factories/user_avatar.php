<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\UserAvatar::class, function (Faker\Generator $faker) {
	return [
		'user_id' => null,
		'name' => $faker->uuid.$faker->randomElement(['.jpg', '.png']),
		'original_name' => $faker->word.$faker->randomElement(['.jpg', '.png']),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserAvatar::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\UserAvatar::class, 'with-user', function (Faker\Generator $faker) {
	return [
		'user_id' => function() {
			return factory(App\User::class)->create()->user_id;
		},
	];
});
