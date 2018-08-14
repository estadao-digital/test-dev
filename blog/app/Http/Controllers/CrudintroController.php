<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CrudintroModel;

use App\Http\Requests\TesterRequest;

use Illuminate\Support\Facades\DB;

class CrudintroController extends Controller
{
    public function index()
    {

        return view('crudintro.index',['' => '']);

    }

    public function datatable(){

	

		if ( empty(session('carros')) )
		{
			$output['carros'] = array();
		} else 
		{
			$output['carros'] = session('carros');
			
		}
		

		return view('crudintro.datatable',['output' => $output]);    	

    }
	
	public function carrosStore(Request $request)
	{
		
		$novoCarro = $request->toArray() ; 

		$carros = session('carros');
				
		$carros[$novoCarro["id"]] = $novoCarro ;
		
		session(['carros' => $carros ]);
		
	
	}
	
	public function getCarro($id)
	{
		$carros = session('carros');
		
		return $carros[$id] ;

		
	}
	
	public function carrosDelete(Request $request)
	{
		

		$id = key ($request->toArray());

		$carros = session('carros');
		
		unset($carros[$id]);
				
		session(['carros' => $carros ]);
		

		
	}

    public function modal()
    {
		return view('crudintro.modal',['output' => 'fsdf']);    	
    }

	

    public function store(TesterRequest $request){

        return view('tester.index',['product' => '']);


        $this->validate($request, ['name' => 'required']);

    }




}
