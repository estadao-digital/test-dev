<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Cocur
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "Cocur",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "Cocur\\Slugify\\",
                libraryFilePath => "Cocur.phar",
                libraryLoadingPath  => "Cocur.phar/Slugify/",
            ]);
        }
    }
}