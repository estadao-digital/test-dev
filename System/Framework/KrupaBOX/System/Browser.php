<?php

class Browser
{
    protected static $__isInitialized = false;
    protected static function __initialize()
    {
        if (self::$__isInitialized == true)
            return null;
        \Import::PHP(__KRUPA_PATH_LIBRARY__ . ".plain/PegasusBrowser.php");
        self::$__isInitialized = true;
    }

    public static function isBrowser()
    {
        self::__initialize();

        $pegBrowser = new \PegasusPHP\Browser(@$_SERVER['HTTP_USER_AGENT']);
        $isBrowser = $pegBrowser->isBrowser(self::getBrowser());
        if ($isBrowser != true && self::isMobile() == true)
            return true;
        return $isBrowser;
    }

    public static function getBrowser()
    {
        self::__initialize();

        $pegBrowser = new \PegasusPHP\Browser(@$_SERVER['HTTP_USER_AGENT']);
        $browser = stringEx($pegBrowser->getBrowser())->toLower();

        if (($browser == "iphone" || $browser == "ipad") && self::isMobile() == true)
            $browser = "safari";

        return $browser;
    }

    public static function getBrowserVersion($returnNumber = true)
    {
        self::__initialize();

        $pegBrowser = new \PegasusPHP\Browser(@$_SERVER['HTTP_USER_AGENT']);
        $version = stringEx($pegBrowser->getVersion())->toLower();

        if ($returnNumber == false)
            return $version;
        if (stringEx($version)->contains(".") == false)
            return floatEx($version)->toFloat();

        $split = stringEx($version)->split(".");
        if ($split->count < 2) return floatEx($version)->toFloat();
        $version = ($split[0] . "." . $split[1]);
        return floatEx($version)->toFloat();
    }

    public static function isMobile()
    {
        self::__initialize();

        $pegBrowser = new \PegasusPHP\Browser(@$_SERVER['HTTP_USER_AGENT']);
        return $pegBrowser->isMobile();
    }

    public static function getHeaders()
    { return \Connection::getRequestHeaders(); }

    public static function getPlatformName()
    {
        self::__initialize();

        $pegBrowser = new \PegasusPHP\Browser(@$_SERVER['HTTP_USER_AGENT']);
        $platform = stringEx($pegBrowser->getPlatform())->toLower();

        if (($platform == "iphone" || $platform == "ipad" || $platform == "apple") && self::isMobile() == true)
            return "ios";
        elseif ($platform == "apple" && self::isMobile() == false)
            return "macosx";

        return $platform;
    }

    public static function getPlatform()
    {
        $platform = self::getPlatformName();

        $platformLower = stringEx($platform)->toLower();
        if (stringEx($platformLower)->startsWith("win"))
            return "windows";
        elseif (stringEx($platformLower)->startsWith("ubun"))
            return "linux";
        elseif (stringEx($platformLower)->startsWith("lin"))
            return "linux";
        elseif (stringEx($platformLower)->startsWith("mac"))
            return "macosx";
        elseif (stringEx($platformLower)->startsWith("andr"))
            return "android";
        elseif (stringEx($platformLower)->startsWith("ios"))
            return "ios";
        return null;
    }

    public static function getLanguageISO()
    {
        if (self::isBrowser() == false)
            return null;

        $languages = \Language::getAllLanguageISO();
        $headers = self::getHeaders();

        if ($headers->containsKey("Accept-Language"))
        {
            $acpLanguages = stringEx($headers["Accept-Language"])->
                replace("-", "_", false)->
                replace(";", ",", false)->
                split(",");
            foreach ($acpLanguages as $acpLanguage) {
                $acpLanguage = stringEx($acpLanguage)->toLower();
                if (stringEx($acpLanguage)->contains("_")) {
                    $fixLang = stringEx($acpLanguage)->split("_");
                    if ($fixLang->count >= 2)
                        $acpLanguage = (stringEx($fixLang[0])->toLower() . "_" . stringEx($fixLang[1])->toUpper());
                }
                if ($languages->contains($acpLanguage))
                    return $acpLanguage;
            }
        }

        return \Language::getDefaultISO();
    }

    public static function getHash()
    {
        return \Security\Hash::toSha1(
            \Connection::getBrowser() . "-" .
            \Connection::getBrowserVersion() . "-" .
            \Connection::getPlatform() . "-" .
            \Security\Hash::toSha1(\Connection::getUserAgent()) . "-" .
            \Connection::getHost() . "-" .
            \Config::get()->server->cryptographyKey
        );
    }
}