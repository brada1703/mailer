<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Field;
use App\FieldValue;
use Faker\Generator as Faker;

$factory->define(FieldValue::class, function (Faker $faker, $attributes) {
    $field = Field::where('id', $attributes['field_id'])->firstOrFail();
    switch ($field->type) {
        case 'date': $value = $faker->date();
            break;
        case 'number': $value = $faker->randomDigit;
            break;
        case 'string': $value = $faker->word;
            break;
        case 'boolean': $value = $faker->randomElement(['true', 'false']);
            break;
    }
    return [
        'value' => $value,
        'field_id' => $attributes['field_id'],
        'subscriber_id' => $attributes['subscriber_id'],
        'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
    ];
});
