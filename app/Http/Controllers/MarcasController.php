<?php

namespace App\Http\Controllers;

use App\Http\Resources\MarcaResource;
use App\Marca;
use Illuminate\Http\Request;

class MarcasController extends Controller
{

    public function index()
    {

        return response(MarcaResource::collection(Marca::all()));
    }
}
