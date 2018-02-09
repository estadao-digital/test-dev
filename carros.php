<?php
require_once "Carro.class.php";
$carro = new Carro();
$metodo = $_SERVER['REQUEST_METHOD'];
if(isset($_POST["metodo"])){
    if($_POST["metodo"]==="PUT"){
        $metodo = "PUT";
    }
}

switch($metodo){
    case 'POST' : echo $carro->create($_POST);
    break;
    case 'PUT' : echo $carro->update($_GET, $_POST);
    break;
    case 'DELETE' : echo $carro->delete($_GET);
    break;
    case 'GET' : print_r($carro->retrieve($_GET));
    break;
}
?>