<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Field;
use App\Subscriber;
use App\FieldValue;
use Faker\Generator as Faker;

$factory->define(FieldValue::class, function (Faker $faker) {
    return [
        'value'         => $faker->word,
        'field_id'      => Field::all()->random()->id,
        'subscriber_id' => Subscriber::all()->random()->id,
        'created_at'    => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
    ];
});
