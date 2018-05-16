<?php

/*
 * Copyright (C) 2016 vagner
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
$path = realpath(dirname(__FILE__));



if (count($argv) > 1) {
	require_once ($path . '/../plugins/debug/debug.php');
	require_once ($path . '/../lib/database.php');
    require_once ($path . '/../lib/functions.php');
    require_once ($path . '/../lib/register.php');
    require_once ($path . '/../lib/security.php');
    require_once ($path . '/../lib/mvcMain.php');
    require_once ($path . "/../config/config.php");
    require_once ($path . "/../config/databases.php");
    require_once ($path . "/../plugins/mydataobj/mydataobj.php");
    
    $conection = $argv[1];
    $table = $argv[2];
    
    
    $db = new mydataobj();
    $db->setconn(database::$conection());
    $sql = "explain $table";
    $db->query($sql);
    $db->debug(1);
    $i = 0;
    while ( $db->getField()) {
        $fields[$i] = $db->getField();
        $types[$i] = $db->getType();
        $keys[$i] = $db->getKey();
        $db->next();
        $i++;
    }
    
    $code = "<?php\n\n";
    $code .='/*
 * Copyright (C) 2016 Vagner Rodrigues
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */';
    $code .= "\n\n\n class $table" . "Model {\n\n";
    
    foreach ($fields as  $f ) {
        $code .= "private $" . $f  . ";\n";
    }
    
    foreach ($fields as  $f ) {
        $code .= "function set" . $f  . '($value) {'  . "\n";
        $code .= '$this->' . $f . '= $value;' . "\n";
        $code .= "}\n\n";
        
        $code .= "function get" . $f  . '() {'  . "\n";
        $code .= 'return $this->' . $f . ';' . "\n";
        $code .= "}\n\n";
    }
    
    
    $code .= ' function list' . $table . '() {
        $db = new mydataobj ();
        $db->setconn(database::'. $conection .'());
        $db->settable("' . $table .  '");
        //$db->addkey("ativo", 1);
        $i = 0;';
    
    $i=0;
    foreach ( $keys as $key ) {
       if ( $key == "PRI" ) {
           $myKey = $fields[$i];
       }
    }
    
    $code .= ' while ($db->get' . $myKey . '()) {' . "\n";
    
    foreach ($fields as  $f ) {
        $code .= '$out[\'' . $f  . '\'][$i] = $db->get' .  $f  .  '();' . "\n";
    }
    
    $code .= ' $db->next();
            $i++;
        }
        return $out;
    }';
    
    $code .= 'function load($' . $myKey  . ') {
        $db = new mydataobj ();
        $db->setconn(database::' . $conection  . '());
        //$db->debug(1);
        $db->settable("' . $table  . '");
        //$db->addkey("ativo", 1);
        $db->addkey("' . $myKey  . '", $' . $myKey  . ');' . "\n";
    
     foreach ($fields as  $f ) {
        $code .= '$this->set' . $f  .  '($db->get' . $f . '());' . "\n";
    }
    
    $code .="}\n";
    
    $code .=  ' function save() {
        $db = new mydataobj ();
        $db->setconn(database::' . $conection  . '());
        $db->settable("' . $table  . '");
        //$db->debug(1);
          if ($this->' . $myKey  . ') {
            $db->addkey("' . $myKey  . '", $this->' . $myKey  . ');
        }' . "\n";
    
     foreach ($fields as  $f ) {
        $code .= '$db->set' . $f  .  '($this->get' . $f . '());' . "\n";
    }
    
    $code .= '$db->save();
        return $db->getlastinsertid();
    }

}' . "\n";
    
    $handle = fopen($table . "Model.php", "wb");
    fwrite($handle, $code);
    fclose($handle);
    //printf($code);
}