<?php
/**
* Classe do carro
*/

class Carro{
	public $id; 
	public $marca; 
	public $modelo; 
	public $ano; 
	
	public function listar(){
		$conexao = mysql_pconnect("localhost","root","") or die($msg[0]); 
		mysql_select_db("teste",$conexao) or die($msg[1]);
		$query = "SELECT * FROM adinan_carros"; 
		$resultado = mysql_query($query,$conexao); 
		echo "<table border='1'>";
		while ($linha = mysql_fetch_array($resultado)) {
			echo '<tr><td>'.$linha['car_ID'].'</td>'.
				'<td>'.$linha['car_MARCA'].'</td>'.
				'<td>'.$linha['car_MODELO'].'</td>'.
				'<td>'.$linha['car_ANO'].'</td>'.
				'<td><a href="javascript:void(0)" onclick="edit('.$linha['car_ID'].');">editar</a></td>'.
				'<td><a href="javascript:void(0)" onclick="del('.$linha['car_ID'].');">remover</a></td>'
				.'</tr>';
		}
		echo "</table>";
	}
	
	public function form($id){
		$conexao = mysql_pconnect("localhost","root","") or die($msg[0]); 
		mysql_select_db("teste",$conexao) or die($msg[1]);
		$query = "SELECT * FROM adinan_carros WHERE car_ID = ".$id; 
		$resultado = mysql_query($query,$conexao); 
		echo "<form id='form'><table border='1'>";
		while ($linha = mysql_fetch_array($resultado)) {
			echo '<tr><td>'.$linha['car_ID'].'</td>'.
				'<td><input type="text" id="carmar" value="'.$linha['car_MARCA'].'"></td>'.
				'<td><input type="text" id="carmod" value="'.$linha['car_MODELO'].'"></td>'.
				'<td><input type="text" id="carano" value="'.$linha['car_ANO'].'"></td>'.
				'<td><a href="javascript:void(0)" onclick="save('.$linha['car_ID'].',document.forms[0].elements[0],document.forms[0].elements[1],document.forms[0].elements[2]);">salvar</a></td>'
				.'</tr>';
		}
		echo "</table></form>";
	}
	
	public function atualizar($id,$marca,$modelo,$ano){ 
		$conexao = mysql_pconnect("localhost","root","") or die($msg[0]); 
		mysql_select_db("teste",$conexao) or die($msg[1]);
		$query = "UPDATE adinan_carros SET car_MARCA='$marca',car_MODELO='$modelo',car_ANO='$ano', WHERE car_ID = ".$id; 
		$resultado = mysql_query($query,$conexao); 
		echo "Carro ".$marca." atualizado!"; 
	}
}
?>