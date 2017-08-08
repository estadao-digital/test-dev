<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TestDev\Classes\Carro;
use TestDev\Repositories\CarroRepository;
use TestDev\Repositories\MarcaRepository;
use Response;

class CarroController extends Controller
{
	public function __construct() {
		$carro = new Carro;
	}

    public function getcarros() {
    	$carroRepository = new CarroRepository;
        $carros = $carroRepository->getCarros();
        $marcaRepository = new MarcaRepository;
        $marcas = $marcaRepository->getMarcas();
        unset($carroRepository);
        unset($marcaRepository);
        return view('index')->with('carros', $carros)->with('marcas', $marcas);
    }

    public function storeCarro(Request $request) {

    }

    public function getCarro($id) {
        $carroRepository = new carroRepository;
        $carro = $carroRepository->getCarro($id);
        return Response::json($carro);
    }

    public function updateCarro(Request $request, $id) {

    }

    public function deleteCarro($id) {

    }
}
