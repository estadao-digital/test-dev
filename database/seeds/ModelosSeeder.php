<?php

use Illuminate\Database\Seeder;

class ModelosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modelos')->delete();
        DB::table('modelos')->insert([
        	 	0 => [
                    'id'     => 1,
                    'marca'  => 1,
                    'modelo' =>	'Mobi',
                ],
                1 => [
                    'id'     => 2,
                    'marca'  => 1,
                    'modelo' => 'Argo',
                ],

                2 => [
                    'id'     => 3,
                    'marca'  => 2,
                    'modelo' => 'i30',
                ],
                3 => [
                    'id'     => 4,
                    'marca'  => 2,
                    'modelo' => 'Elantra',
                ],


                4 => [
                    'id'     => 5,
                    'marca'  => 3,
                    'modelo' => 'Civic',
                ],
                5 => [
                    'id'     => 6,
                    'marca'  => 3,
                    'modelo' => 'City',
                ],

        ]);
    }
}
