<?php
error_reporting(E_ALL);
//error_reporting(E_ERROR | E_PARSE); 
require 'environment.php';

global $config;
$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE", "http://test.elderxavier.com.br/");
        define("DBFILE", $_SERVER['DOCUMENT_ROOT']."/db/db.json");
} else {	
	define("BASE", "http://test.elderxavier.com.br/");
        define("DBFILE", $_SERVER['DOCUMENT_ROOT']."/db/db.json");
}

