<?php
namespace Controller;
require_once('Model/Carro.php');
use Models\Carro;

 class CarroController{
     public function __construct(){
         $this->model = new Carro();
     }
     public function index(){
         return $this->model->index();
    }
     public function show($id){
        return $this->model->show($id);
    }
    public function create(){
    
    }
    public function update($id){
    
    }
    public function destroy($id){
    
    }
     
 }


?>