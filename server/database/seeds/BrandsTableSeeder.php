<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            [    
                'name' => 'Citroën'
            ],
            [
                'name' => 'Fiat'
            ],
            [
                'name' => 'Ford'
            ],
            [
                'name' => 'General Motors'
            ],
            [
                'name' => 'Hyundai'
            ],
            [
                'name' => 'Honda'
            ],
            [
                'name' => 'Nissan'
            ],
            [
                'name' => 'Peugeot'
            ],
            [
                'name' => 'Renault'
            ],
            [
                'name' => 'Toyota'
            ],
            [
                'name' => 'Volkswagen'
            ],
        ]);
    }
}
