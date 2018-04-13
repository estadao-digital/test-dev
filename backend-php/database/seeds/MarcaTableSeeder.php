<?php

use Illuminate\Database\Seeder;

class MarcaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('marca')->insert([

            'descricao' => "Volksvagem",
            ]);

        DB::table('marca')->insert([
            'descricao' => "Fiat",
        ]);

        DB::table('marca')->insert([
            'descricao' => "Chevrolet",
        ]);
    }
}
