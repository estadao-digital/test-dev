<?php
/**
 * Db Class.
 *
 * PHP version 5.6
 *
 * @category Db
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace FastApi\Db;

use FastApi\Db\DbConnector;
/**
 * Db Class.
 *
 * PHP version 5.6
 *
 * @category Db
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
class Db extends DbConnector
{
    
    protected $connection;
    protected $primaryKey;
    protected $table;
    private $_sql = '';
    private $_arrayBind = array();
    public $dbResult        = null;
    
    /**
     * Save in database table
     *
     * @return self::_updateStatement() || self::_insertStatement()
     */
    public function save()
    {
        $primaryKey = $this->primaryKey;

        if ($this->$primaryKey > 0) {
            return $this->_updateStatement($this->$primaryKey);
        }
        return $this->_insertStatement($this->$primaryKey);
    }
    /**
     * Update register in database table
     * 
     * @param Array $fields fields to update
     * 
     * @return self::_updateStatement()
     */
    public function update(...$fields)
    {
        if ($this->_sql == "" || !strstr($this->_sql,"SELECT")) {
            throw new \Exception("There is no selecion to update");
        }
        if (count($fields) == 0) {
            throw new \Exception("There is no fields to update");
        }
        $arraySet = array();
        foreach($fields as $value) {
            if (!is_array($value)) {
                $fieldBind = $fields[0];
                if (strpos($fieldBind, ".")) {
                    $explodefield = explode(".", $fieldBind);
                    $fieldBind = $explodefield[1];
                }
                $this->_arrayBind[':'.$fieldBind]    = $fields[1];
                if(!isset($arraySet[$field[0]])) {
                    $arraySet[$field[0]] = $field[0].' = :'.$fields[0];
                    continue;
                }
            }
            foreach($value as $valueSet) {
                $fieldBind = $value[0];
                if (strpos($fieldBind, ".")) {
                    $explodefield = explode(".", $fieldBind);
                    $fieldBind = $explodefield[1];
                }
                $this->_arrayBind[':'.$fieldBind]    = $value[1];
                if(!isset($arraySet[$value[0]])) {
                    $arraySet[$value[0]] = $value[0].' = :'.$value[0];
                    continue;
                }
            }
        }
        
        $this->_sql.= ' SET '.implode(',',$arraySet);
        $pos = strpos($this->_sql,"FROM ");
        $getSet = strpos($this->_sql, "SET");
        $getWhere = strpos($this->_sql, "WHERE");
        $substrWhere = substr($this->_sql, $getWhere, ($getSet-$getWhere));
        $this->_sql = substr_replace($this->_sql," ", $getWhere, ($getSet-$getWhere));
        $this->_sql = substr_replace($this->_sql,"UPDATE ",0,$pos+4);
        $this->_sql .= ' '.$substrWhere;
        
        return $this->_updateStatement();
    }
    /**
     * Execute the delete in database table
     *
     * @param int $id The Register id to delete
     * 
     * @return $this->_deleteStatement()
     */
    public function delete($id = 0)
    {
        if ($id > 0) {
            $primaryKey = $this->primaryKey;
            $this->$primaryKey = $id;
            return $this->_deleteStatement();
        }
        if ($this->_sql == "" || !strstr($this->_sql,"SELECT")) {
            throw new \Exception("There is no selecion to delete");
        }
        
        $pos = strpos($this->_sql,"FROM ");
        
        $this->_sql = substr_replace($this->_sql,"DELETE FROM ",0,$pos+4);
        
        return $this->_deleteStatement();
    }
    /**
     * Execute the delete in database table
     *
     * @return PDO::execute()
     */
    private function _deleteStatement()
    {
        $primaryKey = $this->primaryKey;
        
        $sql = "DELETE FROM ".$this->table." WHERE ".$this->primaryKey." = :".$this->primaryKey;
        
        $_arrayBind[':'.$this->primaryKey.''] = $this->$primaryKey;
        
        if( trim($this->_sql) != "" ) {
            unset($_arrayBind[':'.$this->primaryKey.'']);
            $result_set = $this->connection->prepare($this->_sql);
            foreach($this->_arrayBind as $key => $val) {
                $result_set->bindValue($key, $val, $this->_varType($val));
            }
            if (!$result_set->execute()) {
                $error = $result_set->errorInfo();
                throw new \Exception($error[2]);
            }
            return true;
        }
        $result_set = $this->connection->prepare($sql);
        
        $this->$primaryKey     = 0;
        
        return $result_set->execute($_arrayBind);
    }
    private function _varType($var) {
        switch(gettype($var)) {
            case 'boolean':
                return \PDO::PARAM_BOOL;
            break;
            case 'integer':
                return \PDO::PARAM_INT;
            break;
            case 'string':
                return \PDO::PARAM_STR;
            break;
            default:
                return \PDO::PARAM_STR;
            break;
        }
    }
    /**
     * Execute the update in database table
     *
     * @param Mixed $key Key to bind
     * 
     * @return PDO::execute()
     */
    private function _updateStatement($key = NULL)
    {
        $sql         = "UPDATE ".$this->table." set ";

        $_arrayBind    = array();
        
        foreach ($this->fields as $field=>$value) {
            if (trim($value) != '') {
                $sql.=$field."= :$field,";
                $_arrayBind[':'.$field.''] = $value;
            }
        }
        
        $sql = rtrim($sql, ',').' WHERE '.$this->primaryKey.' = :'.$this->primaryKey.'';
        
        $_arrayBind[':'.$this->primaryKey.''] = $key;

        if ($key === NULL) {
            unset($_arrayBind[':'.$this->primaryKey.'']);
            $result_set = $this->connection->prepare($this->_sql);
            if (!$result_set->execute($this->_arrayBind)) {
                $error = $result_set->errorInfo();
                throw new \Exception($error[2]);
            }
            return true;
        }
        $result_set = $this->connection->prepare($sql);
        if (!$result_set->execute($_arrayBind)) {
            $error = $result_set->errorInfo();
            throw new \Exception($error[2]);
        }
        return true;
    }
    /**
     * Execute the insert in database table
     *
     * @return PDO::execute()
     */
    private function _insertStatement()
    {
        unset($this->fields[$this->primaryKey]);

        $sql     = "INSERT INTO ".$this->table;
        $fields    = array_flip($this->fields);
        $columnInsert        = "";
        $columnInsertVal    = "";
        foreach ($this->fields as $field=>$value) {
            if (trim($value) != '') {
                $columnInsert.=$field.",";
                $columnInsertVal.=":$field,";
                $_arrayBind[':'.$field.''] = $value;
            }
        }
        $sql .="(".rtrim($columnInsert, ",").") VALUES (".rtrim($columnInsertVal, ',') .')';
        $result_set = $this->connection->prepare($sql);
        if (!$result_set->execute($_arrayBind)) {
            $error = $result_set->errorInfo();
            throw new \Exception($error[2]);
        }
    }
    /**
     * Generates the SELECT string
     *
     * @param Array $arrayFields The select's fields
     * 
     * @return $this
     */
    public function select($arrayFields = array())
    {
        $this->_sql = "SELECT * FROM ".$this->table;

        if (count($arrayFields) != 0) {
            $this->_sql = "SELECT ".implode(",", $arrayFields)." FROM ".$this->table;
        }
        return $this;
    }
    /**
     * Generates the Limit of select
     * 
     * @param Int $limit  The selection limit
     * @param Int $offset The selection limit offset
     * 
     * @return Object $this
     */
    function selectLimit($limit = 0, $offset = 0)
    {
        $limit         = (int)$limit;
        $offset     = (int)$offset;
        if ($limit > 0) {
            $this->_arrayBind[':limit'] = $limit;
            $this->_arrayBind[':offset'] = $offset;
            $this->_sql.= ' LIMIT :limit';
            $this->_sql.= ' OFFSET :offset';
        }
        return $this;
    }
    /**
     * Generates the Where clause
     * 
     * @param String $field  The clause field
     * @param String $clause The clause
     * @param String $value  The clause value
     * 
     * @return Object $this
     */
    public function where($field = '',$clause = '', $value = '')
    {
        if (is_callable($value)) {
            $value = $value();
            if (!$value) {
                return $this;
            }
        }
        $fieldBind = $field;
        if (strpos($fieldBind, ".")) {
            $explodefield = explode(".", $fieldBind);
            $fieldBind = $explodefield[1];
        }
        $count = 1;
        $this->_arrayBind[':'.$fieldBind.$count]    = $value;
        $strSql = '';
        if (!stristr($this->_sql, ' WHERE ')) {
            $strSql = ' WHERE '.$field.' '.$clause.' :'.$fieldBind.$count;
            if ($clause == 'in') {
                unset($this->_arrayBind[':'.$fieldBind]);
                $valuesToBind =  explode(",", $value);
                $stringBind = "";
                foreach ($valuesToBind as $value) {
                    $stringBind.=':'.$fieldBind.$count.',';
                    $this->_arrayBind[':'.$fieldBind.$count] = $value;
                    $count++;
                }
                $stringBind = rtrim($stringBind, ',');
                $strSql = ' WHERE '.$field.' '.$clause.' ('.$stringBind.')';
            }
            $this->_sql.= $strSql;
            return $this;
        }
        $strSql = ' AND '.$field.' '.$clause.' :'.$field.$count;
        if ($clause == 'in') {
            unset($this->_arrayBind[':'.$field.$count]);
            $valuesToBind =  explode(",", $value);
            $stringBind = "";
            $count = 1;
            foreach ($valuesToBind as $value) {
                $stringBind.=':'.$field.$count.',';
                $this->_arrayBind[':'.$field.$count] = $value;
                $count++;
            }
            $stringBind = rtrim($stringBind, ',');
            $strSql = ' AND '.$field.' '.$clause.' ('.$stringBind.')';
        }
        $this->_sql.= $strSql;
        return $this;
    }
    /**
     * Generates the Or clause
     * 
     * @param String $field  The clause field
     * @param String $clause The clause
     * @param String $value  The clause value
     * 
     * @return Object $this
     */
    public function orWhere($field = '',$clause = '', $value = '')
    {
        if (is_callable($value)) {
            $value = $value();
            if (!$value) {
                return $this;
            }
        }
        $fieldBind = $field;
        if (strpos($fieldBind, ".")) {
            $explodefield = explode(".", $fieldBind);
            $fieldBind = $explodefield[1];
        }
        $count             = 1;
        $strSql = ' OR '.$field.' '.$clause.' :'.$fieldBind.$count;
        $this->_arrayBind[':'.$fieldBind.$count]    = $value;
        if ($clause == 'in') {
            unset($this->_arrayBind[':'.$fieldBind]);
            $valuesToBind     =  explode(",", $value);
            $stringBind     = "";
            foreach ($valuesToBind as $value) {
                $stringBind.=':'.$fieldBind.$count.',';
                $this->_arrayBind[':'.$fieldBind.$count] = $value;
                $count++;
            }
            $stringBind = rtrim($stringBind, ',');
            $strSql = ' OR '.$field.' '.$clause.' ('.$stringBind.')';
        }
        $this->_sql.= $strSql;
        return $this;
    }
    /**
     * Generates the Order By string
     * 
     * @param String $field Field to order
     * @param String $type  The order type
     * 
     * @return Object $this
     */
    public function orderBy($field,$type = 'ASC')
    {
        $this->_sql.= ' ORDER BY '.$field.' '.$type;
        return $this;
    }
    /**
     * Generates the Group By string
     * 
     * @param Array ...$fields Fields to group
     * 
     * @return Object $this
     */
    public function groupBy(...$fields)
    {
        if (count($fields) == 0) {
            return $this;
        }
        $this->_sql.= ' GROUP BY '.implode(",", $fields);
        return $this;
    }
    /**
     * Generate the Join string
     * 
     * @param String $type Join Type
     * @param String $tableA First table
     * @param String $tableB Second table
     * @param String $relationObjectB Relation table
     * @param String $relationObjectA Relation table
     * 
     * @return Object $this
     */
    public function join($type = 'INNER',$tableA,  $relationObjectB = '', $relationObjectA = '')
	{
		$type = strtoupper($type);
		if($type != 'INNER' && $type != 'LEFT' && $type != 'RIGHT' && $type != 'OUTER')
		{
			$type = '';
		}
		$tableB = $this->table;
		if(trim($relationObjectB) == '')
		{
			$relationObjectB = $this->primaryKey;
		} 

		if(trim($relationObjectA) == '')
		{
			$relationObjectA = $this->primaryKey;
		} 
		$this->sql.= " ".$type. ' JOIN '. $tableA. ' ON '.$tableB.'.'.$relationObjectB.' = '.$tableA.'.'.$relationObjectA;
		
		return $this;
	}
    /**
     * Executes the select statement
     * 
     * @return Object $this->dbResult
     */
    public function get()
    {
        $resultSet                                  = $this->connection->prepare($this->_sql);
        foreach($this->_arrayBind as $key => $val) {
            $resultSet->bindValue($key, $val, $this->_varType($val));
        }
        $resultSet->execute();
        $tableCollection                            = $this->table."Collection";
        $this->dbResult                            = new \Stdclass;
        $this->dbResult->$tableCollection          = new \Stdclass;
        $this->dbResult->$tableCollection->results = $resultSet->fetchAll(\PDO::FETCH_CLASS);
        $this->dbResult->rows                      = $resultSet->rowCount();
        $resultSet->closeCursor();
        return $this->dbResult;
    }
    /**
     * Provides the result collection
     * 
     * @param Int $id The register id
     * 
     * @return Object $select->$tableCollection->results
     */
    public function findById($id = 0)
    {
        $id                         = (int)$id;
        $tableCollection            = $this->table."Collection";
        $select                     = $this->select()->where($this->primaryKey, '=', $id)->get();
        $primaryKey                 = $this->primaryKey;
        $this->$primaryKey          = $select->$tableCollection->results[0]->$primaryKey;
        return $select->$tableCollection->results[0];
    }
    /**
     * Provides the paginator
     * 
     * @param Int $perPage Number of records per page
     * @param Int $page The page to show
     * 
     * @return Object $select->$tableCollection->results
     */
    public function paginate($perPage = 5, $page = 1) {
        $strPosFrom = strpos($this->_sql,'FROM');
        $sqlCount = "SELECT COUNT(*) as COUNT FROM " . substr($this->_sql, $strPosFrom + 4, strlen($this->_sql));
        $resultSet = $this->connection->prepare($sqlCount);
        foreach($this->_arrayBind as $key => $val) {
            $resultSet->bindValue($key, $val, $this->_varType($val));
        }
        $resultSet->execute();
        $count = ($resultSet->fetchAll(\PDO::FETCH_CLASS));
        $count = $count[0]->COUNT;
        $totalPages = ceil($count/$perPage);
        if($page > $totalPages) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * $perPage;
        $this->selectLimit($perPage, $offset);
        $results = $this->get();
        $results->page = $page;
        $results->totalPages = $totalPages;
        return $results;
    }
}
