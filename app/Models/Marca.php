<?php

namespace App\Models;

class Marca {
    
    private $db;

    public function __construct()
    {
        $this->db = json_decode( file_get_contents(getcwd().'/app/Models/db.json') );
    }

    public function getBrands()
    {
        $marcas = array_map(function ($key) {
            return $key->marca;
        }, $this->db);

        if ( is_array($marcas) ) {
            return array_values( array_unique($marcas) );
        }
        
        return [];
    }

}