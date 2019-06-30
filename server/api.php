<?php
//session_start();
header("Content-type: application/json; charset=utf-8");

require('Response.class.php');
require('CarrosHandler.class.php');


// Variável que contem o método http utilizado na requisição 
$method = $_SERVER["REQUEST_METHOD"];


// URL da requisição efetuada.
$uri = $_SERVER['REQUEST_URI'];

// Variável que contem true ou false caso a requição contenha algum parâmetro
$reqHasParams = !preg_match("/carros\/?$/", $uri);

$response = new Response(404, "Nada Encontrado", []);

switch ($method) {
        // Execute este bloco caso a requisição foi feita utilizando o método GET 
    case "GET":
        // Verifica se na url foi passada algum parâmetro
        if ($reqHasParams) {
            // Recupera o valor do parâmetro
            $uriParam = getParam($uri);

            // Objeto Response contendo os dados que serão repondidos
            $response = CarrosHandler::getInstance()->selectCarroById($uriParam);
        } else {
            // Objeto Response contendo os dados que serão repondidos
            $response = CarrosHandler::getInstance()->selectCarros();
        }

        break;

        // Execute este bloco caso a requisição foi feita utilizando o método POST
    case "POST":
        // Recupera os dados do corpo enviado na requisição
        $reqBody = file_get_contents('php://input');


        // Objeto Response contendo os dados que serão repondidos
        $response = CarrosHandler::getInstance()->insertCarro($reqBody);


        break;
        // Execute este bloco caso a requisição foi feita utilizando o método PUT
    case "PUT":
        // Verifica se na url foi passada algum parâmetro
        if ($reqHasParams) {
            // Recupera o valor do parâmetro
            $uriParam = getParam($uri);

            // Recupera os dados do corpo enviado na requisição
            $reqBody = file_get_contents('php://input');

            // Objeto Response contendo os dados que serão repondidos
            $response = CarrosHandler::getInstance()->updateCarro($uriParam, $reqBody);
        } else {
            // Objeto Response contendo os dados que serão repondidos caso o parâmetro não seja passado na requisição
            $response = new Response(400, "A função put precisa de um parâmetro.", []);
        }

        break;
        // Execute este bloco caso a requisição foi feita utilizando o método DELETE
    case "DELETE":
        // Verifica se na url foi passada algum parâmetro
        if ($reqHasParams) {
            // Recupera o valor do parâmetro
            $uriParam = getParam($uri);

            // Objeto Response contendo os dados que serão repondidos
            $response = CarrosHandler::getInstance()->deleteCarro($uriParam);
        } else {

            // Objeto Response contendo os dados que serão repondidos caso o parâmetro não seja passado na requisição
            $response = new Response(400, "A função delete precisa de um parâmetro.", []);
        }
        break;
    default:
        break;
}

// Função que insere o código de status http na resposta 
http_response_code($response->getStatusCode());

// Escreve no corpo da resposta o resultado da requisição efetuada
print_r($response->getJsonAll());

// Função que retorna o valor do parâmetro passado pela url
function getParam($uri)
{
    $uriParam = explode('carros/', $uri);
    return $uriParam[1];
}
