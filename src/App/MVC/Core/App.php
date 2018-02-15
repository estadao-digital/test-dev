<?php
namespace App\Mvc\Core;
use \App\Mvc\Controller;

final class App{
    protected $url;
    protected $controller;
    protected $method;
    protected $params = [];

    function __construct(){
        $this->seturl();
        
        if($this->url == null){
            $this->controller = new \App\Mvc\Controller\Home();
            return $this->controller->index();
        }

        //get the controller, method and parameters and unset the url in array
        $this->setController();
        $this->setMethod();
        $this->setParameters();

        $this->controller->{$this->method}($this->params);
    }
    
    private function setUrl(){
        preg_match ("/(?<=url=).*$/", $_SERVER["QUERY_STRING"], $matches);
        if(isset($matches[0])){
            $this->url = explode("/", $matches[0]);
        }
    }

    private function setController(){
        $url = [];
        if(isset($this->url[0])){
            $url = $this->url[0];

            if($url != null){
                $this->controller = $this->url[0];
                unset($this->url[0]);
            }
        }else if (isset($this->url["url"])){
            $url = $this->url["url"];

            if($url != null){
                $this->controller = $this->url["url"];
                unset($this->url["url"]);
            }
        }
		
        $newController = "\App\Mvc\Controller\\" . $this->controller;
       
        if(class_exists($newController)) {
            $this->controller = new $newController();
        } else {
            $this->controller = null;
        }
    }

    private function setMethod(){
        switch($_SERVER['REQUEST_METHOD']){
            default:
            case 'GET' :
                $this->method = 'get';
            break;
            case 'POST' :
                $this->method = 'create';
                break;
            case 'PUT' :
                $this->method = 'update';
            break;
            case 'DELETE' :
                $this->method = 'delete';    
            break;
        }
    }

    private function setParameters(){
        //get the total of non null parameters
        $paramsLength =  count(
            array_filter(
                $this->url, 
                function($x){
                    return !empty($x);
                } 
            )
        );

        //get the url
        $url = ($paramsLength > 0) ? array_values($this->url) : null;

        if(isset($this->url)){
            switch($_SERVER['REQUEST_METHOD']){
                default:
                case 'GET' :
                case 'DELETE' :
                    // set id param
                    $this->params = ($url != null) ? $url :  null;
                break;
                case 'PUT' :
                    //get data from put
                    mb_parse_str(file_get_contents("php://input"), $this->params);

                    //set id variable
                    $id = ($url != null) ? (is_array($url) ? $url[0] : null ) :  null;
                    
                    //set the params variable
                    $this->params["id"] = $id;
                break;
                case 'POST' :
                    //set post params
                    $this->params = $_POST;
                break;
            }
            
            unset($this->url);
        }
    }
}