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

class start {
	function index() {
		$obj = new startView();
		$obj->show();
	}
	function formulario() {
		$obj = new startView();
		$obj->formulario();
	}
	
	function mapa() {
		$obj = new startView();
		$obj->mapa();
	}
	
	function video() {
		$obj = new startView();
		$obj->video();
	}
	
	
	function tabela() {
		$obj = new startView();
		$obj->tabela();
	}
	
	function shed() {
		$obj = new startView();
		$obj->shed();
	}
	
	function chart() {
		$obj = new startView();
		$obj->chart();
	}
	
	function execute() {
		
		$execute = new taskRun();
		$execute->run("/usr/bin/gnome-terminal");
		die();
	}
	
	
}