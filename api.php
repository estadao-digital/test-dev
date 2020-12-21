<?php

    require_once  'api/v1/modelos/Carro.class.php';
    require_once 'api/v1/helpers/RotasHelper.php';

    get('/carros', function () {
        $carros = Carro::pegaCarros();
        return json_encode($carros);
    });




    $acao = str_replace('/api.php', '',$_SERVER['REQUEST_URI']);
    dispatch($acao);
?>