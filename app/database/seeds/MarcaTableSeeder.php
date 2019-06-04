<?php

class MarcaTableSeeder extends Seeder
{

  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('marcas')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $objects = [
      
      ['nome' => 'Chevrolet'],

      ['nome' => 'Volkswagen'],

      ['nome' => 'Peugeout'],

      ['nome' => 'Fiat'],

      ['nome' => 'Audi'],

      ['nome' => 'Ford'],

      ['nome' => 'Citroen'],

      ['nome' => 'Ferrari'],

      ['nome' => 'Hyundai'],

      ['nome' => 'Honda'],

      ['nome' => 'BMW'],

      ['nome' => 'Toyota'],

      ['nome' => 'Kia'],

      ['nome' => 'Mazda'],

      ['nome' => 'Nissan'],

      ['nome' => 'Porsche'],

      ['nome' => 'Suzuki'],

      ['nome' => 'Renault'],

      ['nome' => 'Land Rover'],

      ['nome' => 'Subaru'],

      ['nome' => 'Lexus'],

      ['nome' => 'Mitsubishi'],

      ['nome' => 'Volvo'],

      ['nome' => 'Jeep'],

      ['nome' => 'Bentley'],

    ];

    DB::table('marcas')->insert($objects);
  }
}
