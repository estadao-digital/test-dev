<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TestDev\Repositories\ModeloRepository;
use Response;

class ModeloController extends Controller
{

    public function getModelos($id) {
    	$modeloRepository = new ModeloRepository;
        $modelos = $modeloRepository->getModelos($id);
        unset($modeloRepository);
        return Response::json($modelos);
    }

 
}
