<?php

    $token = getallheaders();
    if(!isset($token['token']) || $token['token'] != TOKEN_CLIENT) {
        echo 'Acesso negado - Token Inválido';
        die();
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET') {

        

    }

?>