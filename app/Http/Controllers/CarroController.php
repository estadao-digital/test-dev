<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carro;

class CarroController extends Controller
{
    public function listarCarros() 
    {
        $carros = Carro::all();
    }

    public function obterCarro($idCarro) 
    {
        $carro = Carro::where("id", $idCarro)->get();
    }

    public function deletarCarro($idCarro) 
    {
        $carro = Carro::where("id", $idCarro)->delete();
    }

    public function registrarCarro(Request $request) 
    {
        $dados = $request->all();

        $validade = Validator::validate();

        $carro = Carro::create([
            "marca" => $dados->marca,
            "modelo" => $dados->modelo,
            "ano" => $dados->ano,
            "custo" => $dados->custo,
            "placa" => $dados->placa,
            "venda" => $dados->venda,
        ]);
    }

    public function atualizarCarro(Request $request) 
    {
        $dados = $request->all();

        $carro = Carro::where("id", $dados->idCarro)->update([
            "marca" => $dados->marca,
            "modelo" => $dados->modelo,
            "ano" => $dados->ano,
            "custo" => $dados->custo,
            "placa" => $dados->placa,
            "venda" => $dados->venda,
        ]);
    }
}
