<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Publishers\Carro;
use Illuminate\Http\Request;

class carroController extends BaseController
{
	public $ApiPublisher;

	function __construct( Carro $Carro ){

		$this->Carro = $Carro;

	}

    public function list(){
        return $this->Carro->list();
    }

    public function get( $id  ){
        return $this->Carro->getCarro( $id );
    }
   
    public function insert( Request $request ){
    	$this->validate($request, [
            "Marca" => "required",
            "Modelo" => "required",
            "Ano"   => "required"
        ]);

        $req = $request->all();
        foreach( $req as $index => $value ){
            $this->Carro->set($index, $value); 
        }

        return $this->Carro->save();
    }

    public function update( $id, Request $request ){

        $this->Carro->get( $id );
        $req = $request->all();
        foreach( $req as $index => $value ){
            $this->Carro->set($index, $value); 
        }

        return $this->Carro->save( );
    }
    
    public function delete( $id ){

        $this->Carro->get($id);
        return $this->Carro->delete( );
    }
    

}
