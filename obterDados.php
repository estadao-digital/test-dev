<?php
require_once "Carro.class.php";

$obj = new Carro();

$id = $_POST['id'];

echo $obj->obterDados($id);
