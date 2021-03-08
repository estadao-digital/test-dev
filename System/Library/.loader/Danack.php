<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class Danack
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "Danack",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "PHPToJavascript\\",
                libraryFilePath => "Danack.phar",
                libraryLoadingPath  => "Danack.phar/PHPToJavascript/",
                classDelegate  => function($class) {
                    return ((stringEx($class)->contains("CodeConverterState_"))
                        ? ( stringEx($class)->replace("CodeConverterState_", "CodeConverterState/"))
                        : $class
                    );
                }
            ]);
        }
    }
}