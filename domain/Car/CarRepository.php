<?php

namespace Domain\Car;


class CarRepository
{

    public function listCars()
    {
        $result = file_get_contents(storage_path('database.json'));

        $cars = json_decode($result, true);

        return $cars;
    }


    public function storeCar($data)
    {
          $db = file_get_contents(storage_path('database.json'));
          $filteredDb = json_decode($db, true);

          $lastElement = end($filteredDb);

          if($lastElement) {
              $data['id'] = $lastElement['id'] + 1;
          }else{
              $data['id'] = 1;
          }


          array_push($filteredDb, $data);

          $jsonData = json_encode($filteredDb);

          $res = file_put_contents(storage_path('database.json'), $jsonData);

          return $res;
    }


    public function showCar($id)
    {
        $db = file_get_contents(storage_path('database.json'));
        $filteredDb = json_decode($db, true);

        $key = array_search($id, array_column($filteredDb, 'id'));

        return $filteredDb[$key];
    }


    public function deleteCar($id)
    {
        $db = file_get_contents(storage_path('database.json'));
        $filteredDb = json_decode($db, true);

        $key = array_search($id, array_column($filteredDb, 'id'));

        unset($filteredDb[$key]);
        $jsonData = json_encode(array_values($filteredDb));

        
        file_put_contents(storage_path('database.json'), $jsonData);

        return ['200'];
    }


    public function updateCar($id, $data)
    {
        $db = file_get_contents(storage_path('database.json'));
        $filteredDb = json_decode($db, true);

        $key = array_search($id, array_column($filteredDb, 'id'));

        if(!$filteredDb[$key]){
            return ['400'];
        }

        $data['id'] = $filteredDb[$key]['id'];
        $filteredDb[$key] = $data;
        $jsonData = json_encode($filteredDb);

        file_put_contents(storage_path('database.json'), $jsonData);

        return ['200'];
    }

    public function getValidationRules()
    {
        return [
            'brand' => 'required|string|in:Chevrolet,Volkswagen,Fiat,Renault,Ford,Toyota,Hyundai',//SERIA EXISTS na tabela de brands
            'model' => 'required|string',
            'year'  => 'required|string|max:4'
        ];
    }



}
