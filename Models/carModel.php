<?php
include_once ("../dbInterface.php");
include_once ("../db.php");

class carModel
{
    public function __construct()
    {
        $this->db = new DB();
    }
    public function index($id = 0)
    {
        $query = "SELECT *,  CASE(car_brand)
        WHEN   1 THEN 'Volkswagen'
        WHEN   2 THEN 'Ford'
        WHEN   3 THEN 'Mercedes'
        WHEN   4 THEN 'BMW' END AS marca
         FROM car";
        if ($id != 0) {
            $query .= " WHERE id=" . $id . " LIMIT 1";
        }
        $result = $this->db->runSQL($query);
        while ($row = mysqli_fetch_array($result)) {
            $response[] = $row;
        }
        header('Content-Type: application/json');
        if (!isset($response)) {
            $response = ['code_error' => 1, 'msg_error' => 'Dados não encontrados'];
            echo json_encode($response);
        } else {
            echo json_encode($response);
        }
    }

    public function lastInsered()
    {
        $query = "SELECT * FROM car ORDER BY id DESC LIMIT 1 ;";
        $result = $this->db->runSQL($query);
        while ($row = mysqli_fetch_array($result)) {
            $response[] = $row;
        }
        header('Content-Type: application/json');
        if (!isset($response)) {
            $response = ['code_error' => 1, 'msg_error' => 'Dados não encontrados'];
            echo json_encode($response);
        } else {
            echo json_encode($response);
        }
    }

    public function store($car)
    {
     
        if (!isset($car['id'])) {
            $query = "INSERT INTO car 
            SET car_name='" . $car['car_name'] . "',
                car_price='" . $car['car_price'] . "',
                car_brand='" . $car['car_brand'] . "',
                car_year='" . $car['car_year'] . "' ";
        } else {
            $query = "UPDATE car 
            SET car_name='" . $car['car_name'] . "',
                car_price='" . $car['car_price'] . "',
                car_brand='" . $car['car_brand'] . "'
               WHERE id=" . $car['id'];
        }
        if ($this->db->runSQL($query)) {
            if (!isset($car['id'])) {
                $this->lastInsered();
            } else {
                $this->index($car['id']);
            }
        } else {
            $response = array(
                'status' => 0,
                'status_message' => 'Car saved Failed.'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
    public function destroy($id)
    {
        $query = "DELETE FROM car WHERE id=" . $id;
        if ($this->db->runSQL($query)) {
            $response = array(
                'status' => 0,
                'status_message' => 'Car removed.'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = array(
                'status' => 0,
                'status_message' => 'Car remove Failed.'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}
?>