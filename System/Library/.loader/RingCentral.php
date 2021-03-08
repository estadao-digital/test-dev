<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class RingCentral
    {
        public static function onLoad($data = null)
        {
            Library::load("Psr");
            Library::load("PubNub");
            Library::load("GuzzleHttp");

            Library::defaultLoader([
                name         => "RingCentral",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "RingCentral\\",
                libraryFilePath => "RingCentral.phar",
                libraryLoadingPath  => "RingCentral.phar/",
            ]);

            if ($data->pharEnabled == true) {
                $pharFilePath = (__KRUPA_PATH_LIBRARY__ . "RingCentral.phar");
                \Import::PHAR($pharFilePath . "/Psr7/functions.php");
                return null;
            }

            $cacheFilePath = (\Garbage\Cache::getCachePath() . ".phar/RingCentral.phar/");
            \Import::PHP($cacheFilePath . "Psr7/functions.php");
        }
    }
}