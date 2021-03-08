<?php

namespace KrupaBOX\Internal {

class Error
{
    protected static $isDefaultEnabled = false;
    protected static $delegates = [];

    protected static function forceNoNoticeReport()
    {
        error_reporting(0);
    }

    public static function register($delegate)
    {
        self::forceNoNoticeReport();
        
        if (!is_callable($delegate))
        {
            $string = strval($delegate);
            
            if ($string == "default")
                self::$isDefaultEnabled = true;
            return;
        }
        
        self::$delegates[] = $delegate;
    }
    
    protected static function defaultHandler($code, $message, $file, $line, $context)
    {
        if (stringEx($message)->startsWith("Use of undefined constant"))
            return false;
    }

    protected static function _reportErrorHandler($code, $message, $file, $line, $context)
    {
        self::forceNoNoticeReport();

        if (count(self::$delegates) > 0)
        {
            foreach (self::$delegates as $delegate)
            {
                if ($delegate == null || !is_callable($delegate))
                    continue;
                    
                if ($delegate($code, $message, $file, $line, $context) !== false)
                    return true;  
            }
        }

        if (self::$isDefaultEnabled == true)
            return self::defaultHandler($code, $message, $file, $line, $context);
    }
    
    public static function reportErrorHandler($code, $message, $file, $line, $context)
    {
        if (self::_reportErrorHandler($code, $message, $file, $line, $context) === false)
            return false;

        \KrupaBOX\Internal\Error\Visual::ajaxHandler($code, $message, $file, $line, $context);
        
        if (IS_DEVELOPMENT == false)
        {
            // TODO: better report error
            die();    
        }
        
        return true;
    }
}

}