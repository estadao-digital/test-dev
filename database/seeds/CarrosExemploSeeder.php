<?php

use Illuminate\Database\Seeder;
use App\Marca;
use App\Carro;

class CarrosExemploSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Marca::create(['nome' => 'Fiat']);
        Marca::create(['nome' => 'Volkswagen']);
        Marca::create(['nome' => 'Jeep']);
        Marca::create(['nome' => 'Dodge']);
        Marca::create(['nome' => 'Chevrolet']);
        Marca::create(['nome' => 'Hyundai']);
        Marca::create(['nome' => 'Ford']);
        Marca::create(['nome' => 'Lifan']);
        Marca::create(['nome' => 'BMW']);
        Marca::create(['nome' => 'Mercedez-Bens']);

        Carro::create(['marca_id' => 1, 'modelo' => 'Argo 1.0 Drive', 'ano' => 2019]);
        Carro::create(['marca_id' => 1, 'modelo' => 'Uno 1.5R', 'ano' => 2019]);
        Carro::create(['marca_id' => 2, 'modelo' => 'Virtus 1.6 ComfortLine', 'ano' => 2018]);
        Carro::create(['marca_id' => 2, 'modelo' => 'Fusca 1300', 'ano' => 1968]);
        Carro::create(['marca_id' => 3, 'modelo' => 'Grand Cherokee TrackHawk', 'ano' => 2017]);
        Carro::create(['marca_id' => 4, 'modelo' => 'Charger Hellcat', 'ano' => 2017]);
        Carro::create(['marca_id' => 4, 'modelo' => 'Challenger Demon', 'ano' => 2019]);
        Carro::create(['marca_id' => 4, 'modelo' => 'Challenger Demon', 'ano' => 2019]);
        Carro::create(['marca_id' => 5, 'modelo' => 'Montana 1.4 LT', 'ano' => 2012]);
        Carro::create(['marca_id' => 5, 'modelo' => 'Montana 1.8 Conquest', 'ano' => 2008]);
        Carro::create(['marca_id' => 6, 'modelo' => 'HB20 Comfort Plus', 'ano' => 2013]);
        Carro::create(['marca_id' => 7, 'modelo' => 'Fusion EcoBoost Hybrid', 'ano' => 2015]);
        Carro::create(['marca_id' => 7, 'modelo' => 'F-150 Raptor EcoBoost', 'ano' => 2018]);
        Carro::create(['marca_id' => 8, 'modelo' => 'Civic SI', 'ano' => 2008]);
        Carro::create(['marca_id' => 8, 'modelo' => '328', 'ano' => 1995]);
        Carro::create(['marca_id' => 9, 'modelo' => 'M3', 'ano' => 1998]);
        Carro::create(['marca_id' => 9, 'modelo' => 'M3', 'ano' => 1998]);
        Carro::create(['marca_id' => 10, 'modelo' => 'C180', 'ano' => 2018]);
        Carro::create(['marca_id' => 10, 'modelo' => '560 SEL', 'ano' => 1985]);
    }
}
