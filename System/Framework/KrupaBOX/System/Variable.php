<?php

namespace {
    
class Variable
{
    protected static $types = [
        string, int, float, bool, unknown,
        "array", "object", DateTime, DateTimeEx,
        Arr, stringEx, intEx, floatEx, boolEx
    ];
    
    protected $value;
    
    public function __construct($value = null)
    { $this->value = $value; }
    
    public function convert($toType)
    {
        if ($toType == string)
            return $this->toString();
        elseif ($toType == int)
            return $this->toInt();
        elseif ($toType == bool)
            return $this->toBool();
        elseif ($toType == float)
            return $this->toFloat();
        elseif ($toType == Arr)
            return \Arr($this->value);
        elseif ($toType == DateTimeEx)
            return new \DateTimeEx($this->value);
            
        else return $this->value;
    }

    public function toString()  { return stringEx($this->value)->toString(); }
    public function toInt()     { return intEx($this->value)->toInt(); }
    public function toFloat()   { return floatEx($this->value)->toFloat(); }
    public function toBool()    { return boolEx($this->value)->toBool(); }
    
    public function getType()
    {
        $type = gettype($this->value);
        
        if ($type == "boolean")
            return bool;
        if ($type == "integer")
            return int;
        elseif ($type == "double")
            return float;
        elseif ($type == "NULL")
            return null;
        elseif ($type == "unknown type")
            return "unknown";
        elseif ($type == "object" && $this->isFunction())
            return "function";

        return $type;  
    }
    
    public function isNumeric()  { return is_numeric($this->value); }
    public function isBool()     { return is_bool($this->value); }
    public function isArray()    { return is_array($this->value); }
    public function isInt()      { return is_int($this->value); }
    public function isNull()     { return is_null($this->value); }
    public function isFloat()    { return is_float($this->value); }
    public function isResource() { return is_resource($this->value); }
    public function isScalar()   { return is_scalar($this->value); }
    public function isString()   { return is_string($this->value); }
    
    public function isObject()   { return (is_object($this->value) && !($this->value instanceof Closure)); }
    public function isFunction() { return (is_object($this->value) && ($this->value instanceof Closure)); }
    
    public function isInstance()
    {
        if ($this->isObject() == false)
            return false;
            
        $value = Instance::getName($this->value);
        return ($value != null);
    }
    
    public function isArr()
    {
        if ($this->isInstance() == false)
            return false;
        
        $value = Instance::getName($this->value);
        return $value == Arr;
    }
    
    public function isDateTime()
    {
        if ($this->isInstance() == false)
            return false;
        
        $value = Instance::getName($this->value);
        return $value == DateTime;
    }
    
    public function isDateTimeEx()
    {
        if ($this->isInstance() == false)
            return false;
        
        $value = Instance::getName($this->value);
        return $value == DateTimeEx;
    }
    
    public function isStringEx()
    {
        if ($this->isInstance() == false)
            return false;
        
        $value = Instance::getName($this->value);
        return $value == stringEx;
    }
    
    public function isIntEx()
    {
        if ($this->isInstance() == false)
            return false;
        
        $value = Instance::getName($this->value);
        return $value == intEx;
    }
    
    public function isFloatEx()
    {
        if ($this->isInstance() == false)
            return false;
        
        $value = Instance::getName($this->value);
        return $value == floatEx;
    }
    
    public function isBoolEx()
    {
        if ($this->isInstance() == false)
            return false;
        
        $value = Instance::getName($this->value);
        return $value == boolEx;
    }
    
    public static function isValidType($type)
    {
        $types = Variable::getValidTypes();
        
        foreach ($types as $_type)
            if ($_type == $type)
                return true;

        return false;
    }
    
    public static function get($value = null)
    { return new Variable($value); }
    
    public static function getValidTypes()
    { return self::$types; }
    
    public static function getPreferredTypeByType($type)
    {
        if (!self::isValidType($type))
            return null;
            
        if ($type == string || $type == stringEx || $type == str)
            return string;
        elseif ($type == int || $type == integer || $type == intEx)
            return int;
        elseif ($type == float || $type == double || $type == numeric || $type == floatEx || $type == flt)
            return float;
        elseif ($type == bool || $type == boolean || $type == boolEx)
            return bool;
        elseif ($type == DateTime || $type == DateTimeEx)
            return DateTimeEx;
        elseif ($type == "array" || $type == Arr || $type == "object" || $type == instance)
            return Arr;

        return null;
    }
    
    public static function __onConstructStatic()
    { self::$types = \Arr(self::$types); }
}

}
