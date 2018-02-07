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
        ['descricao' => 'Toyota'],
        ['descricao' => 'Mitsubishi'],
        ['descricao' => 'Honda'],
        ['descricao' => 'Fiat'],
        ['descricao' => 'Chevrolet'],
        ['descricao' => 'Ferrari']
      ]);
    }
}
