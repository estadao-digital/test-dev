<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TestDev\Classes\Car;
use TestDev\Repositories\CarRepository;
use Response;

class CarController extends Controller
{
	public function __construct() {
		$car = new Car;
	}

    public function getCars() {
    	$carRepository = new CarRepository;
        $cars = $carRepository->getCars();
        unset($carRepository);
        return view('index')->with('cars', $cars);
    }

    public function storeCar(Request $request) {

    }

    public function getCar($id) {
        $carRepository = new CarRepository;
        $car = $carRepository->getCar($id);
        return Response::json($car);
    }

    public function updateCar(Request $request, $id) {

    }

    public function deleteCar($id) {

    }
}
