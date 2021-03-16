<?php
  include '../classes/conexao.php';
  include '../classes/carro.php';
  $c1 = new Mysql();
  $c2 = new Carros(NULL,NULL, NULL,NULL, $c1->ConectaMysql());
  echo $c2->getMarcas();
?>
