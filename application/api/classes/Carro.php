<?php

class Carro
{
    public $id, $marca, $modelo, $ano;

    public function __construct($car = null)
    {
        if(!is_null($car))
        {
            foreach($car as $k => $v)
            {
                if(property_exists("Carro", $k))
                    $this->{$k} = $v;
            }
        }
    }

    public function Get()
    {

    }

    public function Create()
    {
        $db = new DB("Carros");
        $result = $db->Insert($this);
        
        if($result->status){
            $this->id = $result->response;
        }

        return $result->status;
    }

    public static function GetAll()
    {
        $db = new DB("Carros");
        return $db->Select()->response;
    }

    public static function GetById($id)
    {
        $db = new DB("Carros");
        return $db->Select($id);
    }

    public function Update($id)
    {
        $db = new DB("Carros");
        return $db->Update($this, $id);
    }

    public function Delete()
    {

    }

    public static function Validate($car)
    {
        if(!isset($car->marca) || empty($car->marca))
            return "O campo 'marca' precisa ser informado";
            
        if(!isset($car->modelo) || empty($car->modelo))
            return "O campo 'modelo' precisa ser informado";

        if(!isset($car->ano) || empty($car->ano))
            return "O campo 'ano' precisa ser informado";

        if(!is_numeric($car->ano))
            return "Informe um ano válido!";

        return true;
    }

}