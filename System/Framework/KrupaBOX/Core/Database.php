<?php

namespace {

    const isPrimary = 'isPrimary';
    const autoIncrement = 'autoIncrement';
    const isNullable = 'isNullable';
    const isEnumerated = 'isEnumerated';
    const cantUpdate = 'cantUpdate';
    const longblob = 'longblob';
    const longtext = 'longtext';

class Database
{
    const ORDER_ASC     = "asc";
    const ORDER_DESC    = "desc";
    const ORDER_RANDOM  = "random";
    
    protected static $models = [];
   
    public static function getInstance()
    {
        $class = \ClassEx::getCaller();

        if (count($class) > 0)
        {
            if (isset($models[$class]) && $models[$class] != null)
                return $models[$class];
         
            $models[$class] = new __DatabaseCaller($class);
            return $models[$class];
        }
      
        return new __DatabaseCaller();
    }
   
    public static function getChangeLogs()
    { return __DatabaseChangeLog::getChangeLogsTable(); }

    protected static $__CI = null;
    protected static function __initialize()
    {
        self::$__CI = \CodeIgniter::getInstance();
        \KrupaBOX\Internal\Loader::loadLinkDB();
        self::$__CI->load->dbutil();
        self::$__CI->load->dbforge();
    }

    public static function getConfig()
    {
        $config = \Config::get();
        return $config->database;
    }

    public static function getAll()
    {
        self::__initialize();
        $databases = Arr(self::$__CI->dbutil->list_databases());
        return $databases;
    }

    public static function add($database)
    {
        $database = toString($database);
        if (stringEx($database)->isEmpty()) return null;
        if (self::getAll()->contains($database) == false)
            return self::$__CI->dbforge->create_database($database);
        return false;
    }

    public static function query($query)
    {
        self::__initialize();
        $query = toString($query);
        $data = self::$__CI->db->query($query);
        if ($data === null || $data === true || $data === false)
            return $data;

        $rows = Arr();
        foreach ($data->result() as $row)
            $rows->add(Arr($row));
        return $rows;
    }

    public static function escape($var)
    {
        self::__initialize();
        $var = toString($var);
        return self::$__CI->db->escape($var);
    }
}

class __DatabaseCaller
{
   protected $class = null;
   protected $CI = null;
   protected $structure = null;
   protected $table = null;
   
   protected $queryChangeLog = [];
   protected $hasUpdateValue = false;   
       
   protected function getCI()
   {
        if ($this->CI == null)
            $this->CI = \CodeIgniter::getInstance();

        return $this->CI;      
   }
   
    public function __construct($class = null)
    {
        if ($class != null)
            $this->class = $class;
         
        $CI = $this->getCI();
        //\KrupaBOX\Internal\Loader::$database;
        //$CI->load->database();

        if ($this->class != null)
        {
            $class = $this->class;

            if (isset($class::$model))
            {
                if (isset($class::$model["structure"]))
                {
                    $this->structure = $class::$model["structure"];
                
                    foreach ($this->structure as $key => &$value)
                        if (!\Variable::get($value)->isArray())
                        $value = [$value];
                }
                
                if (isset($class::$model["table"]))
                    $this->table = stringEx($class::$model["table"])->toString();
            }
        }
   }
   
   private function __parseArray(array $array = null)
   {
      if ($this->structure != null)
         foreach ($array as $key => &$value)
            if ($value !== null && isset($this->structure[$key]))
            {
               $type = $this->structure[$key][0];
               $param = null;
               
               if (isset($this->structure[$key][1]))
                  $param = $this->structure[$key][1];
    
               if ($type == float)
                  $value = floatEx($value)->toFloat();
               elseif ($type == int)
                  $value = intEx($value)->toInt();
               elseif ($type == string)
               {
                  if ($param == encode)
                     $value = stringEx($value)->encode(true);
               }
               elseif ($type == bool)
               {
                  if ($param == enum)
                  {
                     if ($value !== null)
                        $value = ($value == true)
                           ? "true"
                           : "false";
                  }
                  else $value = boolEx($value)->toBool();
               }
               elseif ($type == enum)
               {
                    $enum = arrayk($this->structure[$key])->remove("enum");

                    if (count($enum) <= 0)
                        $array = arrayk($array)->removeKey($key);
                        
                    if (!arrayk($this->structure[$key])->contains($value))
                        $array = arrayk($array)->removeKey($key);
               }
               elseif ($type == "object")
               {
                    $typeClass = \Variable::get($value);
                    
                    if ($typeClass->isDateTime())
                        $value = new \DateTimeEx($value);
                    if (DateTimeEx::isDateTimeEx($value))
                        $value = $value->format(DateTimeEx::FORMAT_ISO8601);
                    else $value = stringEx($value)->toString(); 
               }
            }
            
      return $array;
   }
   
    public function reset()
    { $this->getCI()->db->reset(); }
   
    public function getFields($table = null)
    {
        if ($table == null)
            $table = $this->table;

        $fields = $this->getCI()->db->field_data($table);
        
        foreach ($fields as &$field)
            if (isset($field->primary_key))
            {
                $field->primaryKey = boolEx($field->primary_key)->toBool();
                unset($field->primary_key);
            }

        return $fields;
    }
    
   public function select(array $array = null)
   {
      $isSelectAll = false;
      
      if ($array == null || !\Variable::get($array)->isArray() || count($array) <= 0)
         $isSelectAll = true;

      $this->getCI()->db->select(($isSelectAll == true)
         ? "*"
         : $array);
         
      return $this;
   }
   
    public function where(array $array = null)
    {
        if ($array == null || !\Variable::get($array)->isArray() || count($array) <= 0)
            return $this;
      
        $array = $this->__parseArray($array);
        $this->getCI()->db->where($array);
      
        $this->queryChangeLog[] = ["where" => $array];
        return $this;
    }
    
    public function having(array $array = null)
    {
        if ($array == null || !\Variable::get($array)->isArray() || count($array) <= 0)
            return $this;
            
        $array = $this->__parseArray($array);
        
        foreach ($array as $key => $value)
            $this->getCI()->db->having($key, $value);
            
        $this->queryChangeLog[] = ["having" => $array];
        return $this;
    }

    public function orWhere(array $array = null)
    {
        if ($array == null || !\Variable::get($array)->isArray() || count($array) <= 0)
         return $this;
      
        $array = $this->__parseArray($array);
        $this->getCI()->db->or_where($array);
      
        $this->queryChangeLog[] = ["orWhere" => $array];
        return $this;
    }
   
    public function like(array $array = null)
    {
        if ($array == null || !\Variable::get($array)->isArray() || count($array) <= 0)
            return $this;
      
        $array = $this->__parseArray($array);
        $this->getCI()->db->like($array);
      
        $this->queryChangeLog[] = ["like" => $array];
        return $this;
    }
    
    public function orLike(array $array = null)
    {
        if ($array == null || !\Variable::get($array)->isArray() || count($array) <= 0)
            return $this;
      
        $array = $this->__parseArray($array);
        $this->getCI()->db->or_like($array);
      
        $this->queryChangeLog[] = ["orLike" => $array];
        return $this;
    }
   
    public function set(array $array = null)
    {
        if ($array == null || !\Variable::get($array)->isArray() || count($array) <= 0)
            return $this;

        $array = $this->__parseArray($array);
        $this->getCI()->db->set($array);
        $this->hasUpdateValue = true;   
          
        $this->queryChangeLog[] = ["set" => $array]; 
        return $this;  
    }    
   
    public function limit($limit = null, $offset = null)
    {
        if ($limit == null)
            return $this;
         
        if ($offset == null)
            $this->getCI()->db->limit(intEx($limit)->toInt());
        else $this->getCI()->db->limit(intEx($limit)->toInt(), intEx($offset)->toInt());

        $this->queryChangeLog[] = ["limit" => (["limit" => $limit, "offset" => $offset])]; 
        return $this;
    }
    
    public function order(array $array)
    {
        foreach ($array as $field => $orderType)
            $this->getCI()->db->order_by($field, $orderType);
            
        $this->queryChangeLog[] = ["order" => $array]; 
        return $this;
    }
   
    public function get($table = null)
    {
        $query = new __DatabaseQuery($this->getCI()->db, $this->class);
        $this->queryChangeLog = [];
        return $query->get($table); 
    }
   
    public function insert($table = null)
    {
        $query = new __DatabaseQuery($this->getCI()->db, $this->class);
        $insert = $query->insert($table);
        
        $this->__saveQuery("insert", $table, $this->getInsertId());
        return $insert;
    }
   
    public function update($table = null)
    {
        $query = new __DatabaseQuery($this->getCI()->db, $this->class);
        $this->__saveQuery("update", $table);
                
        if ($this->hasUpdateValue == false)
            return $query; // cant update with empty array
            
        return $query->update($table); 
    }
    
    public function getCount($table = null)
    {
        $query = new __DatabaseQuery($this->getCI()->db, $this->class);
        $this->queryChangeLog = [];
        return $query->getCount($table); 
    }
   
    public function getInsertId()
    { return $this->getCI()->db->insert_id(); }
    
    public function getLastQuery($dump = false)
    {
        $lastQuery = $this->getCI()->db->last_query();
        
            if ($dump == true)
                dump($lastQuery);
                    
        return $lastQuery;
    }
    
    protected function __saveQuery($type, $table = null, $insertId = null)
    {
        $type = stringEx($type)->toString();
        
        if ($table == null)
            $table = $this->table;
        
        if ($type == "insert" || $type == "update")
        {
            if ($insertId != null && $type == "insert")
                $this->queryChangeLog[] = ["insertId" => intEx($insertId)->toInt()]; 
            
            __DatabaseChangeLog::__log($this->table, $type, $this->queryChangeLog);
        }
        
        $this->queryChangeLog = [];
    }
}

class __DatabaseChangeLog
{
    protected static $queryChangeLogs = [];
    
    public static function __log($table, $type, array $queryTable)
    {
        if ($table == null)
            return;
            
        $table = stringEx($table)->toString();
        $type = stringEx($type)->toString();
        
        if ($type != "insert" && $type != "update")
            return;
         
        $queryTable[] = ["method" => $type];
        $queryTableFull = ["table" => $table, "actions" => $queryTable];

        self::$queryChangeLogs[] = $queryTableFull;
    }
    
    public static function getChangeLogsTable()
    { return self::$queryChangeLogs; }
}

class __DatabaseQuery
{
    protected $db     = null;
    protected $class  = null;
    protected $query  = null;
    protected $table  = null;
   
   public function __construct($db, $class = null)
   {
      $this->db = $db;
      $this->class = $class;
      
      if ($this->class != null)
      {
         $class = $this->class;

         if (isset($class::$model) && isset($class::$model["table"]))
            $this->table = stringEx($class::$model["table"])->toString();
      }
   }
   
   public function get($table = null)
   {
      if ($table == null)
         $table = $this->table;
         
      if ($table == null)
         return $this;
         
      $this->query = $this->db->get($table);
      return $this;
   }
   
   public function insert($table = null)
   {
      if ($table == null)
         $table = $this->table;
         
      if ($table == null)
         return $this;
         
      $this->query = $this->db->insert($table);
      return $this;
   }
   
   public function update($table = null)
   {
      if ($table == null)
         $table = $this->table;
         
      if ($table == null)
         return $this;

      $this->query = $this->db->update($table);
      return $this;
   }
   
   public function getCount($table = null)
   {
      if ($table == null)
         $table = $this->table;
         
      if ($table == null)
         return null;
         
      $this->db->from($table);
      return $this->db->count_all_results();
   }
   
   public function getResult()
   {
      $result = $this->query->result();
      
      if (count($result) <= 0)
         return null;
         
      $structure = null;
      
      if ($this->class != null)
      {
         $class = $this->class;
         $table = null;
         
         if (isset($class::$model) && isset($class::$model["table"]))
            $structure = $class::$model["structure"];
      }
      
      foreach($structure as $key => &$value)
         if (!\Variable::get($value)->isArray())
            $value = [$value];
      
      foreach ($result as &$data)
         foreach ($data as $key => &$value)
            if ($value != null && isset($structure[$key]))
            {
               $type = $structure[$key][0];
               
               if ($type == string)
               {
                  if (isset($structure[$key][1]))
                  {
                     if ($structure[$key][1] == encode)
                        $value = stringEx($value)->decode(true);
                  }
               }
               elseif ($type == int)
                  $value = intEx($value)->toInt();
               elseif ($type == float)
                  $value = floatEx($value)->toFloat();
               elseif ($type == bool)
                  $value = boolEx($value)->toBool();
               elseif ($type == DateTime || $type == DateTimeEx)
                  $value = new DateTimeEx($value, (null)//(Krupa::$timeZone != null)
                                                    ? new DateTimeZone(Krupa::$timeZone)
                                                    : null
                  );
            }
      
      return $result;
   }
}

}
