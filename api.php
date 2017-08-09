<?php
include_once 'Carro.class.php';
$path = 'database.json';

if (!empty($_REQUEST['method'])) {
    $method = $_REQUEST['method'];
}

if (!empty($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
}

if (!empty($_REQUEST['marca'])) {
    $marca = $_REQUEST['marca'];
}

if (!empty($_REQUEST['modelo'])) {
    $modelo = $_REQUEST['modelo'];
}

if (!empty($_REQUEST['ano'])) {
    $ano = $_REQUEST['ano'];
}

switch ($method) {

    case 'create':
        $db = array();
        $db['carros'] = array();

        if (file_exists($GLOBALS['path'])) {
            $fileContents = file_get_contents($GLOBALS['path']);
            $db = json_decode($fileContents, true);
        }

        $carro = new Carro(count($db['carros']) + 1, $marca, $modelo, $ano);
        array_push($db['carros'], $carro);

        $file = fopen($GLOBALS['path'],'w');
        fwrite($file, json_encode($db, JSON_PRETTY_PRINT));
        fclose($file);
        break;


    case 'read-all':
        if (!file_exists($GLOBALS['path'])) {
            $db = array();
            $db['carros'] = array();

            $file = fopen($GLOBALS['path'],'w');
            fwrite($file, json_encode($db, JSON_PRETTY_PRINT));
            fclose($file);
        }

        echo file_get_contents($GLOBALS['path']);
        break;


    case 'read':
        if (file_exists($GLOBALS['path'])) {
            $fileContents = file_get_contents($GLOBALS['path']);
            $db = json_decode($fileContents, true);

            foreach ($db['carros'] as $carro) {
                if ($carro['id'] == $id) {
                    return $carro;
                }
            }
        }
        break;


    case 'update':
        if (file_exists($GLOBALS['path'])) {
            $fileContents = file_get_contents($GLOBALS['path']);
            $db = json_decode($fileContents, true);

            $updated_db = array();
            $updated_db['carros'] = array();

            foreach ($db['carros'] as $carro) {
                if ($carro['id'] == $id) {
                    $carro['id'] = $id;
                    $carro['marca'] = $marca;
                    $carro['modelo'] = $modelo;
                    $carro['ano'] = $ano;
                }

                array_push($updated_db['carros'], $carro);
            }

            $file = fopen($GLOBALS['path'],'w');
            fwrite($file, json_encode($updated_db, JSON_PRETTY_PRINT));
            fclose($file);
        }
        break;


    case 'delete':
        if (file_exists($GLOBALS['path'])) {
            $fileContents = file_get_contents($GLOBALS['path']);
            $db = json_decode($fileContents, true);

            $updated_db = array();
            $updated_db['carros'] = array();

            foreach ($db['carros'] as $carro) {
                if ($carro['id'] != $id) {
                    $carro['id'] = count($updated_db['carros']);
                    array_push($updated_db['carros'], $carro);
                }
            }

            $file = fopen($GLOBALS['path'],'w');
            fwrite($file, json_encode($updated_db, JSON_PRETTY_PRINT));
            fclose($file);
        }
        break;
}

?>
