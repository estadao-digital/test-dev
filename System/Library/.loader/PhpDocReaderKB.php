<?php

namespace KrupaBOX\Internal\Library
{
    use KrupaBOX\Internal\Library;

    class PhpDocReaderKB
    {
        public static function onLoad($data = null)
        {
            Library::defaultLoader([
                name         => "PhpDocReaderKB",
                pharEnabled  => $data->pharEnabled,
                preNamespace => "PhpDocReaderKB\\",
                libraryFilePath => "PhpDocReaderKB.phar",
                libraryLoadingPath  => "PhpDocReaderKB.phar/",
            ]);

            if ($data->pharEnabled == true)
                \Import::PHAR(__KRUPA_PATH_LIBRARY__ . "PhpDocReaderKB.phar/AnnotationException.php");
            else \Import::PHP(CACHE_FOLDER . ".phar/PhpDocReaderKB.phar/AnnotationException.php");
        }
    }
}