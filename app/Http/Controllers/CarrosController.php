<?php

namespace App\Http\Controllers;

use App\Carro;
use App\Http\Resources\CarroResource;
use Illuminate\Http\Request;

class CarrosController extends Controller
{
    public function index()
    {
        //Procuro no banco de dados todos os carros
        $carros = Carro::all();
        return response(CarroResource::collection($carros));
    }


    public function store(Request $request)
    {
        //validando os dados do lado servidor caso negativo retorna error 422
        $this->validate($request, [
            'marca_id' => 'required',
            'modelo' => 'required',
            'ano' => 'required|numeric|min:1900|max:2019'
        ]);

        //Cria um novo carro com os parametros repassados
        $carro = Carro::create(['marca_id' => $request['marca_id'], 'modelo' => $request['modelo'], 'ano' => $request['ano']]);

        //retorna como resposta o objeto criado o Carro::Resource é apenas uma formatação para os dados incluirem a marca
        return response(CarroResource::make($carro), 200);
    }

    public function show($id)
    {
        //Procura no banco de dados o carro com o $id e retorna formatado
        $carro = CarroResource::make(Carro::find($id));
        return response($carro, 200);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'marca_id' => 'required',
            'modelo' => 'required',
            'ano' => 'required|numeric|min:1900|max:2019'
        ]);

        //procura no banco o carro pelo id
        $carro = Carro::find($id);

        //depois atualizo as informações de acordo com as novas informações se não houver eu mantenho as antigas
        $carro->marca_id = ($request->input('marca_id')) ?: $carro->marca_id;
        $carro->modelo = ($request->input('modelo')) ?: $carro->modelo;
        $carro->ano = ($request->ano) ?: $carro->ano;

        //salvo no banco de dados as alterações
        $carro->save();
        return response(CarroResource::make($carro), 200);
    }


    public function destroy($id)
    {
        //tenta excluir o carro com o id se for um id válido ele exclui se não retorna um código errado
        (Carro::destroy($id)) ? $msg = "deletado com sucesso" : $msg = "erro ao deletar";

        return response($msg);
    }
}
