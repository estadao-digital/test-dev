<?php

    require_once  'api/v1/modelos/Carro.class.php';
    require_once  'api/v1/modelos/Marca.class.php';
    require_once 'api/v1/helpers/RotasHelper.php';

    //devolve todos os carros
    get('/carros', function () {
        $carros = Carro::pegaCarros();
        return json_encode($carros);
    });

    //Adiciona um novo carro no banco
    post('/carros', function () {
        $carro = new Carro();
        $carro->Marca = $_POST['Marca'];
        $carro->Modelo = $_POST['Modelo'];
        $carro->Ano = $_POST['Ano'];
        return json_encode($carro->salva());
    });

    //Pega um carro por ID
    get('/carros/{id}', function ($id) {
        $carro = Carro::pegaCarroPorId($id);
        return json_encode($carro);
    });

    //Atualiza um carro por ID
    put('/carros/{id}', function ($id) {
        $carro = Carro::pegaCarroPorId($id);
        parse_str(file_get_contents("php://input"),$_PUT);
        $carro->Marca = $_PUT['Marca'];
        $carro->Modelo = $_PUT['Modelo'];
        $carro->Ano = $_PUT['Ano'];
        return json_encode($carro->salva());
    });

    //Deleta o carro por ID
    delete('/carros/{id}', function ($id) {
        Carro::deleta($id);
    });


    //ROTAS DAS MARCAS

    //devolve todas as marcas
    get('/marcas', function () {
        $marcas = Marca::pegaMarcas();
        return json_encode($marcas);
    });

    //Adiciona uma nova marca no banco
    post('/marcas', function () {
        $marca = new Marca();
        $marca->Marca = $_POST['Marca'];
        return json_encode($marca->salva());
    });

    //Pega uma marca por ID
    get('/marcas/{id}', function ($id) {
        $marca = Marca::pegaMarcaPorId($id);
        return json_encode($marca);
    });

    //Atualiza uma marca por ID
    put('/marcas/{id}', function ($id) {
        $marca = Marca::pegaMarcaPorId($id);
        parse_str(file_get_contents("php://input"),$_PUT);
        $marca->Marca = $_PUT['Marca'];
        return json_encode($marca->salva());
    });

    //Deleta a marca por ID
    delete('/marcas/{id}', function ($id) {
        Marca::deleta($id);
    });



    //Estou tirando o '/api.php' das urls antes de chamar o dispatch do RotasHelper
    $acao = str_replace('/api.php', '',$_SERVER['REQUEST_URI']);
    dispatch($acao);
