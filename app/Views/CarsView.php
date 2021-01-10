<?php

namespace App\Views;

use App\Views\Template\Header;

class CarsView{

    public static function index(){
        Header::getHeader();
    }
}