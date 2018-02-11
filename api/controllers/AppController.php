<?php
namespace controllers{
    
    /*
	Class Controller
    */
    class AppController{

        function __construct(){
            
        }

        protected function render($array){
            if(!array_key_exists('status', $array)){
                $array['status'] = 200;
            }
            if(!array_key_exists('message', $array)){
                $array['message'] = '';
            }
            if(!array_key_exists('data', $array)){
                $array['data'] = array();
            }
            return $array;
        }

    }
}
