<?php



		 $mysqli = new mysqli('127.0.0.1', 'root', '', 'carros_cadastrados');


		if ($mysqli->connect_error) {
		    die('Connect Error (' . $mysqli->connect_errno . ') '
		            . $mysqli->connect_error);
		}
		//echo '<p>Conneção realizada '. $mysqli->host_info.'</p>';
		//echo '<p>Server '.$mysqli->server_info.'</p>';

//echo json_encode( '<p>Conneção realizada '. $mysqli->host_info.'</p>')
?>