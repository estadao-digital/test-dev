<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        return Car::all();
    }

    public function store(StoreCarRequest $request)
    {
        Car::create($request->all());
    }

    public function show(Int $id)
    {
        return Car::findOrFail($id);
    }

    public function update(UpdateCarRequest $request, Int $id)
    {
        $car = Car::findOrFail($id);
        $car->update($request->all());
    }


    public function destroy(Int $id)
    {
        $car = Car::findOrFail($id);
        $car->delete();
    }
}
