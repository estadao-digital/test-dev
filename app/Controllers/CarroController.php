<?php

namespace App\Controllers;

use App\Models\Carro;

class CarroController {

    private $carro;

    public function __construct()
    {
        $this->carro = new Carro();
    }

    public function index($id = null)
    {
        $carros = $this->carro->getCars($id);

        return json_encode($carros);
    }

    public function store()
    {
        $carro = $this->carro->saveCar(file_get_contents('php://input'));
        
        return json_encode($carro);
    }

    public function update($id)
    {
        $carros = $this->carro->updateCar($id, file_get_contents('php://input'));

        return json_encode($carros);
    }

    public function destroy($id)
    {
        $carros = $this->carro->deleteCar($id);

        return json_encode($carros);
    }

}