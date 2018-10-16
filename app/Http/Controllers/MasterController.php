<?php

namespace App\Http\Controllers;

class MasterController extends Controller
{
	public function boot()
	{
		//Publica todos os css
	    $this->publishes([
	        __DIR__.'/public/css' => public_path('css'),
	    ], 'public');
	}
}

