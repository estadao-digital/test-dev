<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Hoa
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "Hoa",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "Hoa\\Ustring\\",
                libraryFilePath => "Hoa.phar",
                libraryLoadingPath  => "Hoa.phar/Ustring/",
            ]);
        }
    }
}