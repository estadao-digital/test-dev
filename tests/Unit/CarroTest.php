<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CarroTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function testIndex()
    {
         $response = $this->get('/');
         $response->assertStatus(200);
    }

    public function testCreteCarro()
    {
         \App\Carro::create([
           'marca_id' => 1,
           'modelo' => 'Hilux 4x4',
           'ano' => 2018
         ]);

         $this->assertDatabaseHas('carros', ['modelo' => 'Hilux 4x4', 'ano' => 2018]);
    }
}
