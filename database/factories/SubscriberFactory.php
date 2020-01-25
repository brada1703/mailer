<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subscriber;
use Faker\Generator as Faker;

$factory->define(Subscriber::class, function (Faker $faker) {
    return [
        'email'      => $faker->unique()->safeEmail,
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'state'      => $faker->randomElement(['active', 'unsubscribed', 'junk', 'bounced', 'unconfirmed']),
        'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
    ];
});
