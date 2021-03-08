<?php


namespace
{
    class Model extends \ArrayObject
    {
        use \KrupaBOX\Internal\Traits\Arr\Convert;
        use \BaseClass\Import;

        //use \KrupaBOX\Internal\Traits\ClassEx\CallStatic;
        //use \KrupaBOX\Internal\Traits\ClassEx\ParametersStatic;
        //use function Model\enum as enum;
        const ORDER_ASC  = "asc";
        const ORDER_DESC = "desc";

        private static $__databaseBox = null;

        protected static function table()       { return null; }
        protected static function structure()   { return Arr(); }

        protected static function __migration__()
        {
            \KrupaBOX\Internal\Loader::loadLinkDB();
            $config = \Config::get();
            if ($config->database->migration == true)
                self::__verifyMigration(static::structure());
        }

        private static function __verifyMigration($structure)
        {
            \KrupaBOX\Internal\Loader::loadLinkDB();

            $tableHashCache = null;
            $config = \Config::get();
            if ($config->database->cache->redis === true) {
                $key = (".krupabox." . ROOT_HASH . ".database." . $structure->table . ".structure.blob");
                $tableHashCache = \KrupaBOX\Internal\Kernel::getRedis()->get($key);
            }
            else {
                $path = ("cache://.krupabox/database/" . $structure->table . "/.structure.blob");
                $tableHashCache = toString(\File::getContents($path));
            }

            $tableHash = (\Security\Hash::toSha1($structure->fields) . \KrupaBOX\Internal\Loader::$currentDbHash);

            if ($tableHashCache != $tableHash)
            {
                $tables = \Database\Table::getAll();
                $tableExists = true;
                if ($tables->contains($structure->table) == false)
                    $tableExists = \Database\Table::add($structure->table);

                if ($tableExists == true)
                {
                    $fields = $structure->fields;

                    $dbFields = \Database\Table\Field::getAllByTable($structure->table);

                    $lastKey = null;
                    foreach ($fields as $key => $field)
                    {
                        $fieldData = Arr();
                        $fieldData->field = $key;
                        $fieldData->type = $field->dbType;
                        $fieldData->constraint = $field->dbLength;
                        $fieldData->isPrimary = $field->isPrimary;
                        $fieldData->autoIncrement = $field->autoIncrement;
                        $fieldData->isNullable = $field->isNullable;
                        $fieldData->isEnumerated = $field->isEnumerated;
                        $fieldData->enumerators  = $field->enumerators;

                        \Database\Table\Field::addOrUpdate($structure->table, $fieldData, $lastKey, $field->dbDefined);
                        $lastKey = $key;

                        $dbFields->removeKey($key);
                    }

                    // Set nullable on non-used fields
                    foreach ($dbFields as $dbField) {
                        $dbField->isNullable = true;
                        \Database\Table\Field::addOrUpdate($structure->table, $dbField, null, true);
                    }
                }

                \Database\Table\Field::remove($structure->table, "__krupabox__");
                \File::setContents($path, $tableHash);
            }
        }

        //protected $__relashionshipAlias = null;
//        protected $logSQL = null;

        private static function __getCalledDatabaseBox()
        {
            $getCalled = get_called_class();

            if (self::$__databaseBox != null && isset(self::$__databaseBox[$getCalled]))
                return self::$__databaseBox[$getCalled];

            return null;
        }
        public static function joiner()
        {
            $structure = static::structure();
            static::__migration__();
            return $structure;
        }

        public function toArr()
        { return Arr($this); }

        public function offsetSet($field, $value)
        {
//            if ($field == "logSQL")
//            { $this->logSQL = $value; return; }

            $box = self::__getCalledDatabaseBox();

            if ($box->structure->fields->containsKey($field)) {
                $typedValue = $box->structure->fields[$field]->format($value);
                parent::offsetSet($field, $typedValue); return;
            }

            if ($field == "join")
            { parent::offsetSet($field, $value); return; }

            if ($value == null) {
                $relationships = $box->structure->relationships;
                foreach ($relationships as $relationship)
                    if ($relationship->alias == $field)
                        unset($this[$field]);
            }

        }

//        public function addLogSQL($logSql)
//        {
//            if (!stringEx($logSql)->isEmpty()) {
//                if ($this->logSQL == null) $this->logSQL = Arr();
//                $this->logSQL->add(stringEx($logSql)->toString());
//            }
//        }

        public static function notNull($value)
        {
            if ($value === null)
                return Arr();
            return $value->toArr(true);
        }

        public static function cleanMemory()
        {
            \Model\Link::cleanMemory();
        }

        public function offsetGet($index)
        {
//            if ($index == "logSQL")
//                return $this->logSQL;

            $box = self::__getCalledDatabaseBox();

            if ($box->structure->fields->containsKey($index) && parent::offsetExists($index))
                return parent::offsetGet($index);

            $box = self::__getCalledDatabaseBox();
            $relationships = $box->structure->relationships;

            foreach ($relationships as $relationship)
                if ($relationship->alias == $index)
                    return $this->getRelashionshipField($relationship);

            return parent::offsetGet($index);
        }

        protected function getRelashionshipField($relationship)
        {
            if (isset($this[$relationship->alias])) {
                $value = parent::offsetGet($relationship->alias);
                if ($value != null) return $value;
            }

            $instance = $relationship->model;
            $instanceLink = $instance::link();

            if (!$this->containsField($relationship->field))
                return null;

            $result = $instanceLink->selectAll()->whereEquals($relationship->foreignField, $this[$relationship->field]);

            if ($relationship->multiple == false)
                $result = $result->limit(1);
            elseif ($relationship->limit > 0)
                $result = $result->limit($relationship->limit);

            $result = $result->result();

            if ($relationship->multiple == true)
            {
                if ($result != null)
                    parent::offsetSet($relationship->alias, $result);
                return $result;
            }


            $result = (($result != null && $result->count > 0) ? $result[0] : null);
            if ($result != null)
                parent::offsetSet($relationship->alias, $result);

            return $result;
        }

//        public function updateRelashionship()
//        { $this->__relashionshipAlias = Arr(); }

        public function containsField($field)
        {
            $field = stringEx($field)->toString();
            return $this->offsetExists($field);
        }

        public function order($field, $order = self::ORDER_ASC)
        {
            $field = stringEx($field)->toString();
            return $this->order($field, $order);
        }

        public function __construct($object = null)
        {
            parent::__construct([], \ArrayObject::ARRAY_AS_PROPS);

            if ($object == null) return;

            $object = Arr($object);
            foreach ($object as $key => $value) {
                $_key = intEx($key)->toInt();
                if ($_key == 0 && $key !== 0 && $key !== "0")
                    $this[$key] = $value;
            }
        }

        public static function model()
        { return new static(); }

        public static function getMetadata()
        {
            $structure = self::__getCalledDatabaseBox();
            return $structure;
        }

        public function cleanCache($inludeTable = true)
        { \Garbage\Cache\Database::cleanByModel($this); }

        public static function __onConstructStatic()
        {
            if (self::$__databaseBox == null)
                self::$__databaseBox = [];

            $getCalled = get_called_class();
            $structure = static::structure();
            static::__migration__();

            if ($structure == null)
                return;
            $structure->__class__ = $getCalled;

            if ($structure->table == null)
            {
                $tryTable = stringEx($getCalled)->
                toLower(false)->
                replace("\\", "_");

                if (stringEx($tryTable)->startsWith("model_"))
                    $tryTable = stringEx($tryTable)->subString(stringEx("model_")->length, stringEx($tryTable)->length);

                if (!stringEx($tryTable)->isEmpty())
                    $table = $tryTable;

                if ($table == null)
                    throw new Exception("Model table not defined in: " . $getCalled);

                $structure->changeTable($structure->table);
            }

            if ($structure->fields->count <= 0)
                throw new Exception("Structure fields are empty in: " . $getCalled);

            if ($structure->primaryField == null)
                throw new Exception("Missing primary key field in: " . $getCalled);

            $structure->register();

            $box = (object)[];
            $box->structure = $structure;
            $box->instance  = $getCalled;
            $box->link      = new Model\Link($box->structure, $box->instance);

            self::$__databaseBox[$getCalled] = $box;
            //dump("register " . $getCalled);
            //dump( self::$__databaseBox[$getCalled]);
        }

        protected static function startJoin($foreignKey, \Model\Structure $joinStructure)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->startJoin($foreignKey, $joinStructure);
        }

        protected static function endJoin()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->endJoin();
        }

        protected static function startGroup()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->startGroup();
        }

        protected static function orStartGroup()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->orStartGroup();
        }

        protected static function endGroup()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->endGroup();
        }

        protected static function select()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            $array = func_get_args();
            if (count($array) == 1 && \FunctionEx::isFunction($array[0]))
                return $structure->link->selectByFunction($array[0]);
            return $structure->link->selectByArray($array);
        }

        protected static function selectAll()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->selectAll();
        }

        protected static function selectExcept()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            $array = func_get_args(); return $structure->link->selectExceptByArray($array);
        }

        protected static function whereEquals($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, Model\Link::OPERATOR_EQUALS, $value);
        }

        protected static function whereNotEquals($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, Model\Link::OPERATOR_NOT_EQUALS, $value);
        }

        protected static function orWhereEquals($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, Model\Link::OPERATOR_OR_EQUALS, $value);
        }

        protected static function orWhere($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, Model\Link::OPERATOR_OR_EQUALS, $value);
        }

        protected static function orWhereNotEquals($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, Model\Link::OPERATOR_OR_NOT_EQUALS, $value);
        }

        protected static function whereLike($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, Model\Link::OPERATOR_LIKE, $value);
        }

        protected static function whereNotLike($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, Model\Link::OPERATOR_NOT_LIKE, $value);
        }

        protected static function orWhereLike($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, Model\Link::OPERATOR_OR_LIKE, $value);
        }

        protected static function orWhereNotLike($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, Model\Link::OPERATOR_OR_NOT_LIKE, $value);
        }

        protected static function where($field, $operator = Model\Link::OPERATOR_EQUALS, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, $operator, $value);
        }

        protected static function whereBatch($array)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;

            $array = \Arr($array); $lastValid = null;
            foreach ($array as $where)
                if ($where->count >= 3)
                    $lastValid = $structure->link->whereBatchByOperatorFV($where[0], $where[1], $where[2], $where[3], $where[4]);

            return $lastValid;
        }

        protected static function whereQEX($QEX)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByQEX($QEX);
        }

        protected static function whereBigger($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, Model\Link::OPERATOR_BIGGER, $value);
        }

        public static function link()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link;
        }

        protected static function whereSmaller($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->whereByOperatorFV($field, Model\Link::OPERATOR_SMALLER, $value);
        }

        public function limit($limit = 10, $offset = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->limit($limit, $offset);
        }

        public function offset($offset = 0)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->offset($offset);
        }

        protected static function result()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->result();
        }

        protected static function getLink()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link;
        }
        protected static function getCount()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->getCount();
        }

        protected static function insert()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->insert();
        }

        protected static function update()
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->update();
        }

        protected static function set($field, $value = null)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            return $structure->link->set($field, $value);
        }

        protected static function sets($array)
        {
            $structure = self::__getCalledDatabaseBox(); if ($structure == null) return;
            $array = \Arr($array);

            foreach ($array as $field => $value)
                $structure->link->set($field, $value);

            return $structure->link;
        }

        protected function onSave($model)
        { return $model; }

        public function save($insertIfNotFound = false)
        {
            $model = $this->onSave($this);
            if ($model == false || $model == null)
                return;

            $structure = self::__getCalledDatabaseBox();
            $primaryField = null;

            foreach ($structure->structure->fields as $field => $fieldInfo)
                if ($fieldInfo->isPrimary == true)
                { $primaryField = [field => $field, fieldInfo => $fieldInfo]; break; }

            if ($primaryField == null) return;
            $primaryValue = isset($this[($primaryField[field])]) ? $this[($primaryField[field])] : null;

            if ($primaryValue == null || ($primaryField[fieldInfo]->type == int && $primaryValue <= 0) ||
                ($primaryField[fieldInfo]->type == string && stringEx($primaryValue)->isEmpty()))
            {
                foreach ($structure->structure->fields as $field => $fieldInfo)
                    if ($fieldInfo->isPrimary == false)
                        if ($fieldInfo->type != bool)
                            self::set($field, ($fieldInfo->isNullable && (!$this->containsField($field) || $this[$field] == null)) ? null :
                                ((!$this->containsField($field) || $this[$field] == null) ? "" : $this[$field]));
                        else self::set($field, ($this->containsField($field) == false || $this[$field] == null || $this[$field] == false) ? "false" : "true");

                $insertId = self::insert();
                $this[($primaryField[field])] = $insertId;
            }
            else
            {
                if ($insertIfNotFound == true)
                {
                    self::select($primaryField[field]);
                    self::whereEquals($primaryField[field], $primaryValue);
                    self::limit(1);
                    $result = self::result();

                    if ($result == null || $result->count <= 0)
                    {
                        foreach ($structure->structure->fields as $field => $fieldInfo)
                            if ($fieldInfo->type != bool)
                                self::set($field, ($fieldInfo->isNullable && (!$this->containsField($field) || $this[$field] == null)) ? null :
                                    ((!$this->containsField($field) || $this[$field] == null) ? "" : $this[$field]));
                            else self::set($field, ($this->containsField($field) == false || $this[$field] == null || $this[$field] == false) ? "false" : "true");

                        self::insert();
                        return;
                    }
                }

                foreach ($structure->structure->fields as $field => $fieldInfo)
                    if ($fieldInfo->isPrimary == false)
                    {
                        if ($fieldInfo->type != bool)
                            self::set($field, ($fieldInfo->isNullable && (!$this->containsField($field) || $this[$field] == null)) ? null :
                                ((!$this->containsField($field) || $this[$field] == null) ? "" : $this[$field]));
                        else
                        {
                            self::set($field, ($this->containsField($field) == false || $this[$field] == null || $this[$field] == false) ? "false" : "true");
                        }

                    }


                self::whereEquals($primaryField[field], $primaryValue);
                self::update();
            }
        }
    }
}

/*protected static $CI = null;

protected static function getCI()
{
     if (self::$CI == null)
         self::$CI = &get_instance();

     return self::$CI;
}

public static function load($model, $autoConnect = true)
{
   $model = stringEx($model)->toString();

   $CI = self::getCI();
   $CI->load->model($model, $model, $autoConnect);

   return $CI->{$model};
}  */
