<?php

namespace App\Http\Controllers;

use App\Crud;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Client;

class Contatos extends Controller
{

    /**
     * Exibe todos os carros cadastrados
     *
     * @return Response
     */
    public function index(){
        return Crud::all();
    }

}
