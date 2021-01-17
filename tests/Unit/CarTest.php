<?php

namespace Tests\Unit;

use App\Model\Brand;
use App\Model\Car;
use App\Services\CarService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Tests\TestCase;

class CarTest extends TestCase
{
    use DatabaseMigrations;

    private $carService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->carService = app()->make(CarService::class);
        factory(Brand::class)->create();
        factory(Car::class)->create();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @test
     * @dataProvider dataSetCarWrong
     */
    public function returnErroWhenDataCarIsWrong($idBrand, $model, $year)
    {
        $response = $this->carService->checkingDataForRegistration($idBrand, $model, $year);
        $this->assertInstanceOf(\RuntimeException::class, $response);
    }

    /**
     * @test
     * @dataProvider dataSetCarCorrect
     */
    public function returnIsNullWhenDataCarIsCorrect()
    {
        $response = $this->carService->checkingDataForRegistration(1, 'Celta', 2021);
        $this->assertNull($response);
    }

    /**
     * @test
     * @dataProvider dataSetCarCorrect
     */
    public function checkIfRegisterCarIsCorrect($idBrand, $model, $year)
    {
        $response = $this->carService->registerCar($idBrand, $model, $year);
        $this->assertIsBool($response);
    }

    /**
     * @test
     * @dataProvider dataSetCarCorrect
     */
    public function registerCarCorrectly($idBrand, $model, $year)
    {
        $response = $this->carService->registerCar($idBrand, $model, $year);
        $this->assertTrue($response);
    }

    /**
     * @test
     * @dataProvider dataSetCarWrong
     */
    public function returnErrorWhenTryToUpdataCarWithWrongData($idBrand, $model, $year)
    {
        $response = $this->carService->alterCarInformation($id = 1, $idBrand, $model, $year);
        $this->assertInstanceOf(\RuntimeException::class, $response);
    }

    /**
     * @test
     * @dataProvider dataSetCarCorrect
     */
    public function returnSuccessWhenTryToUpdataCar($idBrand, $model, $year)
    {
        $response = $this->carService->alterCarInformation($id = 1, $idBrand, $model, $year);
        $this->assertNull($response);
    }

    /**
     * @test
     * @dataProvider dataSetCarWrong
     */
    public function returnErrorWhenTryToDeleteCarWithWrongData()
    {
        $response = $this->carService->deleteCar($id = 9999999);
        $this->assertInstanceOf(\RuntimeException::class, $response);
    }

    /**
     * @test
     * @dataProvider dataSetCarCorrect
     */
    public function returnSuccessWhenTryToDeleteCar()
    {
        $response = $this->carService->deleteCar($id = 1);
        $this->assertEquals(1, $response);
    }

    public function dataSetCarWrong()
    {
        return [
            [
                'id_brand' => 99,
                'model' => 'Celta',
                'year' => 2021
            ]
        ];
    }

    public function dataSetCarCorrect()
    {
        return [
            [
                'id_brand' => 1,
                'model' => 'Celta',
                'year' => 2021
            ]
        ];
    }
}
