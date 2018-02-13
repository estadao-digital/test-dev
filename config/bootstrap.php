<?php 

require 'router.php';

$controllers = glob('../controllers/*.php');
foreach ($controllers as $file) {
    require_once($file);   
}