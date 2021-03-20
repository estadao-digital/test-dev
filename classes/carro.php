<?php
 class Carros{
  private $id;
  private $marca;
  private $modelo;
  private $ano;
  private $conn;

  function __construct($id,$marca,$modelo,$ano){
    $this -> id     = $id;
    $this -> marca  = $marca;
    $this -> modelo = $modelo;
    $this -> ano    = $ano;
  }

  function addCarro(){
    if($this->id == NULL){$id = uniqid();}
    else{$id = $$this->id;}

    $array = array(
      'id'     => $id,
      'marca'  => $this->marca,
      'modelo' => $this->modelo,
      'ano'    => $this->ano,
    );
    $json = file_get_contents("db/carros.json");
    $json = json_decode($json,true);
    if($json['0']==NULL) $json = array();
    array_push($json,$array);
    $json_editado = file_put_contents('db/carros.json',json_encode($json));
    $array = array("msg" =>"Carro cadastrado com Sucesso", "id"=>$id);
    return json_encode($array);
  }

  function deleteCarro(){
    $ArrayCarros = array();
    $json = file_get_contents("db/carros.json");
    $json = json_decode($json,true);
    foreach ($json as $key => $value) {
      if($value['id'] == $this->id){
        unset($value);
      }
      array_push($ArrayCarros,$value);
  }
  $json_editado = file_put_contents('db/carros.json',json_encode($ArrayCarros));
  $array = array("msg" =>"Carro deletado com Sucesso", "id"=>$this->id);
  return json_encode($array);
  }


  function updateCarro(){
    $ArrayCarros = array();
    $json = file_get_contents("db/carros.json");
    $json = json_decode($json,true);
    foreach ($json as $key => $value) {
      if($value['id'] == $this->id){
        $value['modelo'] = $this->modelo;
        $value['marca']  = $this->marca;
        $value['ano']    = $this->ano;
      }
      array_push($ArrayCarros,$value);
  }
  $json_editado = file_put_contents('db/carros.json',json_encode($ArrayCarros));
  $array = array("msg" =>"Carro atualizado com Sucesso", "id"=>$value['id']);
  return json_encode($array);
}

  function getCarro(){
    $json = file_get_contents("db/carros.json");
    $json = json_decode($json,true);
    foreach ($json as $key => $value) {
      if($value['id'] == $this->id){
        $array = array('id'        => $value['id'],
                       'marca'     => $value['marca'],
                       'modelo'    => $value['modelo'],
                       'ano'       => $value['ano']);
        return json_encode($array);
      }
    }
  }
  function getCarros(){
    $json = file_get_contents("db/carros.json");
    return $json;
  }
  function getMarcas(){
    $json = file_get_contents("../db/marcas.json");
    return $json;
  }
 }

 ?>
