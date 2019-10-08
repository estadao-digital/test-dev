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
        $json = json_decode(file_get_contents($this->jsonfile), true);
        $object->id = count($json) + 1;
        
        if(is_array($json)){
            $json[] = $object;
        }else{
            $json = array($object);
        }

        $jsonstr = json_encode($json);
        file_put_contents($this->jsonfile, $jsonstr);
        return true;
    }

}