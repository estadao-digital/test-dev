<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Twig
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "Twig",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "Twig_",
                libraryFilePath => "Twig.phar",
                libraryLoadingPath  => "Twig.phar/",
            ]);
        }
    }
}