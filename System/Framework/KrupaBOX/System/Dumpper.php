<?php

namespace {

//// LOAD PHAR OR FALLBACK TO NoPHAR
//$noPharFallbackPath = substr(__KRUPA_PATH_LIBRARY__, 0, strlen(__KRUPA_PATH_LIBRARY__) - 1) . ".NoPHAR/";
//
//if (!@file_exists($noPharFallbackPath . ".disabled") && @file_exists($noPharFallbackPath . "KintDumpper"))
//    \Import::PHP($noPharFallbackPath . "KintDumpper/Kint.class.php");
//else \Import::PHAR(__KRUPA_PATH_LIBRARY__ . "KintDumpper.phar/Kint.class.php");

class Dumpper
{
    protected static $_isAlreadyDumped = false;

    public static function isPageDumped()      { return self::__isAlreadyDumped(); }
    public static function __isAlreadyDumped() { return self::$_isAlreadyDumped; }
    public static function __onDump()          { self::$_isAlreadyDumped = true; }

    protected static $__isLoaded = false;
    public static function __load()
    {
        if (self::$__isLoaded == true) return;

        $config = \Config::get();

        if (\Connection::isCommandLineRequest() == false)
            \Import::PHAR(__KRUPA_PATH_LIBRARY__ . "KintDumpper.phar/Kint.class.php");
        else
        {
            $cachePath = (\Garbage\Cache::getCachePath() . ".phar/KintDumpper.phar");

            if (!\File::exists($cachePath . ".installed"))
            {
                \DirectoryEx::createDirectory($cachePath);
                $phar = new \Phar(__KRUPA_PATH_LIBRARY__ . "KintDumpper.phar", 0);
                $extracted = $phar->extractTo($cachePath, null, true);
                if ($extracted == true)
                    \File::setContents($cachePath . ".installed", "OK");

                if (!\File::exists($cachePath . ".installed"))
                { echo \Serialize\Json::encode([error => INTERNAL_SERVER_ERROR, message => "Missing KintDumpper lib."]); \KrupaBOX\Internal\Kernel::exit(); }
            }

            \Import::PHP($cachePath . "Kint.class.php");
        }

        self::$__isLoaded = true;
    }

    public static function dump($value = null)
    {
        self::__load();

        if (\Connection::isCommandLineRequest() == true)
        { var_dump($value); return null;  }

        if (IS_DEVELOPMENT == true && VISUAL_DEBUGGER_ENABLED == true && (Connection::isBrowser() == true || \Connection::isRobot() == true)) // AND NOT VIEW RENDERER
            \Kint::dump($value, null, true);
        
        if (FILE_DEBUGGER_ENABLED == true || CONSOLE_DEBUGGER_ENABLED == true || AJAX_DEBUGGER_ENABLED == true)
        {
            $getVarNameHack = \Kint::dump($value, null, true, true);
            $getBacktraceHack = \Kint::dump($value, null, true, true, true);
            \KrupaBOX\Internal\Log\Console::log($value, $getVarNameHack, $getBacktraceHack);
        }
    }
}

// FORCE REDECLARE DUMP WITH KINT
function dump($value = null)
{
    Dumpper::__load();

    if (\Connection::isCommandLineRequest() == true)
    { var_dump($value); return null;  }


    if (IS_DEVELOPMENT == true && VISUAL_DEBUGGER_ENABLED == true && (Connection::isBrowser() == true || \Connection::isRobot() == true)) // AND NOT VIEW RENDERER
        \Kint::dump($value, null, true);
        
    if (FILE_DEBUGGER_ENABLED == true || CONSOLE_DEBUGGER_ENABLED == true || AJAX_DEBUGGER_ENABLED == true)
    {
        $getVarNameHack = \Kint::dump($value, null, true, true);
        $getBacktraceHack = \Kint::dump($value, null, true, true, true);
        \KrupaBOX\Internal\Log\Console::log($value, $getVarNameHack, $getBacktraceHack);
    }
}

}
