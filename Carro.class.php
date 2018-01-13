<?php

class Carro {

	public $id;

	public $carroMarca;

	public $carroModelo;

	public $carroAno;

	function __construct($data) {
		if ( empty($data['id']) ) {
			$data['id'] = $this->generate_id();
		}
		$this->fill($data);
	}

	public function generate_id() {
		$id = [rand(0,9)];
		while ( sizeof($id) < 6 ) {
			$id[] = rand(0,9);
		}
		return intval(implode($id));
	}

	public function fill($data) {
		foreach ( $data as $k=>$v ) {
			$this->$k = ( is_numeric($v) ? intval($v) : $v );
		}
	}

	public function save() {
		$data = json_decode( file_get_contents('./db.json'), true );
		foreach ( $data as $k=>$v ) {
			if ( $v['id'] == $this->id ) {
				$data[$k] = $this;
				$update = true;
			}
		}
		if ( !$update ) {
			$data[] = $this;
		}
		file_put_contents('./db.json', json_encode($data));
	}

	public function delete() {
		$data = json_decode( file_get_contents('./db.json'), true );
		foreach ( $data as $k=>$v ) {
			if ( $v['id'] == $this->id ) {
				unset( $data[$k] );
			}
		}
		file_put_contents('./db.json', json_encode($data));
	}

	public static function find($id) {
		$data = json_decode( file_get_contents('./db.json') , true );		
		foreach ( $data as $k=>$v ) {
			if ( $v['id'] == intval($id) ) {
				$carro = new self($v);
				return $carro;
			}
		}
		return null;
	}

}

?>