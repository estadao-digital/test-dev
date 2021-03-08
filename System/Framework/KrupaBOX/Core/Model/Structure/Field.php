<?php

namespace Model\Structure
{
    class Field
    {
        const TYPE_BOOL     = "bool";
        const TYPE_INT      = "int";
        const TYPE_FLOAT    = "float";
        const TYPE_STRING   = "string";
        const TYPE_ENUM     = "enum";
        const TYPE_DATETIME = "DateTime";
        const TYPE_JSON     = "JSON";
        
        protected $__type = self::TYPE_STRING;
        
        protected $__isPrimary        = false;
        protected $__autoIncrement    = false;
        protected $__isNullable       = false;
        protected $__isEnumerated     = false;
        
        protected $__enumerators = null;

        protected $__dbType    = null;
        protected $__dbLength  = null;
        protected $__dbDefined = false;
 
        public function __construct($fields)
        {
            $fields = \Arr($fields);
            if (stringEx($fields[0])->startsWith('\\'))
                $fields[0] = stringEx($fields[0])->subString(1);
            
            if ($fields->count <= 0)
                return;

            foreach ($fields as &$field)
                $field = stringEx($field)->toString();
                
            $type = null;

            if ($fields[0] == self::TYPE_BOOL || $fields[0] == boolEx)
            {
                $type = self::TYPE_BOOL;

                if ($fields->contains(isEnumerated)) {
                    $this->__dbType = "enum";
                    $this->__enumerators = \Arr(["false", "true"]);
                }
                else $this->__dbType = "boolean";
            }
            elseif ($fields[0] == self::TYPE_INT || $fields[0] == intEx) {
                $type = self::TYPE_INT;
                $this->__dbType = "bigint";
                $this->__dbLength = 20;
            }
            elseif ($fields[0] == self::TYPE_FLOAT || $fields[0] == floatEx)
            {
                $type = self::TYPE_FLOAT;
                $this->__dbType = "float";
            }

            elseif ($fields[0] == self::TYPE_DATETIME || $fields[0] == "DateTimeEx")
            {
                $type = self::TYPE_DATETIME;
                $this->__dbType = "DateTime";
            }
            elseif ($fields[0] == self::TYPE_ENUM)
            {
                $type = self::TYPE_ENUM;
                
                $this->__enumerators = \Arr();
                
                foreach ($fields as $_field)
                    if ($_field != $fields[0])
                        $this->__enumerators[] = $_field;

                $this->__dbType = "enum";
            }
            elseif (stringEx($fields[0])->startsWith("bigint"))
            {
                $type = self::TYPE_INT;
                $this->__dbType = "bigint";
                $length = stringEx($fields[0])->remove("bigint(", false)->remove(")", false)->toInt();
                if ($length <= 0) $length = 20;
                $this->__dbLength  = $length;
                $this->__dbDefined = true;
            }
            elseif (stringEx($fields[0])->startsWith("varchar"))
            {
                $type = self::TYPE_STRING;
                $this->__dbType = "varchar";
                $length = stringEx($fields[0])->remove("varchar(", false)->remove(")", false)->toInt();
                if ($length <= 0) $length = 256;
                $this->__dbLength  = $length;
                $this->__dbDefined = true;
            }
            elseif (stringEx($fields[0])->startsWith("longblob"))
            {
                $type = self::TYPE_STRING;
                $this->__dbType = "longblob";
                $this->__dbDefined = true;
            }
            elseif (stringEx($fields[0])->startsWith("longtext"))
            {
                $type = self::TYPE_STRING;
                $this->__dbType = "longtext";
                $this->__dbDefined = true;
            }
            elseif ($fields[0] == self::TYPE_JSON || $fields[0] == "json") {
                $type = self::TYPE_JSON;
                $this->__dbType = "longtext";
                $this->__dbDefined = true;
            }
            else
            {
                $type = self::TYPE_STRING;
                $this->__dbType = "varchar";
                $this->__dbLength = 256;
            }

            if ($type != null)
                $this->__type = $type;
                
            if ($this->type != self::TYPE_ENUM)
            {
                if ($fields->contains(isPrimary))
                    $this->__isPrimary = true;
                if ($fields->contains(isNullable))
                    $this->__isNullable = true;
                if ($fields->contains(isEnumerated) && $this->type != self::TYPE_BOOL)
                    $this->__isEnumerated = true;
                if ($fields->contains(autoIncrement) && $this->isPrimary == true)
                    $this->__autoIncrement = true; 
            }
        }
        
        public function __call($key, $_)
        { return $this->returnValues($key); }
        
        public function __get($key)
        { return $this->returnValues($key); }
        
        protected function returnValues($key)
        {
            if ($key == type)
                return $this->__type;
            elseif ($key == isPrimary)
                return $this->__isPrimary;
            elseif ($key == autoIncrement)
                return $this->__autoIncrement;
            elseif ($key == isNullable)
                return $this->__isNullable;
            elseif ($key == isEnumerated)
                return $this->__isEnumerated;
            elseif ($key == enumerators)
                return $this->__enumerators;
            elseif ($key == dbType)
                return $this->__dbType;
            elseif ($key == dbLength)
                return $this->__dbLength;
            elseif ($key == dbDefined)
                return $this->__dbDefined;
        }
        
        public function __set($k, $_) {}
        
        public function isValidEnum($value, $caseSensitive = false)
        {
            if ($this->type != self::TYPE_ENUM || $this->__enumerators->count <= 0)
                return false;
                
            if ($caseSensitive == false)
                return $this->__enumerators->contains($value);
            
            return $this->formatEnum($value) == $value;
        }
        
        public function formatEnum($value)
        {
            if ($this->type != self::TYPE_ENUM)
                return null;
                
            $valueFormated = null;

            foreach ($this->__enumerators as $enumerator)
                if (stringEx($enumerator)->toLower() == stringEx($value)->toLower())
                { $valueFormated = "" . $enumerator; break; }

            if ($valueFormated == null && $this->__enumerators->count > 0)
                $valueFormated = "" . $this->__enumerators[0];

            return $valueFormated;
        }
        
        public function getDefaultEnum()
        {
            if ($this->type != self::TYPE_ENUM || $this->__enumerators->count <= 0)
                return null;
                
            return $this->__enumerators[0];
        }
        
        public function format($value, $debug = false)
        {
            if ($this->type == self::TYPE_BOOL)
                return boolEx(($this->isNullable && ($value === null || $value === "null")) ? null : (($value === true || $value === "true") ? "true" : "false"))->toBool();

            if ($this->isNullable && $value === null)
                return null;

            if ($this->type == self::TYPE_DATETIME && \Variable::get($value)->isDateTimeEx() && $value->isValid() == false)
                return null;

            if ($this->type === self::TYPE_JSON) {
                if ($this->isNullable && ($value === null || $value === 'null' || $value === ''))
                    return null;
                $_variable = \Variable::get($value);
                if ($_variable->isArray() || $_variable->isArr() || $_variable->isObject())
                    return Arr($value);
                if ($_variable->isString()) {
                    $json = \JSON::parse($value);
                    if ($this->isNullable && $json === null)
                        return null;
                    return Arr($json);
                }
                if ($_variable->isScalar()) {
                    if ($this->isNullable)
                        return null;
                    return Arr();
                }
                if ($this->isNullable)
                    return null;
                return Arr();
            }
            elseif ($this->type == self::TYPE_ENUM)
            {
                if ($this->isValidEnum($value))
                    return $this->formatEnum($value);
                elseif ($this->isNullable)
                    return null;
                else return $this->getDefaultEnum();
            }
            else
            {
                $type = \Variable::getPreferredTypeByType($this->type);
                return \Variable::get($value)->convert($type);
            }  
        }
    }
}
