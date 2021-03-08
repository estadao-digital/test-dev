<?php

namespace {

class floatEx
{
    protected static $implements = null;

    const VALUE = 0;

    const ROUND_DEFAULT = null;
    const ROUND_UPPER   = PHP_ROUND_HALF_UP;
    const ROUND_DOWN    = PHP_ROUND_HALF_DOWN;
    const ROUND_EVEN    = PHP_ROUND_HALF_EVEN;
    const ROUND_ODD     = PHP_ROUND_HALF_ODD;

    
    private $value = 0;
    
    public function __construct($value = null)
    {
        $value = stringEx($value)->toString();
        $this->value = floatval($value);
    }
    
    public function __toString()
    { return $this->toString(); }

    public function toString()
    { return stringEx($this->value)->toString(); }
    
    public function toInt()
    { return intEx($this->value)->toInt(); }
    
    public function toFloat()
    { return $this->value; }

    public function toBool($usePhpParse = false)
    { return boolEx($this->value)->toBool($usePhpParse); }

    public function toPrecision($precision, $round = self::ROUND_DEFAULT) {
        $precision = intEx($precision)->toInt();
        if ($precision <= 0) return floatEx($this->toInt())->toFloat();

        $intNumber = intEx($this->value)->toInt();
        $diff      = floatEx($this->value - $intNumber)->toFloat();
        if ($diff > 0) {
            if ($precision === 0)
                return floatEx(round($this->value, $precision, $round))->toFloat();

            $precisionMultiply = '1';
            for ($i = 0; $i < $precision; $i++)
                $precisionMultiply .= '0';
            $precisionMultiply = intEx($precisionMultiply)->toInt();
            $_round = round($this->value * $precisionMultiply, 0, PHP_ROUND_HALF_UP);
            $_round = $_round / $precisionMultiply;

            return floatEx($_round)->toFloat();
        }

        return floatEx($this->toInt())->toFloat();
    }

    public function toPercent($precision)
    {
        $precision = toInt($precision);
        \Cake::load();
        return \Cake\I18n\Number::toPercentage($this->value, $precision);
    }

    public function format($pattern)
    {
        $pattern = toString($pattern);
        if (stringEx($pattern)->isEmpty())
            return toInt($this->value);

        \Cake::load();
        return \Cake\I18n\Number::format($this->value, ["pattern" => $pattern]);
    }

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

function floatEx($value = 0)
{ return new floatEx($value); }

const floatEx = "floatEx";

function toFloat($value) { return floatEx($value)->toFloat(); }

function flt($value = 0)
{ return floatEx($value); }

class flt extends floatEx {}
const flt = "flt";

}