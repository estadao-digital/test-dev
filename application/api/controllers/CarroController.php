<?php

class CarroController
{

    // [.*] -> /
    public function Teste()
    {
        $car = new Carro();
        $car->id = 2;
        $car->modelo = "aaa";
        $car->marca = "bbb";
        $car->ano = 2017;

        $db = new DB("Carro");
        $db->Insert($car);
    }

    // [GET, POST] -> /carros
    public function LerAdicionarCarros()
    {
        if(Request::Method() == "GET"){
            echo "GET";
        }

        if(Request::Method() == "POST"){
            echo "POST";
        }

    }

    // [GET, PUT, DELETE] -> /carro/(?P<id>[0-9]+?)
    public function Carros()
    {
        if(Request::Method() == "GET"){
            echo "GET";
        }

        if(Request::Method() == "PUT"){
            echo "PUT";
        }

        if(Request::Method() == "DELETE"){
            echo "DELETE";
        }
    }

}