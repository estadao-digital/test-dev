<?php

use auth\userObject;

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
class auth {
	public $acl;
	public $group;
	public $profile;
	public $users;
	public $groupsprofiles;
	public $userObj;
	function __construct() {
		/*
		 * $a = new auth\acl ();
		 * $a->install ();
		 * $u = new auth\users ();
		 * $u->install ();
		 * $g = new auth\groups ();
		 * $g->install ();
		 * $p = new auth\profile ();
		 * $p->install ();
		 */
		$this->acl = new auth\acl ();
		$this->group = new auth\groups ();
		$this->profile = new auth\profile ();
		$this->users = new auth\users ();
		$this->groupsprofiles = new auth\userProfileGroup ();
		$this->userObj= new auth\userObject();
	}
	function getloggedGroupId() {
		$this->users->loadLogin ( session::get ( 'login' ) );
		$this->groupsprofiles->load ( $this->users->getidusers () );
		return $this->groupsprofiles->getgroups_idgroup ();
	}
	function getloggedProfileId() {
		$this->users->loadLogin ( session::get ( 'login' ) );
		$this->groupsprofiles->load ( $this->users->getidusers () );
		return $this->groupsprofiles->getprofile_idprofile ();
	}
	function userLoginExist($login) {
		$this->users->loadLogin ( $login );
		if ($this->users->getidusers ()) {
			return $this->users->getidusers ();
		} else {
			return false;
		}
	}
	/*
	 * This function is legacy from version before 0.7
	 */
	/*
	 * function valide($login, $pass) {
	 *
	 * return $this->authUser($login, $pass);
	 * }
	 *
	 * function access($controler, $login) {
	 * return $this->valideAcl($controler, $login);
	 * }
	 *
	 * function accessAdmin($controler, $login) {
	 * return $this->valideAcl($controler, $login);
	 * }
	 *
	 *
	 */
	function getPages() {
		$ctrl = getcwd () . "/packages/";
		// echo $ctrl;
		$fl = opendir ( $ctrl );
		while ( false !== ($folder = readdir ( $fl )) ) {
			if (! ($folder == ".") xor ($folder == "..")) {
				
				if (is_dir ( $ctrl . "/" . $folder )) {
					// echo "Abrindo " . $ctrl . $folder . "/controllers/<br>";
					$pkg = opendir ( $ctrl . $folder . "/controllers/" );
					while ( false !== ($folderSub = readdir ( $pkg )) ) {
						if (! ($folderSub == ".") xor ($folderSub == "..")) {
							list ( $file, $type ) = explode ( '.', $folderSub );
							
							require_once ($ctrl . "/" . $folder . "/controllers/" . $file . ".php");
							$class_methods = get_class_methods ( $file );
							foreach ( $class_methods as $method_name ) {
								if ($method_name != "__construct") {
									$out [] = $file . "/" . $method_name;
								}
							}
						}
					}
				}
			}
		}
		sort ( $out, SORT_STRING );
		
		return $out;
		// return natcasesort($out);
	}
}
    
