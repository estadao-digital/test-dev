<?php

    $username='root';
    $password='';
    $host='localhost';
    $database='carrosdb';

    $con = new PDO("mysql:host=".$host.";dbname=".$database, $username, $password);

?>