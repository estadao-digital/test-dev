<?php

use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modelos    = ['A1', '145', '118i', 'Fusion', 'RX 350', 'C30', 'Golf GTI', 'Corola', 'Creta'];
        foreach ($modelos as $key=>$model){
            DB::table('cars')->insert([
                'manufacturer_id' => $key+1,
                'model' => $model,
                'year'   => '2017'
            ]);
        }
    }
}
