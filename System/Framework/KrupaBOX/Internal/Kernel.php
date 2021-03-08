<?php

namespace
{
    // Deprecated
    const IS_DEVELOPMENT = true;
    const VISUAL_DEBUGGER_ENABLED = true;
    const CONSOLE_DEBUGGER_ENABLED = true;
    const AJAX_DEBUGGER_ENABLED = true;
    const FILE_DEBUGGER_ENABLED = true;

    function scalar($value)
    {
        $type = gettype($value);

        if ($type == "string")
            return \stringEx($value);
        elseif ($type == "integer")
            return \intEx($value);
        elseif ($type == "double")
            return \floatEx($value);
        elseif ($type == "boolean")
            return \boolEx($value);

        return $value;
    }

    const undefined = null;
}

namespace KrupaBOX\Internal
{
    define("APPLICATION_FOLDER", (__KRUPA_PATH_ROOT__ . "Application/"));
    define("SERVER_FOLDER", (APPLICATION_FOLDER . "Server/"));
    define("CLIENT_FOLDER", (APPLICATION_FOLDER . "Client/"));

    class Kernel
    {
        protected static $isDonePredefinedCheck = false;
        
        protected static $predefinedClasses = null;
        protected static $predefinedFunctions = null;
        
        protected static $instance = null;
        protected static $isCoreLoaded = false;
        protected static $isOutsideCoreLoad = false;

        protected static $filePathsToRegisterIncludeArr = [];

        public static $configApp = null;
        public static $configSidApp = null;
        public static $configSid = null;

        public static function isCoreLoaded()
        { return self::$isCoreLoaded; }

        public static function filePathsToRegisterInclude($filePath, $include = true)
        {
            $filePathsToRegisterIncludeArr[] = $filePath;

            if ($include == true) {
                if (method_exists('Import','PHP'))
                    \Import::PHP($filePath);
                else \KrupaBOX\Internal\Engine::includeInsensitive($filePath);
            }
        }

        protected static $redis = null;

        public static function exit()
        {
            if (self::$redis !== null)
                self::$redis->close();
            exit;
        }

        public static function getRedis()
        {
            $config = \Config::get();

            if ($config->database->cache->redis === true || $config->render->cache->redis === true) {
                if (self::$redis !== null)
                    return self::$redis;

                self::$redis = new \Redis();
                self::$redis->connect($config->redis->host, $config->redis->port);

                if (defined('Redis::SERIALIZER_IGBINARY'))
                    self::$redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_IGBINARY);

                return self::$redis;
            }

            return null;
        }

        public static function onInitialize()
        {
            self::setupConfig();

            //self::hookPredefined();
            self::$instance = new self();

            //@\apache_setenv('no-gzip', 1);
            @\ini_set('zlib.output_compression', 0);
            @\ini_set('implicit_flush', 1);

            @\ini_set('opcache.save_comments', 1);
            @\ini_set('opcache.max_accelerated_file', 65406);

            $memoryConsumption = (int)ini_get('opcache.memory_consumption');
            if ($memoryConsumption > 0 && $memoryConsumption < 256)
                @\ini_set('opcache.memory_consumption', 256);

            \KrupaBOX\Internal\Error::register("default");
            \KrupaBOX\Internal\Core::load();

            if (function_exists("mb_strtolower") == false || mb_strtolower("Index") != "index")
            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing MBSTRING extension."]); exit; }

            self::$isCoreLoaded = true;

            \KrupaBOX\Internal\Library::load("Symfony");

            // Initialize Redis
            self::getRedis();

            // Events: onAwake
            if (\File::exists(SERVER_FOLDER . "Event/OnAwake.php")) {
                \Import::PHP(SERVER_FOLDER . "Event/OnAwake.php");
                if (\ClassEx::exists("Application\\Server\\Event\\OnAwake")) {
                    $instanceName = ("Application\\Server\\Event\\OnAwake");
                    $reflector = new \ReflectionClass($instanceName);
                    if ($reflector->hasMethod("onAwake")) {
                        $method = $reflector->getMethod("onAwake");
                        if ($method->isStatic() && $method->isPublic())
                            $instanceName::onAwake();
                    }
                }
            }

            \KrupaBOX\Internal\Routes::run();
        }

        public function __construct()
        { spl_autoload_register([__CLASS__, 'autoLoader']); }
        
        public function autoLoader($className)
        {
            if (self::$isCoreLoaded == false)
            {
                $filePath = (__KRUPA_PATH_INTERNAL__ . $className);
                $filePath = str_replace("KrupaBOX/KrupaBOX", "KrupaBOX", $filePath);
                $filePath = str_replace("\\", "/", $filePath) . ".php";
                
                if (@file_exists($filePath))
                    \KrupaBOX\Internal\Engine::includeInsensitive($filePath);
    
                return null;
            }
            
            \KrupaBOX\Internal\Loader::handler($className);
        }
        
        protected static function hookPredefined()
        {
            if (self::$isDonePredefinedCheck == true)
                return;
                
            self::$predefinedClasses = get_declared_classes();
            self::$predefinedFunctions = get_defined_functions();

            unset(self::$predefinedClasses[(count(self::$predefinedClasses) - 1)]);
            unset(self::$predefinedClasses[(count(self::$predefinedClasses) - 1)]);

            if (!isset(self::$predefinedFunctions["internal"]))
                self::$predefinedFunctions = [];
            else self::$predefinedFunctions = self::$predefinedFunctions["internal"];
            
            self::$isDonePredefinedCheck = true;
        }
        
        public static function getPredefinedClasses()
        {
            if (self::$isDonePredefinedCheck == true)
                return self::$predefinedClasses;

            self::hookPredefined();
            return self::$predefinedClasses;
        }
        
        public static function getPredefinedFunctions()
        {
            if (self::$isDonePredefinedCheck == true)
                return self::$predefinedFunctions;

            self::hookPredefined();
            return self::$predefinedFunctions;
        }

        protected static function setupConfig()
        {
            $configPath = (ROOT_FOLDER . 'Application/Config/');

            if (function_exists('json_encode') === false)
            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing JSON extension."]); exit; }

            if (@file_exists($configPath . 'Application.json') === true) {
                $configApp = @file_get_contents($configPath . 'Application.json');
                $configApp = @\json_decode($configApp);
                if (is_array($configApp))
                    $configApp = (object)$configApp;
                if ($configApp === null || $configApp === false || is_object($configApp) === false)
                    $configApp = (object)[];
            }

            self::$configApp = $configApp;

            $serverSid = null;

            if (isset($configApp->server) && isset($configApp->server->sidPaths)) {
                foreach ($configApp->server->sidPaths as $sidPath) {
                    $indexOfRoot = strpos($sidPath, 'root://');
                    if ($indexOfRoot === 0)
                        $sidPath = (ROOT_FOLDER . substr($sidPath, 7));
                    if (@file_exists($sidPath) === true) {
                        $serverSid = strval(@file_get_contents($sidPath));
                        $serverSid = trim($serverSid, "\r\n\t ");
                        if ($serverSid === '')
                        { $serverSid = null; }
                        else break;
                    }
                }
            }

            if ($serverSid !== null) {
                self::$configSid = $serverSid;
                $configSidPath = ($configPath . 'Application/' . $serverSid . '.json');

                if (@file_exists($configSidPath) === true) {
                    $configAppSid = @file_get_contents($configSidPath);
                    $configAppSid = @\json_decode($configAppSid);
                    if (is_array($configAppSid))
                        $configAppSid = (object)$configAppSid;
                    if ($configAppSid === null || $configAppSid === false || is_object($configApp) === false)
                        $configAppSid = (object)[];
                    self::$configSidApp = $configAppSid;
                }
            }

            function object_to_array($obj) {
                if(is_object($obj) || is_array($obj)) {
                    $ret = (array) $obj;
                    foreach($ret as &$item) {
                        $item = object_to_array($item);
                    }
                    return $ret;
                }
                else { return $obj; }
            }

            $mergeConfig = object_to_array(self::$configApp);
            $configSidAppArr = object_to_array(self::$configSidApp);

            if (self::$configSidApp !== null)
                $mergeConfig = array_replace_recursive($mergeConfig, $configSidAppArr);


            $cacheFolder = ((isset($mergeConfig['cache']) && isset($mergeConfig['cache']['path'])) ? $mergeConfig['cache']['path'] : null);

            $indexOfRoot = strpos($cacheFolder, 'root://');
            if ($indexOfRoot === 0)
                $cacheFolder = (ROOT_FOLDER . substr($cacheFolder, 7));

            if (is_dir($cacheFolder) === false)
                @mkdir($cacheFolder, 0777,  true);

            if (is_writable($cacheFolder) === false) {

                $altCacheFolder = (ROOT_FOLDER . 'Application/.cache');

                if (is_dir($altCacheFolder) === false)
                    @mkdir($altCacheFolder, 0777, true);

                if (is_writable($altCacheFolder) === false)
                { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Cache folder not writable."]); exit; }
                else $cacheFolder = $altCacheFolder;
            }

            define('CACHE_FOLDER', $cacheFolder . '/');
        }
    }

    Kernel::onInitialize();
}

namespace {
    function kill()
    {
        \KrupaBOX\Internal\Kernel::exit();
    }

}