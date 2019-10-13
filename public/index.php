<?php

# Aqui seria simples utilizar o autoload do próprio composer ou algum outro de terceiro. Não utilizei namespace para
# simplificar o teste.
include '../app/Controller/CarrosController.php';

$method = strtolower($_SERVER['REQUEST_METHOD']);

$arrUri = explode('/',$_SERVER['REQUEST_URI']);
$resource = trim($arrUri[1]); # $resource aqui é semrpe /carros
$controllerName = ucfirst($resource).'Controller';

# O ideal seria um loop nos parâmetros mas como teste só estabelece 1, segue:
$params = null;
if($method == 'get') {
    if(isset($arrUri[2]) && trim($arrUri[2]) != '')
        $params['id'] = $arrUri[2];
    return (new $controllerName)->$method($params);
} elseif($method == 'post') {
    $params =  $_POST;
    return (new $controllerName)->$method($params);
} elseif($method == 'put') {
    parse_str(file_get_contents("php://input"), $params); # o body deve ser necessariamente x-www-form-urlencoded
    $params['id'] = $arrUri[2];
    return (new $controllerName)->$method($params);
} elseif($method == 'delete') {
    $params['id'] = $arrUri[2];
    return (new $controllerName)->$method($params);
}