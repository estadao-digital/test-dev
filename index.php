<?php

    require_once("system/System.php");
    include_once("settings.php");


    System::setUrl(array(
        "" => "teste"
    ));

    new System();