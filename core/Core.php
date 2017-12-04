<?php

namespace core;
class Core {

    public function run() {        
         $currentController = 'controllers\homeController';
         $currentAction = 'index';
        
        $url = explode('index.php', $_SERVER['PHP_SELF']);
        $url = end($url);

        $params = array();
        if (!empty($url) && $url != '/') {
            $url = explode('/', $url);
            array_shift($url);
            
            if (isset($url[0])) {
                $currentAction = $url[0];
                array_shift($url);
            } 

            if (count($url) > 0) {
                $params = $url;                
            }
        } 
        $c = new $currentController();        
        call_user_func_array(array($c, $currentAction), $params);
        
        
    }

}
