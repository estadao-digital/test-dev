<?php

namespace App\v1\Controllers;

class CarrosController extends BaseController
{
    public function listCarros($request, $response, $args)
    {
        // $carros = \App\Models\CarrosModel::select()->with('marca')->get();

        $carros = \App\Models\CarrosModel::select('id', 'modelo', 'ano', 'id_marca')
            ->with(['marca' => function ($query) {
                $query->select('id', 'nome');
        }])->get();

        $return = $response->withJson((object) $carros, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function listCarro($request, $response, $args)
    {
        $id = $args['id'];

        $carros = \App\Models\CarrosModel::where('id', $id)->select('id', 'modelo', 'ano', 'id_marca')
            ->with(['marca' => function ($query) {
                $query->select('id', 'nome');
        }])->get();

        $return = $response->withJson((object) $carros->first(), 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function createCarro($request, $response, $args)
    {
		$params = (object) $request->getParams();
		
		$carro = new \App\Models\CarrosModel;
	
		$carro->modelo = $params->modelo;
		$carro->id_marca = $params->id_marca;
		$carro->ano = $params->ano;
		$carro->save();
		
		
		$return = $response->withJson((object) $carro, 200)
		->withHeader('Content-type', 'application/json');

        
        return $return;
    }

    public function updateCarro($request, $response, $args)
    {
		$id = (int) $args['id'];
		
		$params = (object) $request->getParams();
		
		$carro = \App\Models\CarrosModel::find($id);
		
		if (!$carro) {
			$return = $response->withJson( (object) ["message" => "Carro não encontrado!"], 404)
            ->withHeader('Content-type', 'application/json');
			return $return;
		}
		
		$carro->modelo = $params->modelo;
		$carro->id_marca = $params->id_marca;
		$carro->ano = $params->ano;
		$carro->save();
		
		/*
		$dadosAtualizar = [
			'modelo' => $params->modelo,
			'ano' => $params->ano,
			'id_marca' => $params->id_marca,
		];
		
		$carrosAtualizado = \App\Models\CarrosModel::where('id', $id)->update($dadosAtualizar);
		*/
		
        $return = $response->withJson( (object) $carro, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function deleteCarro($request, $response, $args)
    {
		$id = (int) $args['id'];
		
		$carro = \App\Models\CarrosModel::find($id);
		
		if (!$carro) {
			$return = $response->withJson(["message" => "Carro não encontrado!"], 404)
            ->withHeader('Content-type', 'application/json');
			return $return;
		}
		
		$carro->delete();
		
		//$carroDeletado = \App\Models\CarrosModel::where('id', $id)->delete();
		
        $return = $response->withJson((object) $request->getHeader('Accept'), 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }
}