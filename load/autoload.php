<?php

spl_autoload_register(
    function($classe){
        $file = str_replace("\\","/",$classe).".php";
        if(file_exists($file)){
            require_once $file;
        }
    }
);