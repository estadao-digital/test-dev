<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{

    static function jsonAll(){
        $path = storage_path() . "/json/database.json";
        $json = json_decode(file_get_contents($path), true);
        return $json;
    }

    static function jsonById($id){
        $path = storage_path() . "/json/database.json";
        $json = json_decode(file_get_contents($path), true);
        $result = null;

        foreach ($json as $value){
            if($value['id'] == $id){
                $result = $value;
            }
        }

        return $result;
    }

    static function jsonCreate($data){
        $path = storage_path() . "/json/database.json";
        $json = json_decode(file_get_contents($path), true);

        $last_item  = end($json);
        if($last_item){
            $last_item_id = $last_item['id'];
            $data['id'] = ++$last_item_id;
        }else{
            $data['id'] = 1;
        }

        $json[] = $data;

        file_put_contents($path, json_encode($json));

        return $json;
    }

    static function jsonUpdate($data, $id){
        $path = storage_path() . "/json/database.json";
        $json = json_decode(file_get_contents($path), true);

        foreach ($json as $key => $value){
            if($json[$key]['id'] == $id){
                $json[$key]['marca'] = $data['marca'];
                $json[$key]['modelo'] = $data['modelo'];
                $json[$key]['ano'] = $data['ano'];
            }
        }

        file_put_contents($path, json_encode($json));

        return $json;
    }

    static function jsonDeleteById($id){
        $path = storage_path() . "/json/database.json";
        $json = json_decode(file_get_contents($path), true);
        $result = false;
        foreach ($json as $key => $value){
            if($json[$key]['id'] == $id){
                unset($json[$key]);
                $result = true;
            }
        }
        $json = array_values($json);
        file_put_contents($path, json_encode($json));

        return $result;
    }
}
