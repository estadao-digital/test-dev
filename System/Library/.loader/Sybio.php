<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Sybio
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "Sybio",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "PHPImageWorkshop\\",
                libraryFilePath => "Sybio.phar",
                libraryLoadingPath  => "Sybio.phar/PHPImageWorkshop/",
            ]);
        }
    }
}