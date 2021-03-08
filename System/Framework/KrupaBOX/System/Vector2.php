<?php

class Vector2
{
    protected $x = 0;
    protected $y = 0;

    public static function zero()  { return new Vector2(0, 0); }
    public static function one()   { return new Vector2(1, 1); }
    public static function two()   { return new Vector2(2, 2); }
    public static function three() { return new Vector2(3, 3); }

    public function __construct($x = null, $y = null)
    {
        $this->__set(x, $x);
        $this->__set(y, $y);
    }

    public function __set($key, $value = null)
    {
            if ($key == x) $this->x = floatEx($value)->toFloat();
        elseif ($key == y) $this->y = floatEx($value)->toFloat();
    }

    public function __get($key)
    {
            if ($key == x) return $this->x;
        elseif ($this->y)  return $this->y;

        return null;
    }

    public function toArr()
    { return Arr([x => $this->x, y => $this->y]); }

    public function toVector3()
    { return new Vector3($this->x, $this->y, $this->z); }
}