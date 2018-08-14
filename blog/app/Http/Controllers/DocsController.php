<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class DocsController extends Controller
{
    public function index(){

        return File::get(public_path() . '/docs/index.html');

    }
}
