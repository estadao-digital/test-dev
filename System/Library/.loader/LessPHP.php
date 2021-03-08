<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class LessPHP
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "LessPHP",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "lessc\\",
                libraryFilePath => "LessPHP.phar",
                libraryLoadingPath  => "LessPHP.phar/",
            ]);

            if ($data->pharEnabled == true) {
                $pharFilePath = (__KRUPA_PATH_LIBRARY__ . "LessPHP.phar");
                \Import::PHAR($pharFilePath . "/lessc.inc.php");
                return null;
            }

            $cacheFilePath = (\Garbage\Cache::getCachePath() . ".phar/LessPHP.phar/");
            \Import::PHP($cacheFilePath . "lessc.inc.php");
        }
    }
}