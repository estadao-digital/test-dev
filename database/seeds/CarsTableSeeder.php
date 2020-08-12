<?php

use Illuminate\Database\Seeder;
use App\Car;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \DB::table('users')->delete();

        \DB::table('cars')->insert(array (
        0 => 
          array (
                 'brand' => 'Jeep',
                 'model' => 'Compass',
                 'year' => '2020'
         ),
        1 => 
          array (
                'brand' => 'Land Rover',
                'model' => 'Freelander',
                'year' => '2014'
         ),
        2 => 
          array (
                'brand' => 'Nissan',
                'model' => 'Frontier',
                'year' => '2018'
         )
        ));

    }
}
