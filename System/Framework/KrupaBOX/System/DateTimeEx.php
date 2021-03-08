<?php

const DateTime = 'DateTime';

class DateTimeEx
{    
    const FORMAT_DEFAULT = "Y-m-d  H:i:s";
    
    const FORMAT_ATOM    = DateTime::ATOM;
    const FORMAT_COOKIE  = DateTime::COOKIE;
    const FORMAT_ISO8601 = DateTime::ISO8601;
    const FORMAT_RFC822  = DateTime::RFC822;
    const FORMAT_RFC850  = DateTime::RFC850;
    const FORMAT_RFC1036 = DateTime::RFC1036;
    const FORMAT_RFC1123 = DateTime::RFC1123;
    const FORMAT_RFC2822 = DateTime::RFC2822;
    const FORMAT_RFC3339 = DateTime::RFC3339;
    const FORMAT_RSS     = DateTime::RSS;
    const FORMAT_W3C     = DateTime::W3C;
    
    const FORMAT_MYSQL   = self::FORMAT_ISO8601;

    const DAY_OF_WEEK_MONDAY    = 1;
    const DAY_OF_WEEK_TUESDAY   = 2;
    const DAY_OF_WEEK_WEDNESDAY = 3;
    const DAY_OF_WEEK_THURSDAY  = 4;
    const DAY_OF_WEEK_FRIDAY    = 5;
    const DAY_OF_WEEK_SATURDAY  = 6;
    const DAY_OF_WEEK_SUNDAY    = 7;

    const MONTH_JANUARY   = 1;
    const MONTH_FEBRUARY  = 2;
    const MONTH_MARCH     = 3;
    const MONTH_APRIL     = 4;
    const MONTH_MAY       = 5;
    const MONTH_JUNE      = 6;
    const MONTH_JULY      = 7;
    const MONTH_AUGUST    = 8;
    const MONTH_SEPTEMBER = 9;
    const MONTH_OCTOBER   = 10;
    const MONTH_NOVEMBER  = 11;
    const MONTH_DECEMBER  = 12;

    protected $dateTime = null;

    protected static $defaultTimeZone = null;

    protected static $isInitialized = false;
    protected static function __initialize()
    {
        if (self::$isInitialized == true) return;
        self::$isInitialized = true;

        $config = \Config::get();

        self::$defaultTimeZone = \DateTimeEx\TimeZone::getBySid($config->server->timezone);
        if (self::$defaultTimeZone == null) {
            self::$defaultTimeZone = \DateTimeEx\TimeZone::getBySid(\date_default_timezone_get());
            if (self::$defaultTimeZone == null) self::$defaultTimeZone = \DateTimeEx\TimeZone::getBySid("UTC");
        }
    }

    protected static $isLibraryLoaded = false;
    protected static $libFailFix = null;

    protected static function loadLibs()
    {
        if (self::$isLibraryLoaded == true)
            return null;

        \KrupaBOX\Internal\Library::load("Coduo");
        self::$libFailFix = [
            "just_now.past", "just_now.future", "second.past", "second.future", "minute.past", "minute.future",
            "hour.past", "hour.future", "day.past", "day.future", "week.past", "week.future", "month.past", "month.future",
            "year.past", "year.future", "compound.second", "compound.minute", "compound.hour", "compound.day", "compound.week",
            "compound.month", "compound.year", "compound.past", "compound.future"
        ];

        self::$isLibraryLoaded = true;
    }

    public function __construct($value = null, $dateTimeZone = null)
    {
        self::__initialize();

        if ($dateTimeZone == null)
            $dateTimeZone = self::$defaultTimeZone;
        if (($dateTimeZone instanceof \DateTimeZone) == false) {
            $dateTimeZone = \DateTimeEx\TimeZone::getBySid($dateTimeZone);
            if ($dateTimeZone == null) $dateTimeZone = self::$defaultTimeZone;
        }

        if (self::isDateTimeEx($value))
        { $this->dateTime = $value->toDateTime(); if ($this->dateTime != null && $dateTimeZone != null) @$this->dateTime->setTimezone($dateTimeZone); }
        elseif (\Variable::get($value)->isDateTime())
            $this->dateTime = $value;

        else // try parsing CRAZY STRINGS
        {
            if (stringEx($value)->isEmpty())
            { $this->dateTime = new DateTime("", $dateTimeZone); return; }

            $value = stringEx($value)->replace("T", " ");
            $value = stringEx($value)->replace("/", "-");
            $value = stringEx($value)->replace(".", "-");
            while (stringEx($value)->contains("--"))
                $value = stringEx($value)->replace("--", "-");
            
            $hours = null;
            $date  = null;

            $split = stringEx($value)->split(" ");
            foreach ($split as $_split)
                if (stringEx($_split)->contains(":"))
                    $hours = $_split;
                elseif (stringEx($_split)->contains("-"))
                    $date = $_split;

            if ($date != null && self::parseDate($date) == null)
                $date = null;

            if ($date == null && $hours == null) return null;

            if ($date == null && $hours != null)
            {
                $this->dateTime = @new DateTime("", $dateTimeZone);
                $toStringDateNow = stringEx($this->toString())->split(" ")[0];
                $this->dateTime = @new DateTime($toStringDateNow . " " . self::parseHour($hours)); return;
            }

            if ($date != null && $hours == null)
            { $this->dateTime = @new DateTime(self::parseDate($date) . " 00:00", $dateTimeZone); return; }

            $this->dateTime = @new DateTime(self::parseDate($date) . " " . self::parseHour($hours), $dateTimeZone);
        }
    }

    protected static function parseHour($hourString)
    {
        $parsedHour = ""; $parsedCount = 0;
        $hoursParse = stringEx($hourString)->split(":");
        foreach ($hoursParse as $hourParse)
            if ($parsedCount < 3)
            { $parsedHour .= (intEx($hourParse)->toInt() . ":"); $parsedCount++; }
        if (stringEx($parsedHour)->endsWith(":"))
            $parsedHour = stringEx($parsedHour)->subString(0, stringEx($parsedHour)->count - 1);

        if (!stringEx($parsedHour)->contains(":")) {
            if (stringEx($parsedHour)->isEmpty())
                return "00:00";
            return ($parsedHour . ":00");
        }

        return $parsedHour;
    }

    protected static function parseDate($dateString)
    {
        $findMonthString = false;
        $datesParse = stringEx($dateString)->split("-");
        foreach ($datesParse as &$dateParse)
        {
            $intDateParse = intEx($dateParse)->toInt();
            if ($intDateParse == 0 && !stringEx($dateParse)->contains("0"))
            {
                if ($findMonthString == false)
                {
                    $parsedMonthDate = null;
                    $monthDate = stringEx($dateParse)->toLower(false)->getOnlyLetters();

                    if (stringEx($monthDate)->startsWith(jan))     $parsedMonthDate = jan;
                    elseif (stringEx($monthDate)->startsWith(feb)) $parsedMonthDate = feb;
                    elseif (stringEx($monthDate)->startsWith(mar)) $parsedMonthDate = mar;
                    elseif (stringEx($monthDate)->startsWith(apr)) $parsedMonthDate = apr;
                    elseif (stringEx($monthDate)->startsWith(may)) $parsedMonthDate = may;
                    elseif (stringEx($monthDate)->startsWith(jun)) $parsedMonthDate = jun;
                    elseif (stringEx($monthDate)->startsWith(jul)) $parsedMonthDate = jul;
                    elseif (stringEx($monthDate)->startsWith(aug)) $parsedMonthDate = aug;
                    elseif (stringEx($monthDate)->startsWith(sep)) $parsedMonthDate = sep;
                    elseif (stringEx($monthDate)->startsWith(oct)) $parsedMonthDate = oct;
                    elseif (stringEx($monthDate)->startsWith(nov)) $parsedMonthDate = nov;
                    elseif (stringEx($monthDate)->startsWith(dec)) $parsedMonthDate = dec;

                    if ($parsedMonthDate != null) {
                        $findMonthString = true;
                        $dateParse = $parsedMonthDate;
                    }
                    else $dateParse = 0;
                } else $dateParse = 0;
            }
        }

        $parsedDate = ""; $parsedCount = 0;
        foreach ($datesParse as &$dateParse)
            if ($parsedCount < 3)
            { $parsedDate .= ($dateParse . "-"); $parsedCount++; }
        if (stringEx($parsedDate)->endsWith("-"))
            $parsedDate = stringEx($parsedDate)->subString(0, stringEx($parsedDate)->count - 1);

        $countMissing = (3 - stringEx($parsedDate)->split("-")->count);
        if ($countMissing >= 3)
            return null;

        if ($countMissing > 0)
            for ($i = 0; $i < $countMissing; $i++)
                $parsedDate .= "-0";

        return $parsedDate;
    }

    public function toDifferenceHumanized($compareDate = null)
    {
        self::loadLibs();

        $compareDate = new \DateTimeEx($compareDate);
        if ($compareDate == null) $compareDate = \DateTimeEx::now();
        $compareDate = $compareDate->toDateTime();

        $diffTimeHuman = \Coduo\PHPHumanizer\DateTimeHumanizer::difference($this->dateTime, $compareDate, \Language::getDefaultISO());
        if (stringEx($diffTimeHuman)->containsAny(self::$libFailFix) == false) return $diffTimeHuman;

        if (\Language::getDefaultFallbackISO() != null)
            $diffTimeHuman = \Coduo\PHPHumanizer\DateTimeHumanizer::difference($this->dateTime, $compareDate, \Language::getDefaultFallbackISO());
        if (stringEx($diffTimeHuman)->containsAny(self::$libFailFix))
            $diffTimeHuman = \Coduo\PHPHumanizer\DateTimeHumanizer::difference($this->dateTime, $compareDate, "en");

        return $diffTimeHuman;
    }

    public static function now($dateTimeZone = null)
    {
        self::__initialize();

        if ($dateTimeZone == null)
            $dateTimeZone = self::$defaultTimeZone;
        if (($dateTimeZone instanceof \DateTimeZone) == false) {
            $dateTimeZone = \DateTimeEx\TimeZone::getBySid($dateTimeZone);
            if ($dateTimeZone == null) $dateTimeZone = self::$defaultTimeZone;
        }

        return new DateTimeEx("", $dateTimeZone);
    }
    
    public static function isDateTimeEx($value)
    { self::__initialize(); return (is_object($value) && (get_class($value) == "DateTimeEx")); }

    public static function fromDate($year, $month = null, $day = null, $hour = null, $minute = null, $second = null, $timezone = null)
    {
        $year = intEx($year)->toInt(); if ($year <= 0) return null;

        $month = intEx($month)->toInt();
        if ($month < self::MONTH_JANUARY || $month > self::MONTH_DECEMBER)
            $month = self::MONTH_JANUARY;
        $month = intEx($month)->toPad(\intEx::PAD_LEFT, 2);

        $day = intEx($day)->toInt();
        if ($day <= 0 || $day > 31) $day = 1;
        $day = intEx($day)->toPad(\intEx::PAD_LEFT, 2);

        $hour   = intEx($hour)->toPad(\intEx::PAD_LEFT, 2);
        $minute = intEx($minute)->toPad(\intEx::PAD_LEFT, 2);
        $second = intEx($second)->toPad(\intEx::PAD_LEFT, 2);

        $mount = ($year . "/" . $month . "/" . $day . " " . $hour . ":" . $minute . ":" . $second);
        return new \DateTimeEx($mount, $timezone);
    }

    public static function fromTimestamp($timestamp, $dateTimeZone = null)
    {
        self::__initialize();
        $timestamp = intEx($timestamp)->toInt();

        if ($dateTimeZone == null)
            $dateTimeZone = self::$defaultTimeZone;
        if (($dateTimeZone instanceof \DateTimeZone) == false) {
            $dateTimeZone = \DateTimeEx\TimeZone::getBySid($dateTimeZone);
            if ($dateTimeZone == null) $dateTimeZone = self::$defaultTimeZone;
        }

        $dateTime = new \DateTimeEx(null, $dateTimeZone);
        $dateTime->setTimestamp($timestamp);
        return $dateTime;
    }

    public function getTotalDaysInMonth()
    {
        $month = $this->getMonth();
        $year  = $this->getYear();
        if (!is_numeric($year) or strlen($year) != 4)
            $year = date('Y');
        if ($month == 2 && ($year % 400 == 0 or ($year % 4 == 0 and $year % 100 != 0)))
            return 29;
        $daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        return $daysInMonth[$month - 1];
    }
    
    public function __toString()
    { return $this->toString(); }

    public function isValid()
    { return ($this->dateTime != null); }

    public function isNull()
    { return $this->isValid(); }

    public function toString()
    { return $this->format(self::FORMAT_DEFAULT); }

    public function format($format = DateTimeEx::FORMAT_DEFAULT) { if ($this->dateTime == null) return null; return $this->dateTime->format($format); }
    public function toFormat($format = DateTimeEx::FORMAT_DEFAULT) { return $this->format($format); }

    public function getYear() { if ($this->dateTime == null) return null; return intEx($this->dateTime->format("Y"))->toInt(); }

    public function getMonth($padding = false)
    {
        if ($this->dateTime == null) return null;
        $month = intEx($this->dateTime->format("m"))->toInt();
        if ($padding == true)
            return (($month < 10) ? ("0" . $month) : stringEx($month)->toString());
        return $month;
    }

    public function getDay($padding = false)
    {
        if ($this->dateTime == null) return null;
        $day = intEx($this->dateTime->format("d"))->toInt();
        if ($padding == true)
            return (($day < 10) ? ("0" . $day) : stringEx($day)->toString());
        return $day;
    }
    
    public function getHour($padding = false)
    {
        if ($this->dateTime == null) return null;
        $hour = intEx($this->dateTime->format("H"))->toInt();
        if ($padding == true)
            return (($hour < 10) ? ("0" . $hour) : stringEx($hour)->toString());
        return $hour;
    }

    public function getMinute($padding = false)
    {
        if ($this->dateTime == null) return null;
        $minute = intEx($this->dateTime->format("i"))->toInt();
        if ($padding == true)
            return (($minute < 10) ? ("0" . $minute) : stringEx($minute)->toString());
        return $minute;
    }

    public function getSecond($padding = false)
    {
        if ($this->dateTime == null) return null;
        $second = intEx($this->dateTime->format("s"))->toInt();;
        if ($padding == true)
            return (($second < 10) ? ("0" . $second) : stringEx($second)->toString());
        return $second;
    }

    public function getDayOfWeek() { if ($this->dateTime == null) return null; return \intEx($this->format('N'))->toInt(); }

    public function isWeekend()
    {
        if ($this->dateTime == null) return null;
        $dayOfWeek = $this->getDayOfWeek();
        return ($dayOfWeek == self::DAY_OF_WEEK_SATURDAY || $dayOfWeek == self::DAY_OF_WEEK_SUNDAY);
    }

    public function addYear($intYear)
    {
        if ($this->dateTime == null) return null;
        $intYear = intEx($intYear)->toInt();
        $this->setYear($this->getYear() + $intYear);
        return $this;
    }
    
    public function addMonth($intMonth)
    {
        if ($this->dateTime == null) return null;
        $intMonth = intEx($intMonth)->toInt();
        $this->setMonth($this->getMonth() + $intMonth);
        return $this;
    }
    
    public function addDay($intDay)
    {
        if ($this->dateTime == null) return null;
        $intDay = intEx($intDay)->toInt();
        $this->setDay($this->getDay() + $intDay);
        return $this;
    }
    
    public function addHour($intHour)
    {
        if ($this->dateTime == null) return null;
        $intHour = intEx($intHour)->toInt();
        $this->setHour($this->getHour() + $intHour);
        return $this;
    }
    
    public function addMinute($intMinute)
    {
        if ($this->dateTime == null) return null;
        $intMinute = intEx($intMinute)->toInt();
        $this->setMinute($this->getMinute() + $intMinute);
        return $this;
    }
    
    public function addSecond($intSecond)
    {
        if ($this->dateTime == null) return null;
        $intSecond = intEx($intSecond)->toInt();
        $this->setSecond($this->getSecond() + $intSecond);
        return $this;
    }
    
    public function setYear($intYear)
    {
        if ($this->dateTime == null) return null;
        $intYear = intEx($intYear)->toInt();
        $this->setDate($intYear, $this->getMonth(), $this->getDay());
        return $this;
    }
    
    public function setMonth($intMonth)
    {
        if ($this->dateTime == null) return null;
        $intMonth = intEx($intMonth)->toInt();
        $this->setDate($this->getYear(), $intMonth, $this->getDay());
        return $this;
    }
    
    public function setDay($intDay)
    {
        if ($this->dateTime == null) return null;
        $intDay = intEx($intDay)->toInt();
        $this->setDate($this->getYear(), $this->getMonth(), $intDay);
        return $this;
    }
    
    public function setHour($intHour)
    {
        if ($this->dateTime == null) return null;
        $intHour = intEx($intHour)->toInt();
        $this->setTime($intHour, $this->getMinute(), $this->getSecond());
        return $this;
    }
    
    public function setMinute($intMinute)
    {
        if ($this->dateTime == null) return null;
        $intMinute = intEx($intMinute)->toInt();
        $this->setTime($this->getHour(), $intMinute, $this->getSecond());
        return $this;
    }
    
    public function setSecond($intSecond)
    {
        if ($this->dateTime == null) return null;
        $intSecond = intEx($intSecond)->toInt();
        $this->setTime($this->getHour(), $this->getMinute(), $intSecond);
        return $this;
    }

    public function setDate($intYear, $intMonth, $intDay)
    {
        if ($this->dateTime == null) return null;
        $intYear  = intEx($intYear)->toInt();
        $intMonth = intEx($intMonth)->toInt();
        $intDay   = intEx($intDay)->toInt();
        
        $this->dateTime->setDate($intYear, $intMonth, $intDay);
        return $this;
    }

    public function setTime($intHour, $intMinute, $intSecond = null)
    {
        if ($this->dateTime == null) return null;
        $intHour   = intEx($intHour)->toInt();
        $intMinute = intEx($intMinute)->toInt();
        
        if ($intSecond != null)
            $intSecond = intEx($intSecond)->toInt();
        
        $this->dateTime->setTime($intHour, $intMinute, $intSecond);
        return $this;
    }
    
    public function getTimeZone() { if ($this->dateTime == null) return null; return $this->dateTime->getTimezone(); }
    
    public function setTimeZone($dateTimeZone)
    {
        if ($this->dateTime == null) return null;

        if ($dateTimeZone == null)
            $dateTimeZone = self::$defaultTimeZone;
        if (($dateTimeZone instanceof \DateTimeZone) == false) {
            $dateTimeZone = \DateTimeEx\TimeZone::getBySid($dateTimeZone);
            if ($dateTimeZone == null) $dateTimeZone = self::$defaultTimeZone;
        }

        return @$this->dateTime->setTimezone($dateTimeZone);
    }
    
    public function getTimestamp($returnInt = false)
    {
        if ($this->dateTime == null) return null;
        $timestamp = new \Timestamp($this->dateTime->getTimestamp());
        return ($returnInt == true ? $timestamp->get() : $timestamp);
    }
    public function toTimestamp($returnInt = false) { return self::getTimestamp($returnInt); }

    public function setTimestamp($timeStamp)
    {
        if ($this->dateTime == null)
            $this->dateTime = \DateTimeEx::now()->toDateTime();

        if ($timeStamp instanceof \Timestamp)
            $timeStamp = $timeStamp->get();

        $timeStamp = intEx($timeStamp)->toInt();
        return $this->dateTime->setTimestamp($timeStamp);
    }
    
    public function toDateTime()
    {
        if ($this->dateTime == null) return null;
        return $this->dateTime;
    }

    public function toTime($includeDateFromInit = false)
    {
        if ($includeDateFromInit == true)
            return \Time::fromTimestamp($this->getTimestamp());

        $time = new \Time();
        $time->addSecond($this->getSecond());
        $time->addMinute($this->getMinute());
        $time->addHour($this->getHour());
        return $time;
    }

    public function addTime($time)
    {
        if ($time instanceof \Time)
        {
            if ($time->getMiliSecond() > 0)
                $this->addSecond($time->getMiliSecond() / 1000);

            $this->addSecond($time->getSecond());
            $this->addMinute($time->getMinute());
            $this->addHour($time->getHour());
            $this->addDay($time->getDay());
        }

        return $this;
    }

    public function getUTC()
    {
        if ($this->dateTime == null) return null;
        $dateUTC = $this->copy();
        $dateUTC->setTimeZone(\DateTimeEx\TimeZone::getBySid("UTC"));
        return $dateUTC;
    }

    public function getDaysInMonth($count = false)
    {
        if ($this->dateTime == null) return null;

        if ($count === true) {
            $clone = $this->copy();
            $month = $clone->getMonth();

            while ($clone->getMonth() === $month)
                $clone->addDay(1);
            $clone->addDay(-1);

            return $clone->getDay();
        }

        $clone = $this->copy();
        $month = $clone->getMonth();
        $clone->setHour(0);
        $clone->setMinute(0);
        $clone->setSecond(0);

        while ($clone->getMonth() === $month)
            $clone->addDay(-1);
        $clone->addDay(1);

        $days = Arr();
        while ($clone->getMonth() === $month) {
            $days[] = $clone->copy();
            $clone->addDay(1);
        }

        return $days;
    }

    public function getDaysInWeek($count = false)
    {
        if ($this->dateTime == null) return null;

        if ($count === true)
            return 7;

        $clone = $this->copy();
        $clone->setHour(0);
        $clone->setMinute(0);
        $clone->setSecond(0);

        while ($clone->getDayOfWeek() !== self::DAY_OF_WEEK_MONDAY)
            $clone->addDay(-1);

        $days = Arr();
        while ($clone->getDayOfWeek() !== self::DAY_OF_WEEK_SUNDAY) {
            $days[] = $clone->copy();
            $clone->addDay(1);
        }
        $days[] = $clone->copy();
        return $days;
    }

    public static function getDaysInRange(\DateTimeEx $dateInit, \DateTimeEx $dateFinish, $count = false)
    {
        $_dateInit = $dateInit->copy();
        $_dateFinish = $dateFinish->copy();
        $_dateInit->setHour(0);
        $_dateInit->setMinute(0);
        $_dateInit->setSecond(0);
        $_dateFinish->setHour(0);
        $_dateFinish->setMinute(0);
        $_dateFinish->setSecond(0);

        $dateFinishFormat = $_dateFinish->toFormat();

        $days = Arr();
        $_count = 0;

        while($_dateInit->toFormat() !== $dateFinishFormat)
        {
            if ($count === false)
                $days[] = $_dateInit->copy();
            else $_count++;
            $_dateInit->addDay(1);
        }

        if ($count === false)
            $days[] = $_dateInit->copy();
        else $_count++;


        if ($count === false)
            return $days;

        return $_count;
    }

    public function copy()
    {
        if ($this->dateTime == null) return null;
        $dateStr = $this->toString();
        return new DateTimeEx($dateStr, $this->getTimeZone());
    }
}