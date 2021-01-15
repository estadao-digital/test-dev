<?php


namespace App\Models;


use Illuminate\Support\Facades\Storage;

class Carros
{
    public $id;
    public $marca;
    public $modelo;
    public $ano;

    public function __construct($id){
        $car = $this->loadCar($id);
        $this->id = $car->id;
        $this->marca = $car->marca;
        $this->modelo = $car->modelo;
        $this->ano = $car->ano;
    }
    private function loadCar($id){
       return JsonService::get($id);
    }
}
