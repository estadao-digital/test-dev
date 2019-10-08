<?php

class CarroController
{
    public $post, $get;

    public function __construct()
    {
        $this->get = Request::Get();
        $this->post = Request::Post();
    }

    // [.*] -> /
    public function Teste()
    {
        
    }

    // [GET, POST] -> /carros
    public function LerAdicionarCarros()
    {
        header('Content-Type: application/json');
        $status = false;
        $response = "Erro inesperado!";

        // Retorna todos os Carros
        if(Request::Method() == "GET")
        {
            $cars = Carro::GetAll();
            $response = $cars;
        }

        // Insere novo Carro
        if(Request::Method() == "POST"){
            
            $validacao = Carro::Validate($this->post);
            if($validacao === true)
            {
                $carro = new Carro($this->post);

                if($carro->Create()){
                    $response = "Carro inserido com sucesso!";
                }

            } else {
                $response = $validacao;
            }
        }

        return json_encode(array("response" => $response, "status" => $status));
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