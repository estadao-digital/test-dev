<?php

    $token = getallheaders();
    if(!isset($token['token']) || $token['token'] != TOKEN_CLIENT) {
        echo 'Acesso negado - Token Inválido';
        die();
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET') {

        $path = explode('/',$_GET['url']);
        $retorno = array();

        if($path[0] == 'carros' && empty($path[1])) {            
            
            $listar = Carro::getCarros();

            if($listar != false) {

                $retorno['status'] = 'true';

                foreach ($listar as $key => $value) {

                    $retorno["data"][] = array(
                        "id"=>$value['id'],
                        "id_marca"=>$value['id_marca'],
                        "marca"=>$value['marca'],
                        "modelo"=>$value['modelo'],
                        "ano"=>$value['ano'],
                    );

                }

            }

        }else {

            $id = $path[1];
            $getCar = Carro::getCarro($path[1]);

            if($getCar != false) {

                $validaId = new ValidaCarro();
                $valId = $validaId->validaId($id);

                if($valId == false) {

                    $getCarro = Carro::getCarro($id);

                    if($getCarro != false) {

                        $retono['status'] = 'true';
                        $retorno['id'] = $getCarro['id'];
                        $retorno['id_marca'] = $getCarro['id_marca'];
                        $retorno['marca'] = $getCarro['marca'];
                        $retorno['modelo'] = $getCarro['modelo'];
                        $retorno['ano'] = $getCarro['ano'];

                    }
                    

                }else {

                    $retorno = $valId;

                }

            }else {

                $retorno['status'] = 'false';
                $retorno['erro'] = 'O id informado não existe';

            }

            

        }
        header("Content-Type: application/json");
        echo json_encode($retorno);

    }else if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['marca']) && isset($_POST['modelo']) && isset($_POST['ano'])) {

            $validaPost = new ValidaCarro();
            $marca = $validaPost->validaMarca($_POST['marca']);
            $modelo = $validaPost->validaModelo($_POST['modelo']);
            $ano = $validaPost->validaAno($_POST['ano']);

            if($marca == false && $modelo == false && $ano == false) {

                $carro = new Carro();
                $carro->setId(null);
                $carro->setMarca($_POST['marca']);
                $carro->setModelo($_POST['modelo']);
                $carro->setAno($_POST['ano']);
                $save = $carro->createCar();

                if($save != false) {

                    $retorno['status'] = 'true';
                    $retorno['mensagem'] = 'Cadastro efetuado com sucesso';

                }else {

                    $retorno['status'] = 'false';
                    $retorno['erro'] = 'Erro ao processar a requisição de cadastro';

                }

            }else {

                $retorno['status'] = 'false';
                $retorno['marca'] = $marca;
                $retorno['modelo'] = $modelo;
                $retorno['ano'] = $ano;

            }

            

        }else {

            $retorno['status'] = 'false';
            $retorno['erro'] = 'Todos os parâmetros são necessários para requisição';

        }

        header("Content-Type: application/json");
        echo json_encode($retorno);

    }else if($_SERVER['REQUEST_METHOD'] == 'PUT') {

        $path = explode('/',$_GET['url']);

        if(!isset($path[1]) || empty($path[1]) || !is_numeric($path[1])) {

            $retorno['status'] = 'false';
            $retorno['erro'] = 'O parâmetro id é obrigatório';

        }else {

            $json = file_get_contents('php://input');
            $_PUT = json_decode($json, true);

            $validaCarroEd = Carro::getCarro($path[1]);

            if($validaCarroEd != false) {

                $updateCar = new Carro();
                $updateCar->setId($path[1]);
                $updateCar->setMarca($_PUT['marca']);
                $updateCar->setModelo($_PUT['modelo']);
                $updateCar->setAno($_PUT['ano']);
                $update = $updateCar->updateCar();

                if($update == true) {

                    $retorno['status'] = 'true';
                    $retorno['mensagem'] = 'Carro atualizado com sucesso';

                }

            }else {

                $retorno['status'] = 'false';
                $retorno['erro'] = 'O id informado não existe';

            }

            

        }

        header("Content-Type: application/json");
        echo json_encode($retorno);

    }else if($_SERVER['REQUEST_METHOD'] == 'DELETE') {

        $path = explode('/',$_GET['url']);

        if(!isset($path[1]) || empty($path[1]) || !is_numeric($path[1])) {

            $retorno['status'] = 'false';
            $retorno['erro'] = 'O parâmetro id é obrigatório';

        }else {

            $json = file_get_contents('php://input');
            $_DELETE = json_decode($json, true);

            $validaCarroEx = Carro::getCarro($path[1]);

            if($validaCarroEx != false) {

                $deleteCar = new Carro();
                $deleteCar->setId($path[1]);
                $delete = $deleteCar->deleteCar();

                if($delete == true) {

                    $retorno['status'] = 'true';
                    $retorno['mensagem'] = 'Carro excluido com sucesso';

                }else {

                    $retorno['status'] = 'false';
                    $retorno['erro'] = 'Falha ao tentar excluir';

                }

            }else {

                $retorno['status'] = 'false';
                $retorno['erro'] = 'O id informado não existe';

            }
                        

        }

        header("Content-Type: application/json");
        echo json_encode($retorno);

    }

?>