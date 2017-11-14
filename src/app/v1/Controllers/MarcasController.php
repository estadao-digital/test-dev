<?php

namespace App\v1\Controllers;

class MarcasController extends BaseController
{
    public function listMarcas($request, $response, $args)
    {
        $marcas = \App\Models\MarcasModel::select('id', 'nome')->orderBy('nome', 'ASC')->get();

        $return = $response->withJson((object) $marcas, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }
}