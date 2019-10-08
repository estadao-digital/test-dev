<?php

class CarroController
{

    // [.*] -> /
    public function Teste()
    {
        $db = new DB("Carro");
        echo "<pre>";
        print_r($db->Select());
    }

    // [GET, POST] -> /carros
    public function LerAdicionarCarros()
    {
        // Retorna todos os Carros
        if(Request::Method() == "GET"){
            echo "GET";
        }

        // Insere novo Carro
        if(Request::Method() == "POST"){
            echo "POST";
        }

    }

    // [GET, PUT, DELETE] -> /carro/(?P<id>[0-9]+?)
    public function Carros()
    {
        // Retorna dados do carro com ID especificado
        if(Request::Method() == "GET"){
            echo "GET";
        }

        // Atualizar os dados do carro com ID especificado
        if(Request::Method() == "PUT"){
            echo "PUT";
        }

        // Apagar o carro com ID especificado
        if(Request::Method() == "DELETE"){
            echo "DELETE";
        }
    }

}