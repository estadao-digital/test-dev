<?php

namespace KrupaBOX\Internal
{
    class Core
    {
        protected static $coreFilesPath =
        [
            "Core/StringEx.php",
            "Core/IntEx.php",
            "Core/FloatEx.php",
            "Core/BoolEx.php",
            "Core/ClassEx.php",
            "Core/ArrayEx.php",

            "Core/NoPHP7.php",
            "Core/FunctionEx.php",
            "System/Import.php",

            "Core/Model.php",
            "Core/Model/Structure.php",
            "Core/Model/Structure/Field.php",
            "Core/Model/Link.php",
            "Core/Model/Container.php",
            "Core/Controller.php",

            "System/Type.php",
            "System/Variable.php",

            "Internal/Frameworks.php",
            "Internal/Loader.php",
            "Internal/Error/Visual.php",
            "Internal/Log/Console.php",

            "Core/Database.php", // deprecated
            "Internal/Library.php",
            "Internal/Routes.php",
            "Internal/CLI/Services.php",

            "System/Dumpper.php",
            "Core/Controller/Polling.php",
            "Core/Global.php"
        ];

        public static function load()
        {
            if (\is_dir(APPLICATION_FOLDER) == false)
                @\mkdir(APPLICATION_FOLDER, 0777, true);

            if (\is_writable(APPLICATION_FOLDER) != true) {
                \chmod(APPLICATION_FOLDER, 777);
                if (\is_writable(APPLICATION_FOLDER) != true) {
                    \shell_exec("chmod 777 \"" . APPLICATION_FOLDER . "\"");
                    if (\is_writable(APPLICATION_FOLDER) != true) {
                        \shell_exec("sudo chmod 777 \"" . APPLICATION_FOLDER . "\"");
                        if (\is_writable(APPLICATION_FOLDER) != true)
                        { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Applicatin folder must be writable or chmod 777 (for unix systems).", "path" => APPLICATION_FOLDER]); exit; }
                    }
                }
            }

            self::loadPolyfill();

            $coreHash = "";
            foreach (self::$coreFilesPath as $coreFilePath)
                if (@file_exists(__KRUPA_PATH_INTERNAL__ . $coreFilePath))
                    $coreHash .= filemtime(__KRUPA_PATH_INTERNAL__ . $coreFilePath) . "-";
            $coreHash = sha1($coreHash . PHP_VERSION_ID);

            if (@file_exists(CACHE_FOLDER . "/.krupabox/core/" . $coreHash . ".blob") == true)
            { \KrupaBOX\Internal\Engine::includeInsensitive(CACHE_FOLDER . "/.krupabox/core/" . $coreHash . ".blob"); return; }

            $mountPHP = "<?php\n\n";

            foreach (self::$coreFilesPath as $coreFilePath) {
                if ($coreFilePath == "Core/NoPHP7.php" && PHP_VERSION_7 == true) continue;
                if (@file_exists(__KRUPA_PATH_INTERNAL__ . $coreFilePath))
                { $fileData = @file_get_contents(__KRUPA_PATH_INTERNAL__ . $coreFilePath); $mountPHP .= ((explode("<?php", $fileData)[1]) . "\n\n"); }
            }

            if (@is_dir(CACHE_FOLDER . "/.krupabox/core/")) {
                $scanCache = @scandir(CACHE_FOLDER . "/.krupabox/core/");
                if ($scanCache != null && count($scanCache) > 0)
                    foreach ($scanCache as $_scanCache)
                        if ($_scanCache != "." && $_scanCache != ".." && @is_dir(CACHE_FOLDER . "/.krupabox/core/" . $_scanCache) == false)
                            @unlink(CACHE_FOLDER . "/.krupabox/core/" . $_scanCache);
            }

            @file_put_contents(CACHE_FOLDER . "/.krupabox/core/" . $coreHash . ".blob", $mountPHP);
            \KrupaBOX\Internal\Engine::includeInsensitive(CACHE_FOLDER . "/.krupabox/core/" . $coreHash . ".blob");
        }

        protected static function loadPolyfill()
        {
            $polyfillHash = sha1(
                filemtime(__KRUPA_PATH_INTERNAL__ . "Internal/Polyfill/") . "-" .
                PHP_VERSION_ID . "-" .
                (@extension_loaded('mbstring') ? "1" : "0") . "-" .
                (@extension_loaded('iconv') ? "1" : "0")
            );


            if (@file_exists(CACHE_FOLDER . "/.krupabox/core/polyfill/" . $polyfillHash . ".blob") == true)
            { \KrupaBOX\Internal\Engine::includeInsensitive(CACHE_FOLDER . "/.krupabox/core/polyfill/" . $polyfillHash . ".blob"); return null; }

            $mountPHP = "<?php\n\n";

            if (PHP_VERSION_ID < 50400)           { $fileData = @file_get_contents(__KRUPA_PATH_INTERNAL__ . "Internal/Polyfill/PHP54.php"); $mountPHP .= ((explode("<?php", $fileData)[1]) . "\n\n"); }
            if (PHP_VERSION_ID < 50500)           { $fileData = @file_get_contents(__KRUPA_PATH_INTERNAL__ . "Internal/Polyfill/PHP55.php"); $mountPHP .= ((explode("<?php", $fileData)[1]) . "\n\n"); }
            if (!(@extension_loaded('mbstring'))) { $fileData = @file_get_contents(__KRUPA_PATH_INTERNAL__ . "Internal/Polyfill/Mbstring.php"); $mountPHP .= ((explode("<?php", $fileData)[1]) . "\n\n"); }
            if (!(@extension_loaded('iconv')))    { $fileData = @file_get_contents(__KRUPA_PATH_INTERNAL__ . "Internal/Polyfill/Iconv.php"); $mountPHP .= ((explode("<?php", $fileData)[1]) . "\n\n"); }
            if (PHP_VERSION_ID < 50600)           { $fileData = @file_get_contents(__KRUPA_PATH_INTERNAL__ . "Internal/Polyfill/PHP56.php"); $mountPHP .= ((explode("<?php", $fileData)[1]) . "\n\n"); }
            if (PHP_VERSION_ID < 70000)           { $fileData = @file_get_contents(__KRUPA_PATH_INTERNAL__ . "Internal/Polyfill/PHP70.php"); $mountPHP .= ((explode("<?php", $fileData)[1]) . "\n\n"); }
            if (PHP_VERSION_ID < 70100)           { $fileData = @file_get_contents(__KRUPA_PATH_INTERNAL__ . "Internal/Polyfill/PHP71.php"); $mountPHP .= ((explode("<?php", $fileData)[1]) . "\n\n"); }
            if (PHP_VERSION_ID < 70200)           { $fileData = @file_get_contents(__KRUPA_PATH_INTERNAL__ . "Internal/Polyfill/PHP72.php"); $mountPHP .= ((explode("<?php", $fileData)[1]) . "\n\n"); }
            if (PHP_VERSION_ID < 70300)           { $fileData = @file_get_contents(__KRUPA_PATH_INTERNAL__ . "Internal/Polyfill/PHP73.php"); $mountPHP .= ((explode("<?php", $fileData)[1]) . "\n\n"); }
            if (PHP_VERSION_ID < 70400)           { $fileData = @file_get_contents(__KRUPA_PATH_INTERNAL__ . "Internal/Polyfill/PHP74.php"); $mountPHP .= ((explode("<?php", $fileData)[1]) . "\n\n"); }

            if (!is_dir(CACHE_FOLDER . "/.krupabox/core/polyfill/"))
                @mkdir(CACHE_FOLDER . "/.krupabox/core/polyfill/", 0777, true);

            if (@is_dir(CACHE_FOLDER . "/.krupabox/core/polyfill/")) {
                $scanCache = @scandir(CACHE_FOLDER . "/.krupabox/core/polyfill/");
                if ($scanCache != null && count($scanCache) > 0)
                    foreach ($scanCache as $_scanCache)
                        if ($_scanCache != "." && $_scanCache != ".." && @is_dir(CACHE_FOLDER . "/.krupabox/core/polyfill/" . $_scanCache) == false)
                            @unlink(CACHE_FOLDER . "/.krupabox/core/polyfill/" . $_scanCache);
            }

            @file_put_contents(CACHE_FOLDER . "/.krupabox/core/polyfill/" . $polyfillHash . ".blob", $mountPHP);
            \KrupaBOX\Internal\Engine::includeInsensitive(CACHE_FOLDER . "/.krupabox/core/polyfill/" . $polyfillHash . ".blob");
            return null;
        }
    }
}