<?php

namespace App\Controllers;

use App\Models\BrandsModel;

class BrandsController{

    private $brandsModel;

    public function __construct(){
        $this->brandsModel=new BrandsModel();
    }

    public function index(){
        return $this->brandsModel->index();
    }
}