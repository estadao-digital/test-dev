<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Model\Brand;
use App\Model\Car;
use App\Services\CarService;
use Illuminate\Http\Request;


class CarController extends Controller
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function index(Request $request)
    {
        $cars = Car::query()
            ->orderBy('model')
            ->get();

        $brands = Brand::query()
            ->orderBy('name')
            ->get();

        $message = $request->session()->get('message');

        return view('cars.index', compact('cars', 'brands','message'));
    }

    public function create(Request $request)
    {

        return view('cars.create');
    }

    public function store(CarRequest $request)
    {
        $request->only('marca', 'modelo', 'ano');
        $data = $request->validated();

        $car = $this->carService->registerCar($data['marca'], $data['modelo'], $data['ano']);

        if ($car instanceof \RuntimeException) {
            return response()->json(['message' => $car->getMessage()]);
        }

        return response()->json(['message' => 'Carro cadastrado com sucesso.']);
    }


    public function show($id)
    {
        $car = $this->carService->getCarById($id);

        if ($car instanceof \RuntimeException) {
            return response()->json(['message' => $car->getMessage()], 400);
        }

        return response()->json($car, 200);
    }

    public function edit($id)
    {
        //
    }

    public function update(CarRequest $request, $id)
    {
        $request->only('marca', 'modelo', 'ano');
        $data = $request->validated();

        $car = $this->carService->alterCarInformation($id, $data['marca'], $data['modelo'], $data['ano']);

        if ($car instanceof \RuntimeException) {
            return response()->json(['message' => $car->getMessage()], 400);
        }

        return response()->json(['message' => 'Carro atualizado com sucesso.'], 200);
    }

    public function destroy(Request $request, $id)
    {
        $car = $this->carService->deleteCar($id);

        if ($car instanceof \RuntimeException) {
            return redirect()->route('carros')->with('error', 'Erro ao localizar o register do carro informado.');
        }

        return redirect()->route('carros')->with('success','Carro excluído com sucesso.');
    }
}
