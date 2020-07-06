<?php

class Carro {

    private $conn;
    private $table_name = "carros";

    public $id;
    public $modelo;
    public $ano;
    public $marca_id;
    public $marca_name;
    public $created;

    public function __construct($db){
        $this->conn = $db;
    }

    function read(){

        $query = "SELECT m.name as marca_name, c.id, c.modelo, c.ano, c.marca_id, c.created
                    FROM " . $this->table_name . " c LEFT JOIN marcas m ON c.marca_id = m.id
                    ORDER BY c.created DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
      
        return $stmt;
    }

    function create(){

        $query = "INSERT INTO " . $this->table_name . " SET
                modelo=:modelo, ano=:ano, marca_id=:marca_id, created=:created";

        $stmt = $this->conn->prepare($query);

        $this->modelo=htmlspecialchars(strip_tags($this->modelo));
        $this->ano=htmlspecialchars(strip_tags($this->ano));
        $this->marca_id=htmlspecialchars(strip_tags($this->marca_id));
        $this->created=htmlspecialchars(strip_tags($this->created));

        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":ano", $this->ano);
        $stmt->bindParam(":marca_id", $this->marca_id);
        $stmt->bindParam(":created", $this->created);

        if($stmt->execute()){
            return true;
        }

        return false;
    }


    function readOne(){

        $query = "SELECT m.name as marca_name, c.id, c.modelo, c.ano, c.marca_id, c.created
            FROM " . $this->table_name . " c LEFT JOIN marcas m ON c.marca_id = m.id
            WHERE c.id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->modelo = $row['modelo'];
        $this->ano = $row['ano'];
        $this->marca_id = $row['marca_id'];
        $this->marca_name = $row['marca_name'];
    }

    function update(){

        $query = "UPDATE " . $this->table_name . "
            SET
                modelo = :modelo,
                ano = :ano,
                marca_id = :marca_id
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $this->modelo=htmlspecialchars(strip_tags($this->modelo));
        $this->ano=htmlspecialchars(strip_tags($this->ano));
        $this->marca_id=htmlspecialchars(strip_tags($this->marca_id));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':modelo', $this->modelo);
        $stmt->bindParam(':ano', $this->ano);
        $stmt->bindParam(':marca_id', $this->marca_id);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function delete(){

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if($stmt->execute()){
            return true;
        }

        return false;
    }
}
