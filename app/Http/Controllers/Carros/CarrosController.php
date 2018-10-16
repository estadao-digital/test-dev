<?php

/**
**@author Vitor Caetano <vitor.caetano.silva@usp.br>
**@since 2018-10=10
**Essa clase contém as principais funções da classe Carros
*/
namespace App\Http\Controllers\Carros;

use App\Http\Controllers\Controller;
use App\Models\ReadWriteDataBase;
use Request;
use Input;
class CarrosController extends Controller
{
	/* Função principal método get*/
	public function get($id=null){

		$aView = Request::all();
		$aView['ID'] = $id;

		if(isset($aView['ID'])){
			$aView['head'] = 'Editando Carro: '. $aView['ID'];
		}else{
			$aView['head'] = 'Criando novo Carro';
		}

		$ReadWriteDataBase = new ReadWriteDataBase;
		$content = $ReadWriteDataBase->read();

		$aView['car'] = [];
		$aView['selectCar'] = [];
		if($content){
			$data = explode(PHP_EOL,$content);
			foreach($data as $d){
				$car = explode(',', $d);
				if(isset($car[0]) && $car[0] != ''){
					$carpush = [];
					foreach($car as $c){

						$atrib = explode(':', $c);

						if(!isset($aView['car'])) $aView['car'] = [];

						if(isset($atrib[1])){
							$carpush[$atrib[0]] = $atrib[1];
						}
					}

					if(isset($aView['ID'])){
						if(isset($carpush['ID'])){
							if($aView['ID'] == $carpush['ID']){
								$aView['selectCar'] = $carpush;
							}
						}
					}

					array_push($aView['car'], $carpush);
				}
			}
		}
		return view('carros/default', [
			'content' => $content,
			'aView' => $aView
		]);
	}

	/* Submit form */
	public function post(){
		$aRequest = Request::all();
		$aView = $this->get()['aView'];
		$id = $aRequest['ID'];
		$marca = $aRequest['Marca'];
		$modelo = $aRequest['Modelo'];
		$ano = $aRequest['Ano'];
		$ReadWriteDataBase = new ReadWriteDataBase;
		$content = $ReadWriteDataBase->read();

		$return = [];


		if(isset($aView['create'])){
			if(!isset($id)){
				$message = "Erro: Preencha o ID";
				return redirect()->back()->withErrors(['message' => $message]);
			}
			$aView['create'] = null;
			$this->create($id, $marca, $modelo, $ano);
		}

		if(isset($aView['delete'])){
			$aView['delete'] = null;
			$this->delete($id);
		}

		if(isset($aView['edit'])){
			$aView['edit'] = null;
			$this->edit($id, $marca, $modelo, $ano);
		}

		return view('carros/default',[
			'content' => $content,
			'aView' => $aView
		]);
	}

	/* Ações do Crud */

	public function delete($id = null){
		if ($id == null) return false;
		// Banco de dados ficticio
		$ReadWriteDataBase = new ReadWriteDataBase;
		if($this->exists($id)){
			$ReadWriteDataBase->delete($id);
			$message = "Deletado com sucesso ID: ".$id;
			return redirect()->back()->with('message', $message);
		}
		else{
			$message = 'Este ID não existe mais na base!';
			return redirect()->back()->withErrors(['message' => $message]);
		}
	}

	public function edit($id = null,$marca = null, $modelo = null, $ano = null){
		if(!$this->exists($id)){
			$message = "Não existe o ID: ".$id;
			return redirect()->back()->withErrors(['message' => $message]);
		}
		$this->delete($id);
		$this->create($id, $marca, $modelo, $ano);
		$message = "Editado com sucesso ID: ".$id;
		return redirect()->back()->with('message', $message);
	}

	public function create($id = null,$marca = null, $modelo = null, $ano = null){
		if($this->exists($id)){
			$message = 'Este ID já foi inserido!';
			return redirect()->back()->withErrors(['message' => $message]);
		}else{
			$ReadWriteDataBase = new ReadWriteDataBase;
			$ReadWriteDataBase->write('ID:'.$id.','.'Marca:'.$marca.','.'Modelo:'.$modelo.','.'Ano:'.$ano);
			$message = "Criado com sucesso ID: ".$id;
			return redirect()->back()->with('message', $message);
		}
	}

	public function exists($id = null){
		if ($id == null) return false;
		// Banco de dados ficticio
		$ReadWriteDataBase = new ReadWriteDataBase;
		$content = $ReadWriteDataBase->read();
		$pos = strpos($content, 'ID:'.$id.',');
		$message = '';
		if($content){
			//Verificação de ids repetidos
			if($pos >= 0 && $pos !== false){
				return true;
			}
		}
		if($pos === false || $content == false){
			return false;
		}
	}

	/* Single Page Application*/

	public function spa(){
		return view('carros/spa');
	}

}
