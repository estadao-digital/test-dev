<?php

class CarroController
{
    public $post, $get;

    public function __construct()
    {
        header('Content-Type: application/json');
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
        $status = false;
        $response = "Erro inesperado!";

        // Retorna todos os Carros
        if(Request::Method() == "GET")
        {
            $cars = Carro::GetAll();
            $response = $cars;
        }

        // Insere novo Carro
        if(Request::Method() == "POST")
        {
            
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
        $status = false;
        $response = "Erro inesperado!";
        // Retorna dados do carro com ID especificado
        if(Request::Method() == "GET")
        {
            if($this->get->id > 0){
                $car = Carro::GetById($this->get->id);
                $response = $car;
                $status = true;
            }else{
                $response = "Insira uma ID válida!";
            }
        }

        // Atualizar os dados do carro com ID especificado
        if(Request::Method() == "PUT")
        {
            echo "PUT";
        }

        // Apagar o carro com ID especificado
        if(Request::Method() == "DELETE")
        {
            echo "DELETE";
        }

        return json_encode(array("response" => $response, "status" => $status));
    }

}