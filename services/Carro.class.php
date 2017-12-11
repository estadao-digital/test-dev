<?php
/**
 * Created by PhpStorm.
 * User: MARCIO SANTOS
 * Date: 07/12/2017
 * Time: 14:48
 */

class clsCarro
{

    public $id;
    public $marca;
    public $modelo;
    public $ano;

    private function generate_uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function objectToArray($object) {
        if(!is_object($object) && !is_array($object))
            return $object;

        return array_map('objectToArray', (array) $object);
    }

    public function listCars($db_path)
    {
        $db = file_get_contents($db_path);
        return $db;
    }

    public function listCar($db_path, $id) {
        //DEPRECATED BY THE FILTER FEATURE
    }

    public function addCar($db_path, $obj)
    {
        $db = json_decode(file_get_contents($db_path));
        $id = $this->generate_uuid();
        $obj['id'] = $id;
        $db[] = $obj;
        $output = json_encode($db);
        file_put_contents($db_path, $output);
        return json_encode($obj);
    }

    public function delCar($db_path, $id) {
        file_put_contents('delete.log',$id." | ". $db_path);
        $db = json_decode(file_get_contents($db_path));
        foreach ($db as $key=>$value) {
            if ($value->id==$id) {
                unset($db[$key]);
                break;
            }
        }

        foreach ($db as $row) {$recover[]=$row;}

        $temp = json_encode((array)$recover);
        file_put_contents($db_path, $temp);
        return "200";
    }

    public function editCar($db_path, $car){
        $db = json_decode(file_get_contents($db_path));

        foreach ($db as $key=>$value) {
            if ($value->id==$car[id]) {
                $db[$key] = $car;
                break;
            }
        }

        foreach ($db as $row) {$recover[]=$row;}

        $temp = json_encode((array)$recover);
        file_put_contents($db_path, $temp);
        return "Edit 200";
    }
}