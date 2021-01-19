<?php

    $method = $_SERVER['REQUEST_METHOD'];
    $resource = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
    $contains = file_get_contents('php://input');

    include('../model/Carro.php');


    // var_dump($method);
    // var_dump($resource);
    // var_dump($contains);

    switch ($method) {
    case 'PUT':
        parse_str($contains);
        $c = new Carro();
        $c->setId($resource[0]);
        $c->read();
        $c->setMarca($marca);
        $c->setModelo($modelo);
        $c->setAno($ano);
        $c->update();
        break;
    case 'POST':
        $c = new Carro();
        $c->setMarca($_POST['marca']);
        $c->setModelo($_POST['modelo']);
        $c->setAno($_POST['ano']);
        echo json_encode($c->create());
        break;
    case 'GET':
        if(!empty($resource[0])){
            $c = new Carro();
            $c->setId($resource[0]);
            $c->read();
            echo json_encode($c->jsonMount());
        }else{
            echo json_encode(Carro::list());
        }
        break;
    case 'DELETE':
        $c = new Carro();
        $c->setId($resource[0]);
        echo json_encode($c->delete());
        break;
    default:
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
        die('{"msg": "Método não encontrado."}');  
        break;
    }

?>