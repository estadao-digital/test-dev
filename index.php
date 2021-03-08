<?php

//////////////////////////////////////////////////////////
//                  K R U P A B O X                     //
//               PHP SUBSET & FRAMEWORK                 //
//////////////////////////////////////////////////////////

namespace
{
    const __KRUPA_CONFIG_PATH_APPLICATION__ = "Application";
    const __KRUPA_CONFIG_PATH_SYSTEM__      = "System";

    $isPhp7 = false; $phpVersion = phpversion(); if ($phpVersion != null && strlen($phpVersion) > 0 && $phpVersion[0] == "7") $isPhp7 = true;
    define("PHP_VERSION_7", $isPhp7);
    error_reporting(0);
}

namespace KrupaBOX\Internal
{
    class Engine
    {
        protected static function forceGetFolderPath($basePath, $folderName)
        {
            if (@file_exists($basePath . "/" . $folderName))
                return $basePath . "/" . $folderName;
            $folderNameLower = strtolower($folderName);
            if (@is_dir($basePath) == false)
                return $basePath . "/" . $folderName;
            $scanDir = @scandir($basePath);
            if ($scanDir != null)
                foreach ($scanDir as $key => $value)
                    if (!in_array($value, array(".", "..")))
                        if (strtolower($value) == $folderNameLower)
                            return $basePath . "/" . $value;
            return $basePath . "/" . $folderName;
        }

        protected static function fixPathBars($path)
        {
            if ($path == null) return null;
            $path = strval($path);
            $path = str_replace("\\", "/", $path);
            return $path;
        }

        public static function getInsensitivePathFix($path)
        {
            $pathFix = self::fixPathBars($path);
            if (@file_exists($pathFix) == false) {
                $splitPath = explode("/", $pathFix);
                $fullPathFix = $splitPath[0];
                foreach ($splitPath as $_splitPath)
                    if ($_splitPath != $splitPath[0])
                        $fullPathFix = self::forceGetFolderPath($fullPathFix, $_splitPath);
                return $fullPathFix;
            }
            return $path;
        }

        public static function includeInsensitive($path)
        {
            if (file_exists($path))
            { include($path); return true; }

            $path = self::getInsensitivePathFix($path);
            if (file_exists($path)) { include($path); return true; }
            return false;
        }

        public static function run($baseFile)
        {
            $currentFile = $baseFile;
            $baseName = basename($currentFile);
            $globalPath = str_replace ("\\", "/", substr($currentFile, 0, strlen($currentFile) - strlen($baseName)));

            if (strrpos($globalPath, "/") != (strlen($globalPath) - 1))
                $globalPath .= "/";

            define("__KRUPA_PATH_ROOT__", $globalPath);
            define("ROOT_FOLDER", $globalPath);
            define('ROOT_HASH', sha1($globalPath));
            $configSystem = str_replace ("\\", "/", __KRUPA_CONFIG_PATH_SYSTEM__);

            $rootPath = null;
            if (isset($_SERVER['PATH_TRANSLATED']))
                $rootPath = $_SERVER['PATH_TRANSLATED'];
            if (strlen(strval($rootPath)) <= 0 && isset($_SERVER['DOCUMENT_ROOT']))
                $rootPath = $_SERVER['DOCUMENT_ROOT'];
            if (strlen(strval($rootPath)) <= 0 && function_exists("filter_input") && INPUT_SERVER != null)
                $rootPath = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
            if (strlen(strval($rootPath)) <= 0)
                $rootPath = ROOT_FOLDER;

            if (strlen(strval($rootPath)) > 0)
                $rootPath = str_replace ("\\", "/", $rootPath);
            if (strrpos($rootPath, "/") != (strlen($rootPath) - 1))
                $rootPath .= "/";

            define("ROOT_SERVER_FOLDER", $rootPath);

            while (strpos($configSystem, "/")  === 0) $configSystem = substr($configSystem, 1, strlen($configSystem) - 1);
            while (strrpos($configSystem, "/") === (strlen($configSystem) - 1)) $configSystem = substr($configSystem, 0, strlen($configSystem) - 1);

            define("__KRUPA_PATH_SYSTEM__", $globalPath . $configSystem . "/");
            define("__KRUPA_PATH_FRAMEWORK__", __KRUPA_PATH_SYSTEM__ . "Framework/");
            define("__KRUPA_PATH_LIBRARY__", __KRUPA_PATH_SYSTEM__ . "Library/");
            define("__KRUPA_PATH_INTERNAL__", __KRUPA_PATH_FRAMEWORK__ . "KrupaBOX/");

            if (!file_exists(__KRUPA_PATH_INTERNAL__ . "Internal/Kernel.php"))
                die("INTERNAL ERROR: INVALID SYSTEM PATH!");

            \KrupaBOX\Internal\Engine::includeInsensitive(__KRUPA_PATH_INTERNAL__ . "Internal/Kernel.php");
        }
    }
}

namespace { \KrupaBOX\Internal\Engine::run(__FILE__); }

