<?php
/*
 * Copyright (C) 2016 vagner
 *
 * This file is part of Kolibri.
 *
 * Kolibri is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kolibri is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kolibri. If not, see <http://www.gnu.org/licenses/>.
 */
class aclView {
	function listAcl($arrayAcl, $idprofile) {
		page::addBody ( "<h3>Access for Profile</h3>" );
		$tbl = new htmlTable ();
		$i = 0;
		$form = new formEasy ();
		if (is_array ( $arrayAcl ['idacl'] )) {
			foreach ( $arrayAcl ['idacl'] as $acls ) {
				
				$arrayAcl ['Control'] [$i] = $form->formActionButton ( config::siteRoot () . "/index.php/acl/aclRemove/", "Delete", array (
						"idacl" => $acls,
						"idprofile" => $idprofile 
				) );
				$i ++;
			}
		}
		unset ( $arrayAcl ['idacl'] );
		// $form = new formEasy();
		page::addBody ( $form->formActionButton ( config::siteRoot () . "/index.php/acl/newAcl/", "New ACL", array (
				"idgroup" => $ids 
		) ) );
		
		$out['Page'] = $arrayAcl['page'];
		$out['Group'] = $arrayAcl['Group'];
		$out['Profile'] = $arrayAcl['Profile'];
		$out['Created'] = $arrayAcl['dataCreate'] ;
		$out['Modify'] = $arrayAcl['dataModify'] ;
		$out['Control'] = $arrayAcl['Control'] ;
		
		page::addBody ( $tbl->loadTable ( $out) );
		
		page::render ();
	}
	function newAcl($arrayobj, $groupList, $profileList = '') {
		if (is_array ( $arrayobj )) {
			$i = 0;
			foreach ( $arrayobj as $pages ) {
				$pgArray [$i] [0] = $pages;
				$pgArray [$i] [1] = $pages;
				$i ++;
			}
		}
		$site = config::siteRoot ();
		page::addBody ( "<h3>ACL editor</h3>" );
		$form = new formEasy ();
		$form->action ( config::siteRoot () . "/index.php/acl/saveAcl/" )->method ( 'post' )->openform ();
		$form->addSelect ( "Page", 'page', $pgArray, '', 1 );
		$form->addSelectAjaxTarget ( "Group", "group", $groupList, $arrayUser ['idgroup'], 'idprofile', "$site/index.php/users/ajaxProfile/" );
		$form->addSelect ( "Profile", "idprofile", $profileList, $arrayUser ['idprofile'], 1 );
		$form->type ( 'submit' )->class('btn btn-primary')->value ( 'Save' )->done ();
		$form->type ( 'hidden' )->name ( 'userid' )->value ( $arrayUser ['userid'] )->done ();
		$form->closeForm ();
		page::addBody ( $form->printform () );
		page::render ();
	}
}
