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
        DB::table('cars')->insert(
            [
                'id_brand' => 7,
                'model' => 'Onix',
                'year' => '2021',
                'created_at' => \Carbon\Carbon::now()
            ]
        );
    }
}
