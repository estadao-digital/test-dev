<?php

class Time
{
    const FORMAT_DEFAULT = "d:h:m:s.ms";
    const FORMAT_NO_DAYS = "h:m:s.ms";
    const FORMAT_NO_MILISECONDS = "d:h:m:s";
    const FORMAT_NO_DAYS_AND_MILISECONDS = "h:m:s";

    protected $time = null;

    public function __construct($time = 0)
    {
        $time = stringEx($time)->replace(".", ":");
        if (stringEx($time)->contains(":") == false)
        {
            $time = floatEx($time)->toFloat();
            $this->time = $time;
        }
        else
        {
            $split = stringEx($time)->split(":");
            if (stringEx($split[($split->count - 1)])->count < 3) {
                $time = ($time . ":000");
                $split = stringEx($time)->split(":");
            }

            $miliSecond = $split[($split->count - 1)];
            $second     = ($split->count >= 2) ? $split[($split->count - 2)] : 0;
            $minute     = ($split->count >= 3) ? $split[($split->count - 3)] : 0;
            $hour       = ($split->count >= 4) ? $split[($split->count - 4)] : 0;
            $day        = ($split->count >= 5) ? $split[($split->count - 5)] : 0;

            $this->time = floatEx(0)->toFloat();

            $this->addDay($day);
            $this->addHour($hour);
            $this->addMinute($minute);
            $this->addSecond($second);
            $this->addMiliSecond($miliSecond);
        }
    }

    public static function getCurrent($returnNumber = false)
    {
        $timestamp = null;

        if (function_exists("microtime"))
            $timestamp = floatEx(microtime(true))->toFloat();
        if ($timestamp == null)
            $timestamp = floatEx(time())->toFloat();


        $time = new Time($timestamp);

        if ($returnNumber == true)
            return $time->get();
        return $time;
    }

    public static function now($returnNumber = false)
    { return self::getCurrent($returnNumber); }

    public static function fromDateTime($dateTime)
    {
        $dateTime = new DateTimeEx($dateTime);
        $timeStamp = $dateTime->getTimestamp()->get();
        return new Time($timeStamp);
    }

    public static function fromTimestamp($timestamp)
    {
        if ($timestamp instanceof \Timestamp)
            return new Time($timestamp->get());
        return new Time(intEx($timestamp)->toInt());
    }

    public static function sleep($seconds) //, $useMicro = true)
    {
        $seconds = floatEx($seconds)->toFloat();
        if ($seconds <= 0) return null;

        $_seconds = intEx($seconds)->toInt();
        $_miliSeconds = ($seconds - $_seconds);

        if ($_miliSeconds == 0) {
            $sleep = @sleep($_seconds);
            if ($sleep === false) {
                $sleep = @time_nanosleep($_seconds, 0);
                if ($sleep !== true) return self::_sleep($seconds);
            }
            if ($sleep === false)
                return self::_sleep($seconds);
            return true;
        }

        $nanoTime = ($_miliSeconds * 1000000000);
        $sleep = @time_nanosleep($_seconds, $nanoTime);
        if ($sleep === true)
            return true;

        return self::_sleep($seconds);
    }

    protected static function _sleep($seconds)
    {
        $startTime = \Time::getCurrent()->get();
        while (true)  {
            $diffTime = (\Time::getCurrent()->get() - $startTime);
            if ($diffTime >= $seconds)
                break;
        }
        return true;
    }

    public static function getStartup($returnNumber = false)
    {

    }

    public function get()
    { return $this->time; }

    public function toString()
    { return stringEx($this->get())->toString(); }

    public function __toString()
    { return $this->toString(); }

    public function toFormat($format = self::FORMAT_DEFAULT)
    {
        $format = stringEx($format)->
            replace("ms", $this->getMiliSecond(true), false)->
            replace("s", $this->getSecond(true), false)->
            replace("m", $this->getMinute(true), false)->
            replace("h", $this->getHour(true), false)->
            replace("d", $this->getDay(true));

        return $format;
    }


    public function toDateTime($dateTimeZone = null)
    {
        $dateTime = new \DateTimeEx("", $dateTimeZone);
        $dateTime->setTimestamp($this->time);
        return $dateTime;
    }

    public function toTimestamp($dateTimeZone = null)
    {
        $dateTime = $this->toDateTime($dateTimeZone);
        return $dateTime->toTimeStamp();
    }

    public function addMiliSecond($milisecond)
    {
        $milisecond = floatEx($milisecond)->toFloat();
        if ($milisecond == 0) return $this;
        $milisecond = ($milisecond / 1000);
        $this->time += $milisecond;
        if ($this->time < 0) $this->time = 0;
        $this->time = floatEx($this->time)->toFloat();
        return $this;
    }

    public function addSecond($second)
    {
        $second = floatEx($second)->toFloat();
        $this->time += $second;
        if ($this->time < 0) $this->time = 0;
        $this->time = floatEx($this->time)->toFloat();
        return $this;
    }

    public function addMinute($minute)
    {
        $minute = floatEx($minute)->toFloat();
        $second = ($minute * 60);
        $this->time += $second;
        if ($this->time < 0) $this->time = 0;
        $this->time = floatEx($this->time)->toFloat();
        return $this;
    }

    public function addHour($hour)
    {
        $hour = floatEx($hour)->toFloat();
        $second = ($hour * 3600);
        $this->time += $second;
        if ($this->time < 0) $this->time = 0;
        $this->time = floatEx($this->time)->toFloat();
        return $this;
    }

    public function addDay($day)
    {
        $day = floatEx($day)->toFloat();
        $second = ($day * 86400);
        $this->time += $second;
        if ($this->time < 0) $this->time = 0;
        $this->time = floatEx($this->time)->toFloat();
        return $this;
    }

    public function getMiliSecond($padding = false)
    {
        $time = stringEx($this->time)->toString();
        $timeMS = "000";
        if (stringEx($time)->contains(".")) {
            $time = stringEx($time)->split(".");
            if ($time->count >= 2) $timeMS = intEx($time[1])->toString();
            if (stringEx($timeMS)->count > 3)
                $timeMS = stringEx($timeMS)->subString(0, 3);
        }
        while (stringEx($timeMS)->count < 3)
            $timeMS .= "0";
        if ($padding == true) return $timeMS;
        return intEx($timeMS)->toInt();
    }

    public function getSecond($padding = false)
    {
        $time = ($this->time % 60);
        if ($padding == true)
            return (($time < 10) ? ("0" . $time) : stringEx($time)->toString());
        return $time;
    }

    public function getMinute($padding = false)
    {
        if ($this->time < 60)
            return (($padding == true) ? "00" : 0);

        $time = (0 + $this->time);
        $time = ($time % 3600);
        $time = ($time - ($time % 60));
        $time = intEx($time / 60)->toInt();

        if ($padding == true)
            return (($time < 10) ? ("0" . $time) : stringEx($time)->toString());
        return $time;
    }

    public function getHour($padding = false)
    {
        $time = ($this->time - ($this->time % 3600));
        $time = intEx($time / 3600)->toInt();
        $time = intEx($time % 24)->toInt();

        if ($padding == true)
            return (($time < 10) ? ("0" . $time) : stringEx($time)->toString());
        return $time;
    }

    public function getDay($padding = false)
    {
        $time = ($this->time - ($this->time % 86400));
        $time = intEx($time / 86400)->toInt();

        if ($padding == true)
            return (($time < 10) ? ("0" . $time) : stringEx($time)->toString());
        return $time;
    }

    public function getMiliSecondTotal()
    { return $this->toMiliSecond(); }

    public function getSecondTotal()
    {
        if ($this->time <= 0) return 0;
        return floatEx(0 + $this->time)->toFloat();
    }

    public function getMinuteTotal()
    {
        if ($this->time <= 0) return 0;
        return floatEx($this->time / 60)->toFloat();
    }

    public function getHourTotal()
    {
        if ($this->time <= 0) return 0;
        return floatEx($this->time / 3600)->toFloat();
    }

    public function getDayTotal()
    {
        if ($this->time <= 0) return 0;
        return floatEx($this->time / 86400)->toFloat();
    }

    public function toMiliSecond()
    {
        if ($this->time <= 0) return 0;

        $miliSeconds = intEx($this->time * 1000)->toInt();
        return $miliSeconds;
    }

}