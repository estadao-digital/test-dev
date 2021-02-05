<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Car;
use Carbon\Factory;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['VW', 'Fiat', 'Hyundai', 'Chevrolet'])->each(function ($name) {
           $brand = Brand::create(['name' => $name]);

           $cars = Car::factory()->count(5)->make()->toArray();
           foreach ($cars as $car) {
             $brand->Cars()->create($car);
           }

        });
    }
}
