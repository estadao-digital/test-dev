<?php
    
    header('Access-Control-Allow-Origin: *');
    require_once("system/System.php");
    include_once("settings.php");
    include_once("autoload.php");


    System::setUrl(array(
        "carros"                 => "api.CarroController.LerAdicionarCarros",
        "carros/(?P<id>[0-9]+?)" => "api.CarroController.Carros",
    ));

    System::setUrl(array(
        ""              => "spa.MainController.Page",
        "home"          => "spa.MainController.Home",
        "form"          => "spa.MainController.Form",
    ));

    new System();

?>