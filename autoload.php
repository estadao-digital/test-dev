<?php

spl_autoload_register(
    function ($class){

        $classe = BASE . "spa/classes/$class.php";
        
        if(file_exists($classe))
            require_once($classe);

        $classe = BASE . "api/classes/$class.php";
        
        if(file_exists($classe))
            require_once($classe);
        
    }
);
