<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Pdp
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "Pdp",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "Pdp\\",
                libraryFilePath => "Pdp.phar",
                libraryLoadingPath  => "Pdp.phar/",
            ]);

            if ($data->pharEnabled == true)
                \Import::PHAR(__KRUPA_PATH_LIBRARY__ . "Pdp.phar/functions.php");
            else \Import::PHP(\Garbage\Cache::getCachePath() . ".phar/Pdp.phar/functions.php");
        }
    }
}