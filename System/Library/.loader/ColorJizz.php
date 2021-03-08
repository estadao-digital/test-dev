<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class ColorJizz
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "ColorJizz",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "MischiefCollective\\",
                libraryFilePath => "MischiefCollective.phar",
                libraryLoadingPath  => "MischiefCollective.phar/",
            ]);
        }
    }
}