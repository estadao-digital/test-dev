<?php
require_once "dbInterface.php";
class DB implements DBInterface{
    private $servername;
    private $username;
    private $dbname;
    private $password;    
    var $mysqli;
    public function __construct($servername='localhost',$username='root', $password='', $dbname='employ'){
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->servername =  $servername;
        $this->connectDB();
    }
    public function connectDB() {
        $this->mysqli =  mysqli_connect($this->servername,$this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());
    }
    public function runSQL($sql) {
        $this->result = $this->mysqli->query($sql);
        return $this->result;
    }
    public function qry($dados) {
        $this->newRow = array();
        while($row = $this->mysqli->fetch_array($dados)) {
            array_push($this->newRow,$this->row);
        }
        return $this->newRow;
    }
    public function closeDB() {
        $this->mysqli->close();
    }    
}
