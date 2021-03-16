<?php

  include  'classes/conexao.php';
  include  'functions/util.php';
  include  'classes/carro.php';
  $c1 = new Mysql();
  $conn = $c1->ConectaMysql();
  $method = trim($_SERVER['REQUEST_METHOD']);


  switch ($method) {
    case 'GET':
      if($_GET['id']){
        $c1 = new Carros($_GET['id'],NULL, NULL, NULL,$conn);
        echo $c1->getCarro();
      }
      else{
        $c1 = new Carros(NULL,NULL, NULL, NULL,$conn);
        echo $c1->getCarros();
      }
    break;
    case 'POST':
      $c1 = new Carros(NULL,$_POST['marca'],$_POST['modelo'],$_POST['ano'],$conn);
      $addCarro = $c1->addCarro();
    break;
    case 'PUT':
    $data = convertPuttoarray();
    $c1 = new Carros($data['id'],$data['marca'],$data['modelo'],$data['ano'],$conn);
    echo $c1->updateCarro();
    break;
    case 'DELETE':
    $data = file_get_contents('php://input');
    $data = str_replace('id=','',$data);
    $c1 = new Carros($data, NULL,NULL,NULL,$conn);
    echo $c1->deleteCarro();
    break;
    default:
     header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
     die('{"msg": "Método não encontrado."}');
   break;
  }
  http_response_code(200);
?>
