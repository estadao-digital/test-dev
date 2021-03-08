<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Gajus
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "Gajus",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "Gajus\\Dindent\\",
                libraryFilePath => "Gajus.phar",
                libraryLoadingPath  => "Gajus.phar/Dindent/",
            ]);
        }
    }
}