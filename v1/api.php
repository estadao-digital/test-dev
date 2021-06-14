<?php
include("../Controllers/carController.php");
$car = new carController();
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        // Retrive Products
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $car->get_cars($id);
        } else {
            $car-> get_cars();
        }
        break;
    case 'POST':        
        $car-> insert_car();
        break;
    case 'PUT':                       
        $car->update_car();
        break;
    case 'DELETE':                        
        $car-> delete_car($_GET['id']);
        break;
    default:        
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>