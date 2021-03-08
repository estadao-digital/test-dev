<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class PhpQrCode
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "PhpQrCode",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "QR",
                libraryFilePath => "PhpQrCode.phar",
                libraryLoadingPath  => "PhpQrCode.phar/",
            ]);

            if ($data->pharEnabled == true) {
                $pharFilePath = (__KRUPA_PATH_LIBRARY__ . "PhpQrCode.phar");
                \Import::PHAR($pharFilePath . "/qrlib.php");
                return null;
            }

            $cacheFilePath = (\Garbage\Cache::getCachePath() . ".phar/PhpQrCode.phar/");
            \Import::PHP($cacheFilePath . "qrlib.php");
        }
    }
}