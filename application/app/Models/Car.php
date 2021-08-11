<?php

namespace App\Models;

class Car
{
  public $key;
  public $lastId;
  public $array = [];

  public function getUrlSegment($segment)
  {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $urlExplode = explode('/', $url);
    $urlSegment = $urlExplode[$segment];
    return $urlSegment;
  }

  public function getArrayKey($array, $segment)
  {
    foreach ($array as $value) {
      if ($value['id'] === $segment) {
        $this->key = array_search($segment, array_column($array, 'id'));
        return $this->key;
      }
    }
  }

  public function getArrayLastKey($array)
  {
    $lastKey = array_key_last($array);

    foreach ($array as $key => $value) {
      if ($key === $lastKey) {
        $this->lastId = $value['id'];
        return $this->lastId;
      }
    }
  }

  public function idAutoIncrement($lastId)
  {
    $lastIdAutoIncrement = (integer)$lastId + 1;
    $newId = (string)$lastIdAutoIncrement;
    return $newId;
  }

  public function getArray($array, $arrayKey)
  {
    foreach ($array as $key => $value) {
      if ($key === $arrayKey) {
        $this->array['id'] = $value['id'];
        $this->array['brand'] = $value['brand'];
        $this->array['model'] = $value['model'];
        $this->array['year'] = $value['year'];
        return $this->array;
      }
    }
  }

  public function insertArray($newId, $array)
  {
    $car = [
      'id' => $newId,
      'brand' => $_POST['brand'],
      'model' => $_POST['model'],
      'year' => $_POST['year'],
    ];
    array_push($array, $car);
    return $array;
  }

  public function replaceArray($segment)
  {
    if ('PUT' === $_SERVER['REQUEST_METHOD']) {
      parse_str(file_get_contents('php://input'), $_PUT);
      $this->array['id'] = $segment;
      $this->array['brand'] = $_PUT['brand'];
      $this->array['model'] = $_PUT['model'];
      $this->array['year'] = $_PUT['year'];
      return $this->array;
    }
  }

  public function destroy($array, $segment)
  {
    $key = $this->getArrayKey($array, $segment);
    unset($array[$key]);
    return array_values($array);
  }

}
