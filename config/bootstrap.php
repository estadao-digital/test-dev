<?php 

require 'router.php';

//Global variables
class GLOBAL_CLASS{
    public static $api = 'http://localhost/document_root/api/';
    public static $www = 'http://localhost/document_root/';
}

//require all controllers
$controllers = glob('../controllers/*.php');
foreach ($controllers as $file) {
    require_once($file);   
}
