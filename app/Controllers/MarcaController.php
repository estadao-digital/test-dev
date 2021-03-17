<?php

namespace App\Controllers;

use App\Models\Marca;

class MarcaController {

    private $marca;

    public function __construct()
    {
        $this->marca = new Marca();
    }

    public function index()
    {
        $marcas = $this->marca->getBrands();
        return json_encode($marcas);
    }

}