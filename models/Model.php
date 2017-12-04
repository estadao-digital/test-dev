<?php

namespace models;

class Model {

    protected $db;

    public function __construct() {
        global $config;
        $this->db = DBFILE;
    }

    public function getDB() {
        try { 
            return file_get_contents($this->db);
        } catch (Exception $ex) {            
            return $ex;
        }
    }

    public function setDB($jsonarray) {
        try {
            return file_put_contents($this->db, json_encode($jsonarray));             
        } catch (Exception $ex) {
            return false;
        }
    }

}
