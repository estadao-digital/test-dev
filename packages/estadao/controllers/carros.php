<?php
class carros extends controller {
	function __call($name, $args) {
		
		if ( ! method_exists($this, $name)) {
			debug::log("chamando  $this->requestType valor $name ");
			$this->{strtolower ( $this->requestType )} ( $name );
		}
	}
	function index() {
		if ($this->requestType == 'POST') {
			$m = new carroModel ();
			$m->setmarca ( $this->request ['marca'] );
			$m->setmodelo ( $this->request ['modelo'] );
			$m->setcor ( $this->request ['cor'] );
			$m->setplaca ( $this->request ['placa'] );
			$m->setano ( $this->request ['ano'] );
			$m->setativo ( 1 );
			$id = $m->save ();
			unset ( $m );
			header ( 'HTTP/1.1 201 Created' );
			page::addBody ( json_encode ( array (
					'message' => $id 
			) ) );
			page::renderAjax ();
		}
		if ($this->requestType == 'GET') {
			$m = new carroModel ();
			header ( 'HTTP/1.1 200 Ok' );
			if (count ( $m->listcarro () )) {
				page::addBody ( json_encode ( array("values" => $m->listcarro ())) );
			} else {
				page::addBody ( json_encode ( array () ) );
			}
			page::renderAjax ();
		}
	}
	function get($idcarro) {
		$m = new carroModel ();
		$m->setidcarro ( $idcarro );
		page::addBody ( json_encode ( array("values" => $m->listcarro () )) );
		header ( 'HTTP/1.1 200 Ok' );
		page::renderAjax ();
	}
	function put($idcarro) {
	    debug::log('***********************************************************');
	    debug::log($_GET);
	    debug::log('***********************************************************');
		$m = new carroModel ();
		$m->setidcarro ( $idcarro );
		$m->setmarca ( $this->request ['marca'] );
		$m->setmodelo ( $this->request ['modelo'] );
		$m->setcor ( $this->request ['cor'] );
		$m->setplaca ( $this->request ['placa'] );
		$m->setano ( $this->request ['ano'] );
		$m->setativo ( 1 );
		$m->save ();
		header ( 'HTTP/1.1 200 Ok' );
		page::addBody ( json_encode ( array (
				'message' => 'ok' 
		) ) );
		page::renderAjax ();
	}
	function delete($idcarro) {
		$m = new carroModel ();
		$m->setidcarro ( $idcarro );
		$m->setativo ( 0 );
		$m->save ();
		header ( 'HTTP/1.1 200 Ok' );
		page::addBody ( json_encode ( array (
				'message' => 'ok' 
		) ) );
		page::renderAjax ();
	}
	
	function app() {
		$v = new carrosView();
		
	}
}