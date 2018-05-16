<?php
/*
 *  Copyright (C) 2016 vagner    
 * 
 *    This file is part of Kolibri.
 *
 *    Kolibri is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    Kolibri is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with Kolibri.  If not, see <http://www.gnu.org/licenses/>. 
 */


class htmlTable {

    private $tableClass;
    private $lineClass;
    public $id;

    function settableClass($class) {
        $this->tableClass = $class;
    }

    function setlineClass($class) {
        $this->lineClass = $class;
    }
    
    function setid($id) {
    	$this->id = $id;
    }

        
    function loadTable($table) {
    	
    	if ( strlen($this->id) == 0 ) {
    		$this->id = 'tbl' . rand(1000,9999);
    	}
    	
    	if (  strlen($this->tableClass) == 0 ) {
    		$this->settableClass('table');
    	}
    	
        if ($this->tableClass) {
            $out = "<table id='" . $this->id . "' class='" . $this->tableClass . "'>\n";
        } else {
            $out = "<table>\n";
        }
        if ($this->lineClass) {
            $out .= "<tr class" . $this->lineClass . ">\n";
        } else {
            $out . "<tr>\n";
        }
        $x = 0;
        $y = 0;
        if (is_array($table)) {
        $out .= "<thead>";
        foreach ($table as $key => $value) {

            $out .= "<th>$key</th>";
            $keys [] = $key;

            if (is_array($value)) {
                foreach ($value as $line) {
                    $aux [$x] [$y] = $line;
                    $x ++;
                }
            }
            $y ++;
            $x = 0;
        }
        }
        $out .= "</tr>";
        $out .= "</thead>";
        $out .= "<tbody>";
        if (is_array($aux)) {
            foreach ($aux as $col) {
                if ($this->lineClass) {
                    $out .= "<tr class" . $this->lineClass . ">\n";
                } else {
                    $out . "<tr>\n";
                }

                foreach ($col as $line) {
                    $out .= "<td>$line</td>\n";
                }
                $out .= "</tr>\n";
            }
        }
        $out .= "</tbody>";
        $out .= "</table>";
        return $out;
    }

}
