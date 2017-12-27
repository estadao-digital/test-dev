<?php

use Illuminate\Database\Seeder;

class ManufacturerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $marcas    = ['Audi', 'Alfa Romeo', 'BMW', 'Ford', 'Lexus', 'Volvo', 'Volkswagen', 'Toyota', 'Outros'];


        foreach ($marcas as $marca){
            DB::table('manufacturers')->insert([
                'name' => $marca,
            ]);
        }

    }
}
