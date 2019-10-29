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
        $dados = json_decode(file_get_contents('php://input'));
        $ano =$dados->ano;
        $modelo =$dados->modelo;
        $marca =$dados->marca;
       return $this->model->create($modelo,$marca,$ano);
    }
    public function update($id){
        $dados = json_decode(file_get_contents('php://input'));
        $ano =$dados->ano;
        $modelo =$dados->modelo;
        $marca =$dados->marca;
       return $this->model->update($modelo,$marca,$ano,$id);
    }
    public function destroy($id){
        return $this->model->destroy($id);
    }
     
 }


?>