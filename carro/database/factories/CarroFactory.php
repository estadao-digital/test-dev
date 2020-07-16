<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Carro;
use Faker\Generator as Faker;

$factory->define(Carro::class, function (Faker $faker) {
    return [
        'marca' => $faker->randomElement(['Volvo', 'Ford', 'Chevrolet', 'Fiat', 'BMW', 'Audi']),
        'modelo' => $faker->unique()->word,
        'ano' => $faker->numberBetween($min = 2000, $max = 2020)
    ];
});
