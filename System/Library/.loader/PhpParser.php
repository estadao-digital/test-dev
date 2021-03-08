<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class PhpParser
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "PhpParser",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "PhpParser\\",
                libraryFilePath => "PhpParser.phar",
                libraryLoadingPath  => "PhpParser.phar/",
                classDelegate  => function($class) {
                    return ((stringEx($class)->endsWith("/"))
                        ? (stringEx($class)->subString(0, stringEx($class)->length - 1) . "_")
                        : $class
                    );
                }
            ]);
        }
    }
}