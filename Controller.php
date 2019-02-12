<?php
function __autoload($className){
	include_once("models/$className.php");
}

$cars = new Car("localhost","root","","car");

if(!isset($_POST['action'])) {
	print json_encode(0);
	return;
}

switch($_POST['action']) {
	case 'get_cars':
		print $cars->getCars();		
	break;
	
	case 'add_car':
		$car = new stdClass;
		$car = json_decode($_POST['car']);
		print $cars->add($car);		
	break;
	
	case 'delete_car':
		$car = new stdClass;
		$car = json_decode($_POST['car']);
		print $cars->delete($car);		
	break;
	
	case 'update_field_data':
		$car = new stdClass;
		$car = json_decode($_POST['car']);
		print $cars->updateValue($car);				
	break;
}

exit();