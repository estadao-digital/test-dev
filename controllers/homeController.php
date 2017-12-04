<?php

use models\Carros;

namespace controllers;

class homeController extends Controller {

    protected $carros_model;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->loadTemplate();
    }

    public function listar() {
        $jsondata = $this->getLista();
        $total_itens = $jsondata['total'];
        $p = 1;
        if (isset($_GET['p']) && !empty($_GET['p'])) {
            $p = addslashes($_GET['p']);
        }
        $por_pagina = 12;
        $offset = ( ($p * $por_pagina) - $por_pagina - 1 );

        $total_paginas = ceil($total_itens / $por_pagina);
        $dados['total_paginas'] = $total_paginas;
        $dados['carros'] = $jsondata['carros'];
        $this->loadViewInTemplate('content/listar', $dados);
        $this->loadViewInTemplate('blocks/pagination', $dados);
    }

    public function novo() {
        $dados = array();
        $this->loadViewInTemplate('content/novo', $dados);
    }
    
    public function editar($params) {
        $dados = array('carro'=> $this->getCarro($params) );        
        $this->loadViewInTemplate('content/editar', $dados);
    }

    public function carros($params = NULL) {
        header('Content-Type: application/json; charset=utf-8');
        if (is_numeric(trim($params)) == 1) {
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case "GET":
                    echo json_encode($this->getCarro($params));
                    break;
                case "PUT":                    
                    parse_str(file_get_contents("php://input"),$carro);                    
                    echo json_encode($this->updateCarro($carro));                    
                    break;
               case "DELETE":                    
                    $id = $params;
                    echo json_encode($this->removeCarro($id));
                    break;
            }
        } else if (is_null($params) || trim($params) == "") {
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case "GET":
                    echo json_encode($this->getLista());
                    break;
                case "POST":
                    $carro = $_POST;                    
                    echo json_encode($this->addCarro($carro));
                    break;                                
            }
        }
    }

    private function getLista($offset = 0, $limit = false) {
        $this->carros_model = new \models\Carros;
        $ver = 12;       
        $offset = isset($_GET['p']) ? ( $_GET['p'] * $ver ) - $ver: 0;
        $limit =  isset($_GET['p']) ? $_GET['p'] * $ver : $ver;         
        $data = $this->carros_model->SelectAll($offset, $limit);
        return $data;
    }

    private function getCarro($id) {
        $this->carros_model = new \models\Carros;
        $data = $this->carros_model->SelectAllById($id);
        return $data;
    }

    private function addCarro($carro) {
        $this->carros_model = new \models\Carros;
        $data = $this->carros_model->Insert($carro);
        return $data;
    }
    
    private function updateCarro($carro) {
        $this->carros_model = new \models\Carros;
        $data = $this->carros_model->Update($carro);
        return $data;
    }
    
    private function removeCarro($id) {
        $this->carros_model = new \models\Carros;
        $data = $this->carros_model->Delete($id);
        return $data;
    }
    

}
