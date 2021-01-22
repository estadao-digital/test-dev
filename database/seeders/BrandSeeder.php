<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = ['Fiat', 'Ford', 'Volkswagen'];

        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'name' => $brand,
                'created_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
