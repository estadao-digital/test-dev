<?php

use Illuminate\Database\Seeder;

class CarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('carros')->delete();
        DB::table('carros')->insert([
        	 	0 => [
                    'id'     => 1,
                    'marca'  => 'Fiat',
                    'modelo' =>	'Uno',
                    'ano'	 =>	2010,
                ],
        ]);
    }
}
