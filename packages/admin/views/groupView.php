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


class groupView  {

    function __construct() {
        
    }

    function listGroups($arrayGroups) {
        page::addBody("<h3>Group List</h3>");
         $form = new formEasy();
         $arrayGroups['Group'] = $arrayGroups['name'];
         $arrayGroups['Users in group'] = $arrayGroups['users'];
         page::addBody($form->formActionButton(config::siteRoot() .  "/index.php/group/newGroup/", "New Group",''));
        if (is_array($arrayGroups)) {
            $i=0;
            foreach ( $arrayGroups['idgroup'] as $idgroup) {
                $form = new formEasy();
                $arrayGroups['Control'][$i] = $form->formActionButton(config::siteRoot() . "/index.php/group/delGroup/", "Delete",array("idgroup" => $idgroup));
                $i++;
            }
        }
        unset($arrayGroups['name']);
        unset($arrayGroups['users']);
        unset($arrayGroups['enable']);
        unset( $arrayGroups['idgroup']);
        $table = new htmlTable();
         page::addBody($table->loadTable($arrayGroups));
         page::render();
    }
    
    function newGroup() {
        
         page::addBody("<h3>New group</h3>");
         $form = new formEasy();
         $form->action(config::siteRoot() . "/index.php/group/saveGroup/")->method("post")->openForm();
         $form->addText("Group Name", "groupName", "",1);
         $form->type("submit")->class('btn btn-primary')->value("Save")->done();
        $form->closeForm();
        page::addBody($form->printform());
        page::render();
    }
    
}