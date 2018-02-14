<?php 
require '../api/config/database.php';

$host = \DATABASE_CONFIG::$default['host'];
$database = \DATABASE_CONFIG::$default['database'];
$login = \DATABASE_CONFIG::$default['login'];
$password = \DATABASE_CONFIG::$default['password'];

$db = new \PDO('mysql:host='.$host, $login, $password); //connect
$db->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION ); // enable errors to PDO

$sql = "CREATE DATABASE IF NOT EXISTS $database;";
$query = $db->prepare($sql);
if($query->execute()) {
    $sql = "CREATE TABLE IF NOT EXISTS $database.`cars` (
        `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `brand_name` varchar(45) COLLATE utf8_bin NOT NULL,
        `model` varchar(100) COLLATE utf8_bin NOT NULL,
        `year` int(11) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
    $query = $db->prepare($sql);
    if($query->execute()) echo 'Banco de dados criado';
    else echo 'Erro ao criar o banco de dados';
} else echo 'Erro ao criar o banco de dados';

