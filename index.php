<?php

$loader = require __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

use Entities\Cars;
use Models\CarsDAO;

$car = new Cars(null,"BMW","X5","2018");
$carDAO = new CarsDAO();

$carDAO->insert($car);


