<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class CarrosController extends Controller
{
    
    public function index() {

        return carros::all();

    }

    public function store(Request $request) {

        $car = carros::create([
            "id"=>$request->input("id"),
            "marca"=>$request->input("marca")
            "modelo"=>$request->input("modelo")
            "ano"=>$request->input("ano")
        ]);

        return $car;

    }

    public function update(Request $request, User $car) {

        $car->name = $request->input('marca');
        $car->email = $request->input('modelo');
        $car->ano = $request->input('ano');

        $car->save();

        return $car;

    }

    public function remove(User $car) {

        $car->delete();

        return response()->json([
            'message'=>'Carro excluído com sucesso'
        ]);

    }

}
