<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Nikic
    {
        public static function onLoad($data = null)
        {
            $pharFilePath = (__KRUPA_PATH_LIBRARY__ . "Nikic.phar");

            if ($data->pharEnabled == true)
            {
                \Import::PHAR($pharFilePath . "/TokenStream/TokenStream.php");
                \Import::PHAR($pharFilePath . "/TokenStream/TokenException.php");
                \Import::PHAR($pharFilePath . "/TokenStream/Token.php");
                return null;
            }

            $cacheFilePath = (\Garbage\Cache::getCachePath() . ".phar/Nikic.phar/");

            if (!\File::exists($cacheFilePath . ".installed")) {
                \DirectoryEx::createDirectory($cacheFilePath);
                $phar = new \Phar($pharFilePath, 0);
                $extracted = $phar->extractTo($cacheFilePath, null, true);
                if ($extracted == true)
                    \File::setContents($cacheFilePath . ".installed", "OK");

                if (!\File::exists($cacheFilePath . ".installed"))
                {
                    \Header::getContentType("application/json");
                    \Header::sendHeader();
                    echo \Serialize\Json::encode([error => INTERNAL_SERVER_ERROR, message => "Missing Nikic lib."]);
                    \KrupaBOX\Internal\Kernel::exit();
                }
            }

            \Import::PHP($cacheFilePath . "TokenStream/TokenStream.php");
            \Import::PHP($cacheFilePath . "TokenStream/TokenException.php");
            \Import::PHP($cacheFilePath . "TokenStream/Token.php");
        }
    }
}