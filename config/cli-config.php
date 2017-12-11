<?php
/**
 * Created by PhpStorm.
 * Agency: OnFour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 24/05/2017
 */

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Registry\Registry;

include "config-entity.php";

$entityManager = registry::resolve("entityManager");

return ConsoleRunner::createHelperSet($entityManager);