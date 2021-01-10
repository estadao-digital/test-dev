<?php

namespace App\Views\Template;



class Template{

    public static function getTemplate($view){
        include "app/Views/Template/Header.php";
        include "app/Views/Template/Nav.php";
        include "app/Views/$view.php";
        include "app/Views/Template/Footer.php";
    }
}