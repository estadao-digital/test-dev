<?php
/**
* Classe do carro
*/

include 'Connect.php';

class Carro {

    private $id;
    private $marca;
    private $modelo;
    private $ano;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    public function getModelo()
    {
        return $this->modelo;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    public function getAno()
    {
        return $this->ano;
    }

    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    # Podeia usar os atributos diretamente também.
    public function load($params) {
        $this->setId(isset($params['id']) ? $params['id'] : null);
        $this->setAno(isset($params['ano']) ? $params['ano'] : null);
        $this->setMarca(isset($params['marca']) ? $params['marca'] : null);
        $this->setModelo(isset($params['modelo']) ? $params['modelo'] : null);
    }

    # Chamei as propriedades diretamente e não os metodos get() pois estou dentro da classe.
    public function insert() {
        # Se a tabela deve ser criada no plural ou no singular é discutível.
        $sql = 'INSERT INTO carros(ano, marca, modelo) VALUES (:ano,:marca,:modelo)';
        $conn = Connect::prepare($sql);
        $conn->bindValue('ano',  $this->ano);
        $conn->bindValue('marca', $this->marca);
        $conn->bindValue('modelo' , $this->modelo);
        return $conn->execute();
    }

    public function update() {
        # Se a tabela deve ser criada no plural ou no singular é discutível.
        $sql = 'UPDATE carros SET ano = :ano, marca = :marca, modelo = :modelo WHERE id = :id ';
        $conn = Connect::prepare($sql);
        $conn->bindValue('ano',  $this->ano);
        $conn->bindValue('marca', $this->marca);
        $conn->bindValue('modelo' , $this->modelo);
        $conn->bindValue('id', $this->id);
        return $conn->execute();
    }

    public function delete(){
        $sql =  'DELETE FROM carros WHERE id = :id';
        $conn = Connect::prepare($sql);
        $conn->bindValue('id', $this->id);
        return $conn->execute();
    }

    public function fetch() {
        $sql = 'SELECT * FROM carros';
        if(isset($this->id)) {
            $sql .= ' where id = :id';
        }
        $sql .= ' order by id desc';

        $conn = Connect::prepare($sql);
        $conn->bindValue('id', $this->id);
        $conn->execute();
        return $conn->fetchAll();
    }

}

?>