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

class group extends controller {

    function index() {
        $m = new groupModel();
        $v = new groupView();
        $lst = $m->listGroup();
        $i=0;
        foreach ( $lst['idgroup'] as $id ) {
        	
        	$lst['users'][$i] = $m->numUser($id);
        	$i++;
        }
        $v->listGroups($lst);
    }

    function newGroup() {

        $v = new groupView();
        $v->newGroup();
    }

    function saveGroup() {
    	debug::log("GRUPO " . $this->request['groupName']);
    	
        $m = new groupModel();
        $m->setenable(1);
        $m->setname($this->request['groupName']);
        $m->save();
        $this->index();
    }

    function delGroup() {
        $m = new groupModel($this->request['idgroup']);
        $v = new groupView();
        
        if ($m->numUser($this->request['idgroup']) < 1) {
            
            $m->setenable('0');
            $m->save();
            $this->index();
        }else{
            page::addBody("Remove users from group before delete");
             $this->index();
        }
    }

}
