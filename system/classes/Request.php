<?php

class Request
{
    public static function Method(){
        return $_SERVER["REQUEST_METHOD"];
    }
}