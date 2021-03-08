<?php

/*
class arrayk
{
    private $value = [];
    
    public function __construct(&$value = null)
    {
        $type = type($value)->get();

        if ($type == arrayk)
            $this->value = $value;
        elseif ($type == object)
            $this->value = (array)$value;    
        elseif ($type == string)
        {
            $decode = Json::decode($value);

            if ($decode != null)
                $this->value = (array)$decode;  
            else $this->value = [$value];
        }
        else $this->value = [$value];
    }
    
    public function __get($name)
    {
        $name = stringEx($name)->toLower();
        
        if ($name == "length" || $name == "count")
            return \intEx(count($this->value))->toInt();
            
        return null;
    }
    
    public function __toString()
    { return $this->toString(); }
    
    public function toString()
    { return Json::encode($this->value); }
    
    public function toArray()
    { return $this->value; }
    
    public function unSplit($splitter = ",")
    {
        $splitter = stringEx($splitter)->toString();
        return implode($splitter, $this->value);
    }
    
    public function toObject()
    { return (object)$this->value; }
    
    public function serialize()
    { return serialize($this->value); }
 
    public function contains($value)
    { return in_array($value, $this->value); }
    
    public function containsKey($key)
    { return array_key_exists($key, $this->value); }
    
    public function add($value, $canDuplicate = false, $returnArray = true)
    {
        if ($canDuplicate == false && $this->contains($value))
            return ($returnArray == true) ? $this->toArray() : $this;

        $this->value[] = $value;  
        return ($returnArray == true) ? $this->toArray() : $this;
    }
    
    public function addKey($key, $value, $returnArray = true)
    {
        if ($this->containsKey($key))
            return ($returnArray == true) ? $this->toArray() : $this;

        $this->value[$key] = $value;
        ksort($this->value);
        return ($returnArray == true) ? $this->toArray() : $this;
    }
    
    public function remove($value, $returnArray = true)
    {
        if(($key = array_search($value, $this->value)) !== false)
            unset($this->value[$key]);
            
        $this->value = array_values($this->value);
        return ($returnArray == true) ? $this->toArray() : $this;
    }
    
    public function removeKey($key, $returnArray = true)
    {
        if($this->containsKey($key))
            unset($this->value[$key]);
            
        return ($returnArray == true) ? $this->toArray() : $this;
    }
    
    public function order($returnArray = true)
    {
        sort($this->value);
        return ($returnArray == true) ? $this->toArray() : $this;
    }
    
    public function clear($returnArray = true)
    {
        $this->value = [];
        return ($returnArray == true) ? $this->toArray() : $this;
    }
}

function arrayk($value = null)
{ return new arrayk($value); }

const arrayk = "array";*/
