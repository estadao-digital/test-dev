<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CarTest extends TestCase
{
    /**
     * A basic test Car.
     *
     * @return void
     */
    public function getCar()
    {
        $response = $this->call('GET', '/carros');

            $this->assertEquals(200, $response->status());
        }
}
