<?php

namespace Http
{
    class Browser
    {
        const HOST_DEFAULT = "http://localhost:4444/wd/hub";

        const DRIVER_FIREFOX = "firefox";
        const DRIVER_CHROME  = "chrome";

        private static $__isInitialized = false;
        private static function __initialize()
        {
            if (self::$__isInitialized == true) return;
            \KrupaBOX\Internal\Library::load("Selenium");
            self::$__isInitialized = true;
        }


        public static function open($host = self::HOST_DEFAULT, $driver = self::DRIVER_FIREFOX)
        {
            self::__initialize();

            $host   = stringEx($host)->toString();
            $driver = stringEx($driver)->toString();

            if ($driver != self::DRIVER_CHROME && $driver != self::DRIVER_FIREFOX)
                $driver = self::DRIVER_FIREFOX;

            $_driver = null;
            if ($driver == self::DRIVER_FIREFOX)
                $_driver = \Facebook\WebDriver\Remote\DesiredCapabilities::firefox();
            elseif ($driver == self::DRIVER_CHROME)
                $_driver = \Facebook\WebDriver\Remote\DesiredCapabilities::chrome();

            return \Facebook\WebDriver\Remote\RemoteWebDriver::create($host, $_driver);
        }
    }
}