<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Sabberworm
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "Sabberworm",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "Sabberworm\\CSS\\",
                libraryFilePath => "Sabberworm.phar",
                libraryLoadingPath  => "Sabberworm.phar/CSS/",
            ]);
        }
    }
}