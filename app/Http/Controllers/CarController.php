<?php

namespace App\Http\Controllers;

use App\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Action to paging cars
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cars = Car::orderBy('id', 'desc')->paginate(6);

        return response()->json($cars);
    }

    /**
     * Action to create car based on request
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCar(Request $request)
    {
        $car = Car::create($request->all());

        return response()->json($car);
    }

    /**
     * Action to get car based on id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCar($id)
    {
        $car = Car::find($id);

        return response()->json($car);
    }

    /**
     * Action to update car based on request and id
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCar(Request $request, $id)
    {
        $car = Car::find($id);

        $car->model = $request->input('model');
        $car->brand = $request->input('brand');
        $car->price = $request->input('price');
        $car->year = $request->input('year');
        $car->image = $request->input('image');

        $car->save();

        return response()->json($car);
    }

    /**
     * Action to delete car based on id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCar($id)
    {
        $car = Car::find($id);
        $car->delete();

        return response()->json('deleted');
    }

}
