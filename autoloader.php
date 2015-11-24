<?php

function loadClasses ($pClassName) {
    $file_name = __DIR__ . "/classes/" . $pClassName . ".php";
    if(file_exists($file_name)){
        require_once($file_name);    
    }
}

function loadModels ($pClassName) {
    $file_name = __DIR__ . "/models/" . $pClassName . ".php";
    if(file_exists($file_name)){
        require_once($file_name);    
    }
}
spl_autoload_register("loadClasses");
spl_autoload_register("loadModels");

require_once __DIR__.'/ActiveRecord.php';
#class Book extends ActiveRecord\Model { }

#$b = new Book;
#$b->test = 'teste';
