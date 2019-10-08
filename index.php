<?php
    
    header('Access-Control-Allow-Origin: *');
    require_once("system/System.php");
    include_once("settings.php");
    include_once("autoload.php");


    System::setUrl(array(
        "" => "api.CarroController.Teste",
        "carros"                 => "api.CarroController.LerAdicionarCarros",
        "carros/(?P<id>[0-9]+?)" => "api.CarroController.Carro",
    ));

    new System();

?>