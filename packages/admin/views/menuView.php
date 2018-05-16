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
class menuView {
	function __construct() {
		page::addJsFile ( '::siteroot::/vendors/jquery-ui/external/jquery/jquery.min.js' );
		page::addCssFile ( "::siteroot::/vendors/bootstrap-treeview/src/css/bootstrap-treeview.css" );
		page::addJsFile ( "::siteroot::/vendors/bootstrap-treeview/src/js/bootstrap-treeview.js" );
	}
	function listMenus($menuArrays) {
		$form = new formEasy ();
		page::addBody ( "<h3>Menus</h3>" );
		page::addBody ( $form->formActionButton ( config::siteRoot () . "/index.php/menuManager/menuNew/", "New Menu", '' ) );
		if (is_array ( $menuArrays )) {
			$i = 0;
			
			foreach ( $menuArrays ['idMenu'] as $idMenu ) {
			    $menuArrays ['Delete'] [$i] = $form->formActionIcon ( config::siteRoot () . "/index.php/menuManager/delete/", "", array (
			        "idMenu" => $idMenu
			    ), 'fa fa-trash ' );
			    $menuArrays ['Control'] [$i] = $form->formActionIcon ( config::siteRoot () . "/index.php/menuManager/itens/", "", array (
			        "idMenu" => $idMenu
			    ), 'fa fa-list ' );
			    $i ++;
			}
			
			$tableOut['Name'] = $menuArrays['menuName'];
			$tableOut['Group'] = $menuArrays['groupName'];
			$tableOut['Profile'] = $menuArrays['profileName'];
			$tableOut['Delete'] = $menuArrays['Delete'];
			$tableOut['Edit'] = $menuArrays['Control'];
			
			unset ( $menuArrays ['idMenu'] );
			$table = new htmlTable ();
			page::addBody ( '<br>' . $table->loadTable ( $tableOut ) );
		}
		
		page::render ();
	}
	function menuNew($groupList) {
		page::addBody ( "<h3>New Menu</h3>" );
		$site = config::siteRoot ();
		$form = new formEasy ();
		$form->action ( config::siteRoot () . "/index.php/menuManager/saveMenu/" )->method ( "post" )->openform ();
		$form->addText ( "Menu Name", 'menuName', '', 1 );
		$form->addSelectAjaxTarget ( "Group", "group", $groupList, $arrayUser ['groupid'], 'profile', "$site/index.php/users/ajaxProfile/" );
		$form->addSelect ( "Profile", "profile", $profileList, $arrayUser ['profileid'] );
		$form->type ( 'submit' )->class('btn btn-primary')->value ( "Create" )->done ();
		page::addBody ( $form->printform () );
		page::render ();
	}
	function listMenusItens($menuArrays, $idMenu) {
		$form = new formEasy ();
		page::addBody ( "<h3>Menu Itens</h3>" );
		
		page::addBody ( $form->formActionButton ( config::siteRoot () . "/index.php/menuManager/menuNewItem/", "New Menu Item", array (
				"idMenu" => $idMenu 
		) ) );
		
		$v = new menuGen ();
		
		page::addBody ( '<br>' );
		page::addBody ( $v->htmlTreeTable ( $menuArrays, $idMenu, 1 ) );
		
		page::render ();
	}
	function newItem($itensMenu, $idMenu, $groupList) {
		$i = 0;
		if (is_array ( $itensMenu )) {
			foreach ( $itensMenu ['idMenuItem'] as $item ) {
				$list [$i] [0] = $item;
				$list [$i] [1] = $itensMenu ['itemName'] [$i];
				$i ++;
			}
		}
		$site = config::siteRoot ();
		page::addBody ( "<h2>New menu item</h2>" );
		$form = new formEasy ();
		$form->action ( config::siteRoot () . "/index.php/menuManager/saveItem/" )->openform ();
		$form->addText ( "Item Name", 'itemName', '', 1 );
		$form->addSelectAjaxTarget ( "Group", "group", $groupList, $arrayUser ['groupid'], 'profile', "$site/index.php/users/ajaxProfile/" );
		$form->addSelect ( "Profile", "profile", $profileList, $arrayUser ['profileid'] );
		$form->addText ( "Item Address", 'address', config::siteRoot () . 'index.php/', 1 );
		$form->addText ( "Item DOM Class (optional)", 'class', '', 0 );
		$form->addText ( "Item DOM Name (optional)", 'name', '', 0 );
		$form->addText ( "Item DOM Id (optional)", 'id', '', 0 );
		$form->addText ( "Item Icon", 'icon', '', 0 );
		$cod = "
        <b>Icons Suggest</b><br>
		<a  target='_blank' href='https://fontawesome.com/icons?d=gallery'>Fontawesome</a><br>
		<a  target='_blank' href='https://material.io/icons/'>Material Icons</a><br>
		<a  target='_blank' href='https://useiconic.com/open/'>Ionic</a><br>
		<a  target='_blank' href='https://octicons.github.com/'>Octicons</a><br>
		";
		$form->addhtml ( $cod );
		$form->type ( 'hidden' )->name ( 'idMenu' )->value ( $idMenu )->done ();
		$form->addSelect ( "Parent Item (optional)", 'idParent', $list, '' );
		$form->type ( "submit" )->class('btn btn-primary')->value ( "Save" )->done ();
		page::addBody ( $form->printform () );
		
		page::render ();
	}
}
