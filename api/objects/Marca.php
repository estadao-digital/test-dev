<?php
class Marca
{
    private $id;
    private $nome;

    public function __construct() {

    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNome($marca)
    {
        $this->marca = $marca;
    }

    public function getNome()
    {
        return $this->marca;
    }


}
?>