<?php
/**
 * Classe do carro
 */
//action.php
include('Api.php');

$api_object = new API();

if (isset($_POST['action'])) {
    
    if ($_POST['action'] == 'insert') {
        $data = $api_object->insert();
    }
    
    if ($_POST["action"] == 'fetch_single') {
        $data = $api_object->fetch_single($_POST["id"]);
    }
    if ($_POST["action"] == 'update') {
        $data = $api_object->update();
    }
    
    if ($_POST["action"] == 'delete') {
        $data = $api_object->delete($_POST["id"]);
    }
}

?> 