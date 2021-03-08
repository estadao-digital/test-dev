<?php

class Vector3
{
    protected $x = 0;
    protected $y = 0;
    protected $z = 0;

    public static function zero()  { return new Vector3(0, 0, 0); }
    public static function one()   { return new Vector3(1, 1, 1); }
    public static function two()   { return new Vector3(2, 2, 2); }
    public static function three() { return new Vector3(3, 3, 3); }

    public function __construct($x = null, $y = null, $z = null)
    {
        $this->__set(x, $x);
        $this->__set(y, $y);
        $this->__set(z, $z);
    }

    public function __set($key, $value = null)
    {
        if ($key == x) $this->x = floatEx($value)->toFloat();
        elseif ($key == y) $this->y = floatEx($value)->toFloat();
        elseif ($key == z) $this->z = floatEx($value)->toFloat();
    }

    public function __get($key)
    {
        if ($key == x) return $this->x;
        elseif ($this->y)  return $this->y;
        elseif ($this->z)  return $this->z;
        
        return null;
    }
    
    public function toArr()
    { return Arr([x => $this->x, y => $this->y, z => $this->z]); }

    public function toVector2()
    { return new Vector2($this->x, $this->y); }
}
