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
        DB::table('carros')->insert(
            [
                'marca' => Str::random(10),
                'modelo' => Str::random(10),
                'ano' => rand(1998, 2021),
                'placa' => Str::random(10),
                'cambio' => Str::random(10),
                'custo' => rand(10000, 20000),
                'venda' => rand(20000, 45000),
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ],
            [
                'marca' => Str::random(10),
                'modelo' => Str::random(10),
                'ano' => rand(1998, 2021),
                'placa' => Str::random(10),
                'cambio' => Str::random(10),
                'custo' => rand(10000, 20000),
                'venda' => rand(20000, 45000),
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]
        );
    }
}
