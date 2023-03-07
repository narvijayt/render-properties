<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Message::class, function (Faker\Generator $faker) {
	return [
		'user_id' => null,
		'conversation_id' => null,
		'message_text' => $faker->words(20, true),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Message::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Message::class, 'with-conversation', function (Faker\Generator $faker) {
	$conv = factory(App\Conversation::class)->states('with-user')->create();
	return [
		'user_id' => $conv->user_id,
		'conversation_id' => $conv->conversation_id
	];
});
