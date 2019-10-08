<?php

class System{

    public static $urls = array();

    public function __construct(){

        foreach(self::$urls as $url => $application){
            echo $application;
        }

    }


    public static function setUrl($urls){
        foreach($urls as $k => $v){
            self::$urls[$k] = $v;
        }

    }


}