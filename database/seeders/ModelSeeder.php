<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = ['Punto', 'Ka', 'Gol'];

        foreach ($models as $model) {
            DB::table('models')->insert([
                'name' => $model,
                'created_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
