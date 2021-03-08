<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Selenium
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "Selenium",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "Facebook\\WebDriver\\",
                libraryFilePath => "Selenium.phar",
                libraryLoadingPath  => "Selenium.phar/WebDriver/",
            ]);
        }
    }
}