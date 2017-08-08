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

  public function storeModelo($data) {
    $modelo = new Modelo;
    $modelo->Modelo = $data->modelo;
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