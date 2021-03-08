<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class WhoIsPHP
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "WhoIsPHP",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "Whois\\",
                libraryFilePath => "Whois.phar",
                libraryLoadingPath  => "Whois.phar/",
                classDelegate  => function($class) {
                    return ((stringEx($class)->endsWith("/"))
                        ? (stringEx($class)->subString(0, stringEx($class)->length - 1) . "_")
                        : $class
                    );
                }
            ]);

            if ($data->pharEnabled == true) {
                \Import::PHAR(__KRUPA_PATH_LIBRARY__ . "WhoIsPHP.phar/whois.main.php");
            }
            else
            {
                \Import::PHP(CACHE_FOLDER . ".phar/WhoIsPHP.phar/whois.main.php");
            }


        }
    }
}