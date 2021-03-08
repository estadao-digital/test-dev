<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class ReactPHP
    {
        public static function onLoad($data = null)
        {
            \KrupaBOX\Internal\Library::load("Evenement");
            \KrupaBOX\Internal\Library::load("RingCentral");
            \KrupaBOX\Internal\Library::load("Psr");
            \KrupaBOX\Internal\Library::load("GuzzleHttp");

            Library::defaultLoader([
                name         => "ReactPHP",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "React\\",
                libraryFilePath => "ReactPHP.phar",
                libraryLoadingPath  => "ReactPHP.phar/",
            ]);


        }
    }
}