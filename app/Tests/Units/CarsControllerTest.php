<?php

namespace App\Tests\Units;

use App\Controllers\CarsController;
use App\Services\Cars;
use Core\JsonDb;
use App\Tests\Tests;


class CarsControllerTest{
    
    public $db;
    public $carsController;
    public $lastId;
    public $params;

   

    public function __constructor(){
        $this->$db=new JsonDb();
        $this->$carsController=new CarsController();
        $this->params=[
            "carro"=>"Im a test car",
            "marca"=>"Im a test brand",
            "modelo"=>"im a test model",
            "ano"=>"2021",
        ];
    }
    
   
    public function ShouldInsert_andReceiveJson(){
       

       $insert=$this->$carsController->store($this->params);
       $correctValue=true;
       $expected=$insert['success'];
       $this->lastId=$insert['data']['id'];
       Tests::assertEquals($expected,$correctValue,"ShouldInsert_andReceiveJson");

    }

    public function ShouldList_andReceiveJson(){
        $list=$this->$carsController->index();
        if($list['data'][0]['id']!=""){
            $characterId=true;
        }
        Tests::assertEquals(true,$characterId,"ShouldList_andReceiveJson");
    }

    public function ShouldShow_andReceiveJson(){
        $show=$this->$carsController->show($this->lastId);
        if($show['data']['id']!=""){
            $characterId=true;
        }
        Tests::assertEquals(true,$characterId,"ShouldShow_andReceiveJson");
    }

    public function ShouldUpdate_andReceiveJson(){
        $params=[
            "carro"=>"Im a updated Unit Test Car"
        ];

       $update=$this->$carsController->update($this->lastId,$params);
       $expected=$insert['success'];
       $updatedName=$update['data']['carro'];
       Tests::assertEquals($params['carro'],$updatedName,"ShouldUpdate_andReceiveJson");
    }

    

 
}