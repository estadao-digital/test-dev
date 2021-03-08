<?php

namespace KrupaBOX\Internal\Error {

class Visual
{
    protected static $alreadyRegistered = false;
    protected static $errorHandler      = null;

    public static function register()
    {
        if (self::$alreadyRegistered == true)
            return;

        //\KrupaBOX\Internal\Library::load("PHPError");
        \Import::PHP(__KRUPA_PATH_LIBRARY__ . ".plain/php_error.php");
        ini_set("display_errors", "Off");
        self::$errorHandler = \php_error\reportErrors();

        self::$alreadyRegistered = true;
    }
    
    public static function ajaxHandler($code, $message, $file, $line, $context)
    {
        if (IS_DEVELOPMENT == false)
        {
            // TODO: better ajax report error
            //die();    
        }
        
        // TODO: if Ajax -> send error with json
        // die()
    }
    
    // TODO: ajax data send method
    public static function onErrorVisualHandler($contents)
    {
        if (method_exists("Config", "get"))
        {
            $config = \Config::get();
            if ($config->server->environment == release)
            {
                try { @ob_clean(); } catch (Exception $ex) {}

//                if (method_exists("Security\\Cryptography", "toRijndael128"))
//                    $contents = \Security\Cryptography::toRijndael128($contents, $config->server->cryptographyKey);

//                if (method_exists("Security\\JsonWebToken", "encode"))
//                {
//                    $key = new \Security\Key($config->server->cryptographyKey);
//                    $contents = \Security\JsonWebToken::encode($contents, $key);
//                }
//                else $contents = "* PRIVATE ERROR LOG ONLY *";

                echo json_encode([error => "INTERNAL_SERVER_ERROR", message => $contents]);
                \KrupaBOX\Internal\Kernel::exit();
            }
        }
    }
}

Visual::register();

}
