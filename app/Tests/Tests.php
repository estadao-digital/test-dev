<?php
namespace App\Tests;

use Exception;
use DirectoryIterator;

class Tests{

    public static function runTests(){
      
        foreach(new DirectoryIterator(__DIR__."/Units") as $file){
            $className=\substr( $file->getFileName(),0,-4);
           
            if($className!=""){
                $nclass="App\Tests\Units\\$className";
                $testClass=new $nclass();
                $methods=\get_class_methods($nclass);
                foreach($methods as $method){
                        $testClass->$method();
                    
                }
            }

       
        };
    }

    public static function assertEquals($expectedValue,$passedvalue,$test){
        if($expectedValue != $passedvalue){
            $msn= "The test $test Expected: $expectedValue but received $passedvalue";
            throw new Exception($msn);
        }

        echo "Test $test - Ok <br>";
    }

}