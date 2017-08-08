<?php 

namespace TestDev\Repositories;


use TestDev\Models\Car;


class CarRepository
{

	public function getCar($id) {
		return Car::select('*')->where('id', '=', $id)->get();
  }

  public function getCars() {
    return Car::select('*')->paginate(6);
  }

  public function storeCar($data) {
    $car = new Car;
    $car->marca = $data->marca;

  }

  public function updateCar($request, $id) {
    return Car::where('id', $id)->update([
      'marca' => $request->marca,
      'modelo' => $request->modelo,
      'ano' => $request->ano,
      ]);
  }


  public function deleteCar($id) {
    $car = Car::find($id);
    $car->delete();
  }

  	
}