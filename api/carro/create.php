<?php
// requisição headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

include_once '../class/carro.php';

$database = new Database();
$db = $database->getConnection();

$carro = new Carro($db);

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->modelo) &&
    !empty($data->ano) &&
    !empty($data->marca_id)
){

    $carro->modelo = $data->modelo;
    $carro->ano = $data->ano;
    $carro->marca_id = $data->marca_id;
    $carro->created = date('Y-m-d H:i:s');

    if($carro->create()){

        http_response_code(201);

        echo json_encode(array("message" => "Carro criado com sucesso!"));

    } else {

        http_response_code(503);

        echo json_encode(array("message" => "Erro ao criar carro!"));
    }
} else {

    http_response_code(400);

    echo json_encode(array("message" => "Erro ao criar carro, dados incompletos."));
}