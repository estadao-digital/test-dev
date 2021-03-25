<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\App;

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$app = new App;