<?php

class Marca
{
    private $conn;
    private $table_name = "marcas";

    public $id;
    public $name;
    public $created;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readAll()
    {
        $query = "SELECT id, name FROM " . $this->table_name . " ORDER BY name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function read(){

        $query = "SELECT id, name FROM " . $this->table_name . " ORDER BY name";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }
}