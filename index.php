<?php
require_once('Core/Rotas.php');
route('/', function () {
    return "Hello World";
});
route('/about', function () {
    return "Hello form the about route";
});
$action = $_SERVER['REQUEST_URI'];
dispatch($action);
?>