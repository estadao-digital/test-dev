<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TestDev\Classes\Carro;
use TestDev\Repositories\CarroRepository;
use TestDev\Repositories\MarcaRepository;
use TestDev\Repositories\ModeloRepository;
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
        $modeloRepository = new ModeloRepository;
        $modelos = $modeloRepository->getAll();
        unset($carroRepository);
        unset($marcaRepository);
        unset($modeloRepository);
        return view('index')->with('carros', $carros)->with('marcas', $marcas)->with('modelos', $modelos);
    }

    public function storeCarro(Request $request) {
        $carroRepository = new CarroRepository;
        $carro = $carroRepository->storeCarro($request);
        return Response::json($carro);
    }

    public function getCarro($id) {
        $carroRepository = new carroRepository;
        $carro = $carroRepository->getCarro($id);
        return Response::json($carro);
    }

    public function updateCarro(Request $request, $id) {
        $carroRepository = new carroRepository;
        $carro = $carroRepository->updateCarro($request, $id);
    }

    public function deleteCarro($id) {
        $carroRepository = new carroRepository;
        $carro = $carroRepository->deleteCarro($id);
    }
}
