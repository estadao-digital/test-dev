<?php
namespace App\Mvc\Model;

class Car {
    private $arrayData;
    private $car;

    function __construct(){
        $this->car = new \App\Mvc\Service\CarJsonData();
    }

    public function get($id = null){
        return $this->car->get($id);
    }
    
    public function create($params = null){
        return $this->car->create($params);
    }

    public function update($params = null){
        return $this->car->update($params);
    }

    public function delete($id = null){
        return $this->car->delete($id);
    }
}