<?php 
require_once "Carro.class.php";

$obj = new Carro();

$dados = array(
    $_POST['marca'],
    $_POST['modelo'],
    $_POST['ano']
);

echo $obj->criarCarro($dados);
