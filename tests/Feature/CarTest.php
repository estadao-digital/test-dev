<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan as Artisan;

use Cars\Car\Services\CarService;

class CarTest extends TestCase
{
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    
    public function test_list_car_default()
    {
        $expected = ['0' => [  "car_id" => "1",
                                "car_name" => "Astra",
                                "car_model" => "GLS",
                                "car_year" => "2000",
                                "car_image" => "images/car/chevrolet-car.jpg",
                                "car_image" => "images/car/chevrolet-car.jpg",
                                "manufacturer_name" => "Chevrolet",
                                "manufacturer_image" => "images/manufacturer/chevrolet.jpg"
                            ]
                    ];
        $carService = new CarService();
        $this->assertEquals( $carService->getFilterList( [] )->toArray() , $expected );
    }

    public function test_list_car_filter_no_results()
    {
        $carService = new CarService();
        $this->assertEquals( $carService->getFilterList( [ 'name' => 'não vai ter' ] )->toArray() , [] );
    }

    public function test_list_car_filter_one_result()
    {
        $expected = ['0' => [  "car_id" => "1",
                                "car_name" => "Astra",
                                "car_model" => "GLS",
                                "car_year" => "2000",
                                "car_image" => "images/car/chevrolet-car.jpg",
                                "car_image" => "images/car/chevrolet-car.jpg",
                                "manufacturer_name" => "Chevrolet",
                                "manufacturer_image" => "images/manufacturer/chevrolet.jpg"
                            ]
                    ];
        $carService = new CarService();
        $this->assertEquals( $carService->getFilterList( [ 'name' => 'Astra' ] )->toArray() , $expected );
    }

    public function test_update_car()
    {
        $expected = [   "id" => 1,
                        "name" => "Astra Mudei",
                        "model" => "GLS Mudei",
                        "year" => "2000",
                        "excluded" => "0",
                        "image_location" => "images/car/chevrolet-car.jpg",
                        "manufacturer_id" => "2",
                    ];
        $params = [ 'name' => 'Astra Mudei' , 
                    'model' => 'GLS Mudei',
                    "year" => "2000",
                    "image_location" => "images/car/chevrolet-car.jpg",
                    "manufacturer_id" => "2", ];
        $carService = new CarService();
        $carService->update( '1' , $params );
        $final = $carService->edit( 1 )->toArray();
        
        $this->assertEquals( $final , $expected );
    }
    /**
     * @expectedException         \Cars\Car\Exceptions\CarEditException
     * @expectedExceptionMessage O Campo Ano deve ser numérico
     */
    public function test_update_fail_year_not_number_car()
    {
        $params = [ 'name' => 'Astra Mudei' , 
                    'model' => 'GLS Mudei',
                    "year" => "NAO E NUMERO",
                    "image_location" => "images/car/chevrolet-car.jpg",
                    "manufacturer_id" => "2", ];
        $carService = new CarService();
        $carService->update( '1' , $params );
        $carService->edit( 1 )->toArray();
    }

    public function test_exclude_car()
    {
        $expected = [   "id" => 1,
                        "name" => "Astra",
                        "model" => "GLS",
                        "year" => "2000",
                        "excluded" => "1",
                        "image_location" => "images/car/chevrolet-car.jpg",
                        "manufacturer_id" => "2",
                    ];
        $carService = new CarService();
        $carService->remove( 1 );
        $final = $carService->edit( 1 )->toArray();
        
        $this->assertEquals( $final , $expected );
    }

    public function test_create_car()
    {
        $expected = [   "name" => "Golf",
                        "model" => "GTI",
                        "year" => "2005",
                        "excluded" => "0",
                        "image_location" => "images/car/wolksvagem-car.jpg",
                        "manufacturer_id" => "6",
                    ];
        $carService = new CarService();
        $carService->create( $expected );
        $final = $carService->edit( 2 )->toArray();
        $expected['id'] = 2;
        $this->assertEquals( $final , $expected );
    }
    /**
     * @expectedException         \Cars\Car\Exceptions\CarEditException
     * @expectedExceptionMessage Preencha o campo Nome
     */
    public function test_fail_create_null_name_car()
    {
        $expected = [   "name" => null,
                        "model" => "GTI",
                        "year" => "2005",
                        "excluded" => "0",
                        "image_location" => "images/car/wolksvagem-car.jpg",
                        "manufacturer_id" => "6",
                    ];
        $carService = new CarService();
        $carService->create( $expected );
        $carService->edit( 2 )->toArray();
    }

    public function test_list_car_filter_after_create()
    {
        $expected = ['0' => [  "car_id" => "1",
                                "car_name" => "Astra",
                                "car_model" => "GLS",
                                "car_year" => "2000",
                                "car_image" => "images/car/chevrolet-car.jpg",
                                "manufacturer_name" => "Chevrolet",
                                "manufacturer_image" => "images/manufacturer/chevrolet.jpg"
                            ],
                        '1' =>  [   
                                    "car_id" => "2",
                                    "car_name" => "Golf",
                                    "car_model" => "GTI",
                                    "car_year" => "2005",
                                    "car_image" => "images/car/wolksvagem-car.jpg",
                                    "manufacturer_name" => "Wolksvagem",
                                    "manufacturer_image" => "images/manufacturer/wolksvagem.jpg",
                                ]
                    ];
        $this->test_create_car();

        $carService = new CarService();
        $this->assertEquals( $carService->getFilterList( [] )->toArray() , $expected );
    }

    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
