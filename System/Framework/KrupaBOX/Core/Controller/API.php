<?php

namespace Controller;

class API extends \CI_Controller
{
    public static function load($controller)
    {
        \Import::PHP(__KRUPA_PATH_INTERNAL__ . "/controllers/" . $controller . ".php");
        $split = stringEx($controller)->split("/");
        
        $controller = $split[(count($split) - 1)];
        
        if ($controller != null && $controller != "")
        return new $controller();
        
        throw new Exception("Controller '" . $controller . "' not found.");
    }
   
    protected $parameters = [];
    protected function onInitialize() {}
    
    public function _remap($method)
    {
        $this->onInitialize();
        
        $CI = &get_instance();
        $uriString = $CI->uri->uri_string();
        $uriString = stringEx($uriString)->replace("/", "\\");

        $requestMethod = @$_SERVER['REQUEST_METHOD'];
        if ($requestMethod != "GET" && $requestMethod != "POST" && $requestMethod != "PUT" && $requestMethod != "DELETE")
            $requestMethod = "GET";
            
        $requestMethod = stringEx($requestMethod)->toLower();
        $uriString = stringEx($uriString)->replace("\\", "/");

        // Direct controller
        if (\Import::PHP(__KRUPA_PATH_INTERNAL__ . "controllers/" . $uriString . ".php"))
        {
            $uriString = stringEx($uriString)->replace("/", " ");
            $uriString = stringEx($uriString)->format(\stringEx::FORMAT_NAME);
            $uriString = stringEx($uriString)->replace(" ", "\\");
            $uriString = "Controller\\" . $uriString;

            //if (\arrayk($preUriSplit)->count <= 1)
            //    show_404();
            
            $instance = new $uriString;
            $instance->onInitialize();
            $instance->index();
            $instance->$requestMethod();
            return;
        }
        
        // Parameter controller
        $preUriSplit = stringEx($uriString)->split("\\");
        $preUriString = stringEx($uriString)->subString(0,
            stringEx($uriString)->length
            - stringEx($preUriSplit[\arrayk($preUriSplit)->count - 1])->length
            - 1
        );
        
        $preUriString = stringEx($preUriString)->replace("\\", "/");

        if (\Import::PHP(__KRUPA_PATH_INTERNAL__ . "controllers/" . $preUriString . ".php"))
        {
            $preUriString = stringEx($uriString)->replace("/", " ");
            $preUriString = stringEx($preUriString)->format(\stringEx::FORMAT_NAME);
            $preUriString = stringEx($preUriString)->replace(" ", "\\");
            $preUriString = "Controller\\" . $preUriString;

            if (\arrayk($preUriSplit)->count <= 2)
                show_404();

            $instance = new $preUriString;
            $instance->onInitialize();
            $instance->index();
            $instance->$requestMethod($preUriSplit[\arrayk($preUriSplit)->count - 1]);
            return;
        }
        \show_404();
    }
}