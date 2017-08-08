<?php

use Illuminate\Database\Seeder;

class CarrosSeeder extends Seeder
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
                    'marca'  => 1,
                    'modelo' =>	1,
                    'ano'	 =>	2010,
                ],
                1 => [
                    'id'     => 2,
                    'marca'  => 1,
                    'modelo' => 2,
                    'ano'    => 2011,
                ],
                2 => [
                    'id'     => 3,
                    'marca'  => 2,
                    'modelo' => 1,
                    'ano'    => 2012,
                ],
                3 => [
                    'id'     => 4,
                    'marca'  => 3,
                    'modelo' => 1,
                    'ano'    => 2013,
                ],
        ]);
    }
}
