<?php

class JavaScript
{
    protected static $_isLoaded = false;
    protected static function _load()
    {
        if (self::$_isLoaded == true) return null;

        if (@class_exists("V8Js") == false)
        { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", message => "Missing V8JS binary."]); \KrupaBOX\Internal\Kernel::exit(); }

        self::$_isLoaded = true;
    }

    public static function fromJS($code)
    {
        self::_load();
        $v8 = new \V8Js();
        return @$v8->executeString($code);
    }

    public static function getVersion()      { return null; }
    public static function getMajorVersion() { return null; }
    public static function getMinorVersion() { return null; }
}