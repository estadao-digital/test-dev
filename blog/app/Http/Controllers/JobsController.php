<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JobsController extends Controller
{
    public function index(){
        return response()->json(array("aaa"=>"bbb"));
    }

    public function api()
    {

        return response()->json(array("aaa"=>"bbb"));
    }
}
