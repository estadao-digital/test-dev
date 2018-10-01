<?php
/**
* Classe do carro
*/

require ('conexao.php');


class ConsultasMysql{


public $marca;
public $modelo;
public $ano;

	public function SelectQuery($marca,$modelo,$ano){
			 $sql = "SELECT Id,Marca, Modelo, Ano FROM carros_cadastrados.carros";
		if($nome != '' or $idade != '' or $games != '')
			$sql .= " where Marca = '$marca' or Modelo = '$modelo' or Ano = '$ano' ";

		return  $sql;
	}

	public function InsertQuery($marca,$modelo,$ano){
		 	$sql2 = "INSERT INTO carros_cadastrados.carros (Marca,idade,Games) values  ('$marca','$modelo','$ano')";
		 return $sql2;

	}

	public function Updatequery($coluna,$valor,$id){
			$sql3 = "UPDATE carros_cadastrados.carros set $coluna = '$valor' where indice = '$id'";
			return $sql3;
	}
	//$mysqli->close();

}
?>