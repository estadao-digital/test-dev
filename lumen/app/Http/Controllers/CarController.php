<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAll(Request $request)
    {
        try {
            $cars = Car::all();

            return $this->sendResponse($cars, "Registros encontrados.");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $get->code() ?? 400);
        }
    }

    public function get($id)
    {
        try {
            $car = Car::find($id);

            if (!$car) {
                return $this->sendResponse([], 'Registro não encontrado!');
            }

            return $this->sendResponse($car, "Registros inseridos.");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $get->code() ?? 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'brand' => 'required',
                'model' => 'required',
                'year' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors(), 200);
            }

            $car = new Car();
            $car->id = time();
            $car->brand = $request->brand;
            $car->model = $request->model;
            $car->year = $request->year;
            $car->save();

            return $this->sendResponse($car, "Registro inserido com sucesso.");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $car = Car::find($id);

            if (!$car) {
                return $this->sendResponse([], 'Registro não encontrado!');
            }

            $validator = Validator::make($request->all(), [
                'brand' => 'required',
                'model' => 'required',
                'year' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors(), 200);
            }

            $car->brand = $request->brand ?? $car->brand;
            $car->model = $request->model ?? $car->model;
            $car->year = $request->year ?? $car->year;
            $car->save();

            return $this->sendResponse($car, "Registro atualizado com sucesso.");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        try {
            $car = Car::find($id);

            if (!$car) {
                return $this->sendError('Registro não encontrado!', 200);
            }

            $car->delete();

            return $this->sendResponse($car, 'Registro removido com sucesso.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }
}
