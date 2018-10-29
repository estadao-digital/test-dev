<?php
// set configs api json
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, PUT, GET, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, multipart/form-data");
// classe com?leta do carro
require_once 'Carro.class.php';

$carro = new Carro();
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            // utilizado para listagens em geral
            if ($_SERVER['PATH_INFO']) {
                $pathInfo = $_SERVER['PATH_INFO'];
                $id = str_replace('/', '', $pathInfo);
                $retorno = $carro->listaCarro($id);
            } else {
                $retorno = $carro->listaCarro();
            }
            $codigoRetorno = 200; //sucesso no retorno

            break;
        case 'POST':
            // utilizado para cadstro de carro
            $dadosCarro = json_decode(file_get_contents("php://input"));
            $retorno = $carro->criaCarro($dadosCarro);
            $codigoRetorno = 201; //registro criado

            break;
        case 'PUT':
            // utilizado para atualização de carro
            $pathInfo = $_SERVER['PATH_INFO'];
            $id = str_replace('/', '', $pathInfo);

            $dadosCarro = json_decode(file_get_contents("php://input"));
            $retorno = $carro->atualizaCarro( $id, $dadosCarro );

            break;
        case 'DELETE':
            // utilizado para exclusão de carro
            $pathInfo = $_SERVER['PATH_INFO'];
            $id = str_replace('/', '', $pathInfo);
            $retorno = $carro->excluiCarro($id);
            $codigoRetorno = 200; //sucesso no retorno

            break;
        default:

            $retorno = $carro->listaCarro();

            break;
    }

    if( $retorno != false ){
        // Sucesso na operação
        http_response_code($codigoRetorno);
        echo json_encode(array("retorno" => $retorno));

    }
}catch (Exception $e){
    http_response_code(400); //Erro
    echo json_encode(array("retorno" => $e->getMessage()));
}