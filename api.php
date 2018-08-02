<?php
class EnviaDados{


public function listaDados(){

    $recebe_json = file_get_contents('teste.json');

    $teste = json_decode($recebe_json,true);

    return $teste;

}

}