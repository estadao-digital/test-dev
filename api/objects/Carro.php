<?php
class Carro
{
    private $id;
    private $marca;
    private $modelo;
    private $ano;

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

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    public function getModelo()
    {
        return $this->modelo;
    }

    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    public function getAno()
    {
        return $this->ano;
    }

}
?>