<?php

class Carro
{
    public $id, $marca, $modelo, $ano;

    public function Get(){

    }

    public function Create(){
        $status = false;
        $db = new DB("Carro");
        $db->Insert($this);
    }

    public function Update(){

    }

    public function Delete(){

    }

    public static function Validate($car)
    {
        if(!isset($car->marca) || empty($car->marca))
            return "A marca precisa ser informada";
            
        if(!isset($car->modelo) || empty($car->modelo))
            return "O modelo precisa ser informado";

        if(!isset($car->ano) || empty($car->ano))
            return "O ano precisa ser informado";

        if(!is_numeric($car->ano))
            return "Informe um ano válido!";
    }

}