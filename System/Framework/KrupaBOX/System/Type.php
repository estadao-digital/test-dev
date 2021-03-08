<?php

namespace {
/*
class Type
{
    private $value = null;
    
    public function __construct($value = null)
    { $this->value = $value; }
    
    public function get()
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
            return unknown;
        
        return $type;    
    }
    
    public function isNumeric()  { return is_numeric($this->value); }
    public function isBool()     { return is_bool($this->value); }
    public function isArray()    { return is_array($this->value); }
    public function isInt()      { return is_int($this->value); }
    public function isNull()     { return is_null($this->value); }
    public function isFloat()    { return is_float($this->value); }
    public function isObject()   { return is_object($this->value); }
    public function isResource() { return is_resource($this->value); }
    public function isScalar()   { return is_scalar($this->value); }
    public function isString()   { return is_string($this->value); }

    public function isClass()
    {
        if ($this->isObject() == false)
            return false;
            
        $value = ClassEx::getName($this->value);
        return ($value != null);
    }
    
    public function isDateTime()
    {
        if ($this->isClass() == false)
            return false;
        
        $value = ClassEx::getName($this->value);
        return $value == DateTime;
    }
    
    public function isDateTimeEx()
    {
        if ($this->isClass() == false)
            return false;
        
        $value = ClassEx::getName($this->value);
        return $value == DateTimeEx;
    }
    
    public function isStringEx()
    {
        if ($this->isClass() == false)
            return false;
        
        $value = ClassEx::getName($this->value);
        return $value == string;
    }
    
    public function isIntEx()
    {
        if ($this->isClass() == false)
            return false;
        
        $value = ClassEx::getName($this->value);
        return $value == "int";
    }
    
    public function isFloatEx()
    {
        if ($this->isClass() == false)
            return false;
        
        $value = ClassEx::getName($this->value);
        return $value == float;
    }
    
    public function isArr()
    {
        if ($this->isClass() == false)
            return false;
        
        $value = ClassEx::getName($this->value);
        return $value == Arr;
    }
}

function type($value = null)
{ return new Type($value); }

*/
}