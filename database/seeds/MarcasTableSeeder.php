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
        App\Marca::insert([
            ['nome' => 'Chevrolet'],
            ['nome' => 'Fiat'],
            ['nome' => 'Ford'],
            ['nome' => 'Hyundai'],
            ['nome' => 'Toyota'],
        ]);
    }
}
