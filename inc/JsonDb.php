<?php
namespace Core;
use Exception;

class JsonDb{
        
        private $__db;
    
        private static $__db_prefix = 'db_';   
    
        public function __construct($path = '')
        {
           $this->initialization($path);
           
        }
    
        public function obj2array($object = 0)
        {
            if(is_object($object) || is_array($object))
            {
                $array = array();
                foreach($object as $attr => $value)
                {
                    $array[$attr] = $this->obj2array($value);
                }
                return $array;
            }
            else
            {
                return $object;
                exit;
            }
        }
  
        public function insert($content = array() , $table = '')
        {
            
            $result = $this->obj2array($this->getAll($table));
            array_push($result,$content);
            $content = json_encode($result);
    
            $_path = str_replace('\\','/',$table);
            $_path .= '.json';
            $db_url = $this->__db.'/'.self::$__db_prefix.$_path;            
            $result = file_put_contents($db_url, $content);
            if($result)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    
      
        public function delete($cond = array() , $table = '')
        {
            $result = $this->obj2array($this->getAll($table));
            $cond_array = array();
            foreach($result as $key => $value)
            {
                if(array_intersect($value , $cond))
                {
                    array_push($cond_array , $key);
                }
            }
            if(count($cond_array) > 0)
            {
                foreach ($cond_array as $value) 
                {
                    unset($result[$value]);
                }
                $result = $this->replace($result , $table);
                if($result)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
    
     
         public function update($cond = array() , $content = array() , $table = '')
         {
            $result = $this->obj2array($this->getAll($table));
            $cond_array = array();
            foreach($result as $key => $value)
            {
                if(array_intersect($value , $cond))
                {
                    array_push($cond_array , $key);
                }
            }
            if(count($cond_array) > 0)
            {
                foreach ($cond_array as $value) 
                {
                    foreach($content as $key => $v)
                    {
                        isset($result[$value][$key]) ? $result[$value][$key]= $v : null;
                    }
                }
                $result = $this->replace($result , $table);
                if($result)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
         }
        
    
        public function getAll($table = '')
        {
            $file = self::chkFile($table);
            return ($file) ? self::getFileContents($file) : false;
        }
        
        public function getById($table = '',$id)
        {
            $file = self::chkFile($table);
             ($file) ? $returned=(array)self::getFileContents($file) : false;
             return  $returned[\array_search($id,array_column($returned, 'id'))];
        }
   
        private function initialization($path)
        {
            $path=__PATH_ROOT__.$path;
           try
           {
                $path = str_replace('\\','/',$path);
                if (is_dir($path))
                {
                    $this->__db = $path;    
                }
                else
                {
                    throw new Exception(self::error('db_error'));
                }
            }
            catch (exception $e)
            {
                exit($e->getMessage());
            }
        }
   
        private function chkFile($path = '')
        {
            try
            {
                $_path = str_replace('\\','/',$path);
                $_path .= '.json';
                $file = $this->__db.'/'.self::$__db_prefix.$_path;
                if(file_exists($file))
                {
                    return $file;
                }
                else
                {
                    $message = 'table "'.$path.'" does not exists!!!';
                    throw new Exception($message);
                }
            }
            catch (exception $e)
            {
                exit($e->getMessage());
            }
        }

        private function replace($content = array() , $table = '')
        {
            $content = json_encode($content);
    
            $_path = str_replace('\\','/',$table);
            $_path .= '.json';
            $db_url = $this->__db.'/'.self::$__db_prefix.$_path;
            
            $result = file_put_contents($db_url, $content);
            if($result)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    

        private static function getFileContents($file = '')
        {
            try
            {
                $content = file_get_contents($file);    //  获取数据表信息
                $result  = json_decode($content);       //  解析json
                if(!$result)
                {
                    throw new Exception(self::error('db_table'));
                }
                return $result;
            }
            catch (exception $e)
            {
                exit($e->getMessage());
            }
        }
    

        private static function error($lv = 'null_tip')
        {
            $error_msg = array(
                'null_tip' => '
                The error message does not exist',
                'db_error' => '
                The database file directory does not exist',
                'db_table' => '
                Data table data format error'
            );
            if(!array_key_exists($lv , $error_msg))
            {
                return $error_msg['null_tip'];
            }
            return $error_msg[$lv];
        }
    
    }