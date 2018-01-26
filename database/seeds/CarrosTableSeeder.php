<?php

use Illuminate\Database\Seeder;

class CarrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('carros')->insert([
            'modelo' => "Fiesta",
            'marca_id' => "1",
            'ano' => "2010"
        ]);

        DB::table('carros')->insert([
            'modelo' => "Uno",
            'marca_id' => "2",
            'ano' => "2011"
        ]);

        DB::table('carros')->insert([
            'modelo' => "Gol",
            'marca_id' => "3",
            'ano' => "2013"
        ]);

        DB::table('carros')->insert([
            'modelo' => "Onix",
            'marca_id' => "4",
            'ano' => "2014"
        ]);

        DB::table('carros')->insert([
            'modelo' => "Edge",
            'marca_id' => "1",
            'ano' => "2017"
        ]);

        DB::table('carros')->insert([
            'modelo' => "Idea",
            'marca_id' => "2",
            'ano' => "2017"
        ]);

        DB::table('carros')->insert([
            'modelo' => "Polo",
            'marca_id' => "3",
            'ano' => "2015"
        ]);

        DB::table('carros')->insert([
            'modelo' => "Vectra",
            'marca_id' => "4",
            'ano' => "2002"
        ]);

    }
}
