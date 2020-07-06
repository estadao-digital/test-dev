<?php
// requição para header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../class/carro.php';

$database = new Database();
$db = $database->getConnection();

$carro = new Carro($db);

$stmt = $carro->read();
$num = $stmt->rowCount();

if($num>0){

    $carros_arr=array();
    $carros_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $carro_item=array(
            "id" => $id,
            "modelo" => $modelo,
            "ano" => $ano,
            "marca_id" => $marca_id,
            "marca_name" => $marca_name
        );

        array_push($carros_arr["records"], $carro_item);
    }

    http_response_code(200);

    echo json_encode($carros_arr);

} else {

    http_response_code(404);

    echo json_encode(
        array("message" => "Nenhum carro encontrado!")
    );
}