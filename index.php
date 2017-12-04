<?php
session_start();
require 'config.php';


spl_autoload_register(function ($class) {
    require_once(str_replace('\\', '/', $class . '.php'));
});

use core\Core;
$core = new Core();
$core->run();

?>