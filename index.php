<?php
include_once('Api.php'); 
$objCarros = new API();
$url = 'http://localhost:3000/carros'; 

$objCarros->getRequest($url);
?>