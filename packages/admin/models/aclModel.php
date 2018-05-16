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
class aclModel {
	private $idacl;
	private $page;
	private $idprofile;
	private $idgroup;
	private $dataCreate;
	private $dataModify;
	private $enable;
	function __construct($idacl = '') {
	}
	function save() {
		$sys = new auth ();
		$sys->acl->setpage($this->page);
		$sys->acl->setgroups_idgroup($this->idgroup);
		$sys->acl->setprofile_idprofile($this->idprofile);
		$sys->acl->setenable(1);
		$sys->acl->saveAcl();
		//$sys->addAcl ( $this->page, $this->idgroup, $this->idprofile );
	}
	function listAcl($idprofile) {
		$sys = new auth ();
		$sys->profile->load ( $idprofile );
		return $sys->acl->listacl ( $sys->profile->getgroups_idgroup (), $idprofile );
	}
	function setpage($page) {
		$this->page = $page;
	}
	function setidprofile($idprofile) {
		$this->idprofile = $idprofile;
	}
	function setidgroup($idgroup) {
		$this->idgroup = $idgroup;
	}
	function getpages() {
		$sys = new auth ();
		return $sys->getPages ();
	}
	function delIdacl($idacl) {
		if ($idacl) {
			$sys = new auth ();
			$sys->acl->loadAcl( $idacl );
			$sys->acl->setenable ( 0 );
			$sys->acl->saveAcl( 0 );
		}
	}
}



