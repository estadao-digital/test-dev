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


class usersView {

    function newUser() {
        $form = new formEasy();
        $form->openForm();
        $form->addText("Name", 'nome', '', 1);
        $form->addText("E-mail ", 'login', '', 1);
        $form->addText("Organizartion ", 'group', '', 1);
        $form->addPasswordCad('Password', 'senha', '', 1);
        $form->addcapcha();
        $form->type('submit')->value('Save')->done();
        page::addBody($form->printform());
        page::render();
    }

    function listaGroups($groupArray) {
        $table = new htmlTable();
        page::addBody("<h3>Users Manager</h3>");
        $tbl['Groups'] = $groupArray['name'];
        $i = 0;
        $form = new formEasy();
        foreach ($groupArray['idgroup'] as $ids) {
            //$tbl['Controle'][$i] = "<form method='post' action='::siteroot::/index.php/users/listUser/'> <input type='hidden' name='idgroup' value='$ids'><input type='submit' value= 'Users'> </form>";
            $tbl['Control'][$i] = $form->formActionButton('::siteroot::/index.php/users/listUser/', 'Users',array('idgroup'=>$ids));
            $i++;
        }
        page::addBody($table->loadTable($tbl));
        page::render();
    }

    function listUsers($userArray) {
        $table = new htmlTable();
        page::addBody("<h3>Users Manager</h3>");
        $tbl['Login'] = $userArray['login'];
        $tbl['Name'] = $userArray['username'];
        $tbl['Profile'] = $userArray['profile'];
        $tbl['Created'] = $userArray['datacreate'];
        $tbl['Modified'] = $userArray['datemodify'];
        $i = 0;
        $form = new formEasy();
        if (is_array($userArray)) {
            foreach ($userArray['iduser'] as $ids) {
                //$tbl['Controle'][$i] = "<form method='post' action='::siteroot::/index.php/users/userEdit/'> <input type='hidden' name='iduser' value='$ids'><input type='submit' value= 'Edit'> </form>";
                $tbl['App tokens'][$i] = $form->formActionButton('::siteroot::/index.php/apptokens/index/', 'App tokens',array('iduser'=>$ids));
                $tbl['Control'][$i] = $form->formActionButton('::siteroot::/index.php/users/userEdit/', 'Edit',array('iduser'=>$ids));
                $i++;
            }
        }
        $form = new formEasy();
        $form->method('post')->action(config::siteRoot() . '/index.php/users/userEdit/')->openForm();
        $form->type('hidden')->name('groupid')->value( $userArray['groupid'])->done();
       
        $form->type("submit")->class('btn btn-primary')->value("New User")->done();
       
        $form->closeForm();
       
        page::addBody($form->printform());
        page::addBody($table->loadTable($tbl));
        
        
        page::render();
    }

    function userEdit($arrayUser,$groupList,$profileList) {
    	if ( $arrayUser['login'] ) {
    		page::addBody("<h3>Editing user " . $arrayUser['login']  . "</h3>");
    	}else{
    		page::addBody("<h3>New user</h3>");
    	}
    	
        $site = config::siteRoot();
        
        $form = new formEasy();
        $form->method('post')->action(config::siteRoot() . '/index.php/users/saveUser/')->openForm();
        $form->addText("Login", "login", $arrayUser['login'],1);
        $form->addText("Name", "userName", $arrayUser['userName'],1);
        $form->addSelectAjaxTarget("Group", "group", $groupList,$arrayUser['groupid'],'profile',"$site/index.php/users/ajaxProfile/");
        $form->addSelect("Profile", "profile", $profileList,$arrayUser['profileid']);
        $form->addText('Created', '', $arrayUser['dataCreated']);
        $form->addText('Modified', '', $arrayUser['dataModified']);
        $form->addPasswordCad("Password", 'password', '');
        $form->type('submit')->class('btn btn-primary')->value('Save')->done();
        $form->type('hidden')->name('userid')->value($arrayUser['userid'])->done();
        $form->closeForm();
        page::addBody($form->printform());
        page::render();
    }

    function groupAjax($groupArray) {
        $i=0;
        $cod .=  "<option value=''>Select</option>";
        foreach ( $groupArray['idgroup']  as $id ) {
            $name = $groupArray['name'][$i];
            $cod .=  "<option value='$id'>$name</option>";
            $i++;
        }
       // page::addBody(json_encode($groupArray));
        page::addBody($cod);
        page::renderAjax();
    }

    function profilesAjax($profileArray) {
        $i=0;
        $cod .=  "<option value=''>Selecione</option>";
        if (is_array($profileArray)){
        foreach ( $profileArray['idprofile']  as $id ) {
            $name = $profileArray['name'][$i];
            $cod .=  "<option value='$id'>$name</option>";
            $i++;
        }
        }
       // page::addBody(json_encode($groupArray));
        debug::log($cod);
        page::addBody($cod);
        page::renderAjax();
    }

}
