<?php

namespace {
    
class Import
{
    protected static $importedPHPs = null;

    private static $__isInitialized = false;
    private static function __initialize()
    {
        if (self::$__isInitialized == true) return;
        self::$importedPHPs = Arr();
        self::$__isInitialized = true;
    }

    public static function PHP($phpFilePath, $canDuplicate = false)
    {
        self::__initialize();

        if(class_exists('File\Wrapper'))
            $phpFilePath = \File\Wrapper::parsePath($phpFilePath);

        $phpFilePath = \KrupaBOX\Internal\Engine::getInsensitivePathFix($phpFilePath);
        if ($canDuplicate == false && self::$importedPHPs->contains($phpFilePath)) return true;

        if (file_exists($phpFilePath))
        {
            \KrupaBOX\Internal\Engine::includeInsensitive($phpFilePath);
            self::$importedPHPs->add($phpFilePath);
            return true;
        }

        return false;
    }

    public static function PHAR($pharFilePath, $canDuplicate = false)
    {
        //self::__initialize();

        if (\File::exists("phar://" . $pharFilePath))
            return boolEx(include_once("phar://" . $pharFilePath))->toBool();

        //$phpFilePath = \KrupaBOX\Internal\Engine::getInsensitivePathFix($phpFilePath);
//        if ($canDuplicate == false && self::$importedPHPs->contains($phpFilePath)) return true;
//
//        if (file_exists($phpFilePath))
//        {
//            \KrupaBOX\Internal\Engine::includeInsensitive($phpFilePath);
//            self::$importedPHPs->add($phpFilePath);
//            return true;
//        }

        return false;
    }

    public static function register($phpFilePath)
    { if (!self::$importedPHPs->contains($phpFilePath)) self::$importedPHPs->add($phpFilePath); }
}

}