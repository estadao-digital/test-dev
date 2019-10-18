<?php

    $token = getallheaders();
    if(!isset($token['token']) || $token['token'] != TOKEN_CLIENT) {
        echo 'Acesso negado - Token Inválido';
        die();
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET') {

        $path = explode('/',$_GET['url']);

        if($path[0] == 'marcas' && empty($path[1])) {

            $listar = Carro::getMarcas();

            $cont = 0;
            foreach ($listar as $key => $value) {
                $retorno[$cont]['id'] = $value['id'];
                $retorno[$cont]['marca'] = $value['marca'];

                $cont = $cont + 1;
            }

        }

        echo json_encode($retorno);

    }else {

        $retorno['status'] = 'false';
        $retorno['erro'] = 'Método enviado incorreto';
        echo json_encode($retorno);
    }

?>