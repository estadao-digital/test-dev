<?php

namespace KrupaBOX\Internal\Traits\Arr
{
    trait Counter
    {
        public function length()
        { return $this->count(); }
        
        public function isEmpty()
        { return ($this->count() <= 0); }
    }
       
    trait Convert
    {
        public function __toString()
        { return $this->toString(); }
        
        public function toString()
        { return json_encode($this); }
        
        public function toJson()
        { return $this->toString(); }
        
        public function toArray($convertChildrens = true)
        {
            $Arrport = $this->getArrayCopy();
            
            foreach ($Arrport as $key => &$value)
            {
                $variable = \Variable::get($value);
    
                if ($variable->isArr() && $convertChildrens == true)
                    $value = $value->toArray();
                else if ($variable->isDateTimeEx())
                    $value = $value->toDateTime();    
            }
            
            return $Arrport;
        }
        
        public function toSerialize()
        {
            $array = $this->toArray();
            return serialize($array);
        }
    }
}

namespace
{
    /**
     * Description for the class
     * @property int $length
     * @property int $count
     * @property int $first
     * @property int $last
     */
    class Arr extends \ArrayObject
    {
        use \KrupaBOX\Internal\Traits\Arr\Counter;
        use \KrupaBOX\Internal\Traits\Arr\Convert;
        
        public function __construct($value = null, $forceParseInstances = false, $tryDecodeJson = false)
        {
            $variable = \Variable::get($value);
            $type = $variable->getType();
    
            $preferred = \Variable::getPreferredTypeByType($type);
            
            if ($preferred != Arr)
            {
                if ($type == string)
                {
                    $decode = json_decode($value);
        
                    if ($tryDecodeJson == true && $decode != null)
                        $value = (array)$decode;  
                    elseif (!stringEx($value)->isEmpty())
                        $value = [$value];
                    else $value = null;
                }
                elseif ($value != null)
                    $value = [$value];
            }
            
            if ($value != null)
            {
                if ($variable->isArr() && !is_array($value))
                    $value = $value->toArray();
                elseif ($variable->isObject())
                    $value = (array)$value;
            }
            else $value = [];
    
            parent::__construct($value, \ArrayObject::ARRAY_AS_PROPS);
            
            // Type deep arrays
            foreach ($this as $key => &$value)
            {
                $variable = \Variable::get($value);
                $type = $variable->getType();

                if ($type == object && ($variable->isDateTime() || $variable->isDateTimeEx()))
                    $type = DateTime;

                if (\Variable::getPreferredTypeByType($type) == Arr && ($forceParseInstances == true || $variable->isInstance() == false))
                    $value = \Arr($value);
                else self::__variableCheck($value, $forceParseInstances);
            }
        }

        public function copy()
        {
            $copy = new \Arr($this->toArray(false));
            return $copy;
        }
        
        public function offsetGet($offset)
        {
            if (($offset == "length" || $offset == "count") && !parent::offsetExists($offset))
                return $this->count();
            elseif ($offset == "first" && !parent::offsetExists($offset))
                return $this->getFirst();
            elseif ($offset == "last" && !parent::offsetExists($offset))
                return $this->getLast();
            
            return parent::offsetGet($offset);
        }
        
        public function offsetSet($offset, $value)
        {
            self::__variableCheck($value);
            parent::offsetSet($offset, $value);
        }
        
        public function contains($value)
        {
            foreach ($this as $key => $_value)
                if ($value == $_value)
                    return true;
       
            return false;
        }
        
        public function indexOf($value, $onlyNumbers = false, $onlyNumbersNullOnNotFound = false, $getLastIndex = false)
        {
            $indexOf = null;
            
            foreach ($this as $key => $_value)
                if ($value == $_value)
                { $indexOf = $key; if ($getLastIndex == false) break; }
            
            if ($onlyNumbers == true)
            {
                if (!\Variable::get($indexOf)->isInt() || $indexOf == null || $indexOf < 0)
                    $indexOf = -1;
                    
                if ($indexOf < 0 && $onlyNumbersNullOnNotFound == true)
                    $indexOf = null;
    
                return $indexOf;
            }
            
            return $indexOf;
        }
        
        public function lastIndexOf($value, $onlyNumbers = false, $onlyNumbersNullOnNotFound = false)
        { return $this->indexOf($value, $onlyNumbers, $onlyNumbersNullOnNotFound, true); }
        
        public function containsKey($key)
        { return $this->offsetExists($key); }
        
        public function add($value, $canDuplicate = true)
        {
            if ($canDuplicate == false && $this->contains($value))
                return $this;
                
            $this[] = $value;
            return $this;
        }
        
        public function addKey($key, $value)
        { $this[$key] = $value; return $this; }
        
        protected function _removeKey($key)
        {
            if ($key !== null && (isset($this[$key]) || $this->offsetExists($key)))
                unset($this[$key]);
            return $this;
        }

        public function removeKey($keys)
        {
            $args = func_get_args();
            if (count($args) === 1)
                $args = $args[0];
            $args = Arr($args);

            foreach ($args as $arg)
                $this->_removeKey($arg);
        }

        public function sort()
        { $this->asort(); return $this; }

        public function sortByKey()
        { $this->ksort(); return $this; }

        public function sortByDelegate($delegate)
        {
            if (\FunctionEx::isFunction($delegate) == false)
                return null;
            $this->uasort(function ($a, $b) use($delegate) {
                $response = $delegate($a, $b);
                if ($response === false)    $response = -1;
                elseif ($response === true) $response = 1;
                elseif ($response === null) $response = 0;
                if ($response !== -1 && $response !== 1 && $response !== 0)
                    $response = 0;
                return $response;
            });
            return $this;
        }

        public function shuffle()
        {
            $shuffle = $this->toArray();
            \shuffle($shuffle);
            return Arr($shuffle);
        }

        public function remove($value)
        {
            $removeKey = null;
            
            foreach ($this as $key => $_value)
                if ($value == $_value)
                { $removeKey = $key; break; }

            if ($removeKey !== null)
                $this->removeKey($removeKey);

            return $this;
        }

        public function convertChildrens()
        {
            $convertedArray = \Arr($this);
            foreach ($convertedArray as &$value)
                $value = Arr($value);
            return $convertedArray;
        }

        public function reverse()
        {
            $arr = $this->toArray();
            $reverse = array_reverse($arr, true);
            return Arr($reverse);
        }

        public static function fromSerialize($serializeString)
        {
            $serializeString = stringEx($serializeString)->toString();
            $array = unserialize($serializeString);
            return new Arr($array);
        }

        public static function isArr($value)
        {
            return ($value instanceof Arr);
        }
        
        public static function fromJson($jsonString)
        {
            $jsonString = stringEx($jsonString)->toString();
            return new Arr($jsonString, true);
        }

        public function toHumanList($and = "and", $separator = ", ")
        {
            $separator = toString($separator);
            $and = toString($and);
            \Cake::load();
            $arr = [];
            foreach ($this as $value)
                $arr[] = toString($value);
            return \Cake\Utility\Text::toList($arr, $and, $separator);
        }

        private static function __variableCheck(&$value, $forceParseInstances = false)
        {
            $variable = Variable::get($value); 
            
            if ($value == null)
                return;
            elseif ($variable->isDateTime())
                $value = new \DateTimeEx($value);
            elseif ($variable->isInstance())
            {
                if ($variable->isStringEx())
                    $value = $value->toString();
                elseif ($variable->isIntEx())
                    $value = $value->toInt();
                elseif ($variable->isFloatEx())
                    $value = $value->toFloat();
                elseif ($variable->isBoolEx())
                    $value = $value->toBool();
            }
            elseif ($variable->isObject() || $variable->isArray())
                $value = new Arr($value);
        }
        
        public function setTypeByArray($array, $createIfNotExists = false)
        {
            if ($array == Arr || $array == null)
                return;
                
            $array = \Arr($array);
    
            if($array->isEmpty())
                return;
    
            if ($array->length == 1)
            {
                if ($array->containsKey(0))
                {
                    $type = Variable::getPreferredTypeByType($array[0]);
                    
                    if ($type != null)
                        foreach ($this as $key => &$value)
                            $value = Variable::get($value)->convert($type);
                    
                    if ($type == null && Variable::get($array[0])->isArr())
                    {
                        foreach ($this as $key => &$value)
                            $value = \Arr($value);
                            
                        foreach ($this as $key => &$value)
                            $value->setTypeByArray($array[0]);
                    }
                    
                    return;
                }
            }
            
            foreach ($array as $typeKey => $typeValue)
            {
                if (!$this->containsKey($typeKey))
                {
                    if ($createIfNotExists == false)
                        continue;

                    $this->{$typeKey} = null;
                }
                    
                $type = Variable::getPreferredTypeByType($typeValue);
                    
                if ($type != null)
                    $this->{$typeKey} = Variable::get($this->{$typeKey})->convert($type);
                elseif (Variable::get($typeValue)->isArr())
                {
                    $this->{$typeKey} = \Arr($this->{$typeKey});
                    $this->{$typeKey}->setTypeByArray($typeValue, $createIfNotExists);
                }
            }
        }

        public function filter($delegate, $isKeyValue = false)
        {
            if (!\FunctionEx::isFunction($delegate))
                return null;

            $filteted = Arr();

            if ($isKeyValue == false)
                foreach ($this as  $value)  {
                    $isValid = $delegate($value);
                    if ($isValid == true) $filteted->add($value);
                }
            else foreach ($this as $key => $value)  {
                $isValid = $delegate($key, $value);
                if ($isValid == true) $filteted->addKey($key, $value);
            }

            return $filteted;
        }

        public function find($delegate, $isKeyValue = false)
        {
            if (!\FunctionEx::isFunction($delegate))
                return null;

            if ($isKeyValue == false)
                foreach ($this as  $value)  {
                    $isValid = $delegate($value);
                    if ($isValid == true) return $value;
                }
            else foreach ($this as $key => $value)  {
                $isValid = $delegate($key, $value);
                if ($isValid == true) return Arr([key => $key, value => $value]);
            }

            return null;
        }

        public function getKeys()
        {
            $keys = array_keys((array)$this);
            if ($keys != null) return Arr($keys);
            return Arr();
        }

        public function getLast()
        {
            if ($this->count <= 0) return null;
            $keys = $this->getKeys();
            return ($this[($keys[$keys->count - 1])]);
        }

        public function getFirst()
        {
            if ($this->count <= 0) return null;
            $keys = $this->getKeys();
            return ($this[($keys[0])]);
        }

        public function limit($limit, $isKeyValue = false)
        {
            $limit = intEx($limit)->toInt();
            if ($limit <= 0) return Arr();

            $currentLimit = 0;
            $limited = Arr();

            if ($isKeyValue == false)
                foreach ($this as  $value) {
                    if ($currentLimit >= $limit) break;
                    $limited->add($value);
                    $currentLimit++;
                }
            else foreach ($this as $key => $value)  {
                if ($currentLimit >= $limit) break;
                $limited->addKey($key, $value);
                $currentLimit++;
            }

            return $limited;
        }

        public function clear()
        {
            $keys = $this->getKeys();
            foreach ($keys as $key)
                $this->removeKey($key);
        }

        public function unsplit($delimiter = ",")
        {
            $delimiter = stringEx($delimiter)->toString();

            $mountStr = "";
            foreach ($this as $value)
                $mountStr .= ($value .= $delimiter);

            if ($mountStr != "" && !stringEx($delimiter)->isEmpty())
                $mountStr = stringEx($mountStr)->subString(0, stringEx($mountStr)->length - stringEx($delimiter)->length);
            return $mountStr;
        }

        public function merge($array = null, $replace = true)
        {
            $thisArray = $this->toArray();
            $array = Arr($array)->toArray();

            $newArray = (($replace == true)
                ? array_replace_recursive($thisArray, $array)
                : array_merge_recursive($thisArray, $array)
            );

            return Arr($newArray);
        }

        public function toJSON()
        { return \Serialize\Json::encode($this); }

        public static function notNull($value)
        {
            if ($value === null)
                return Arr();
            return Arr($value);
        }
    }

    class ArrayEx extends \Arr {}

    function Arr($value = null)
    {
        return \Variable::get($value)->isArr()
            ? $value : new Arr($value);
    }

    function ArrayEx($value = null)
    {
        return \Variable::get($value)->isArr()
            ? $value : new Arr($value);
    }

    const Arr = "Arr";
    const ArrayEx = "Arr";
}
