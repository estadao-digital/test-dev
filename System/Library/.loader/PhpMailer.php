<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class PhpMailer
    {
        public static function onLoad($data = null)
        {
            $pharFilePath = (__KRUPA_PATH_LIBRARY__ . "PhpMailer.phar");

            if ($data->pharEnabled == true) {
                \Import::PHAR($pharFilePath . "/PHPMailerAutoload.php");
                return null;
            }

            $cacheFilePath = (\Garbage\Cache::getCachePath() . ".phar/PhpMailer.phar/");

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
                    echo \Serialize\Json::encode([error => INTERNAL_SERVER_ERROR, message => "Missing PhpMailer lib."]);
                    \KrupaBOX\Internal\Kernel::exit();
                }
            }

            \Import::PHP($cacheFilePath . "PHPMailerAutoload.php");
        }
    }
}