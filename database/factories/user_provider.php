<?php

$factory->define(App\UserProvider::class, function(Faker\Generator $faker) {
    return [
        'user_id' => null,
        'email' => $faker->safeEmail,
        'provider' => $faker->randomElement(['facebook']),
        'provider_id' => $faker->uuid,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => $faker->dateTime,
    ];
});

$factory->state(App\UserProvider::class, 'default', function(Faker\Generator $faker) {
    return [];
});

$factory->state(App\UserProvider::class, 'with-user', function(Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->user_id;
        }
    ];
});