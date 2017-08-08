<?php 

namespace TestDev\Repositories;


use TestDev\Models\Modelo;
use DB;

class ModeloRepository
{

  public function getModelo($id) {
    return Modelo::Find($id);
  }

  public function getModelos($id) {
    return Modelo::select('*')->where('marca', '=', $id)->select('*')->get();
  }

  public function getCarroModelo($id) {
    return DB::table('carros')->join('modelos', 'modelos.id', '=', 'carros.modelo')->select('modelo.*')->get();
  }

  public function getAll() {
    return Modelo::All();
  }

  public function storeModelo($data) {
    $modelo = new Modelo;
     $modelo->marca = $data->marca;
    $modelo->modelo = $data->modelo;
    $modelo->save();
    return $modelo;
  }

  public function updateModelo($request, $id) {
    return Modelo::where('id', $id)->update([
      'marca' => $request->marca,
      'modelo' => $request->modelo,
      ]);
  }


  public function deleteCar($id) {
    $modelo = Modelo::find($id);
    $modelo->delete();
  }

    
}