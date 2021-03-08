<?php

namespace KrupaBOX\Internal {

class Loader
{
    const NAMESPACE_MODEL_PREFIX = "Application/Server/Model/";
    const NAMESPACE_COMPONENT_PREFIX = "Application/Server/Component/";
    const NAMESPACE_CONTROLLER_PREFIX = "Application/Server/Controller/";

    const NAMESPACE_VIEW_PREFIX = "Application/Client/View/";

    public static $database = null;
    public static function handler($className)
    {
        $load = false;
        $className = stringEx($className)->replace("\\", "/");

        if (stringEx($className)->startsWith(self::NAMESPACE_CONTROLLER_PREFIX))
        {
            $controllerPath = (SERVER_FOLDER . "Controller/" . stringEx($className)->subString(stringEx(self::NAMESPACE_CONTROLLER_PREFIX)->length, (stringEx($className)->length)) . ".php");

            $config = \Config::get();
//            if ($config->compiler->controller === true)
                \PHP\Compiler\PHP7::compileToPHP5($controllerPath, true);
//            else \KrupaBOX\Internal\Engine::includeInsensitive($controllerPath);
        }

        if (stringEx($className)->startsWith(self::NAMESPACE_VIEW_PREFIX))
        {
            $viewPath = (CLIENT_FOLDER . "View/" . stringEx($className)->subString(stringEx(self::NAMESPACE_VIEW_PREFIX)->length, (stringEx($className)->length)) . ".");

            if (file_exists($viewPath . html))
                $viewPath .= html;
            elseif (file_exists($viewPath . htm))
                $viewPath .= htm;
            elseif (file_exists($viewPath . xhtml))
                $viewPath .= xhtml;

            $getCompiledView = \Render\FrontEngine\Compilation\Cache::getCachedViewReflector($viewPath);
            if ($getCompiledView == null)
            {
                $compiled = \Render\FrontEngine\Compilation\View::compile($viewPath);
                \Render\FrontEngine\Compilation\Cache::setCachedViewReflector($viewPath, $compiled);
                $getCompiledView = \Render\FrontEngine\Compilation\Cache::getCachedViewReflector($viewPath);
            }

            if ($getCompiledView != null)
            {
                $cacheViewPath = \Render\FrontEngine\Compilation\Cache::getCachedPathViewReflector($viewPath);
                if ($cacheViewPath != null && !stringEx($cacheViewPath)->isEmpty())
                    \KrupaBOX\Internal\Kernel::filePathsToRegisterInclude($cacheViewPath);

                return;
            }
        }

        try
        {
            if (stringEx($className)->startsWith(self::NAMESPACE_MODEL_PREFIX) && file_exists(SERVER_FOLDER . "Model/" . stringEx($className)->subString(stringEx(self::NAMESPACE_MODEL_PREFIX)->length, (stringEx($className)->length)) . ".php"))
            {
                self::modelLoad($className);
                $instanceName = stringEx($className)->replace("/", "\\");

                $reflector = new \ReflectionClass($instanceName);
                    if ($reflector->hasMethod("__onConstructStatic") && $reflector->getMethod("__onConstructStatic")->isStatic())
                        $instanceName::__onConstructStatic();

                return;
            }

            if ($load == false && stringEx($className)->startsWith(self::NAMESPACE_COMPONENT_PREFIX) && file_exists(SERVER_FOLDER . "Component/" . stringEx($className)->subString(stringEx(self::NAMESPACE_COMPONENT_PREFIX)->length, (stringEx($className)->length)) . ".php")) {
                $filePath = (SERVER_FOLDER . "Component/" . stringEx($className)->subString(stringEx(self::NAMESPACE_COMPONENT_PREFIX)->length, (stringEx($className)->length)) . ".php");

                $config = \Config::get();
//                if ($config->compiler->component == true)
                    \PHP\Compiler\PHP7::compileToPHP5($filePath, true);
//                else \KrupaBOX\Internal\Kernel::filePathsToRegisterInclude($filePath);
            }
        }
        catch (Exception $e) {}

        try
        {
            if (file_exists(__KRUPA_PATH_INTERNAL__ . "System/" . $className . ".php"))
            {
                $filePath = (__KRUPA_PATH_INTERNAL__ . "System/" . $className . ".php");
                \KrupaBOX\Internal\Kernel::filePathsToRegisterInclude($filePath);

                $instanceName = stringEx($className)->replace("/", "\\");
                $reflector = new \ReflectionClass($instanceName);
                if ($reflector->hasMethod("__onConstructStatic") && $reflector->getMethod("__onConstructStatic")->isStatic())
                    $instanceName::__onConstructStatic();

                return;
            }
        } catch (Exception $e) {}
    }

    public static $currentDbHash = null;
    protected static function __verifyMigration()
    {
        $config = \Config::get();

        $db = ["default" => array(
            dsn	         => "",
            hostname     => $config->database->host,
            password     => $config->database->password,
            username     => $config->database->username,
            database     => "",
            dbdriver     => $config->database->driver,
            dbprefix     => "",
            pconnect     => FALSE,
            db_debug     => false,
            cache_on     => FALSE,
            cachedir     => "application/cache/query",
            char_set     => "utf8",
            dbcollat     => "utf8_unicode_ci",
            swap_pre     => "",
            encrypt      => FALSE,
            compress     => FALSE,
            stricton     => FALSE,
            failover     => [],
            save_queries => TRUE
        )];

        if (stringEx($config->database->driver)->toLower() == "mysqli" && !@function_exists("mysqli_init"))
        { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing MYSQLI extension."]); exit; }

        @\CodeIgniter::getInstance()->
        load->database($db['default'], FALSE, TRUE);

        // Check migration
        if (self::$currentDbHash == null) {
            $config = \Config::get();
            if ($config->database->cache->redis === true) {
                $key = ".krupabox." . ROOT_HASH . ".database.global.structure.blob";
                self::$currentDbHash = \KrupaBOX\Internal\Kernel::getRedis()->get($key);
            }
            else {
                self::$currentDbHash = toString(\File::getContents("cache://.krupabox/database/.global/.structure.blob"));
            }
        }


        $dbConfig = \Database::getConfig();
        $dbConfig->_serverSid = \Config::get()->server->sid;
        $dbHash   = \Security\Hash::toSha1($dbConfig);

        if (self::$currentDbHash != $dbHash)
        {
            self::$currentDbHash = $dbHash;
            $__CI = \CodeIgniter::getInstance();
            $__CI->load->dbutil();
            $databases = $__CI->dbutil->list_databases();
            $findDb = false;
            foreach ($databases as $_database)
                if ($_database == $dbConfig->sid)
                { $findDb = true; break; }

            if ($findDb == false) {
                $__CI->load->dbforge();
                $__CI->dbforge->create_database($dbConfig->sid);
            }

            $config = \Config::get();
            if ($config->database->cache->redis === true) {
                $key = ".krupabox." . ROOT_HASH . ".database.global.structure.blob";
                \KrupaBOX\Internal\Kernel::getRedis()->set($key, $dbHash);
            }
            else {
                \File::setContents("cache://.krupabox/database/.global/.structure.blob", $dbHash);
            }

        }
    }

    protected static $__isFirstLinkDB = false;
    public static function loadLinkDB()
    {
        $config = \Config::get();

        if (self::$__isFirstLinkDB == false && $config->database->migration == true) {
            self::__verifyMigration();
            self::$__isFirstLinkDB = true;
        }

        $db = ["default" => array(
            dsn	         => "",
            hostname     => $config->database->host,
            password     => $config->database->password,
            username     => $config->database->username,
            database     => $config->database->sid,
            dbdriver     => $config->database->driver,
            dbprefix     => "",
            pconnect     => FALSE,
            db_debug     => false,
            cache_on     => FALSE,
            cachedir     => "application/cache/query",
            char_set     => "utf8",
            dbcollat     => "utf8_unicode_ci",
            swap_pre     => "",
            encrypt      => FALSE,
            compress     => FALSE,
            stricton     => FALSE,
            failover     => [],
            save_queries => TRUE
        )];

        if ($config->database->sid == null || $config->database->sid == "")
            throw new \Exception(
                "Database error: " . 500 . "\n" .
                "Message: "        . "Missing database config."
            );

        if (stringEx($config->database->driver)->toLower() == "mysqli" && !@function_exists("mysqli_init"))
        { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing MYSQLI extension."]); exit; }

        @\CodeIgniter::getInstance()->
            load->database($db['default'], FALSE, TRUE);
    }
    
    private static function modelLoad($className)
    {
        self::loadLinkDB();

        $config = \Config::get();
        $filePath = (SERVER_FOLDER . "Model/" . stringEx($className)->subString(stringEx(self::NAMESPACE_MODEL_PREFIX)->length, (stringEx($className)->length)) . ".php");

//        if ($config->compiler->model == true)
            \PHP\Compiler\PHP7::compileToPHP5($filePath, true, true);
//        else \KrupaBOX\Internal\Kernel::filePathsToRegisterInclude($filePath);
    }
    
    public static $dbx = null;
}




//if (ENVIRONMENT == "development") error_reporting(E_ALL & ~E_NOTICE);

}