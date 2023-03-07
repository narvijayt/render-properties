<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => 'admin',
        'display_name' => 'Admin',
        'description' => 'Admin Role',
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Role::class, 'default', function (Faker\Generator $faker) {
    return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Role::class, 'admin', function (Faker\Generator $faker) {
    return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Role::class, 'user', function (Faker\Generator $faker) {
    return [
        'name' => 'user',
        'display_name' => 'user',
        'description' => 'User Role',
    ];
});