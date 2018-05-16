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


class groupModel {

    private $idgroup;
    private $name;
    private $enable;

   function __construct($idgroup = '') {
       $sys = new auth();
       $sys->group->load($idgroup);
       $this->idgroup =$sys->group->getidgroup();
       $this->name =$sys->group->getname();
       $this->enable = 1;
    }

    function save() {
        $sys = new auth();
         if ( $this->idgroup ) {
         	$sys->group->setidgroup($this->idgroup);
         }
         $sys->group->setname($this->name);
         $sys->group->setenable($this->enable);
         $sys->group->save();
    }

    function listGroup() {
        $sys = new auth();
        return $sys->group->listgroups();
    }

    function setname($name) {
        $this->name = $name;
    }

    function setenable($enable) {
        if ($enable) {
            $this->enable = 1;
        } else {
            $this->enable = 0;
        }
    }

    function getname() {
        return $this->name;
    }

    function getenable() {
        return $this->enable;
    }

    function numUser($idgroup) {
        $sys = new auth();
        
        $myArray = $sys->groupsprofiles->listMembersGroup($idgroup);
        debug::log($myArray);
        debug::log("Total " . count($myArray['iduser']));
        return count($myArray['iduser']);
    }

}
