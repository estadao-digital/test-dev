<?php
// requisição headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../class/carro.php';

$database = new Database();
$db = $database->getConnection();

$carro = new Carro($db);

$carro->id = isset($_GET['id']) ? $_GET['id'] : die();

$carro->readOne();

if($carro->modelo!=null){

    $product_arr = array(
        "id" =>  $carro->id,
        "modelo" => $carro->modelo,
        "ano" => $carro->ano,
        "marca_id" => $carro->marca_id,
        "marca_name" => $carro->marca_name

    );

    http_response_code(200);

    echo json_encode($product_arr);
} else {

    http_response_code(404);

    echo json_encode(array("message" => "Carro não existe!"));
}