<?php

class Car {
	
	private $dbh;

	public function __construct($host,$user,$pass,$db)	{		
		$this->dbh = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);		
	}

	public function getCars(){				
		$sth = $this->dbh->prepare("SELECT * FROM cars");
		$sth->execute();
		return json_encode($sth->fetchAll());
	}

	public function add($car){	
		$sth = $this->dbh->prepare("INSERT INTO cars(marca, modelo, ano) VALUES (?, ?, ?)");

		$sth->execute(array($car->marca, $car->modelo, $car->ano));		
		return json_encode($this->dbh->lastInsertId());
	}
	
	public function delete($car){	
		$sth = $this->dbh->prepare("DELETE FROM cars WHERE id=?");
		$sth->execute(array($car->id));
		return json_encode(1);

	}
	
	public function updateValue($car){		
		$sth = $this->dbh->prepare("UPDATE cars SET ". $car->field ."=? WHERE id=?");
		$sth->execute(array($car->newvalue, $car->id));				
		return json_encode(1);	
	}
}
?>