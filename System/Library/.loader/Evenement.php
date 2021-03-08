<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Evenement
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "Evenement",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "Evenement\\",
                libraryFilePath => "Evenement.phar",
                libraryLoadingPath  => "Evenement.phar/",
            ]);
        }
    }
}