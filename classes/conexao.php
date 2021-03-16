<?php
  class Mysql{
    private $host    = '172.20.0.2';
    private $usuario = 'root';
    private $passwd  = 'SliceIT';
    private $bd      = 'SLICEIT';
    function ConectaMysql(){
      $conn = mysqli_connect("$this->host", "$this->usuario", "$this->passwd", "$this->bd");
      $conn->set_charset("utf8");
      if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        return $conn;
    }
  }


 ?>
