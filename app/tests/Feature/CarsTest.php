<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarsTest extends TestCase
{
    //use RefreshDatabase;
    /**
     * Test List Cars.
     *
     * @return void
     */
    public function test_list_cars()
    {
        $response = $this->getJson('api/cars');
        $response->assertStatus(200);
    }
    /**
     * Test Can Show Car.
     *
     * @return void
     */
    public function test_can_show_car()
    {
        $response = $this->getJson('api/cars/3');
        $response->assertStatus(200)
        ->assertJsonFragment(['id' => 3]);
    }
    /**
     * Test Create Car.
     *
     * @return void
     */
    public function test_create_car()
    {
        $response = $this->postJson('api/cars',
        [
            "brand_id"=> "1",
            "model"=> "Model New",
            "year"=> "2021",
            "description"=> "BLA BLA BLA BLA reprehenderit consequatur ab quod earum rerum placeat.",
            "amount"=> "10999.28"
        ]);
        $response->assertStatus(200);
    }
     /**
     * Test Update Car.
     *
     * @return void
     */
    public function test_update_car()
    {
        $response = $this->putJson('api/cars/3' ,
        [
            "brand_id"=> "1",
            "model"=> "Model Updated",
            "year"=> "2020",
            "description"=> "Updated BLA BLA BLA BLA reprehenderit consequatur ab quod earum rerum placeat.",
            "amount"=> "9999.28"
        ]);
        $response->assertStatus(200);
    }
    /**
     * Test Can Delete Car.
     *
     * @return void
     */
    public function test_can_delete_car()
    {
        $response = $this->deleteJson('api/cars/7');
        $response->assertStatus(200)
        ->assertJsonFragment(['message' => 'Carro excluido com sucesso.']);
    }
}
