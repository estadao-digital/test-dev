<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\BaseController;
use App\Http\Resources\CarResource;

class CarController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::with('brand')->get();
        return $this->sendResponse(CarResource::collection($cars), 'Carros Retornadas com sucesso!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'model' => 'required|min:2'
        ],
        [
            'model.required' => 'Preencha o modelo.',
            'model.min' => 'O modelo deve conter 2 ou mais caracteres.'
        ]);

        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());
        }

        $car = Car::create($input);

        return $this->sendResponse(new CarResource($car), 'Carro criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = $this->exists($id);

        if($car){
            return $this->sendResponse(new CarResource($car), 'Carro recuperado com sucesso.');
        }else{
            return $this->sendError('Carro não encontrado.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'model' => 'required|min:2'
        ],
        [
            'model.required' => 'Preencha o modelo.',
            'model.min' => 'O modelo deve conter 2 ou mais caracteres.'
        ]);

        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());
        }

        if($car){
            $car->brand_id = $input['brand_id'];
            $car->model = $input['model'];
            $car->year = $input['year'];
            $car->description = $input['description'];
            $car->amount = $input['amount'];
           // $car->image = $input['image'];
            $car->save();
            return $this->sendResponse(new CarResource($car), 'Carro atualizado com sucesso.');
        }else{
            return $this->sendError('Carro não encontrado.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = $this->exists($id);

        if($car){
            $car->delete();
            return $this->sendResponse([], 'Carro excluido com sucesso.');
        }else{
            return $this->sendError('Carro não encontrada.');
        }
    }

    public function upload($id ,Request $request)
    {
        $car = $this->exists($id);
        if(!$car )
            return $this->sendError('Carro não encontrado.');

        $validator = Validator::make($request->all(),[
        'file' => 'required|mimes:jpg,png|max:2048',
        ]);

        if($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        if ($file = $request->file('file')){
            $path = $file->store('',['disk' => 'uploads_car']);
            $car->image = $path;
            $car->save();

            return response()->json([
            "success" => true,
            "message" => "Arquivo salvo com sucesso",
            "file" => $path
            ]);
        }
    }

    public function exists($id)
    {
        $car = Car::with('brand')->find($id);
        if($car)
            return $car;
        else
            return false;
    }
}
