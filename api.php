<?php
require_once('./Carro.class.php');

session_start();
$carro = new Carro;

// Recupera o tipo de requisição a variável enviada
$tipoRequest = $_SERVER['REQUEST_METHOD'];
$vars = explode('/', trim($_SERVER['PATH_INFO'],'/'));

// Verifica se a primeira parte da url é 'carros'
if (!preg_match('@carros@is', $vars[0])) {
    http_response_code(404);
    die('API nao localizada');
}

// Recupera o id do request e verifica se é numérico
$id = @$vars[1];
if ($id && !is_numeric($id)) {
    $erro = ['Status' => false, 'message' => 'O id do veiculo deve ser numerico'];
    die(json_encode($erro));
} else {
    $carro->id = $id;
}


// create SQL based on HTTP method
switch ($tipoRequest) {
    case 'GET':
        if ($carro->id) {
            $retorno = $carro->exibe();
        } else {
            $retorno = $carro->lista();
        }
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $post_data);
        $carro->marca = $post_data['marca'];
        $carro->modelo = $post_data['modelo'];
        $carro->ano = $post_data['ano'];

        if ($carro->atualiza($carro)) {
            $retorno = ['Status' => true, 'message' => 'Carro atualizado com sucesso!'];
        } else {
            $retorno = ['Status' => false, 'message' => 'Nao foi possivel atualizar o carro!'];
        }

        break;
    case 'POST':
        $carro->marca = $_POST['marca'];
        $carro->modelo = $_POST['modelo'];
        $carro->ano = $_POST['ano'];

        if ($carro->salva()) {
            $retorno = ['Status' => true, 'message' => 'Carro salvo com sucesso!'];
        } else {
            $retorno = ['Status' => false, 'message' => 'Nao foi possivel salvar o carro!'];
        }

        break;
    case 'DELETE':
        if ($carro->deleta()) {
            $retorno = ['Status' => true, 'message' => 'Carro deletado com sucesso!'];
        } else {
            $retorno = ['Status' => true, 'message' => 'Nao foi possivel deletar o carro!'];
        }

        break;
}
die(json_encode($retorno));

echo "fim da api";
