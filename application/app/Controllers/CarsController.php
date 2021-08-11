<?php

namespace App\Controllers;

use Core\Json;
use App\Models\Car;

class CarsController
{

  public $jsonpath = './config/cars.json';

  public function read()
  {
    $json = new Json();
    $jsonFile = $json->getJsonFile($this->jsonpath);
    return $json->jsonResponse(200, $jsonFile);
  }

  public function create()
  {
    $car = new Car();
    $json = new Json();

    $jsonFile = $json->getJsonFile($this->jsonpath);
    $phpArray = $json->jsonToPhp($jsonFile);
    $phpArrayId = $car->getArrayLastKey($phpArray);
    $phpArrayNewId = $car->idAutoIncrement($phpArrayId);
    $phpNewArray = $car->insertArray($phpArrayNewId, $phpArray);
    $jsonData = $json->phpToJson($phpNewArray);
    $json->saveJasonFile($this->jsonpath, $jsonData);
    $jsonMessage = $json->jsonMessage('Carro inserido com sucesso');
    return $json->jsonResponse(201, $jsonMessage);
  }

  public function update()
  {
    $car = new Car();
    $json = new Json();

    $urlSegment = $car->getUrlSegment(2);
    $jsonFile = $json->getJsonFile($this->jsonpath);
    $phpArray = $json->jsonToPhp($jsonFile);
    $phpArrayKey = $car->getArrayKey($phpArray, $urlSegment);
    $phpReplacedArray = $car->replaceArray($urlSegment);
    $phpArray[$phpArrayKey] = $phpReplacedArray;
    $jsonData = $json->phpToJson($phpArray);
    $json->saveJasonFile($this->jsonpath, $jsonData);
    $jsonMessage = $json->jsonMessage('Carro atualizado com sucesso');
    return $json->jsonResponse(200, $jsonMessage);
  }

  public function readOne()
  {
    $car = new Car();
    $json = new Json();

    $urlSegment = $car->getUrlSegment(2);
    $jsonFile = $json->getJsonFile($this->jsonpath);
    $phpArray = $json->jsonToPhp($jsonFile);
    $phpArrayKey = $car->getArrayKey($phpArray, $urlSegment);
    $phpSelectedArray = $car->getArray($phpArray, $phpArrayKey);
    $jsonData = $json->phpToJson($phpSelectedArray);
    return $json->jsonResponse(200, $jsonData);
  }

  public function delete()
  {
    $car = new Car();
    $json = new Json();

    $urlSegment = $car->getUrlSegment(2);
    $jsonFile = $json->getJsonFile($this->jsonpath);
    $phpArray = $json->jsonToPhp($jsonFile);
    $phpNewArray = $car->destroy($phpArray, $urlSegment);
    $jsonData = $json->phpToJson($phpNewArray);
    $json->saveJasonFile($this->jsonpath, $jsonData);
    $jsonMessage = $json->jsonMessage('Carro excluído com sucesso');
    return $json->jsonResponse(200, $jsonMessage);
  }

}
