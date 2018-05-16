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

class autenticator extends model {
	
	function __construct(){
		parent::__construct();
	}
	
	function authentic($login,$pass,$key='') {

		$auth = new auth();
		$out = 0;
		if ($auth->users->authUser($login, $pass)) {
			$out = 1;
		} 
		if ( count($key)) {
			//$login = $auth->valideKey($key);
			if ( $login ) {
				session::init ();
				session::set ( "login", $login);
				session::set ( "logged","on");
				session::set('authorized',true);
			}
		}
		return $out;
	}
	
	
	
	function register() {
		session::init ();
		session::set ( "login", $this->request ['login'] );
		session::set ( "logged","on");
	}
}