<?php
require 'environment.php';

$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/test-dev/");
	$config['dbname'] = 'teste-dev';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	define("BASE_URL", "http://localhost/test-dev/");
	$config['dbname'] = 'teste-dev';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
}

global $db;
try {
	$db = new PDO("mysql:dbname=".$config['dbname'].";charset=utf8;host=".$config['host'], $config['dbuser'], $config['dbpass']."");
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}