<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Field;
use Faker\Generator as Faker;

$factory->define(Field::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'type' => $faker->randomElement(['date', 'number', 'string', 'boolean']),
        'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
    ];
});
