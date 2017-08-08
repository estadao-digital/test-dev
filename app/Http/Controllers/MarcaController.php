<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TestDev\Repositories\MarcaRepository;
use Response;

class MarcaController extends Controller
{

   public function storeMarca(Request $request) {
    $marcaRepository = new MarcaRepository;
    $marca = $marcaRepository->storeMarca($request);
    return Response::json($marca);
   }

   public function getMarcas() {
    $marcaRepository = new MarcaRepository;
    $marcas = $marcaRepository->getMarcas();
    return Response::json($marcas);
   }

 
}
