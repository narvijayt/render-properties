<?php

$factory->define(\App\MatchRenewal::class, function (Faker\Generator $faker) {
	return [
		'match_id' => null,
		'user_id1' => null,
		'user_id2' => null,
		'accepted_at1' => null,
		'accepted_at2' => null,
		'deleted_at' => null,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\MatchRenewal::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\MatchRenewal::class, 'accepted-1', function (Faker\Generator $faker) {
	return [
		'accepted_at1' => \Carbon\Carbon::now()->subDay(1),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\MatchRenewal::class, 'accepted-2', function (Faker\Generator $faker) {
	return [
		'accepted_at2' => \Carbon\Carbon::now()->subDay(1),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\MatchRenewal::class, 'accepted-both', function (Faker\Generator $faker) {
	return [
		'accepted_at1' => \Carbon\Carbon::now()->subDay(1),
		'accepted_at2' => \Carbon\Carbon::now()->subDay(1),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\MatchRenewal::class, 'with-users', function (Faker\Generator $faker) {
	$match = factory(\App\Match::class)->states('with-users')->create();
	return [
		'match_id' => $match->match_id,
		'user_id1' => $match->user_id1,
		'user_id2' => $match->user_id2,
		'accepted_at1' => \Carbon\Carbon::now()->subday(1),
		'accepted_at2' => null,
		'deleted_at' => null,
	];
});

