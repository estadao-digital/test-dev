<?php

# Aqui seria simples utilizar o autoload do próprio composer ou algum de terceiro porém, para este teste procurei não
# utilizar o composer e sendo assim não utilizei autoload. Também não criei um autoload na mão pois levaria algum tempo
# precioso para a avaliação do meu teste. Pelo mesmo motivo não usei namespace.
include 'app/Controller/CarrosController.php';

$uri = explode('/',$_SERVER['REQUEST_URI']);

$resource = trim($uri[1]);


if($resource == '') {
    include 'public/index.html';
    exit();
}

$className = ucfirst($resource).'Controller';

$method = strtolower($_SERVER['REQUEST_METHOD']);

# O ideal seria um loop nos parâmetros mas como teste só estabelece 1, segue:
$params = null;
if($method == 'get' && isset($uri[2]) && trim($uri[2]) != '') {
    $params['id'] =  $uri[2];
} elseif($method == 'post') {
    $params =  $_POST;
} elseif($method == 'put') {
    parse_str(file_get_contents("php://input"), $params); # o body deve ser necessariamente x-www-form-urlencoded
    $params['id'] = $uri[2];
} elseif($method == 'delete') {
    $params['id'] = $uri[2];
}


# O parâmetro do path (que seria a "?query string" do path no HTTP padrão) está sendo passado como partâmetro para o
# método porém,  poderia ser armazenado no padrão Registry, carregado em um objeto Request ou até mesmo manipulado
# diretamente dentro do método através da variável global $_SERVER.
return (new $className)->$method($params);