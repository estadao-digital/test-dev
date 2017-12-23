<?php
class Carros_Controller {	
	
	function __construct()
	{
		$this->Model = new Carros_Models();
		$this->Marcas = new Marcas_Models();
		$this->View = new Paginas();
	}
	
	public function listar()
	{
		
		$dados['title'] = "Lista de Carros";
		$dados['url_css'] =  (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].'/prova/assets/css/';
		$dados['url_js'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].'/prova/assets/js/';
		
		$dataJson = $this->Model->getData();
		
		$limiter = $this->Model->getIdAi();
		$lista = '';
		$marcas = $this->Marcas->getData();
		$nomeMarca = '';
		usort($dataJson, 'sortById');
		foreach($dataJson as $carro)
		{
			foreach($marcas as $marca)
			{
				if($carro['marca'] == $marca['id'])
				{
					$nomeMarca = $marca['nome'];
				}
			}

			$lista .= '<tr data-item="'.$carro['id'].'"><td data-edit="false">'.$carro['id'].'</td><td data-edit="modelo">'.$carro['modelo'].'</td><td data-edit="ano">'.$carro['ano'].'</td><td data-edit="marca" data-select="'.$carro['marca'].'">'.$nomeMarca.'</td><td><button type="button" onclick="editarItem('.$carro['id'].')" class="button button-3d button-blue button-mini" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';

		}
		$dados['lista_carros'] = $lista;
		
		$pagina = $this->View->render('lista',$dados);
		
		echo $pagina;
	}
	public function ajaxListaMarcas()
	{
		echo $this->Marcas->getDataAjax();
	}
	public function ajaxSalvarItem()
	{
		if($_POST['item'])
		{
			$data = $_POST['item'];
			echo $this->Model->saveData($data);
		}		
	}
	public function ajaxCriarItem()
	{
		if($_POST['item'])
		{
			$data = $_POST['item'];
			$this->Model->insertData($data);
			echo $this->ajaxListar();
		}		
	}
	public function ajaxExcluirItem()
	{
		if($_POST['item'])
		{
			$data = $_POST['item'];
			$this->Model->deleteData($data);
			echo $this->ajaxListar();
		}		
	}

	public function ajaxListar()
	{
		$dataJson = $this->Model->getData();
		$lista = '';
		$marcas = $this->Marcas->getData();
		usort($dataJson, 'sortById');
		
		$nomeMarca = '';
		foreach($dataJson as $carro)
		{
			foreach($marcas as $marca)
			{
				if($carro['marca'] == $marca['id'])
				{
					$nomeMarca = $marca['nome'];
				}
			}
			$lista .= '<tr data-item="'.$carro['id'].'"><td data-edit="false">'.$carro['id'].'</td><td data-edit="modelo">'.$carro['modelo'].'</td><td data-edit="ano">'.$carro['ano'].'</td><td data-edit="marca" data-select="'.$carro['marca'].'">'.$nomeMarca.'</td><td><button type="button" onclick="editarItem('.$carro['id'].')" class="button button-3d button-blue button-mini" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
		}
		
		return $lista;
	}

}