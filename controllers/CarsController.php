<?php
require '../config/bootstrap.php';

class CarsController{
    private $car;

    function __construct(){}

    function getCars() {
        require_once('../classes/Util.php');
        $util = new Util();
        $result = $util->callApi('GET', 'http://localhost/document_root/api/carros/');
        $cars = json_decode($result)->data;

        $result = $util->callApi('GET', 'http://localhost/document_root/api/marcas/');
        $brands = json_decode($result)->data;

        echo $util->render('cars/index', array('cars'=>$cars,'brands'=>$brands));
    }

    function getCar($id) {
        
    }

    function addCar() {
        $data = $_POST;
        require_once('../classes/Util.php');
        $util = new Util();
        $result = $util->callApi('POST', 'http://localhost/document_root/api/carros/', json_encode($data));

        echo $result;
    }

    function updateCar($id) {
        $data = $_POST;
        require_once('../classes/Util.php');
        $util = new Util();
        $result = $util->callApi('PUT', 'http://localhost/document_root/api/carros/'.$id, json_encode($data));

        echo $result;
    }

    function deleteCar($id) {
        require_once('../classes/Util.php');
        $util = new Util();
        $result = $util->callApi("DELETE", 'http://localhost/document_root/api/carros/'.$id);

        echo $result;
    }
    
}
