<?php

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
}