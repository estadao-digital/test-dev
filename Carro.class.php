<?php
class Carro {
  
  public function salvaCarro($carro){

  }
  public function getCarros(){
    $arquivo = "json.json";

    $info = file_get_contents($arquivo);
  
    $obj = stripslashes($info); 
    $lendo = json_decode( $obj,true);
    $arrayCarro = array();
    foreach($lendo as $campo){

      $arrayCarro[] = array('id'=> $campo['id'], 'carro' => $campo['carro'], 'marca' => $campo['marca'], 'ano' =>$campo['ano']);

    }
    return $arrayCarro;
  }

  public function getMarcas(){
    $arquivo = "marca.json";

    $info = file_get_contents($arquivo);
  
    $obj = stripslashes($info); 
    
    $lendo = json_decode( $obj,true);
    $arrayMarca = array();
    foreach($lendo as $campo){

      $arrayMarca[] = array('marca'=> $campo['marca']);

    }

    return $arrayMarca;
  }

  
  
}