<?php

namespace App\Http\Controllers;

use App\Marca;

class MarcaController extends Controller
{
    public function index()
    {
        return Marca::all()->toJson();
    }
}
