<?php

function pegarDataHoraAtual(){
    return date("Y-m-d H:i:s");
}

function pegarDataAtual(){
    return date("Y-m-d");
}

function somarData($dias){
    return date('Y-m-d', strtotime("+".$dias." days",strtotime(date("Y-m-d"))));
}
