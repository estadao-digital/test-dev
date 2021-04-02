<?php
/**
 * @author      Anderson de Souza <anderson17ads@hotmail.com.br>
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

require __DIR__ . '/../vendor/autoload.php';

use App\Core\App;
use App\Core\Router;
use App\Core\Request;

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$router = new Router(new Request);
$app = new App($router);