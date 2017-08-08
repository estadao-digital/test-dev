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
        return response()->json(['modelos' => $modelos]);
    }

    public function getCarroModelo($id) {
        $modeloRepository = new ModeloRepository;
        $modeloCarro = $modeloRepository->getModeloCarro($id);
        unset($modeloRepository);
        return response()->json(['modelo' => $modeloCarro]);
    }

    public function storeModelo(Request $request) {
    $modeloRepository = new ModeloRepository;
    $modelo = $modeloRepository->storeMarca($request);
    return Response::json($modelo);
   }

 
}
