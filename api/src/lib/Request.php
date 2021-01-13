<?php

namespace app\lib;

abstract class Request {

    public static function post() {
        return $_POST ?? [];
    }

    public static function get() {
        return $_GET ?? [];
    }

    public static function put() {
        parse_str(file_get_contents('php://input'), $data);
        return $data ?? [];
    }
}