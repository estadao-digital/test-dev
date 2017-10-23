<?php

namespace App\Http\Controllers;

use App\Car;
use App\CarBrand;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Car::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required|string|max:255',
            'year' => 'required|string',
            'brand_id' => 'required|integer|exists:car_brands,id',
        ]);

        $car = new Car;
        $car->model = $request->get('model');
        $car->year = $request->get('year');
        $brand = CarBrand::find($request->get('brand_id'));

        $car->brand()->associate($brand);

        $car->save();
        return response($car, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        return $car;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'model' => 'required|string|max:255',
            'year' => 'required|string',
            'brand_id' => 'required|integer|exists:car_brands,id',
        ]);
        $car->model = $request->get('model');
        $car->year = $request->get('year');
        $brand = CarBrand::find($request->get('brand_id'));

        $car->brand()->associate($brand);

        $car->save();
        return $car;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return response(null, 204);
    }
}
