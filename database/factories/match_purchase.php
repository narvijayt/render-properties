
<?php
$factory->define(\App\MatchPurchase::class, function (Faker\Generator $faker) {
	return [
		'user_id' => null,
		'type' => \App\Enums\MatchPurchaseType::COMPLIMENTARY,
		'quantity' => 1,
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\MatchPurchase::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\MatchPurchase::class, 'complimentary', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\App\MatchPurchase::class, 'purchased', function (Faker\Generator $faker) {
	return [
		'type' => \App\Enums\MatchPurchaseType::PURCHASED,
	];
});
