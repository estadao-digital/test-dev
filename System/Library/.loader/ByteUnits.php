<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class ByteUnits
    {
        public static function onLoad($data = null)
        {
            if ($data->pharEnabled == true)
                \Import::PHAR(__KRUPA_PATH_LIBRARY__ . "ByteUnits.phar/functions.php");
            else \Import::PHP(\Garbage\Cache::getCachePath() . ".phar/ByteUnits.phar/functions.php");

            Library::defaultLoader([
                name         => "ByteUnits",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "ByteUnits\\",
                libraryFilePath => "ByteUnits.phar",
                libraryLoadingPath  => "ByteUnits.phar/",
            ]);

        }
    }
}