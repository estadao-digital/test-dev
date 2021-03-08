<?php

namespace DateTimeEx
{
    class TimeZone
    {
        protected static $timezones = null;
        protected static $timezonesAlias = null;

        protected static $__isInitialized = false;
        protected static function __initialize()
        {
            if (self::$__isInitialized == true) return;

            self::$timezones = Arr();
            self::$timezonesAlias = Arr();
            $timezoneSids = Arr(\DateTimeZone::listIdentifiers());

            foreach ($timezoneSids as $timezoneSid)
                self::$timezones[stringEx($timezoneSid)->toLower()] = $timezoneSid;

            self::$__isInitialized = true;
        }

        public static function getBySid($timeZoneStr = null)
        { return self::fromString($timeZoneStr); }

        public static function fromString($timeZoneStr = null)
        {
            self::__initialize();

            $timeZoneStr = stringEx($timeZoneStr)->toLower();
            if (self::$timezones->containsKey($timeZoneStr))
                return @(new \DateTimeZone(self::$timezones[$timeZoneStr]));

            if (self::$timezonesAlias->containsKey($timeZoneStr))
                return @(new \DateTimeZone(self::$timezonesAlias[$timeZoneStr]));

            $timeZoneStrParse = stringEx($timeZoneStr)->
                removeAccents(false)->
                replace("=>", "/", false)->
                replace("->", "/", false)->
                replace(">", "/", false)->
                replace("|", "/", false)->
                replace("@", "/", false)->
                replace("+", "/", false)->
                replace(" ", "_", false)->
                replace(" /", "/", false)->
                replace("/ ", "/");
            while (stringEx($timeZoneStrParse)->contains("//"))
                $timeZoneStrParse = stringEx($timeZoneStrParse)->replace("//", "/");
            while (stringEx($timeZoneStrParse)->contains("__"))
                $timeZoneStrParse = stringEx($timeZoneStrParse)->replace("__", "_");
            $timeZoneStrParse = stringEx($timeZoneStrParse)->
                replace("_/", "/", false)->
                replace("/_", "/");
            while (stringEx($timeZoneStrParse)->contains("//"))
                $timeZoneStrParse = stringEx($timeZoneStrParse)->replace("//", "/");

            if (self::$timezones->containsKey($timeZoneStrParse)) {
                self::$timezonesAlias[$timeZoneStr] = self::$timezones[$timeZoneStrParse];
                return @(new \DateTimeZone(self::$timezonesAlias[$timeZoneStr]));
            }

            return null;
        }

        public static function getByConnection()
        {
            $location = \Connection::getLocation();
            if ($location == null) return null;
            return $location->timezone;
        }

        public static function getByIpAddress($ipAddress = null)
        {
            $location = \Location::getByIpAddress("172.217.28.78");
            if ($location == null) return null;
            return $location->timezone;
        }

        public static function getAll()
        { return Arr(\DateTimeZone::listIdentifiers()); }
    }
}