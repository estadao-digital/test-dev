<?php


// mysqli_connect("db", "root", "root") or die(mysqli_error());
// echo "Connected to MySQL<br />";


// $pdo = new PDO("mysql:host=db;dbname=base", 'root', 'root', );

// // //Execute a "SHOW DATABASES" SQL query.
// $stmt = $pdo->query('SHOW TABLES');

// // //Fetch the columns from the returned PDOStatement
// $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);

// var_dump($databases); die();

require_once __DIR__ . '/vendor/autoload.php';

function dd($var){
    echo '<pre>';
    var_dump($var);
    die();
}

require_once 'router.php';