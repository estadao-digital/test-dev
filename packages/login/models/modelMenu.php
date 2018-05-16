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

class modelMenu {
	function getMenu() {
		
		$menub[0]['name'] = "Cadastre-se";
		$menub[0]['link'] = "::siteroot::/index.php/start/formulario";
		$menub[1]['name'] = "Login-in";
		$menub[1]['link'] = "::siteroot::/index.php/login/index";
		$menub[2]['name'] = "Formulário";
		$menub[2]['link'] = "::siteroot::/index.php/start/formulario";
		$menub[3]['name'] = "Mapa";
		$menub[3]['link'] = "::siteroot::/index.php/start/mapa";
		$menub[4]['name'] = "Vídeo";
		$menub[4]['link'] = "::siteroot::/index.php/start/video";
		$menub[5]['name'] = "Tabela";
		$menub[5]['link'] = "::siteroot::/index.php/start/tabela";
		$menub[5]['name'] = "Agenda";
		$menub[5]['link'] = "::siteroot::/index.php/start/shed";
	
	
		$menu[0]['name'] = "Home";
		$menu[0]['link'] = "::siteroot::";
		
		$menu[1]['name'] = "Menu";
		$menu[1]['link'] = $menub;
		
		
		$m = new menuGen();
		$m->load($menu);
		$m->setId('nav');
		return $m->done();
		
	}
}