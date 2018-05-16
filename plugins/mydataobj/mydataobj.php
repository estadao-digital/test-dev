<?php
/*
 * Copyright (C) 2016 vagner
 *
 * This file is part of Kolibri.
 *
 * Kolibri is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kolibri is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kolibri. If not, see <http://www.gnu.org/licenses/>.
 */
require_once (__dir__ . '/mydataobjInterface.php');

class mydataobj implements mydataobjInterface
{

    private $conn;

    private $readonly;

    private $fields = array();

    private $query;

    private $result;

    private $line = 0;

    private $table;

    private $data;

    private $dataArray = array();

    private $keys = array();

    private $debugdata = 0;

    private $fieldsloaded = 0;

    private $conType = 'mysql';

    private $hostOrFilename;

    private $order = array();

    function __call($method, $value)
    {
        foreach ($value as $v) {
            if (isset($v) or count($v)) {
                $out = $v;
            }
        }
        
        if (substr($method, 0, 3) == 'get') {

            $param = substr($method, 3);
            
            return $this->getvalueKey($param);
        }
        
        if (substr($method, 0, 3) == 'set') {
            $key = substr($method, 3);
            
                       
            return $this->setvalue($key, addslashes($out));
        }
    }

    function __constructor()
    {
        $this->reset;
    }

    private function setDataArray($myarray)
    {
        foreach ($myarray as $keyName => $keyValue) {
            $this->setvalue($keyName, $keyValue);
        }
    }

    function settable($table)
    {
        $this->table = $table;
        return $this->table;
    }

    function connect($dbServer = 'mysql', $hostOfFilename, $port, $db, $user, $pass)
    {
        try {
            $this->conn = new PDO("$dbServer:host=" . $hostOfFilename . ';port=;' . $port . 'dbname=' . $db, $user, $pass);
            $this->conType = $dbServer;
        } catch (PDOException $e) {
            debug::log("Database Error: " . $e->getMessage());
        }
        
        return $this->conn;
    }

    function setconType($type)
    {
        $this->conType = $type;
    }

    function setconn($conn)
    {
        $this->conn = $conn;
    }

    function query($sql)
    {
        if (! $conn) {
            $conn = $this->conn;
        }
        if ( $conn ) {
        if ($this->debugdata) {
            debug::log("QUERY: $sql");
        }
        
        $result = $this->conn->prepare($sql);
        $result->execute();
        $this->dataArray = array();
        $this->line = 0;
        
        $this->result = $result;
        return $this->result;
        }
        return false;
    }

    function debug($mode)
    {
        if ($mode) {
            $this->debugdata = 1;
        } else {
            $this->debugdata = 0;
        }
    }

    private function fetch_assoc($result = '')
    {
        if (! $result) {
            $result = $this->result;
        }
        
        if ($result) {
            if ((count($this->dataArray) == 0) and ! $this->line) {
                $r = $result->fetchAll(PDO::FETCH_ASSOC);
                $this->line = 0;
                
                $i = 0;
                foreach ($r as $z => $row) {
                    
                    foreach ($row as $k => $v) {
                        
                        $this->dataArray[$i][$k] = $v;
                    }
                    $i ++;
                }
                if (count($this->dataArray[0])) {
                    return $this->dataArray[0];
                } else {
                    return false;
                }
            } else {
                $this->line ++;
                if (count($this->dataArray[$this->line])) {
                    return $this->dataArray[$this->line];
                } else {
                    return false;
                }
            }
        } else {
            if ($this->debugdata) {
                debug::log("ERROR: impossibile to get fields name from query " . $this->query);
            }
            return false;
        }
    }

    function next($result = '')
    {
        $this->fieldsloaded = 0;
        if ($this->debugdata) {
            debug::log("Next executed");
        }
    }

    private function getvalueKey($key)
    {
        if (! $this->result) {
            
            if ($this->debugdata) {
                debug::log("No result for get$key()");
            }
            
            if (! $this->query) {
                
                if ($this->debugdata) {
                    debug::log("Calling select query");
                }
                
                $this->result = $this->selectquery();
            }
        }
        
        if ($this->fieldsloaded == 0) {
            $this->data = $this->fetch_assoc($this->result);
            
            $this->fieldsloaded = 1;
        }
        if ($this->debugdata) {
            debug::log(print_r($this->data, true));
            debug::log("Get $key value: " . $this->data[$key]);
        }
       
        return $this->data[$key];
     
    }

    private function setvalue($key, $value)
    {
        if ($value === '0') {
            $this->fields[$key] = '0';
        } else {
            $this->fields[$key] = $value;
        }
        
        if ($this->debugdata) {
        	debug::log("SET $key = $value");
        }
        
        return $this->fields[$f];
    }

    function reset()
    {
        $this->result = '';
        $this->keys = '';
        $this->query = '';
        unset($this->fields);
        $this->fields = array();
        $this->readonly = '';
        $this->fieldsloaded = 0;
        unset($this->keys);
        unset($this->fields);
        $this->keys = array();
        $this->fields = array();
        $this->dataArray = array();
        $this->line = 0;
        $this->data = '';
        $this->line = 0;
        
        if ($this->debugdata) {
            debug::log("Reset executed");
        }
    }

    private function fieldList($table) {
    	$lst = array();
    	$db = new mydataobj();
    	$db->setconn($this->conn);
    	if ( $this->conType == 'sqlite') {
    		$db->query("PRAGMA table_info('$table'");
    		while ( $db->getname()) {
    			$lst[] = $db->getname();
    			$db->next();
    		}
    	}
    	if ( $this->conType == 'mysql') {
    		$db->query("show fields from $table");
    		while ( $db->getField()) {
    			$lst[] = $db->getField();
    			$db->next();
    		}
    	}
    	return $lst;
    	
    }
    
    function save()
    {
        if (count($this->keys) > 0) {
            
            $query = $this->updatequery();
            if ($this->debugdata) {
                debug::log("starting  query : " . $query);
            }
            $this->query($query);
        } else {
            $query = $this->insertquery();
            if ($this->debugdata) {
                debug::log("starting query.. : " . $query);
            }
            $this->query($query);
            
            $sql = "SELECT LAST_INSERT_ID() AS lastinsertid ";
            $this->query($sql);
        }
    }

    function addkey($key, $value)
    {
        $this->keys[$key] = $value;
    }

    function delkey($key)
    {
        $aux = '';
        
        foreach (array_keys($this->keys) as $a) {
            
            if ($a != $key) {
                
                $aux[$a] = $this->keys[$a];
            }
        }
        
        $this->keys = '';
        $this->keys = array();
        $this->keys = $aux;
    }

    private function insertquery()
    {
       /* if ($this->conType == 'mysql') {
            if ($this->debugdata) {
                debug::log("mysql selected");
            }
            $sql = "show fields from $this->table";
        }
        
        if ($this->conType == 'sqlite') {
            if ($this->debugdata) {
                debug::log("sqlite selected");
            }
            $sql = "PRAGMA table_info('$this->table')";
        }
        
        if ($this->debugdata) {
            debug::log("running query : " . $sql);
        }
        $result = $this->query($sql);
        
        $sql = '';
        $fieldList = '';
        $v = 0;
        while ($res = $this->fetch_assoc($result)) {
            
            if ($this->conType == 'mysql') {
                $field = $res['Field'];
            }
            if ($this->conType == 'sqlite') {
                $field = $res['name'];
            }
            
            if (! $v) {
                if ($this->fields[$field]) {
                    $sql .= "'" . $this->fields[$field] . "'";
                    $fieldList .= $field;
                    $v ++;
                }
            } else {
                if ($this->fields[$field]) {
                    $sql .= ",'" . $this->fields[$field] . "'";
                    $fieldList .= "," . $field;
                }
            }
        }*/
    	$fields = $this->fieldList($this->table);
    	foreach ( $fields as $f  ) {
    		if ( $this->fields[$f]) { 
    			$v[] = "'" . $this->fields[$f] . "'";
    		}else{
    			$v[] = "null";
    		}
    	}
    	$fieldList = implode(",",$fields);
    	$sql = implode(",",$v);
        $sqlQuery = "insert into $this->table ($fieldList) values ($sql)";
        
        return $sqlQuery;
    }

    private function updatequery()
    {
       // $sql = "show fields from $this->table";
        
        $result = $this->query($sql);
        
        $sql = " update $this->table set ";
        $v = 0;
        
        $fields = $this->fieldList($this->table);
        foreach ( $fields as $f ) {
        	if (array_key_exists($f, $this->fields)) {
        		$rule[] = " $f='" . $this->fields[$f] . "'";
        	}
        }
        $sql .= implode(",",$rule);
       /* while ($res = $this->fetch_assoc($result)) {
            
           
            $field = $res['Field'];
            
            if (! $v) {
                if (array_key_exists($field, $this->fields)) {
                    $sql .= " $field='" . $this->fields[$field] . "'";
                    $v ++;
                }
            } else {
                if (array_key_exists($field, $this->fields)) {
                    $sql .= ", $field='" . $this->fields[$field] . "'";
                }
            }
        }*/
        
        $sql .= " where ";
        
        $aux = '';
        
        $and = 0;
        
        foreach (array_keys($this->keys) as $a) {
            
            if (! $and) {
                if (is_array($this->keys[$a])) {
                    $elements = $this->keys[$a];
                    $str = '';
                    foreach ($elements as $item) {
                        $str .= "'$item',";
                    }
                    $str = substr($str, 0, - 1);
                    $sql .= " $a in (" . $this->keys[$a] . ")";
                } else {
                    $sql .= " $a='" . $this->keys[$a] . "'";
                }
                $and ++;
            } else {
                if (is_array($this->keys[$a])) {
                    $elements = $this->keys[$a];
                    $str = '';
                    foreach ($elements as $item) {
                        $str .= "'$item',";
                    }
                    $str = substr($str, 0, - 1);
                    $sql .= " and $a in (" . $this->keys[$a] . ")";
                } else {
                    $sql .= " and $a='" . $this->keys[$a] . "'";
                }
            }
        }
        
        return $sql;
    }

    private function selectquery()
    {
        $sql = "select * from $this->table";
        
        if (count($this->keys)) {
            
            $sql .= " where ";
            $and = 0;
            
            foreach (array_keys($this->keys) as $a) {
                
                if (! $and) {
                    if (is_array($this->keys[$a])) {
                        $elements = $this->keys[$a];
                        $str = '';
                        foreach ($elements as $item) {
                            $str .= "'$item',";
                        }
                        $str = substr($str, 0, - 1);
                        $sql .= " $a in (" . $this->keys[$a] . ")";
                    } else {
                        $sql .= " $a='" . $this->keys[$a] . "'";
                    }
                    $and ++;
                } else {
                    if (is_array($this->keys[$a])) {
                        $elements = $this->keys[$a];
                        $str = '';
                        foreach ($elements as $item) {
                            $str .= "'$item',";
                        }
                        $str = substr($str, 0, - 1);
                        $sql .= " and $a in (" . $this->keys[$a] . ")";
                    } else {
                        $sql .= " and $a='" . $this->keys[$a] . "'";
                    }
                }
            }
        }
        $and = 0;
        if (count($this->order)) {
            $sql .= " order by ";
            foreach ($this->order as $o) {
                if (! $and) {
                    $sql .= $o;
                    $and ++;
                } else {
                    $sql .= "," . $o;
                }
            }
            $sql .= " asc";
        }
        
        if ($this->debugdata) {
            debug::log("$sql");
        }
        // echo "Debug $sql<br>";
        $this->result = $this->query($sql);
        return $this->result;
    }

    function delete()
    {
        if ($this->table) {
            if (count(array_keys($this->keys)) > 0) {
                $and = 0;
                foreach (array_keys($this->keys) as $a) {
                    
                    if (! $and) {
                        if (is_array($this->keys[$a])) {
                            $elements = $this->keys[$a];
                            $str = '';
                            foreach ($elements as $item) {
                                $str .= "'$item',";
                            }
                            $str = substr($str, 0, - 1);
                            $sql .= "  $a in (" . $this->keys[$a] . ")";
                        } else {
                            $sql .= "  $a='" . $this->keys[$a] . "'";
                        }
                        $and ++;
                    } else {
                        if (is_array($this->keys[$a])) {
                            $elements = $this->keys[$a];
                            $str = '';
                            foreach ($elements as $item) {
                                $str .= "'$item',";
                            }
                            $str = substr($str, 0, - 1);
                            $sql .= " and $a in (" . $this->keys[$a] . ")";
                        } else {
                            $sql .= " and $a='" . $this->keys[$a] . "'";
                        }
                    }
                }
                
                $deleteQuery = "delete from " . $this->table . " where " . $sql;
                $this->query($deleteQuery);
            }
        }
    }

    function addorder($key)
    {
        if ($this->debugdata) {
            debug::log("Add order $key");
        }
        array_push($this->order, $key);
    }
}

?>
