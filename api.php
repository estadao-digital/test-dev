<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8"); 

//===============================================
$parramUrl = explode('/', $_SERVER['REQUEST_URI']);
$parram = $parramUrl[2];
$loc1 = $parramUrl[1];

//echo $loc1;

$method = $_SERVER['REQUEST_METHOD'];
$contents = file_get_contents('db.json');
$json = json_decode($contents, true);
$body = file_get_contents('php://input');

//===============================================
if($method === 'POST'){
    $jsonBody = json_decode($body, true);
    $lastId = end($json[$loc1]);
    $jsonBody['id'] = $lastId['id']+1;
    $json[$loc1][] = $jsonBody;
    file_put_contents('db.json', json_encode($json));
    echo true;
}

//===============================================
if($method === 'GET'){
    if($parram){
        $jsonGetSingle = json_decode($contents, true);
        $check = false;
        foreach($jsonGetSingle[$loc1] as $key => $obj){
            if($obj['id'] == $parram){
                $check = true;
                echo json_encode($jsonGetSingle[$loc1][$key]);
                break;
            }
        }
        if($check == false){ echo 'Nada encontrado'; }
    } else {
        $contents = json_decode($contents, true);
        echo json_encode($contents[$loc1]);
    }
}

//===============================================
if($method === 'PUT'){
    $item = false;
    foreach($json[$loc1] as $key => $value){
        if($value['id'] == $parram){
            $item = $key;
            break;
        }
    }
    $jsonBody = json_decode($body, true);
    $jsonBody['id'] = $parram;
    $json[$loc1][$item] = $jsonBody;
    file_put_contents('db.json', json_encode($json));
    echo true;
}

//===============================================
if($method === 'DELETE'){
    $item = false;
    foreach($json[$loc1] as $key => $value){
        if($value['id'] == $parram){
            $item = $key;
            break;
        }
    }
    unset($json[$loc1][$item]);
    //$json[$loc1] = array_values($json[$loc1]);
    file_put_contents('db.json', json_encode($json));
    echo true;
}