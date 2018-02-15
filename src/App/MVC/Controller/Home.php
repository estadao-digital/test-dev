<?php
namespace App\Mvc\Controller;

class Home{
    public function index($params = null){
        $view = new \App\Mvc\View\View('home/index');
    }
}