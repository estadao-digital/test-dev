<?php

class Api {

    public $dev;

    public function __construct() {
    }

    public function route($route) {
        if(isset($_GET['pagina']) && $_GET['pagina'] == $route) {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: access");
            header("Access-Control-Allow-Credentials: true");
            header('Content-Type: application/json');
            if(!isset($_GET['id'])) {
                $this->{$_SERVER['REQUEST_METHOD']}();
            } else {
                $this->{$_SERVER['REQUEST_METHOD']}($_GET['id']);
            }
        } else {
            include 'index.html';
        }
    }
    public function GET($id = NULL) {
        header("Access-Control-Allow-Methods: GET");
        if($id == NULL) {
            $file = json_decode(file_get_contents("database/carros.json"), true);
            echo json_encode($file);
        } else {
            $file = json_decode(file_get_contents("database/carros.json"), true);
            $key = $this->findId($file, $id);

            if($key !== NULL) {
                echo json_encode($file[$key]);
            } else {
                echo json_encode(array('type' => 'error', 'messagem' => 'Item não encontrado.'));
            }
        }
    }

    public function POST() {
        header("Access-Control-Allow-Methods: POST");
        if(!empty($_POST)) {
            $file = json_decode(file_get_contents("database/carros.json"), true);
            if($file == NULL) {
                $file = array();
            }
            extract($_POST);
            $id = count($file) + 1;
            array_push($file, array('id' => $id, 'modelo' => $modelo, 'marca' => $marca, 'ano' => $ano));
            file_put_contents("database/carros.json", json_encode($file));
            echo json_encode(array('type' => 'success', 'messagem' => 'Item inserido.', 'id' => $id));
        } else {
            echo json_encode(array('type' => 'error', 'messagem' => 'Não há dados para inserir.'));
        }
    }

    public function PUT($id = NULL) {
        header("Access-Control-Allow-Methods: PUT");
        if($id != NULL) {
            parse_str(file_get_contents('php://input'), $_PUT);
            if(!empty($_PUT)) {
                $file = json_decode(file_get_contents("database/carros.json"), true);

                $key = $this->findId($file, $id);
                $file[$key]['modelo'] = $_PUT['modelo'];
                $file[$key]['marca'] = $_PUT['marca'];
                $file[$key]['ano'] = $_PUT['ano'];

                file_put_contents("database/carros.json", json_encode($file));
                echo json_encode(array('type' => 'success', 'messagem' => 'Item alterado.'));
            } else {
                echo json_encode(array('type' => 'error', 'messagem' => 'Não há dados para inserir.'));
            }
        } else {
            echo json_encode(array('type' => 'error', 'messagem' => 'É necessário informar o ID.'));
        }
    }

    public function DELETE($id = NULL) {
        header("Access-Control-Allow-Methods: DELETE");
        if($id != NULL) {
            $file = json_decode(file_get_contents("database/carros.json"), true);

            $key = $this->findId($file, $id);
            unset($file[$key]);
            foreach ($file as $k => $f) {
                if($id < $f['id']) {
                    $file[$k]['id']--;
                }
            }
            file_put_contents("database/carros.json", json_encode($file));
            echo json_encode(array('type' => 'success', 'messagem' => 'Item deletado.'));
        } else {
            echo json_encode(array('type' => 'error', 'messagem' => 'É necessário informar o ID.'));
        }
    }

    public function findId($file, $id) {
        $key = NULL;
        foreach ($file as $k => $f) {
            if($f['id'] == $id) {
                $key = $k;
            }
        }
        return $key;
    }
}