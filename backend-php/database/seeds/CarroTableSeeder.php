<?php

use Illuminate\Database\Seeder;

class CarroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0;$i<=100;$i++){

            DB::table('carro')->insert([
                'marca_id' => rand(1,3),
                'modelo' => str_random(10),
                'ano' => rand(1980,2018),
            ]);
        }
    }
}
