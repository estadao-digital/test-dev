<?php
/**
 * Created by PhpStorm.
 * Agency: onfour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 08/12/17
 */

include 'vendor/autoload.php';
include 'config/config-entity.php';

use Application\Controller\IndexController;

$index = new IndexController($_GET['p']);
$index->render();