<?php
/**
 * Created by PhpStorm.
 * User: MARCIO SANTOS
 * Date: 06/12/2017
 * Time: 20:10
 */

$params = json_decode(file_get_contents('php://input'), true);
$meth = $_SERVER['REQUEST_METHOD'];

file_put_contents('parms.log',print_r($params, true));

$db_path = "../json/db.json";


include("carro.class.php");

try {
    $carro = new clsCarro();

    switch ($meth) {
        case 'GET':
            /*
             * DEPRACATED BY THE FILTER FEATURE - FOR REFERENCE PURPOSE ONLY.
            if($params['edit']) {
                $ret = $carro->listCar($db_path,$params['id']);
            } else {
                $ret = $carro->listCars($db_path);
            }
            */
            $ret = $carro->listCars($db_path);
            break;
        case 'POST':
            $ret = $carro->addCar($db_path, $params['car']);
            break;
        case 'PUT':
            $ret = $carro->editCar($db_path, $params['car']);
            break;
        case 'DELETE':
            $ret = $carro->delCar($db_path, $params['id']);
            break;
    }

    echo $ret;


} catch (NoRecordsException $e) {
    file_put_contents('error.log',print_r($e,true)."\n", FILE_APPEND);
} catch (InvalidDataException $e) {
    file_put_contents('error.log',print_r($e,true)."\n", FILE_APPEND);
}
