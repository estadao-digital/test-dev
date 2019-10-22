<?php

namespace Model;

class Carro extends Model{

public function index(){

}
public function create_table(){
     $tabela = file_get_contents( "car.sql" );
     return $this->query($tabela,[])
}
public function show(){

    }
public function create(){

        }
public function update(){

            }
public function destroy(){

}
}
?>