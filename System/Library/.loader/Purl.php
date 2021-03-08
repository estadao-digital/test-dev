<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Purl
    {
        public static function onLoad($data = null)
        {
            Library::load("Pdp");

            Library::defaultLoader([
                name         => "Purl",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "Purl\\",
                libraryFilePath => "Purl.phar",
                libraryLoadingPath  => "Purl.phar/",
            ]);
        }
    }
}