<?php
include('conn.php');

$modelo = $_POST['modelo'];
$marca = $_POST['marca'];
$ano = $_POST['ano'];



$query = mysql_query("INSERT INTO carros (modelo, marca, ano) VALUES ('$modelo', '$marca', '$ano')");

?>