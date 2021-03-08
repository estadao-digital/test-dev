<?php

class Timestamp
{
    protected $value = 0;

    public function __construct($timestamp = null)
    { $this->value = intEx($timestamp)->toInt(); }

    public static function fromDateTimeEx(\DateTimeEx $dateTime)
    {
        $timestamp = intEx($dateTime->getTimestamp())->toInt();
        return new Timestamp($timestamp);
    }

    public static function now($returnInt = false)
    {
        $timestamp = \DateTimeEx::now()->getTimestamp();
        return ($returnInt == true ? $timestamp->get() : $timestamp);
    }
    public function set($timestamp)
    {
        intEx($timestamp)->toInt();
        $this->value = $timestamp;
    }

    public function getDays()
    { return \intEx((($this->value / 60) / 60) / 24)->toInt();  }

    public function getHours()
    { return \intEx(($this->value / 60) / 60)->toInt();  }

    public function getMinutes()
    { return \intEx($this->value / 60)->toInt();  }

    public function getSeconds()
    { return $this->value;  }

    public function get()
    { return $this->value; }

    public function getStopwatch()
    {
        $stopwatch = Arr();

        $stopwatch->days    = 0;
        $stopwatch->hours   = 0;
        $stopwatch->minutes = 0;
        $stopwatch->seconds = 0;

        $value = (0 + $this->value);

        $dayStamp = (60 * 60 * 24);
        while ($value > $dayStamp)
        { $stopwatch->days++; $value -= $dayStamp; }

        $hourStamp = (60 * 60);
        while ($value > $hourStamp)
        { $stopwatch->hours++; $value -= $hourStamp; }

        $minuteStamp = 60;
        while ($value > $minuteStamp)
        { $stopwatch->minutes++; $value -= $minuteStamp; }

        $stopwatch->seconds = $value;
        return $stopwatch;
    }

    public function toInt()
    { return intEx($this->value)->toInt(); }

    public function toString()
    { return stringEx($this->value)->toString(); }

    public function __toString()
    { return $this->toString(); }

}