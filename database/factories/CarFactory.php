<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Car;
use Faker\Generator as Faker;

$factory->define(Car::class, function (Faker $faker) {
    return [
        'id_brand' => 1,
        'model' => $faker->name,
        'year' => 2021
    ];
});
