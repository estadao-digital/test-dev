<?php

use Illuminate\Database\Seeder;
use Cars\Car\Entities\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAll();
    }

    private function createAll()
    {
        Car::firstOrCreate([
            'id' => '1',
            'name' => 'Astra',
            'model' => 'GLS',
            'year' => '2000',
            'manufacturer_id' => '2',
            'image_location' => 'images/car/chevrolet-car.jpg',
            ]);
    }
}
