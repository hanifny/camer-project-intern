<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Unit;
use Faker\Generator as Faker;

$factory->define(Unit::class, function (Faker $faker) {
    return [
        'unit_code' => $faker->randomElement(['Indomart', 'Alfamart', 'j.co', 'Starbucks']) . $faker->numerify('###'),
        'floor' => 'B',
        'unit_type' => 'GG',
    ];
});
