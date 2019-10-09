<?php
global $_DELETE;
global $_PUT;

class Request
{
    public static function Method(){
        return $_SERVER["REQUEST_METHOD"];
    }

    public static function Get(){
        $data = new stdClass;
        foreach($_GET as $k => $v)
            $data->$k = addslashes($v);
        return $data;
    }

    public static function Post(){
        $data = new stdClass;
        foreach($_POST as $k => $v){
            if(is_string($v)){
                $data->$k = addslashes(strip_tags($v));
            } else if(is_array($v)) {
                $a = new stdClass;
                foreach($v as $kv => $vv)
                    $a->{$kv} = addslashes(strip_tags($vv));

                $data->{$k} = $a;
            }
        }
        return $data;
    }


    

    public static function Put()
    {

        $a_data = array();
        parse_raw_http_request($a_data);
        
        $_PUT = $a_data;


        $data = new stdClass;
        foreach($_PUT as $k => $v){
            if(is_string($v)){
                $data->$k = addslashes(strip_tags($v));
            } else if(is_array($v)) {
                $a = new stdClass;
                foreach($v as $kv => $vv)
                    $a->{$kv} = addslashes(strip_tags($vv));

                $data->{$k} = $a;
            }
        }
        return $data;
    }

    public static function Delete()
    {
        $a_data = array();
        parse_raw_http_request($a_data);
        
        $_DELETE = $a_data;
        
        $data = new stdClass;
        foreach($_DELETE as $k => $v){
            if(is_string($v)){
                $data->$k = addslashes(strip_tags($v));
            } else if(is_array($v)) {
                $a = new stdClass;
                foreach($v as $kv => $vv)
                    $a->{$kv} = addslashes(strip_tags($vv));

                $data->{$k} = $a;
            }
        }
        return $data;
    }
}

function parse_raw_http_request(array &$a_data)
{
    // read incoming data
    $input = file_get_contents('php://input');
    
    if(isset($_SERVER['CONTENT_TYPE'])){

        // grab multipart boundary from content type header
        preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
        
        $boundary = $matches[1];
    
        // split content by boundary and get rid of last -- element
        $a_blocks = preg_split("/-+$boundary/", $input);
        array_pop($a_blocks);
    
        // loop data blocks
        foreach ($a_blocks as $id => $block)
        {
        if (empty($block))
            continue;
    
        // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char
    
        // parse uploaded files
        if (strpos($block, 'application/octet-stream') !== FALSE)
        {
            // match "name", then everything after "stream" (optional) except for prepending newlines 
            preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
        }
        // parse all other fields
        else
        {
            // match "name" and optional value in between newline sequences
            preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
        }
        $a_data[$matches[1]] = $matches[2];
        }        
    }
}
    