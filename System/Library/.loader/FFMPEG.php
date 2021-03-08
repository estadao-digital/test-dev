<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class FFMpeg
    {
        public static function onLoad($data = null)
        {
            Library::load("Symfony");
            Library::load("Doctrine");
            Library::load("Evenement");
            Library::load("Monolog");
            Library::load("Psr");
            Library::load("Neutron");
            Library::load("Alchemy");

            Library::defaultLoader([
                name         => "FFMpeg",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "FFMpeg\\",
                libraryFilePath => "FFMpeg.phar",
                libraryLoadingPath  => "FFMpeg.phar/",
            ]);
        }
    }
}