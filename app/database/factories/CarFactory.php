<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'model'   => $this->faker->word(6),
            'year'    => $this->faker->year,
            'description' => $this->faker->text($maxNbChars = 200),
            'amount'      => $this->faker->randomFloat(2,1500,19000),
            'image'      => $this->faker->numberBetween($min = 1, $max = 4).'.jfif'
        ];
    }
}
