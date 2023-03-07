
<?php
$factory->define(\App\Match::class, function (Faker\Generator $faker) {
	return [
		'user_id1' => null,
		'user_type1' => null,
		'user_id2' => null,
		'user_type2' => null,
		'accepted_at1' => null,
		'accepted_at2' => null,
		'deleted_at' => null,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\Match::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\Match::class, 'accepted-1', function (Faker\Generator $faker) {
	return [
		'accepted_at1' => \Carbon\Carbon::now()->subDay(1),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\Match::class, 'accepted-2', function (Faker\Generator $faker) {
	return [
		'accepted_at2' => \Carbon\Carbon::now()->subDay(1),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\Match::class, 'accepted-both', function (Faker\Generator $faker) {
	return [
		'accepted_at1' => \Carbon\Carbon::now()->subDay(1),
		'accepted_at2' => \Carbon\Carbon::now()->subDay(1),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\Match::class, 'deleted', function (Faker\Generator $faker) {
	return [
		'accepted_at1' => \Carbon\Carbon::now()->subDay(1),
		'accepted_at2' => \Carbon\Carbon::now()->subDay(1),
		'deleted_at' => \Carbon\Carbon::now()->subDay(1),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\Match::class, 'with-users', function (Faker\Generator $faker) {
	$realtor = factory(\App\User::class)->states('type-realtor')->create();
	$broker = factory(\App\User::class)->states('type-broker')->create();
	return [
		'user_id1' => $broker->user_id,
		'user_type1' => $broker->user_type,
		'user_id2' => $realtor->user_id,
		'user_type2' => $realtor->user_type,
		'accepted_at1' => \Carbon\Carbon::now()->subDay(1),
		'accepted_at2' => \Carbon\Carbon::now()->subDay(1),
		'deleted_at' => null,
	];
});

