<?php
namespace Controller;
require_once('Model/Carro.class.php');

 class CarroController{
     public function __construct(){
         $this->model = new Carro();
     }
     public function index(){
         return $this->model;
    }
     public function show($id){

    }
    public function create(){
    
    }
    public function update($id){
    
    }
    public function destroy($id){
    
    }
     
 }


?>