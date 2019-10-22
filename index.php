<?php
require_once('Core/Rotas.php');
require_once('Model/Model.php');
require_once('Model/Carro.class.php');

route('/', function () {
    $model = new Carro();
    return $model->create_table();
});
route('/about', function () {
    return "Hello form the about route";
});
$action = $_SERVER['REQUEST_URI'];
dispatch($action);
?>