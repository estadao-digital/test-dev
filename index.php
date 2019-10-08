<?php
    require_once("system/System.php");
    include_once("settings.php");
    include_once("autoload.php");


    System::setUrl(array(
        "carros"                 => "api.CarroController.LerAdicionarCarros",
        "carros/(?P<id>[0-9]+?)" => "api.CarroController.Carro",
    ));

    new System();