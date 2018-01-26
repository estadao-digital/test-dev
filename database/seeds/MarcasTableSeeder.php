<?php

use Illuminate\Database\Seeder;

class MarcasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('marcas')->insert([
            'marca' => "Ford",
        ]);

        DB::table('marcas')->insert([
            'marca' => "Fiat",
        ]);

        DB::table('marcas')->insert([
            'marca' => "Volkswagen",
        ]);

        DB::table('marcas')->insert([
            'marca' => "Chevrolet",
        ]);
    }
}