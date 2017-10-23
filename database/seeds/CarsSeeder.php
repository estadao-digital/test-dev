<?php

use Illuminate\Database\Seeder;
use App\Car;

class CarsSeeder extends Seeder
{
    private $cars = [
        ['model' => 'Corsa Hatch', 'brand_id' => 1, 'year' => '1997'],
        ['model' => 'Corsa Sedan', 'brand_id' => 1, 'year' => '1998'],
        ['model' => 'Uno Mile', 'brand_id' => 2, 'year' => '2000'],
        ['model' => 'Uno', 'brand_id' => 2, 'year' => '1990'],
        ['model' => 'Civic', 'brand_id' => 8, 'year' => '2012'],
        ['model' => 'City', 'brand_id' => 8, 'year' => '2013'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->cars as $car){
            Car::create($car);
        }
    }
}
