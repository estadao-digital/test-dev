<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class GuzzleHttp
    {
        public static function onLoad($data = null)
        {
            Library::load("Psr");

            Library::defaultLoader([
                name         => "GuzzleHttp",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "GuzzleHttp\\",
                libraryFilePath => "GuzzleHttp.phar",
                libraryLoadingPath  => "GuzzleHttp.phar/",
            ]);

            if ($data->pharEnabled == true) {
                $pharFilePath = (__KRUPA_PATH_LIBRARY__ . "GuzzleHttp.phar");
                \Import::PHAR($pharFilePath . "/functions.php");
                \Import::PHAR($pharFilePath . "/Psr7/functions.php");
                return null;
            }

            $cacheFilePath = (\Garbage\Cache::getCachePath() . ".phar/GuzzleHttp.phar/");
            \Import::PHP($cacheFilePath . "functions.php");
            \Import::PHP($cacheFilePath . "Psr7/functions.php");
        }
    }
}