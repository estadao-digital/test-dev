<?php

namespace Model
{
    class Structure extends \Arr
    {
        protected static $__registered = null;
        
        protected $__isRegistered = false;
        protected $__table = null;
        protected $__fields = null;
        protected $__primaryField = null;
        protected $__class = null;
        protected $__relationships = null;
        
        public function __construct($tableOrStructure, $structure, $relashionships = null)
        {
            $onlyStructure = false;
            
            if ($structure == null)
            { $structure = $tableOrStructure; $onlyStructure = true; }

            $structure = \Arr($structure);
            
            if ($structure->count <= 0)
                throw new Exception("Missing structure array.");
 
            $this->__fields = \Arr();
            
            foreach ($structure as $key => &$fields)
            {
                if (stringEx($key)->isEmpty() || (stringEx($key)->toString() == "0" && $key == 0))
                    continue;
                
                $Arr = \Variable::get($fields)->isArr();
                
                if ($Arr == false)
                    $fields = \Arr($fields);

                $this->__fields[$key] = new Structure\Field($fields);
            }

            if ($onlyStructure == false)
            {
                $table = stringEx($tableOrStructure)->toString();
                $this->__table = $table;

                if ($table === '')
                    throw new \Exception("Missing @table comment");
            }

            $findPrimary = false;
            foreach ($this->__fields as $key => $field)
                if ($field->isPrimary)
                { $this->__primaryField = ["key" => $key, field => $field]; $findPrimary = true; break; }
            if ($findPrimary == false)
                throw new \Exception("Missing primary field!");

            $orderFields = Arr();
            foreach ($this->__fields as $key => $field)
                if ($key == $this->__primaryField["key"])
                { $orderFields->addKey($key, $field); break; }
            foreach ($this->__fields as $key => $field)
                if ($key != $this->__primaryField["key"])
                { $orderFields->addKey($key, $field); }
            $this->__fields = $orderFields;

            $this->__relationships = Arr();

            if ($onlyStructure == false && $relashionships != null)
            {
                $relashionships = Arr($relashionships);

                foreach ($relashionships as $relashionship)
                {
                    $relashionship = Arr($relashionship);

                    if ($relashionship->containsKey(field) && $relashionship->containsKey(alias) && $relashionship->containsKey(foreignField) && $relashionship->containsKey(model) &&
                        !stringEx($relashionship->field)->isEmpty() && !stringEx($relashionship->alias)->isEmpty() && !stringEx($relashionship->foreignField)->isEmpty() && !stringEx($relashionship->model)->isEmpty())
                    {
                        $isValidField = false;

                        foreach ($this->__fields as $key => $field) {
                            if ($key == $relashionship->field)
                            { $isValidField = true; break; }
                        }

                        if ($isValidField == true)
                        {

                            if ($relashionship->containsKey(multiple))
                                $relashionship->multiple = boolEx($relashionship->multiple)->toBool();
                            elseif ($relashionship->containsKey(isMultiple))
                                $relashionship->multiple = boolEx($relashionship->isMultiple)->toBool();
                            else $relashionship->multiple = true;

                            if ($relashionship->containsKey(limit))
                                $relashionship->limit = intEx($relashionship->limit)->toInt();
                            else $relashionship->limit = 0;

                            $this->__relationships->add($relashionship);
                        }
                    }
                }
            }
        }
        
        public function __get($key)
        {
            if ($key == table)
                return ($this->__table != null) ? ("" . $this->__table) : null;
            elseif ($key == fields)
                return $this->__fields; //   ->copy();
            elseif ($key == primaryField)
                return $this->__primaryField; // copy
            elseif ($key == "__class__")
                return $this->__class;
            elseif ($key == relationships)
                return $this->__relationships; //
        }
        
        public function __set($key, $value)
        {
            if ($key == "__class__")
                $this->__class = $value;
        }
        
        public function changeTable($table)
        {
            if ($this->__isRegistered == true)
                return;
                
            $table = stringEx($table)->toString();
            $this->__table = $table; // TODO: return copy array
        }
        
        public function register()
        {
            if ($this->__isRegistered == true)
                return;
                
            $this->__isRegistered = true;
            
            if (self::$__registered == null)
                self::$__registered = \Arr();
                
            if (self::$__registered->containsKey($this->table))
                throw new \Exception("You cant register two differents structures for same table. Use same model!");
                
            self::$__registered[$this->table] = $this;
        }
        
        public static function getByTable($table)
        {
            if (self::$__registered == null || !self::$__registered->containsKey($table))
                return null;
 
            return self::$__registered[$table];
        }
    }
}
