<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Permission::class, function (Faker\Generator $faker) {
    return [
        'name' => 'edit-users',
        'display_name' => 'Edit Users',
        'description' => 'Edit user permission',
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Permission::class, 'default', function (Faker\Generator $faker) {
    return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Permission::class, 'edit-users', function (Faker\Generator $faker) {
    return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Permission::class, 'create-entry', function (Faker\Generator $faker) {
    return [
        'name' => 'create-entry',
        'display_name' => 'Create Entry',
        'description' => 'Create entry permission',
    ];
});