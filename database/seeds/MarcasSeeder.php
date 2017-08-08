<?php

use Illuminate\Database\Seeder;

class MarcasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('marcas')->delete();
        DB::table('marcas')->insert([
        	 	0 => [
                    'id'     => 1,
                    'marca'  => 'Fiat',
                ],
                1 => [
                    'id'     => 2,
                    'marca'  => 'Hyundai',
                ],
                2 => [
                    'id'     => 3,
                    'marca'  => 'Honda',
                ],
        ]);
    }
}
