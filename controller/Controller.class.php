<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require "view/View.class.php";
require "model/Carro.class.php";
		ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'].'/tmp');
		session_start();
/**
* 
*/
class Controller
{
	//function __construct(argument)
	//{
		
	//}

	function start(){

		if(empty($_GET)){
			View::get_view('index', '');
		}else{
			$action = $_GET['action'];
			//var_dump($this->action);die;
			$this->$action();
		}

	}

	function home(){
		View::get_view('home', '');
	}

	function new_car(){

		if(empty($_SESSION['carros'])){
			$id_new_car = 1;
		}else{
			$id_last_car = Carro::get_carros();
			$id_new_car = end($id_last_car)["id"] + 1;
		}

		View::get_view('cadastro_carro', $id_new_car);
	}

	function insert_new_car(){

		$new_car = new Carro($_POST["id"],$_POST["marca"],$_POST["modelo"],$_POST["ano"]);

		$new_car->insert_carro();

		View::get_view('finaliza_cadastro_carro', $new_car);
	}

	static function get_all_cars(){

		$carros = Carro::get_carros();

		View::get_view('geral_carros', $carros);
	}

	function pagina_buscar(){
		View::get_view('buscar_carros', 'home_buscar');
	}

	function get_car(){

		$carro = Carro::get_carro($_GET['id']);
	
		View::get_view('buscar_carros', $carro);
	}

	function pagina_update(){

		View::get_view('atualizar_carro', Carro::get_carro($_GET['id']));

	}

	function update_car(){
		Carro::update_carro($_GET['id'], $_POST['marca'], $_POST['modelo'], $_POST['ano']);

		self::get_all_cars();
	}

	function delete_car(){

		$id = (int)$_GET['id'];

		Carro::delete_carro($id);

		Controller::get_all_cars();
	
	}
}

?>