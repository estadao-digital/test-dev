<?php 

namespace TestDev\Repositories;


use TestDev\Models\Marca;
use DB;

class MarcaRepository
{

  public function getMarca($id) {
    return Car::Find($id);
  }

  public function getMarcas() {
    return Marca::All();
  }

  public function storeMarca($data) {
    $marca = new Marca;
    $marca->marca = $data->marca;
  }

  public function updateMarca($request, $id) {
    return Marca::where('id', $id)->update([
      'marca' => $request->marca,
      ]);
  }


  public function deleteCar($id) {
    $marca = Marca::find($id);
    $marca->delete();
  }

  	
}