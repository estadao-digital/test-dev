<?php
//session_start();

require('./Carro.class.php');

$h = new Handle();

class Handle {

	public $db = './db.json';
	public $cars = [];

	function __construct() {
		$id = intval($_GET['id']);
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
			$this->add_car(json_decode( file_get_contents('php://input'), true ));
		} elseif ( $_SERVER['REQUEST_METHOD'] == "PUT" ) {
			$this->update_car($id, json_decode( file_get_contents('php://input'), true ));
		} elseif ( $_SERVER['REQUEST_METHOD'] == "DELETE" ) {
			if ( empty($id) ) {
				echo "Informe um ID";
			} else {
				$this->delete_car($id);
			}
		} elseif ( !empty($_GET['id']) ) {
			$this->list_car($id);
		} else {
			$this->list_cars();
		}
	}

	public function list_cars() {
		$this->read_db();
		echo json_encode($this->cars);
	}

	public function list_car($id) {
		if ( empty($id) ) {
			echo json_encode(['msg'=>'Informe um ID']);			
		} else {
			$carro = Carro::find($id);
			if ( empty($carro) ) {
				echo json_encode(['msg'=>'Carro não encontrado']);
			} else {
				echo json_encode($carro);
			}
		}
	}

	public function add_car($data) {
		if ( empty($data['carroMarca']) || empty($data['carroModelo']) || empty($data['carroAno']) ) {
			echo json_encode(['msg'=>'Dados incorretos']);
		} else {
			$carro = new Carro($data);
			$carro->save();
			echo json_encode($carro);
		}
	}

	public function update_car($id, $data) {
		if ( empty($id) ) {
			echo json_encode(['msg'=>'Informe um ID']);
		} else {
			if ( empty($data['carroMarca']) || empty($data['carroModelo']) || empty($data['carroAno']) ) {
				echo json_encode(['msg'=>'Dados incorretos']);
			} else {
				$carro = Carro::find($id);
				if ( count($carro) > 0 ) {
					$carro->fill($data);
					$carro->save();
					//echo json_encode($carro);
					echo json_encode(['msg'=>'Carro atualizado']);
				} else {
					echo json_encode(['msg'=>'Carro não encontrado']);
				}
			}
		}
	}

	public function delete_car($id) {
		if ( empty($id) ) {
			echo json_encode(['msg'=>'Informe um ID']);
		} else {
			$carro = Carro::find($id);
			if ( count($carro) > 0 ) {
				$carro->delete();
				echo json_encode(['msg'=>'Carro deletado']);
			} else {
				echo json_encode(['msg'=>'Carro não encontrado']);
			}
		}
	}

	public function read_db() {
		if ( file_exists($this->db) ) {
			$data = json_decode( file_get_contents($this->db) );
			foreach ( $data as $i ) {
				$carro = new Carro;
				$carro->fill($i);
				$this->cars[] = $carro;
			}
		}
	}

}

?>