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

class profile extends controller {

    function index() {
        $m = new profileModel();
        $v = new profileView();
        $v->listaGroups($m->listGroups());
    }

    function groupProfile() {
        $m = new profileModel();
        $v = new profileView();
        $v->groupProfile($m->listprofile($this->request['idgroup']));
    }

    function newProfile() {
        $v = new profileView();
        $m = new profileModel();
        $v->newProfile($m->listGroups());
    }

    function saveProfile() {

        $m = new profileModel();
        $m->setname($this->request['profileName']);
        $m->setenable(1);

        $m->setIdGroup($this->request['idgroup']);
        $m->save();
        $this->groupProfile();
    }

    private function profileName($idprofile) {
        $sys = new auth();
        $sys->profile->load($idprofile);
        return $sys->profile->getname();
    }

    function listUsers() {
        $v = new usersView();
        $m = new profileModel();
        $list = $m->listUsersProfile($this->request['idprofile']);
        $i = 0;
        if ( count($list)) {
        foreach ($list['users_idusers'] as $iduser) {
        	$sys = new auth();
        	$sys->users->load($iduser);
        	$list['iduser'][$i] = $iduser;
        	$list['login'][$i] = $sys->users->getlogin();
        	$list['username'][$i] = $sys->users->getuserName();
        	$list['profile'][$i] = $this->profileName($this->request['idprofile']);
        	$list['datacreate'][$i] = $sys->users->getdataCreate();
        	$list['datemodify'][$i] = $sys->users->getdateModify();
            $i++;
        }
        }
        unset($list['idProfile']);
        $v->listUsers($list);
    }

    function delProfile() {
        $m = new profileModel();
        $list = $m->listUsersProfile($this->request['idprofile']);
        if ( count($list['users_idusers']) == 0 ) {
            $mdel = new profileModel();
            debug::log("RECEBUI ORDEM APAGAR " . $this->request['idprofile']);
            $mdel->deleteProfile($this->request['idprofile']);
             $this->index();
        }else{
            page::addBody("<p>User profile has user, remove users first</p>");
            $this->index();
        }
    }

}
