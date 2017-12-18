<?php

use Illuminate\Database\Seeder;
use Cars\Car\Entities\Manufacturer;

class ManuFacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAll();        
    }

    private function createAll()
    {
        Manufacturer::firstOrCreate([
            'id' => '1',
            'name' => 'Honda',
            'slug' => 'honda',
            'image_location' => 'images/manufacturer/honda.jpg',
        ]);

        Manufacturer::firstOrCreate([
            'id' => '2',
            'name' => 'Chevrolet',
            'slug' => 'chevrolet',
            'image_location' => 'images/manufacturer/chevrolet.jpg',
        ]);
        
        Manufacturer::firstOrCreate([
            'id' => '3',
            'name' => 'Toyota',
            'slug' => 'toyota',
            'image_location' => 'images/manufacturer/toyota.jpg',
        ]);
        
        Manufacturer::firstOrCreate([
            'id' => '4',
            'name' => 'Ford',
            'slug' => 'ford',
            'image_location' => 'images/manufacturer/ford.jpg',
        ]);

        Manufacturer::firstOrCreate([
            'id' => '5',
            'name' => 'Renault',
            'slug' => 'renault',
            'image_location' => 'images/manufacturer/renault.jpg',
        ]);

        Manufacturer::firstOrCreate([
            'id' => '6',
            'name' => 'Wolksvagem',
            'slug' => 'wolksvagem',
            'image_location' => 'images/manufacturer/wolksvagem.jpg',
        ]);

    }
}
