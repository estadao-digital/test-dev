<?php

namespace Core;

class Output{

    public static function JSON($array){
        @header('Content-Type: application/json');
        echo json_encode($array);
    }
}