<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('users')->insert(
            [
                'name' => $faker->firstNameMale . ' ' . $faker->lastName,
                'email' => 'user1@globant.com',
                'password' => Hash::make('password'),
            ]
        );

        DB::table('users')->insert(
            [
                'name' => $faker->firstNameFemale . ' ' . $faker->lastName,
                'email' => 'user2@globant.com',
                'password' => Hash::make('password'),
            ]
        );
    }
}
