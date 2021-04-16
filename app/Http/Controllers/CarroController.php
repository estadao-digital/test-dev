<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Carro;
use App\Marca;

class CarroController extends Controller
{
    public function indexView()
    {
        $marcas = Marca::all();
        return view('carros', compact('marcas'));
    }

    public function index()
    {
        $carros = Carro::all();
        return $carros->toJson();
    }

    public function store(Request $request)
    {
        $carro = new Carro();
        $carro->modelo = $request->input('modelo');
        $carro->marca_id = $request->input('marca_id');
        $carro->ano = $request->input('ano');
        $carro->descricao = $request->input('descricao');
        $carro->save();
        return json_encode($carro);
    }

    public function show($id)
    {
        $carro = Carro::find($id);
        if (isset($carro)) {
            return json_encode($carro);            
        }
        return response('carrouto não encontrado', 404);
    }


    public function update(Request $request, $id)
    {
        $carro = Carro::find($id);
        if (isset($carro)) {
            $carro->marca_id = $request->input('marca_id');
            $carro->modelo = $request->input('modelo');
            $carro->ano = $request->input('ano');
            $carro->descricao = $request->input('descricao');
            $carro->save();
            return json_encode($carro);
        }
        return response('Carro não encontrado', 404);
    }

    public function destroy($id)
    {
        $carro = Carro::find($id);
        if (isset($carro)) {
            $carro->delete();
            return response('OK', 200);
        }
        return response('Carro não encontrado', 404);
    }
}
