<?php

class CarroController
{
    public $post, $get;

    public function __construct()
    {
        header('Content-Type: application/json');
        $this->get = Request::Get();
        $this->post = Request::Post();
        $this->put = Request::Put();
        $this->delete  = Request::Delete();
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
                    $status = true;
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
        if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE')) {
            parse_str(file_get_contents('php://input'), $_DELETE);
        }
        if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'PUT')) {

            parse_str(file_get_contents('php://input'), $_PUT);
        }

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
            $carro = new Carro($this->put);
            
            if($this->get->id > 0 && count(Carro::GetById($this->get->id)) > 0){
                if($carro->Update($this->get->id))
                {
                    $response = "Carro atualizado com sucesso!";
                    $status = true;
                }
            }else{
                $response = "Insira uma ID válida!";
            }

        }

        // Apagar o carro com ID especificado
        if(Request::Method() == "DELETE")
        {
            if($this->get->id > 0)
            {
                if(count(Carro::GetById($this->get->id)) > 0)
                {
                    $carro = Carro::GetById($this->get->id)[0];
                
                    if($carro->Delete())
                    {
                        $status = true;
                        $response = "Carro excluido com sucesso!";
                    }

                }else{
                    $response = "Carro não encontrado!";
                }
    
            }else{
                echo "Insira uma ID válida";
            }
        }

        return json_encode(array("response" => $response, "status" => $status));
    }

}
