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
        ['modelo' => 'Hilux', 'marca_id' => 1, 'ano' => 2018 ],
        ['modelo' => 'L200 Triton', 'marca_id' => 2, 'ano' => 2018 ],
        ['modelo' => 'Civic', 'marca_id' => 3, 'ano' => 2018 ],
        ['modelo' => 'Estrada', 'marca_id' => 4, 'ano' => 2018 ]
      ]);
    }
}
