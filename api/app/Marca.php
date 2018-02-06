<?php

namespace App;


class Marca
{
    public $id;
    public $marca;

    const PATH_FILE_JSON = "/../database/seeds/data/marcas.json";

    protected static function load_json() 
    {
        $file_path = realpath(__DIR__ . static::PATH_FILE_JSON);
        return file_get_contents($file_path);
    } 

    public static function all() 
    {
        $json = json_decode(static::load_json(), true);
        return $json;
    } 

    public static function find_index_by_name($marca) 
    {
        $marcas = static::all();
        $index = array_search($marca, array_column($marcas, 'marca'));

        return $index;
    }
}