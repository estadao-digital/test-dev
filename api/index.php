<?php
session_start(); # Inicio a Sessão

header('Content-Type: application/json'); # A resposta desse arquivo sempre sera um json

$response = []; # Resposta padrão

$method = $_SERVER['REQUEST_METHOD']; #Reconheço qual metodo vai ser usado

include 'Carro.class.php';

$url = $_SERVER['REQUEST_URI']; #Pego toda a url
$pages = array_filter(explode('/', $url)); #pego cada parte da url para usa-la

$preSet = ['id', 'Marca', 'Modelo', 'Ano']; #apenas esses dados serao passados para a base
//$_POST = array_intersect($preSet, $_POST);

if ($pages[1]) {
    $carro = new carro();

    #Quando o metodo é um GET
    if ($method == 'GET') {
        #Se esta buscando um ID expecifico mostro ele caso contrario mostro tudo
        if (isset($pages[3])) {
            $response = $carro->load($pages[3]);
        } else {
            $response = $carro->load();
        }
    }
    #Quando o metodo é um post
    if ($method == 'POST') {
        #Monto a resposta com o status e o id do item criado
        $response = [
            'id' => $carro->create([$pages[2] => $_POST]),
            'status' => '200'
        ];
    }

    #Quando o metodo é um put
    if ($method == 'PUT') {
        #Pego o que foi recebido em formato de json e converto para um array
        $data = json_decode(file_get_contents("php://input"), true);
        #Com o array recebido mando ele e o id do item para a alteracao
        $carro->edit($pages[3], [$pages[2] => $data]);
        #respondo com o id e o status 200
        $response = ['id' => $pages[2],
            'status' => '200'];
    }

    #Quando o metodo é um delete
    if ($method == 'DELETE') {
        #mando o id para ser apagado e respondo com 200
        $carro->delete($pages[3]);
        $response = ['status' => '200'];
    }
}

#por fim mostro o resultado
echo json_encode($response, JSON_PRETTY_PRINT);
?>