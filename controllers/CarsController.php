<?php
require '../config/bootstrap.php';

/**
 * Cars Controller
 * Basically calls the api and returns the view rendered
 */
class CarsController{
    private $car;

    function __construct(){}

    function getCars() {
        require_once('../classes/Util.php');
        $util = new Util();
        $result = $util->callApi('GET', 'carros/');
        $cars = json_decode($result)->data;

        $result = $util->callApi('GET', 'marcas/');
        $brands = json_decode($result)->data;

        echo $util->render('cars/index', array('cars'=>$cars,'brands'=>$brands));
    }


    function addCar() {
        $data = $_POST;
        require_once('../classes/Util.php');
        $util = new Util();
        $result = $util->callApi('POST', 'carros/', json_encode($data));

        echo $result;
    }

    function updateCar($id) {
        $data = $_POST;
        require_once('../classes/Util.php');
        $util = new Util();
        $result = $util->callApi('PUT', 'carros/'.$id, json_encode($data));

        echo $result;
    }

    function deleteCar($id) {
        require_once('../classes/Util.php');
        $util = new Util();
        $result = $util->callApi("DELETE", 'carros/'.$id);

        echo $result;
    }
    
}
