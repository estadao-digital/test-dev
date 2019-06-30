<?php
// Classe que representa um carro
class Carro
{
    var $carro_id;
    var $carro_marca;
    var $carro_modelo;
    var $carro_ano;

    function __construct($carro_id, $carro_marca, $carro_modelo, $carro_ano)
    {
        $this->carro_id = $carro_id;
        $this->carro_marca = $carro_marca;
        $this->carro_modelo = $carro_modelo;
        $this->carro_ano = $carro_ano;
    }
    function getCarroId()
    {
        return $this->carro_id;
    }
    function setCarroId($carro_id)
    {
        $this->carro_id = $carro_id;
    }
    function getCarroMarca()
    {
        return $this->carro_marca;
    }
    function setCarroMarca($carro_marca)
    {
        $this->carro_marca = $carro_marca;
    }
    function getCarroModelo()
    {
        return $this->carro_modelo;
    }
    function setCarroModelo($carro_modelo)
    {
        $this->carro_modelo = $carro_modelo;
    }
    function getCarroData()
    {
        return $this->carro_data;
    }
    function setCarroData($carro_data)
    {
        $this->carro_data = $carro_data;
    }
}
