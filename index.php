<?php
define("__PATH_ROOT__",__DIR__);
require  __DIR__."/configs/db.php";
require  __DIR__."/configs/main.php";
require_once __DIR__."/vendor/autoload.php";
use Routes\Routes;
new Routes();
