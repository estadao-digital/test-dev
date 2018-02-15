<?php

namespace App\Mvc\Service;

class CarJsonData{
    private $file;
    private $arrayData;
    
    function __construct(){
        $path = getcwd();
        $this->file = $path . "\json\car.json";

        $this->arrayData = json_decode(file_get_contents($this->file), true);
    }

    public function get($id)
    {   
        $result = $id != null ? $this->getById($id) : $this->arrayData;
        echo json_encode($result);
    }
    
    public function getById($id){
        if($this->ifValidId($id)){
            foreach($this->arrayData as $key => $value){
                if($value["id"] == $id){
                    return [$this->arrayData[$key]];
                }
            }
        }
        
        return json_encode(["message" => "Id inválido"]);
    }

    public function create($params){
        $dataValues = [
            "id" => $this->getNewId(),
            "marca" => $params["marca"],
            "modelo" => $params["modelo"],
            "ano" => $params["ano"]
        ];
        
        echo $this->saveArrayDataInFile($dataValues);
    }
    
    public function update($params){
        foreach($this->arrayData as $key => $value){
            if($value["id"] == $params["id"]){
                $this->arrayData[$key]["marca"] = $params["marca"];
                $this->arrayData[$key]["modelo"] = $params["modelo"];
                $this->arrayData[$key]["ano"] = $params["ano"];
            }
        }
        
        echo $this->saveArrayDataInFile();
    }
    
    public function delete($id){
        if($id == null){
            echo false;
        } else {
            foreach($this->arrayData as $key => $value){
                if($value["id"] == $id){
                    unset($this->arrayData[$key]);
                    echo true;
                    break;
                } else {
                    echo 0;
                }
            }
            
            $this->saveArrayDataInFile();
        }
    }

    private function ifValidId($id){
        $pass = true;

        $pass = ($id != null) && $pass; 
        $pass = is_numeric($id) && $pass; 
        
        return $pass;
    }

    private function getNewId(){
        return $this->getLastId() + 1;
    }

    private function getLastId(){
        $lastId = 0;

        foreach($this->arrayData as $key => $value){
            if($value["id"] > $lastId){
                $lastId = $value["id"];
            }
        }
        
        return $lastId;
    }
    
    private function saveArrayDataInFile($dataValues = null){
        if(isset($dataValues)){
            array_push($this->arrayData, $dataValues);
        }
        if(file_put_contents($this->file, json_encode($this->arrayData, JSON_PRETTY_PRINT))){
            return $this->getLastId();
        } else {
            return false;
        }
    }
}