<?php
spl_autoload_register(
    function ($class){
        
        $classe = BASE . "application/spa/classes/$class.php";
        
        if(file_exists($classe))
            require_once($classe);

        $classe = BASE . "application/api/classes/$class.php";

        if(file_exists($classe))
            require_once($classe);        
    }
);
