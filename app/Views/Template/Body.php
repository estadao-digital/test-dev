<?php

namespace App\Views\Template;



class Body{

    public static function getBody($view){
        include "app/Views/$view.php";
    }
}