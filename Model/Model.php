<?php
class Model {

public function __construct(){
$this->usuario = 'bf00fc7e826f36';
$this->senha ='f5f495c1';
$this->host = 'us-cdbr-iron-east-05.cleardb.net';
}
public function query($sintexe,$campos){
    try {
    $connection = new PDO("mysql:host=$this->host;dbname=heroku_59fa39afa14a72d", $this->usuario, $this->senha);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connection->prepare($sintexe)->execute($campos);
    }catch(PDOException $e){
     return "Falha na conexão:".$e->getMessage();   
    }
    return 'oi';

}
}
?>
