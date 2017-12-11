<?php
/**
 * Created by PhpStorm.
 * Agency: onfour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 11/12/17
 */


include '../../../../vendor/autoload.php';
require('../../../../config/config-entity.php');
require('../../../../module/Application/src/Model/Module.php');
require('../../../../module/Vehicle/src/Model/VehicleModel.php');

use Registry\Registry;
use Vehicle\VehicleModel\VehicleModel;

$vehicle = new VehicleModel();
$vehicle->deleteVehicle($_GET['id']);