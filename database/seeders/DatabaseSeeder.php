<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Simple array of brands and models
        $items = [
            'Fiat' => [
                'Punto',
                'Palio'
            ],
            'Ford' => [
                'Fiesta',
                'Ka'
            ],
            'Volkswagen' => [
                'Gol',
                'Fox',
                'CrossFox'
            ]
        ];

        // Create data
        foreach ($items as $key => $item) {
            $data = DB::table('brands')->insertGetId([
                'name' => $key,
                'created_at' => date("Y-m-d H:i:s")
            ]);

            foreach ($item as $value) {
                DB::table('models')->insert([
                    'brand_id' => $data,
                    'name' => $value,
                    'created_at' => date("Y-m-d H:i:s")
                ]);
            }
        }
    }
}
