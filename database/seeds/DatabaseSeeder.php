<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(MarcasTableSeeder::class);
        $this->call(CarrosTableSeeder::class);
    }
}
