<?php

/*
 * Copyright (C) 2018 vagner
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

class apptokensView {
	
	
	function index($apps,$userid) {
		
		page::addBody("<h3>Applications tokens</h3>");
		$form = new formEasy();
		page::addBody($form->formActionButton(config::siteRoot() . "/index.php/apptokens/newtoken/", "New token",array('iduser'=>$userid)));
		if ( is_array($apps)) {
			$i=0;
			
			foreach ( $apps['token'] as $token) {
				$apps['Control'][$i] = $form->formActionButton(config::siteRoot() . "/index.php/apptokens/delToken/","Remove", array('token' => $token, 'iduser' => $userid));
				$i++;
			}
			$t = new dataTable();
			page::addBody($t->loadTable($apps));
		}
		page::render();
	}
	
	function newToken($userid) {
		page::addBody("<h3>New Token</h3>");
		$form = new formEasy();
		$form->action(config::siteRoot() . "/index.php/apptokens/saveToken/")->method("post")->openForm();
		$form->addText("Application Name", 'appname', '');
		$form->type("hidden")->name("iduser")->value($userid)->done();
		$form->type("submit")->class('btn btn-primary')->value("Save")->done();
		page::addBody($form->printform());
		page::render();
		
	}
	
}