<?php
$c1 = new Mysql();
 class Carros{
  private $id;
  private $marca;
  private $modelo;
  private $ano;
  private $conn;

  function __construct($id,$marca,$modelo,$ano,$conn){
    $this -> id     = $id;
    $this -> marca  = $marca;
    $this -> modelo = $modelo;
    $this -> ano    = $ano;
    $this -> conn   = $conn;
  }

  function addCarro(){
    $sql = "INSERT INTO CARROS (MARCA, MODELO, ANO) VALUES('{$this->marca}','{$this->modelo}','{$this->ano}')";
    $query = mysqli_query($this->conn,$sql)or die(mysqli_error());
    $id = mysqli_insert_id($conn);
    $array = array("msg" =>"Carro cadastrado com Sucesso", "id"=>$id);
    return json_encode($array);
  }
  function updateCarro(){
    $sql = "UPDATE CARROS SET MARCA = '{$this->marca}',MODELO='{$this->modelo}',ANO ='{$this->ano}' WHERE ID = '{$this->id}'";
    $query = mysqli_query($this->conn,$sql)or die(mysqli_error());
    $array = array("msg" =>"Carro atualizado com Sucesso", "id"=>$id);
    return json_encode($array);
  }
  function deleteCarro(){
    $sql = "DELETE FROM CARROS WHERE ID ='{$this->id}'";
    $query = mysqli_query($this->conn,$sql)or die(mysqli_error());
    $array = array("msg" =>"Carro deletado com Sucesso", "id"=>$id);
    return json_encode($array);
  }

  function getCarro(){
    $sql = "SELECT CARROS.ID, MARCA.DESCRICAO AS MARCA,MARCA.ID AS ID_MARCA,CARROS.MODELO, CARROS.ANO
            FROM CARROS
            LEFT JOIN MARCA ON MARCA.ID = CARROS.MARCA
            WHERE CARROS.ID = '{$this->id}'";
    $query = mysqli_query($this->conn,$sql) or die(mysqli_error());
    $check = mysqli_num_rows($query);
    if($check > 0 ){
      while($temp = mysqli_fetch_array($query)){
        $id        = $temp['ID'];
        $id_marca  = $temp['ID_MARCA'];
        $marca     = $temp['MARCA'];
        $modelo    = $temp['MODELO'];
        $ano       = $temp['ANO'];
        $array = array('id'        => $id,
                       'id_marca'  => $id_marca,
                       'marca'     => $marca,
                       'modelo'    => $modelo,
                       'ano'       => $ano);
      }
    }
    else{
      $array = array("error"=> 404,"msg" =>"Erro carro não encontrado");
    }

    return json_encode($array);
  }
  function getCarros(){
    $ArrayCarros = array();
    $sql = "SELECT CARROS.ID, MARCA.DESCRICAO AS MARCA,CARROS.MODELO, CARROS.ANO
            FROM CARROS
            LEFT JOIN MARCA ON MARCA.ID = CARROS.MARCA";
    $query = mysqli_query($this->conn,$sql) or die(mysqli_error());
    while($temp = mysqli_fetch_array($query)){
      $id     = $temp['ID'];
      $marca  = $temp['MARCA'];
      $modelo = $temp['MODELO'];
      $ano    = $temp['ANO'];
      $array = array('id'     => $id,
                     'marca'  => $marca,
                     'modelo' => $modelo,
                     'ano'    => $ano);
      array_push($ArrayCarros,$array);
    }
    return json_encode($ArrayCarros);
  }
  function getMarcas(){
    $ArrayMarcas = array();
    $sql = "SELECT ID, DESCRICAO FROM MARCA";
    $query = mysqli_query($this->conn,$sql) or die(mysqli_error());
    while($temp = mysqli_fetch_array($query)){
      $id         = $temp['ID'];
      $descricao  = $temp['DESCRICAO'];
      $array = array('id'         => $id,
                     'descricao'  => $descricao);
      array_push($ArrayMarcas,$array);
    }
    return json_encode($ArrayMarcas);
  }





 }

 ?>
