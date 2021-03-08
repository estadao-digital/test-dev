<?php

namespace {
    
class boolEx
{
    protected static $implements = null;

    const VALUE = null;
    
    private $value = null;
    
    public function __construct($value = null, $usePhpParse = false)
    {
        //if ($usePhpParse)
        //    $this->value = boolval($value);
        //else
        if (is_null($value) || is_bool($value))
            $this->value = $value;
        elseif (is_int($value) || is_float($value))
            $this->value = ($value <= 0) ? false : true;
        elseif (is_string($value) || !function_exists("boolval"))
        {
            $stringValue = stringEx($value)->toLower();
            if ($stringValue == "true" || $stringValue == "1" || $stringValue == "on" || $stringValue == "yes")
                $this->value = true;
            elseif ($stringValue == "false" || $stringValue == "0" || $stringValue == "off" || $stringValue == "no")
                $this->value = false;
            else $this->value = null;
        }
        else boolval($value);
    }
    
    public function __toString()
    { return $this->toString(); }

    public function toString($usePhpParse = false)
    { return stringEx($this->value)->toString($usePhpParse); }
    
    public function toInt()
    { return stringEx($this->value)->toInt(); }
    
    public function toFloat()
    { return stringEx($this->value)->toInt(); }

    public function toBool($usePhpParse = false)
    { return $this->value; }

    public static function implement($name, $delegate)
    {
        if (method_exists(self::class, $name) || \FunctionEx::isFunction($delegate) == false)
            return false;

        if (self::$implements == null)
            self::$implements = Arr();

        self::$implements[$name] = $delegate;
        return true;
    }

    public function __call($name, $arguments)
    {
        if (self::$implements == null || self::$implements->containsKey($name) == false)
            \trigger_error('Call to undefined method '. __CLASS__ . '::' . $name . '()', E_USER_ERROR);

        $callFunction = self::$implements[$name];
        \array_unshift($arguments , $this->value);
        return \call_user_func_array($callFunction, $arguments);
    }
}

function boolEx($value = null)
{ return new boolEx($value); }

function boolean($value = null)
{ return new boolEx($value); }

function toBool($value) { return boolEx($value)->toBool(); }

const boolEx = "boolEx";
const boolean = "bool";

}