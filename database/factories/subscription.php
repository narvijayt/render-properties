
<?php
$factory->define(\Laravel\Cashier\Subscription::class, function (Faker\Generator $faker) {
	return [
		'user_id' => null,
		'name' => 'main',
		'braintree_id' => '7df72f',
		'braintree_plan' => 'df8sf3',
		'quantity' => 1,
		'ends_at' => null,
		'created_at' => \Carbon\Carbon::now()->subDay(1),
		'updated_at' => \Carbon\Carbon::now()->subDay(1),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\Laravel\Cashier\Subscription::class, 'default', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\Laravel\Cashier\Subscription::class, 'active', function (Faker\Generator $faker) {
	return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\Laravel\Cashier\Subscription::class, 'grace-period', function (Faker\Generator $faker) {
	return [
		'ends_at' => \Carbon\Carbon::now()->addDays(mt_rand(5, 30)),
	];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(\Laravel\Cashier\Subscription::class, 'expired', function (Faker\Generator $faker) {
	return [
		'ends_at' => \Carbon\Carbon::now()->subDays(mt_rand(5, 30)),
	];
});
