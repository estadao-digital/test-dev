<?php
require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App();
$container = $app->getContainer();
$container['Carro'] = function() {
    return new Model\Carro();
};

$app->get('/carros', function ($request, $response, $args) {
    try {
        $return = $this->Carro->listar();
        $status = 200;
    } catch (\Exception $e) {
        // Todo: log
        $return = ['message' => $e->getMessage()];
        $status = 500;
    }
    return $response->withJson($return, $status);
});

$app->post('/carros', function ($request, $response, $args) {
    try {
        $data = $request->getParams();
        if (empty($data['marca']) || empty($data['modelo']) || empty($data['ano'])) {
            throw new Exception('Verique campos em branco');
        }
        if ($this->Carro->incluir($data)) {
            $return = ['message' => 'Carro salvo com sucesso'];
            $status = 200;
        } else {
            $return = ['message' => 'Falha inesperada ao salvar carro'];
            $status = 500;
        }
    } catch (\Exception $e) {
        // Todo: log
        $return = ['message' => $e->getMessage()];
        $status = 400;
    }
    return $response->withJson($return, $status);
});

$app->get('/carros/{id}', function ($request, $response, $args) {
    try {
        $return = $this->Carro->get($args['id']);
        $status = 200;
    } catch (\Exception $e) {
        // Todo: log
        $return = ['message' => $e->getMessage()];
        $status = 404;
    }
    return $response->withJson($return, $status);
});

$app->put('/carros/{id}', function ($request, $response, $args) {
    try {
        $data = $request->getParams();
        if (empty($data['marca']) || empty($data['modelo']) || empty($data['ano'])) {
            throw new Exception('Verique campos em branco');
        }

        if ($this->Carro->editar($args['id'], $data)) {
            $return = ['message' => 'Carro atualizado com sucesso'];
            $status = 200;
        } else {
            $return = ['message' => 'Falha inesperada ao atualizar carro'];
            $status = 500;
        }
    } catch (\Exception $e) {
        // Todo: log
        $return = ['message' => $e->getMessage()];
        $status = 404;
    }
    return $response->withJson($return, $status);
});

$app->delete('/carros/{id}', function ($request, $response, $args) {
    try {
        if ($this->Carro->excluir($args['id'])) {
            $return = ['message' => 'Carro excluído com sucesso'];
            $status = 200;
        } else {
            $return = ['message' => 'Falha inesperada ao excluir carro'];
            $status = 500;
        }
    } catch (\Exception $e) {
        // Todo: log
        $return = ['message' => $e->getMessage()];
        $status = 404;
    }
    return $response->withJson($return, $status);
});

return $app;
