<?php

require_once ("Model.class.php");


class Carro extends Model{

   protected $database = "carros";

    public $modelo;
    public $marca;
    public $ano;

}
?>