<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Support\Facades\Artisan as Artisan;


class ApiCarTest extends TestCase
{
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function test_fail_create_item()
    {   
        $this->post('/services/v1/carros',[ "name" => "Golf",
                                                "model" => "GTI",
                                                "year" => "NAO E NUMERO",
                                                "excluded" => "0",
                                                "image_location" => "images/car/wolksvagem-car.jpg",
                                                "manufacturer_id" => "6",
                                            ])
                ->assertStatus(400)
                ->assertJson([
                                'message' => 'O Campo Ano deve ser numérico' 
                            ]);
    }

    public function test_create_item()
    {   
        $this->post('/services/v1/carros',[ "name" => "Golf",
                                                "model" => "GTI",
                                                "year" => "2005",
                                                "excluded" => "0",
                                                "image_location" => "images/car/wolksvagem-car.jpg",
                                                "manufacturer_id" => "6",
                                            ])
                ->assertStatus(200)
                ->assertJson([
                                'message' => 'Carro criado com sucesso' 
                            ]);
    }

    public function test_fail_update_item()
    {   
        $this->put('/services/v1/carros/1',[     
                                                "id" => "1",
                                                "name" => "Astra MUDEI",
                                                "model" => null,
                                                "year" => "2000",
                                                "excluded" => "0",
                                                "image_location" => "images/car/chevrolet-car.jpg",
                                                "manufacturer_id" => "6",
                                            ])
                ->assertStatus(400)
                ->assertJson([
                                'message' => "Preencha o campo Modelo" 
                            ]);
    }
    public function test_update_item()
    {   
        $this->put('/services/v1/carros/1',[     
                                                "id" => "1",
                                                "name" => "Astra MUDEI",
                                                "model" => "GLS MUDEI",
                                                "year" => "2000",
                                                "excluded" => "0",
                                                "image_location" => "images/car/chevrolet-car.jpg",
                                                "manufacturer_id" => "6",
                                            ])
                ->assertStatus(200)
                ->assertJson([
                                'message' => 'Carro editado com sucesso' 
                            ]);
    }

    public function test_remove_item()
    {   
        $this->delete('/services/v1/carros/1',[     
                                                "id" => "1",
                                                "name" => "Astra MUDEI",
                                                "model" => "GLS MUDEI",
                                                "year" => "2000",
                                                "excluded" => "0",
                                                "image_location" => "images/car/chevrolet-car.jpg",
                                                "manufacturer_id" => "6",
                                            ])
                ->assertStatus(200)
                ->assertJson([
                                'message' => 'Carro excluido com sucesso' 
                            ]);
    }

    public function test_edit_item()
    {   
        $this->get('/services/v1/carros/1',[     
                                                "id" => "1",
                                            ])
                ->assertStatus(200)
                ->assertJson([
                                "id"=> 1,
                                "name"=> "Astra",
                                "model"=> "GLS",
                                "image_location"=> "images/car/chevrolet-car.jpg",
                                "year"=> "2000",
                                "excluded"=> "0",
                                "manufacturer_id" => "2",
                            ]);
    }
    public function test_list_two_items()
    {   
        $this->get('/services/v1/carros/1',[     
                                                "id" => "1",
                                            ])
                ->assertStatus(200)
                ->assertSeeText('GLS')
                ->assertSeeText('chevrolet-car.jpg')
                ->assertSeeText('Astra');
    }

    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
