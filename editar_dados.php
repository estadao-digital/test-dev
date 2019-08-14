<?php
require_once "Carro.class.php";

$obj = new Carro();

$dados = array(
    $_POST['idU'],
    $_POST['modeloU'],
    $_POST['marcaU'],
    $_POST['anoU'],
);

echo $obj->editarDados($dados);