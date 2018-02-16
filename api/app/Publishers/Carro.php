<?php

namespace App\Publishers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class Carro{
	
	private $ID;
	private $Modelo;
	private $Marca;
	private $Ano;
	private $index;

	function __construct( $ID = null ){
		
		if( $ID ) $data = $this->get( $ID );
	}

	private function getData( ){	
		$content = file_get_contents("../storage/data.json");	
		return ( $content ? json_decode( $content ) : [] ) ;
	}

	private function setData( $data ){		
		return  file_put_contents("../storage/data.json", json_encode( $data) ) ;
	}

	public function set( $prop, $value ){
		$this->$prop = $value;
	}

	public function getCarro( $id ){
		//return json_encode( $this->get( $id ) );
		return response()->json([
			    'success' => true,
			    'data' => $this->get( $id )
			],200);
	}

	public function save(){

		$data = $this->getData();
		// Update
		if( $this->ID ){	

			$data[$this->index]->Marca = $this->Marca;
			$data[$this->index]->Modelo = $this->Modelo;	
			$data[$this->index]->Ano = $this->Ano;	
			$ID = $this->ID;

		} else {

			$count = end($data);

			$ID = ( isset($count->ID) ? $count->ID + 1 : 1 );

			// Insert
			$data[] = [ "ID" => $ID, 
						"Marca" => $this->Marca,
						"Modelo" => $this->Modelo,
						"Ano" => $this->Ano ];
		}

		if( $this->setData( $data ) ){
			$this->get( $ID );
			
			return response()->json([
			    'success' => true,
			    'id' => $this->ID,
			    'message' => 'Registro gravado com sucesso'
			],200);

		} else {
			
			return response()->json([
			    'success' => false,
			    'message' => 'Erro ao gravar registro'
			],200);	

		}
	}


	private function setProp( $data ){

		foreach ($data as $key => $value) {
			$this->$key = $value;
		}

	}

	public function get( $ID = null ){
		$data = $this->getData();
		if( count( $data ) ) {
			$n = 0;
			foreach( $data as $index => $d ){
				if( $ID == $d->ID ){
					$this->index = $n;
					$this->setProp( $d );
					return $d;
				}
				$n++;
			}
		} 

		return response()->json([
		    'success' => false,
		    'message' => 'Nenhum registro encontrado'
		],200);	
		
	}

	public function list( ){		
		$results = $this->getData();

		return response()->json([
		    'success' => true,
		    'data' => $results
		],200);

	}


	public function delete( ){

		$new = [];
		$data = $this->getData();
		unset( $data[ $this->index ] );
		foreach( $data as $i => $v ){
			$new[] = $v;
		}

		$this->setData( $new );

		return response()->json([
			    'success' => true,
			    'message' => 'Registro apagado com sucesso'
			],200);
		
	}



}
