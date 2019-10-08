<?php

class CarroController
{
    public function Teste(){
        echo "teste";
    }

    // [GET, POST] -> carros/
    public function LerAdicionarCarros(){

        if(Request::Method() == "GET"){
            echo "GET";
        }

        if(Request::Method() == "POST"){
            echo "POST";
        }

    }

    // [GET, PUT, DELETE] -> carro/(?P<id>[0-9]+?)
    public function Carros(){
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