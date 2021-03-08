<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class PubNub
    {
        public static function onLoad($data = null)
        {
            Library::load("Monolog");

            Library::defaultLoader([
                name         => "PubNub",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "PubNub\\",
                libraryFilePath => "PubNub.phar",
                libraryLoadingPath  => "PubNub.phar/",
            ]);
        }
    }
}