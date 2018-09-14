<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ContatoEnviarRequest;
use App\model\carrosmodel;

class HomeController extends Controller
{

    public function index()
    {
        $carro = carrosmodel::all();
        return view('home.index')->with('carro' ,$carro);
    }

    public function insertdata(Request $request)
    {
        $carro = new carrosmodel();
        $carro->fabricante = $request->fabricante;
        $carro->modelo = $request->modelo;
        $carro->ano = $request->ano;
        $carro->preco = $request->preco;
        $carro->save();
        return response()->json($carro);
    }

    public function updatedata(Request $request)
    {
        $carro = carrosmodel::find($request->id);
        $carro->fabricante = $request->fabricante;
        $carro->modelo = $request->modelo;
        $carro->ano = $request->ano;
        $carro->preco = $request->preco;
        $carro->save();
        return response()->json($carro);
    }

    public function deletedata(Request $request)
    {
        carrosmodel::where('id', $request->id)->delete();
        return response()->json();
    }
}
