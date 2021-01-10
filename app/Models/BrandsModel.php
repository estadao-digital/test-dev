<?php

namespace App\Models;

use Core\JsonDb;

class BrandsModel{
    private $db;

    public function __construct(){
        $this->db=new JsonDb("/json");
    }

    public function index(){
        $return= $this->db->getAll("brands");
        return ["success"=>true,"method"=>"index","criteria"=>["key"=>$criteria,"value"=>$value],"data"=>$return];
    }
}