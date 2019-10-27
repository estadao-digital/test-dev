<?php

namespace Models;

use PDO;

class Cars
{

    private $id, $brand, $model, $year, $conn;

    function __construct($id = null, $brand = null, $model = null, $year = null)
    {
        $this->id       = $id;
        $this->brand    = $brand;
        $this->model    = $model;
        $this->year     = $year;

        $conn = new PDO('mysql:host=localhost;dbname=estadao', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);

        $this->conn = $conn;
    }

    function find($id)
    {
        $sql = "SELECT * FROM Cars WHERE id = :id";

        $data = $this->conn->prepare($sql);
        $data->bindValue(':id', $id);
        $data->execute();

        return $data->fetch(PDO::FETCH_ASSOC, null);
    }

    function findAll()
    {
        $sql = "SELECT * FROM Cars";

        $data = $this->conn->prepare($sql);
        $data->execute();

        return $data->fetchAll(PDO::FETCH_OBJ);
    }

    function insert($obj)
    {
        $sql = "INSERT INTO Cars(brand, model, year) VALUES(:brand, :model, :year)";

        $data = $this->conn->prepare($sql);
        $data->bindValue(':brand', $obj['brand']);
        $data->bindValue(':model', $obj['model']);
        $data->bindValue(':year', $obj['year']);
        $data->execute();
    }

    function update($obj, $id)
    {
        $sql = "UPDATE Cars SET brand=:brand, model=:model, year=:year WHERE id=:id";

        $data = $this->conn->prepare($sql);
        $data->bindValue(':id', $id);
        $data->bindValue(':brand', $obj['brand']);
        $data->bindValue(':model', $obj['model']);
        $data->bindValue(':year', $obj['year']);
        $data->execute();
    }

    function delete($id)
    {
        $sql = "DELETE FROM Cars WHERE id=:id";

        $data = $this->conn->prepare($sql);
        $data->bindValue(':id', $id);
        $data->execute();
    }
}
