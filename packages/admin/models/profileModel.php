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
class profileModel {
	private $idprofile;
	private $idgroup;
	private $name;
	private $enable = 1;
	private $adminProfile;
	private $dataCreate;
	private $dataModify;
	function __construct($idprofile = '') {
		$sys = new auth ();
		$sys->profile->load ( $idprofile );
	}
	function save() {
		$sys = new auth ();
		$sys->profile->setenable ( $this->enable );
		$sys->profile->setgroups_idgroup ( $this->idgroup );
		$sys->profile->setname ( $this->name );
		$sys->profile->save ();
	}
	function listprofile($idGroup) {
		$sys = new auth ();
		
		return $sys->profile->listprofile ( $idGroup );
	}
	function listGroups() {
		$sys = new auth ();
		return $sys->group->listgroups ();
	}
	function listUsersProfile($idProfile) {
		$sys = new auth ();
		$sys->profile->load ( $idProfile );
		$groupId = $sys->profile->getgroups_idgroup ();
		//unset ( $sys );
		//$sys = new auth ();
		return $sys->groupsprofiles->listuserProfileGroup($groupId,$idProfile);
		
	}
	function deleteProfile($idprofile) {
		if ( $idprofile) {
			$sys = new auth ();
			debug::log("APAGANDO PROFILE $idprofile");
			$sys->profile->load ( $idprofile);
			$sys->profile->setenable ( 0 );
			$sys->profile->save ();
		}
	}
	function setname($name) {
		$this->name = $name;
	}
	function setIdGroup($idGroup) {
		$this->idgroup = $idGroup;
	}
	function setadminProfile($idUser) {
		$this->adminProfile = $idUser;
	}
	function setenable($enable) {
		if ($enable) {
			$this->enable = 1;
		} else {
			$this->enable = 0;
		}
	}
	function getadminProfile($idProfile) {
		return $this->adminProfile;
	}
	function getname() {
		return $this->name;
	}
	function getenable() {
		return $this->enable;
	}
}