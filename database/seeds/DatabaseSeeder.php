<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('carros')->insert([
            'marca' => str_random(10),
            'modelo' => str_random(10),
            'ano' => str_random(4),
        ]);
    }
}
