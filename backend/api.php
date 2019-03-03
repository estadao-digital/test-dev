<?php
    require_once('Carro.class.php');

    header('Access-Control-Allow-Origin: *', false);
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X- Request-With');
    header('Content-type: application/json');

    if(!array_key_exists('path', $_GET)){
        echo 'Error path missing';
        exit;
    }

    $path = explode('/', $_GET['path']);
    
    if(count($path) == 0 || $path[0] == ''){
        echo 'Error path missing';
        exit;
    }

    $param = '';
    if(count($path) > 1){
        $param = $path[1];
    }

    $contents = file_get_contents('carros.json');

    $json = json_decode($contents, true);

    $method = $_SERVER['REQUEST_METHOD'];
    
    $body = file_get_contents('php://input');

    $carroObject = new Carro();

    switch ($method) {
        case 'GET':
            $carroObject->getCarros($json[$path[0]], $contents, $param);
            break;
        case 'POST':
            $carroObject->createCarro($json[$path[0]], $json, $body);
            break;
        case 'PUT':
            $carroObject->saveCarro($json[$path[0]], $json, $body, $param);
            break;
        case 'DELETE':
            $carroObject->removeCarro($json[$path[0]], $json, $param);
            break;
        default:
            break;
    }
?>