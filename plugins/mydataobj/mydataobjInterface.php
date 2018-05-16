<?php

interface mydataobjInterface {
    
    function addkey($key,$values);
    function addorder($key);
    function connect($dbServer='mysql',$hostOfFilename, $port, $db,$user,$pass);
    function delete();
    function delkey($key);
    function next($result='');
    function query($query);
    function reset();
    function save();
    function setconn($connection);
    function settable($table);
    
}