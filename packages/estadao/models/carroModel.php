<?php


class carroModel {
	private $idcarro;
	private $marca;
	private $modelo;
	private $ano;
	private $cor;
	private $placa;
	private $ativo;
	function setidcarro($value) {
		$this->idcarro = $value;
	}
	function getidcarro() {
		return $this->idcarro;
	}
	function setmarca($value) {
		$this->marca = $value;
	}
	function getmarca() {
		return $this->marca;
	}
	function setmodelo($value) {
		$this->modelo = $value;
	}
	function getmodelo() {
		return $this->modelo;
	}
	function setano($value) {
		$this->ano = $value;
	}
	function getano() {
		return $this->ano;
	}
	function setcor($value) {
		$this->cor = $value;
	}
	function getcor() {
		return $this->cor;
	}
	function setplaca($value) {
		$this->placa = $value;
	}
	function getplaca() {
		return $this->placa;
	}
	function setativo($value) {
		$this->ativo = $value;
	}
	function getativo() {
		return $this->ativo;
	}
	function listcarro() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "carro" );
		if ( $this->idcarro) {
			$db->addkey('idcarro', $this->idcarro);
		}
		$db->addkey("ativo", 1);
		$i = 0;
		while ( $db->getidcarro () ) {
			$out ['idcarro'] [$i] = $db->getidcarro ();
			$out ['marca'] [$i] = $db->getmarca ();
			$out ['modelo'] [$i] = $db->getmodelo ();
			$out ['ano'] [$i] = $db->getano ();
			$out ['cor'] [$i] = $db->getcor ();
			$out ['placa'] [$i] = $db->getplaca ();
			$out ['ativo'] [$i] = $db->getativo ();
			$db->next ();
			$i ++;
		}
		return $out;
	}
	function load($idcarro) {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		// $db->debug(1);
		$db->settable ( "carro" );
		// $db->addkey("ativo", 1);
		$db->addkey ( "idcarro", $idcarro );
		$this->setidcarro ( $db->getidcarro () );
		$this->setmarca ( $db->getmarca () );
		$this->setmodelo ( $db->getmodelo () );
		$this->setano ( $db->getano () );
		$this->setcor ( $db->getcor () );
		$this->setplaca ( $db->getplaca () );
		$this->setativo ( $db->getativo () );
	}
	function save() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "carro" );
		$db->debug(1);
		if ($this->idcarro) {
			$db->addkey ( "idcarro", $this->idcarro );
		}
		$db->setidcarro ( $this->getidcarro () );
		$db->setmarca ( $this->getmarca () );
		$db->setmodelo ( $this->getmodelo () );
		$db->setano ( $this->getano () );
		$db->setcor ( $this->getcor () );
		$db->setplaca ( $this->getplaca () );
		$db->setativo ( $this->getativo () );
		$db->save ();
		return $db->getlastinsertid ();
	}
	function delete($idcarro) {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "carro" );
		$db->addkey ( "idcarro", $idcarro);
		$db->setativo('0');
		$db->save();
	}
}
