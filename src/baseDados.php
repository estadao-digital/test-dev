<?php

class baseDados
{
    private $carrosJson;

    function __construct() {
       $this->carrosJson =  __DIR__ . '/../data/carros.json';
    }

    public function lerCarros(){             
        $r = null;
        $data = file_get_contents($this->carrosJson);
        if($data)
         $r = json_decode($data, true);        
         return $r;
    }

    public function gravarArquivo($data){
        if(file_put_contents($this->carrosJson, json_encode($data))){
         return true;
        }else{
         return false;
        }        
    }   
}