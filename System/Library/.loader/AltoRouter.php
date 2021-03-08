<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class AltoRouter
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "AltoRouter",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "AltoRouter\\",
                libraryFilePath => "AltoRouter.phar",
                libraryLoadingPath  => "AltoRouter.phar/",
            ]);

            if ($data->pharEnabled == true) {
                $pharFilePath = (__KRUPA_PATH_LIBRARY__ . "AltoRouter.phar");
                \Import::PHAR($pharFilePath . "/AltoRouter.php");
                return null;
            }

            $cacheFilePath = (\Garbage\Cache::getCachePath() . ".phar/AltoRouter.phar/");
            \Import::PHP($cacheFilePath . "AltoRouter.php");
        }
    }
}