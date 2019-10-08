<?php

class DB
{
    public $table, $object, $jsonfile;

    public function __construct($_table = "")
    {
        if(!empty($_table))
        {
            $this->table = $_table;
        }

        if(!is_dir(BASE . "database"))
            mkdir(BASE . "database");
        
        $db_dir = BASE . "database/";

        $this->jsonfile = $db_dir . $_table . ".json";
        
        if(!file_exists($this->jsonfile)){
            $dbfile = fopen($this->jsonfile, "w");
            fwrite($dbfile, "");
            fclose($dbfile);
        }

    }

    public function Insert($object)
    {
        $status = false;
        $response = null;
        try{
            $json = json_decode(file_get_contents($this->jsonfile), true);
            $object->id = count($json) + 1;
            
            if(is_array($json)){
                $json[] = $object;
            }else{
                $json = array($object);
            }
    
            $jsonstr = json_encode($json);
            file_put_contents($this->jsonfile, $jsonstr);
            $status = true;
            $response = $object->id;
        }catch(Exception $e){}

        return (object)array("status" => $status, "response" => $response);
    }

    public function Update($object, $id)
    {
        $json = json_decode(file_get_contents($this->jsonfile), true);
        $array = array();

        $found = false;

        foreach($json as $k => $v)
        {
            if($v["id"] == $id){
                $object->id = $id;
                $array[] = $object;
                $found = true;
            }else{
                $array[] = (object)$v;
            }
        }

        if(!$found)
            return -1;

        $jsonstr = json_encode($array);
        file_put_contents($this->jsonfile, $jsonstr);
        return true;
    }

    public function Delete($id)
    {
        $json = json_decode(file_get_contents($this->jsonfile), true);
        $array = array();

        $found = true;

        foreach($json as $k => $v)
        {
            if($v["id"] == $id){
                $found = true;
            }else{
                $array[] = (object)$v;
            }
        }

        if(!$found)
            return -1;

        $jsonstr = json_encode($array);
        file_put_contents($this->jsonfile, $jsonstr);
        return true;
    }

    public function Select($id = 0)
    {
        $status = false;
        $response = null;

        try{
            $json = json_decode(file_get_contents($this->jsonfile), true);
            $array = array();
            
            $found = false;

            if(count($json) > 0){

                foreach($json as $k => $v)
                {
                    if($v["id"] == $id || $id == 0){
                        $array[] = (object)$v;
                        $found = true;
                    }
                }
                
                if(!$found){
                    $response = "Registro não encontrado";
                }else{
                    $status = true;
                    $response = $array;
                }

            }else{
                $status = true;
                $response = array();
            }


        } catch(Exception $e) {}

        return (object)array("response" => $response, "status" => $status);
    }

}