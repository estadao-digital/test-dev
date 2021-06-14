<?php
interface DBInterface {
    public function connectDB();
    public function closeDB();
    public function runSQL($sql);
    public function qry($dados);
}



?>