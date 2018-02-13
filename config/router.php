<?php 
    $url = $_SERVER['REQUEST_URI'];
    $split = preg_split("/(\/controllers\/)()*/", $url);
    if(array_key_exists(1,$split)){
        $array_url = explode('/',$split[1]);

        $controller = str_replace('.php','',$array_url[0]);
        unset($array_url[0]);

        $action = $array_url[1];
        unset($array_url[1]);

        $param = $array_url;
        class Index {
            
            static function main($controller, $action, $param) { 
                $class = new $controller();
                call_user_func_array(array($class, $action), $param);
            }
        
        }

        Index::main($controller, $action, $param);
    }
?>