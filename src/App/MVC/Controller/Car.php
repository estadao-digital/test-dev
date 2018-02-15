<?php
namespace App\Mvc\Controller;

class Car{
    private $params;
    private $method;
    private $data = null;
    private $model;

    function __construct(){
        $this->model = new \App\Mvc\Model\Car();
    }

    public function index($params = null){
        $view = new \App\Mvc\View\View('home/index');
    }

    public function get($params = null){
        $id = isset($params[0]) ? $params[0] : null;
        
        return $this->model->get($id);
    }
    
    public function create($params = null){
        return $this->model->create($params);
    }
    
    public function update($params = null){
        return $this->model->update($params);
    }
    
    public function delete($params = null){
        $id = isset($params[0]) ? $params[0] : null;

        return $this->model->delete($id);
    }
}