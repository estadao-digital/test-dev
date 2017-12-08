<?php

require_once "Carro.class.php";

$method = $_SERVER['REQUEST_METHOD'];
//$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
//$input = json_decode(file_get_contents('php://input'),true);

//$method= $_GET["var"];
$carro = new Carro();


if($method=="GET"){
    $carro->listaCarro();
}elseif ($method=="PUT") {
    $id    =isset($_PUT["id"]) ? $_PUT["id"] : '' ;
    $marca =isset($_PUT["marca"]) ? $_PUT["marca"] : '' ;
    $modelo=isset($_PUT["modelo"]) ? $_PUT["modelo"] : '' ;
    $ano   =isset($_PUT["ano"]) ? $_PUT["ano"] : '' ;
    $carro->setId($id);
    $carro->setMarca($marca);
    $carro->setModelo($modelo);
    $carro->setAno($ano);
    $carro->editarCarro();
}elseif ($method=="POST") {
    $marca =isset($_POST["marca"]) ? $_POST["marca"] : '' ;
    $modelo=isset($_POST["modelo"]) ? $_POST["modelo"] : '' ;
    $ano   =isset($_POST["ano"]) ? $_POST["ano"] : '' ;
    $carro->setMarca($marca);
    $carro->setModelo($modelo);
    $carro->setAno($ano);
    $carro->incluirCarro();
}elseif ($method=="DELETE") {
    $id    =isset($_DELETE["id"]) ? $_DELETE["id"] : '' ;
    $carro->setId($id);
    $carro->excliurCarro();
}




