<?php

namespace App\Views\Template;

class Styles{

    public static function getStyles(){
        ?>
       <link href="dist/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
       <link href="dist/vendor/fontawesome/fontawesome.min.css" rel="stylesheet" >
       <link href="dist/vendor/jquery/ui/jquery-ui.css" rel="stylesheet" >

       <link href="dist/css/cars.css" rel="stylesheet">
       
        <?php
    }
}