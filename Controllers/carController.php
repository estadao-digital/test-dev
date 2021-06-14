<?php
include "../db.php";

include("../Models/carModel.php");

class carController{
    function get_cars($id = 0)
    {
        $car = new carModel();
        $car->index($id);
    }
    function insert_car()
    {
        $post_vars = json_decode(file_get_contents("php://input"), true);
        $arrayCar = [];
        $car = new carModel();
        $arrayCar['car_name']   =  $post_vars['car_name'];
        $arrayCar['car_price']   = $post_vars['car_price'];
        $arrayCar['car_year']   =  $post_vars['car_year'];
        $arrayCar['car_brand']   = $post_vars['car_brand'];
        $car->store($arrayCar);
    }

    function update_car()
    {
        $post_vars = json_decode(file_get_contents("php://input"), true);
        $arrayCar = [];
        $car = new carModel();
        $arrayCar['id']             =  $post_vars['id'];
        $arrayCar['car_name']   =  $post_vars['car_name'];
        $arrayCar['car_price']   = $post_vars['car_price'];
        $arrayCar['car_year']   =  $post_vars['car_year'];
        $arrayCar['car_brand']   = $post_vars['car_brand'];
        $car->store($arrayCar);
    }
    function delete_car($id)
    {     
        $car = new carModel();
        $car->destroy($id);    
    
    }

}
?>
