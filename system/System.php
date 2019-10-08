<?php

class System{

    public static $urls = array();
    public static $APP, $CLASS, $ACT;

    public function __construct(){

        $match = false;
        $control = "";

        foreach(self::$urls as $url => $application){

            $parsed_url = parse_url(URI);
            $matches = array();

            if(preg_match("#^\/?{$url}\/?$#i", $parsed_url["path"], $matches)){
                $match = true;
                $control = $application;

                foreach($matches as $param => $value){
                    if(! is_numeric($param) and $param != 'querystring'){
                        $_GET[$param] = $value;
                    }
                }
            }
        }

        if($match){
            
            if(isset(explode(".", $control)[1])){
                $control = explode(".", $control);

                self::$APP      = $app   = $control[0];
                self::$CLASS    = $class = $control[1];
                self::$ACT      = $act   = $control[2];

                $file = BASE . "application/" . $app . "/controllers/" . $class . ".php";

                if(!file_exists($file))
                    die("O arquivo '$file' não existe!");

                include_once($file);

                if(!class_exists($class))
                    die("A classe '$class' não existe!");

                $c = new $class();

                if(!method_exists($c, $act))
                    die("A função '$act' não existe!");

                print_r($c->$act());

            }

        }

    }


    public static function setUrl($urls){
        foreach($urls as $k => $v){
            self::$urls[$k] = $v;
        }

    }


}