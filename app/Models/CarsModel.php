<?php
namespace App\Models;

use Core\JsonDb;
use Core\Utilities;

class CarsModel{
    private $db;

    public function __construct(){
        $this->db=new JsonDb("/json");
    }

    public function list(){
       $return= $this->db->getAll("cars");
       return ["success"=>true,"method"=>"list","data"=>Utilities::objectToArray($return)];


    }

    public function store($params){
        $insertParams=[
            'id'=>md5(mt_rand()),
            'carro'=>$params['carro'],
            'marca'=>$params['marca'],
            'modelo'=>$params['modelo'],
            'ano'=>$params['ano']
        ];
        $insert=$this->db->insert($insertParams,"cars");
        return ["success"=>true,"method"=>"insert","data"=>$insertParams];
        

    }

    public function delete($id){
        $delete=$this->db->delete(["id"=>$id],"cars");
        if($delete){
            return ["success"=>true,"method"=>"delete","data"=>["id"=>$id]];
        }else{
            return ["success"=>false,"method"=>"delete","error"=>"id não encontrado "];
        }
        

    }

    public function show($id){
        $select=$this->db->getById("cars",$id);
        return ["success"=>true,"method"=>"show","data"=>Utilities::objectToArray($select)];
    }

    public function update($id,$vars){
        $update=$this->db->update(["id"=>$id] , $vars , $table = 'cars');
        return ["success"=>true,"method"=>"update","data"=>Utilities::objectToArray($this->db->getById("cars",$id))];

 
    }

}