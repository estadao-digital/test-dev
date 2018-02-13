<?php

class Util{

    function __construct(){}

    /**
     * Function to call the API
     */
    public function callAPI($method, $url, $data = false) {
        $url = GLOBAL_CLASS::$api.$url;
        $curl = curl_init();
    
        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
    
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data){
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
    
        // Optional Authentication:
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($curl, CURLOPT_USERPWD, "username:password");
    
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
        $result = curl_exec($curl);
    
        curl_close($curl);
    
        return $result;
    }

    //Function to render the view
    function render($path, $data=array()) {
        ob_start();
        extract($data, EXTR_SKIP); //send $data to the included file (view)
        include('../views/'.$path.'.php');
        $var=ob_get_contents(); 
        ob_end_clean();
        return $var;
    }
}
?>