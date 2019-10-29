<?php
namespace Models;
require_once 'Icarro.php';
require_once 'Model.php';


class Carro extends Model implements Icarro{
public function __construct(){
     parent::__construct();
     $this->tabela();
}
public function index(){
$query = 'SELECT * FROM USUARIO';
return $this->select($query,[]);
}
public function tabela(){
     $tabela ='CREATE TABLE IF NOT EXISTS USUARIO(
          id int  UNSIGNED AUTO_INCREMENT PRIMARY KEY,
           marca VARCHAR(50),
           modelo varchar(50),
           ano  varchar(5)
       )';
     return $this->create_table($tabela,[]);
}
public function show($id){
     $query = 'SELECT * FROM USUARIO Where id ='.$id;
     return $this->select($query,[]);
}
public function create($modelo,$marca,$ano){
$query='INSERT INTO USUARIO(MODELO,MARCA,ANO)VALUES('."'".$modelo."','".$marca."','".$ano."')";
return $this->query($query,[],1);
}
public function update($modelo,$marca,$ano,$id){
     $query='UPDATE  USUARIO SET modelo='."'".$modelo."',marca='".$marca."',ano='".$ano."' WHERE id=".$id;
      return $this->query($query,[],2);
}
public function destroy($id){
     $query='DELETE FROM USUARIO WHERE id ='.$id;
     return $this->query($query,[],3);
}
}
?>