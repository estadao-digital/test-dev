<?php
use Slim\Http\Request;
use Slim\Http\Response;

// index
$app->get('/', function (Request $request, Response $response) {    
    require 'public/spa.php';
});

// retornar todos os carros cadastrados.
$app->get('/api/carros/', function (Request $request, Response $response) {    
    $baseDados  = new baseDados;    
    $carros     = $baseDados->lerCarros();
    if(!$carros)
        $carros['msg'] = 'Nenhum veiculo cadastro';

    $newResponse = $response->withJson($carros, 200);
    return $newResponse;    
});

// cadastrar um novo carro.
$app->post('/api/carros/', function (Request $request, Response $response) {

    $marca  = $request->getParam('inputMarca');
    $modelo = $request->getParam('inputModelo');
    $ano    = intval( $request->getParam('inputAno') );

    if(!empty($marca) && !empty($modelo) && !empty($ano)){
        $baseDados  = new baseDados;    
        $carros     = $baseDados->lerCarros();
        $carros[]   = ['marca' => $marca, 'modelo' => $modelo, 'ano' => $ano ];
        $baseDados->gravarArquivo($carros);
        $retorno['msg'] = 'Veiculo cadastro com sucesso';
        $status = 200;
    }else{
        $retorno['msg'] = 'Cadastro não realizado. Preencha todos os campos';
        $status = 400;
    }

    $newResponse = $response->withJson($retorno, $status);
    return $newResponse;    
});

// retornar o carro com ID especificado.
$app->get('/api/carros/{id}', function (Request $request, Response $response) {    
    $id = intval($request->getAttribute('id')); 
    if($id >= 0 && is_integer($id)){
        $baseDados  = new baseDados;    
        $carros     = $baseDados->lerCarros();
        if(array_key_exists($id, $carros)){
            $retorno    = $carros[$id];
            $status     = 200;
        }else{
            $retorno['msg'] = 'Codigo do veiculo não encontrado';
            $status         =  400;
        }
    }else{
        $retorno['msg'] = 'Codigo do veiculo inválido ';
        $status         = 400;
    }

    $newResponse = $response->withJson($retorno, $status);
    return $newResponse;    

});

// atualizar os dados do carro com ID especificado.
$app->put('/api/carros/{id}', function (Request $request, Response $response) {
    
    $marca  = $request->getParam('inputMarca');
    $modelo = $request->getParam('inputModelo');
    $ano    = intval( $request->getParam('inputAno') );
    
    $id     = $request->getAttribute('id');
    

    if(!empty($marca) && !empty($modelo) && !empty($ano)){
        $baseDados  = new baseDados;    
        $carros     = $baseDados->lerCarros();
        if(array_key_exists($id, $carros)){
            $carros[$id]   = ['marca' => $marca, 'modelo' => $modelo, 'ano' => $ano ];
            $baseDados->gravarArquivo($carros);
            $retorno['msg'] = 'Veiculo alterado com sucesso';
            $status = 200;
        }else{
            $retorno['msg'] = 'Codigo do veiculo não encontrado';
            $status         =  400;
        }        
    }else{
        $retorno['msg'] = 'Cadastro não atualizado. Preencha todos os campos';
        $status = 400;
    }

    $newResponse = $response->withJson($retorno, $status);
    return $newResponse;    
});

// apagar o carro com ID especificado.
$app->delete('/api/carros/{id}', function (Request $request, Response $response) {    
        $id = $request->getAttribute('id'); 
        $baseDados  = new baseDados;    
        $carros     = $baseDados->lerCarros();
        if(array_key_exists($id, $carros)){
            unset($carros[$id]);
            $baseDados->gravarArquivo($carros);
            $retorno['msg'] = 'Caddastro excluido com sucesso';
            $status     = 200;
        }else{
            $retorno['msg'] = 'Codigo do veiculo não encontrado';
            $status         =  400;
        }    
    $newResponse = $response->withJson($retorno, $status);
    return $newResponse; 
});