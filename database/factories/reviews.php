
<?php
$factory->define(App\Review::class, function (Faker\Generator $faker) {
    return [
        'review_id' => $faker->uuid,
        'reviewer_user_id' => null,
        'subject_user_id' => null,
        'reject_message' => null,
        'status' => \App\Enums\ReviewStatusType::ACCEPTED,
        'message' => $faker->words(100, true),
        'rating' => $faker->numberBetween(1, 5),
        'created_at' => $faker->dateTime,
        'rejected_at' => null,
        'deleted_at' => null,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Review::class, 'default', function (Faker\Generator $faker) {
    return [];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Review::class, 'with-user', function (Faker\Generator $faker) {
    return [
        'reviewer_user_id' => (int)(function() {
            return factory(App\User::class)->create()->user_id;
        }),
        'subject_user_id' => (int)(function() {
            return factory(App\User::class)->create()->user_id;
        }),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Review::class, 'with-user-rejected', function (Faker\Generator $faker) {
    return [
        'rejected_message' => $faker->words(50, true),
        'rejected_at'      => $faker->dateTimeThisMonth,
        'status'           => \App\Enums\ReviewStatusType::REJECTED,
        'reviewer_user_id' => (int)(function() {
            return factory(App\User::class)->create()->user_id;
        }),
        'subject_user_id' => (int)(function() {
            return factory(App\User::class)->create()->user_id;
        }),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Review::class, 'with-user-overridden', function (Faker\Generator $faker) {
    return [
        'rejected_message' => $faker->words(50, true),
        'rejected_at'      => $faker->dateTimeThisMonth,
        'status'           => \App\Enums\ReviewStatusType::OVERRIDDEN,
        'reviewer_user_id' => (int)(function() {
            return factory(App\User::class)->create()->user_id;
        }),
        'subject_user_id' => (int)(function() {
            return factory(App\User::class)->create()->user_id;
        }),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Review::class, 'with-user-rejected-deleted', function (Faker\Generator $faker) {
    return [
        'rejected_message' => $faker->words(50, true),
        'rejected_at'      => $faker->dateTimeThisMonth,
        'deleted_at'       => $faker->dateTimeThisMonth,
        'status'           => \App\Enums\ReviewStatusType::REJECTED,
        'reviewer_user_id' => (int)(function() {
            return factory(App\User::class)->create()->user_id;
        }),
        'subject_user_id' => (int)(function() {
            return factory(App\User::class)->create()->user_id;
        }),
    ];
});