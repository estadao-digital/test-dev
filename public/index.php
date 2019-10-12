<?php

# Aqui seria simples utilizar o autoload do próprio composer ou algum outro de terceiro. Não utilizei namespace para
# simplificar o teste.
include '../app/Controller/CarrosController.php';

$arrUri = explode('/',$_SERVER['REQUEST_URI']);
$resource = trim($arrUri[1]);

$method = strtolower($_SERVER['REQUEST_METHOD']);

$className = ucfirst($resource).'Controller';

# O ideal seria um loop nos parâmetros mas como teste só estabelece 1, segue:
$params = null;
if($method == 'get') {
    $params['id'] = $arrUri[2];
    return (new $className)->$method($params);
} elseif($method == 'post') {
    $params =  $_POST;
    return (new $className)->$method($params);
} elseif($method == 'put') {
    parse_str(file_get_contents("php://input"), $params); # o body deve ser necessariamente x-www-form-urlencoded
    $params['id'] = $arrUri[2];
    return (new $className)->$method($params);
} elseif($method == 'delete') {
    $params['id'] = $arrUri[2];
    return (new $className)->$method($params);
}


# O parâmetro do path (que seria a "?query string" do path no HTTP padrão) está sendo passado como partâmetro para o
# método porém,  poderia ser armazenado no padrão Registry, carregado em um objeto Request ou até mesmo manipulado
# diretamente dentro do método através da variável global $_SERVER.
