<?php

namespace App\Controllers;


use App\Validators\Validator;
use App\Services\CarsService;
use App\Models\CarsModel;
use App\Views\Template\Template;
use App\Views\Template\Footer;
use App\Views\Template\Body;

class CarsController{
    private $carsModel;
    private $rules;

    public function __construct(){
        $this->carsModel=new CarsModel();
        $this->rules = [
            'carro' => ['required', 'minLen' => 2,'maxLen' => 50],
            'marca' => ['required', 'minLen' => 2,'maxLen' => 50],
            'modelo' => ['required', 'minLen' => 2,'maxLen' => 50],
            'ano' => ['required', 'minLen' =>4,'maxLen' => 4, 'numeric']
        ];
    }

    public function index(){
        Template::getTemplate("CarsView");
    }
    
    public function list(){
        return $this->carsModel->list();
    }

    public function store($data){
        $v = new Validator();
        $v->validate($data, $this->rules);
        return $this->carsModel->store($data);
       
    }

    public function update($id,$vars){
        $updateRules=[];
        foreach($vars  as  $key => $var){
            array_key_exists($key, $this->rules) ? $updateRules[$key]=$this->rules[$key] : null;
         }
        $v = new Validator();
        $v->validate($vars, $updateRules);
        return $this->carsModel->update($id,$vars);
    }

    public function delete($id){
        return $this->carsModel->delete($id);
    }

    public function show($id){
        return $this->carsModel->show($id);
    }
    
}