<?php


class Carro extends Model implements Icarro{

public function index(){

}
public function create_table(){
     $tabela = file_get_contents( "car.sql" );
     return $this->query($tabela,[]);
}
public function show($id){

}
public function create(){

}
public function update($id){

}
public function destroy($id){

}
}
?>