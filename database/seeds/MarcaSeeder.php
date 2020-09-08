<?php

use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Marca::insert([
            [
               'nome'=>'hyundai'
            ],
            [
                'nome'=>'GM-Chevrolet'
            ],
            [
                'nome'=>'Volvo'
            ],
            [
                'nome'=>'Fiat'
            ],
            [
                'nome'=>'Volkswagen'
            ],
            [
                'nome'=>'Ford'
            ],
            [
                'nome'=>'Toyota'
            ],
        ]);
    }
}
