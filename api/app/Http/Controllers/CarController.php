<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;


class CarController extends Controller
{
    public function index()
    {
        $cars = Car::jsonAll();
        return response()->json($cars);
    }

     public function create(Request $request)
     {
        $cars = Car::jsonCreate($request->json()->all());
        return response()->json($cars);
     }

     public function show($id)
     {
        $cars = Car::jsonByid($id);
        return response()->json($cars);
     }

     public function update(Request $request, $id)
     {
        $car = Car::jsonUpdate($request->json()->all(), $id);
        return response()->json($car);
     }

     public function destroy($id)
     {
        // $cars = Car::jsonDeleteById($id);
        // return response()->json($cars);

        if(Car::jsonDeleteById($id))
            return response()->json('Carro removido com sucesso!!!');
     }

}
