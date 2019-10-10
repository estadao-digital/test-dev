<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Carro;

class CarroController extends Controller
{
    public function listarCarros() 
    {
        $carros = Carro::all();

        return response()->json([
            'success'=>true, 
            'message' => "" , 
            'data' => $carros
        ], 200);
    }

    public function obterCarro($id) 
    {
        $carro = Carro::where("id", $id)->get();

        return response()->json([
            'success'=>true, 
            'message' => "" , 
            'data' => $carro
        ], 200);
    }

    public function deletarCarro($id) 
    {
        $carro = Carro::where("id", $id)->delete();

        return response()->json([
            'success'=>true, 
            'message' => "carro deletado com sucesso!" , 
            'data' => []
        ], 200);
    }

    public function registrarCarro(Request $request) 
    {
        $dados =  (object) json_decode($request->getContent());

        $validator = Validator::make((array)$dados, Carro::rules());

        if ($validator->fails()) 
            return response()->json(['error'=>$validator->errors()], 401);            
        
        $carro = Carro::create([
            "marca" => $dados->marca,
            "modelo" => $dados->modelo,
            "ano" => $dados->ano,
            "custo" => $dados->custo,
            "placa" => $dados->placa,
            "venda" => $dados->venda,
            "cambio" => $dados->cambio
        ]);

        return response()->json([
            'success'=>true, 
            'message' => "Carro cadastrado com sucesso!" , 
            'data' => $carro
        ], 200);
    }

    public function atualizarCarro(Request $request) 
    {
        $dados =  (object) json_decode($request->getContent());

        $validator = Validator::make((array)$dados, Carro::rules());

        if ($validator->fails()) 
            return response()->json(['error'=>$validator->errors()], 401);

        $carro = Carro::where("id", $dados->id)->update([
            "marca" => $dados->marca,
            "modelo" => $dados->modelo,
            "ano" => $dados->ano,
            "custo" => $dados->custo,
            "placa" => $dados->placa,
            "venda" => $dados->venda,
            "cambio" => $dados->cambio
        ]);

        return response()->json([
            'success'=>true, 
            'message' => "Carro atualizado com sucesso!" , 
            'data' => Carro::find($dados->id)
        ], 200);
    }
}
