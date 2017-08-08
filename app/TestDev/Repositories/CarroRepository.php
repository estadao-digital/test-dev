<?php 

namespace TestDev\Repositories;


use TestDev\Models\Carro;
use DB;

class CarroRepository
{

	public function getCarro($id) {
		return Carro::Find($id);
  }

  public function getCarros() {
    return DB::table('carros')->join('marcas', 'marcas.id', '=', 'carros.marca')->join('modelos', 'modelos.id', '=', 'carros.modelo')->select('carros.*', 'marcas.marca as marca', 'modelos.modelo as modelo')->paginate(6);
  }

  public function storeCarro($data) {
    $car = new Carro;
    $car->marca = $data->marca;
    $car->modelo = $data->modelo;
    $car->ano = $data->ano;
    $car->save();
    $carfill = DB::table('carros')->join('marcas', 'marcas.id', '=', $car->marca)->join('modelos', 'modelos.id', '=', $car->modelo)->select('carros.*', 'marcas.marca as marca', 'modelos.modelo as modelo')->where('carros.id', '=', $car->id)->get();
    return $carfill;
  }

  public function updateCarro($request, $id) {
    return Carro::where('id', $id)->update([
      'marca' => $request->marca,
      'modelo' => $request->modelo,
      'ano' => $request->ano,
      ]);
  }


  public function deleteCarro($id) {
    $car = Carro::find($id);
    $car->delete();
  }

  	
}