<?php
// requição para header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../class/marca.php';

$database = new Database();
$db = $database->getConnection();

$marca = new Marca($db);

$stmt = $marca->read();
$num = $stmt->rowCount();

if($num>0) {

    $marcas_arr=array();
    $marcas_arr["records"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $marca_item=array(
            "id" => $id,
            "name" => $name
        );

        array_push($marcas_arr["records"], $marca_item);
    }

    http_response_code(200);

    echo json_encode($marcas_arr);
} else {

    http_response_code(404);

    echo json_encode(
        array("message" => "Nenhuma Marca encontrada!")
    );
}