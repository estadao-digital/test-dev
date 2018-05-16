<?php

/*
 * Copyright (C) 2016 Vagner Rodrigues
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */
namespace auth {

	class acl {
		private $idacl;
		private $page;
		private $groups_idgroup;
		private $profile_idprofile;
		private $dataCreate;
		private $dataModify;
		private $enable;
		function install() {
			$sql = "CREATE TABLE `acl` (
			  `idacl` int(11) NOT NULL AUTO_INCREMENT,
			  `page` varchar(45) COLLATE utf8_bin DEFAULT NULL,
			  `groups_idgroup` int(11) NOT NULL,
			  `profile_idprofile` int(11) NOT NULL,
			  `dataCreate` datetime DEFAULT NULL,
			  `dataModify` datetime DEFAULT NULL,
			  `enable` int(11) DEFAULT NULL,
			  PRIMARY KEY (`idacl`),
			  KEY `fk_acl_groups1_idx` (`groups_idgroup`),
			  KEY `fk_acl_profile1_idx` (`profile_idprofile`)
			) ENGINE=MyISAM AUTO_INCREMENT=584793 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
			";
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->query ( $sql );
			unset ( $db );
		}
		function setidacl($value) {
			$this->idacl = $value;
		}
		function getidacl() {
			return $this->idacl;
		}
		function setpage($value) {
			$this->page = $value;
		}
		function getpage() {
			return $this->page;
		}
		function setgroups_idgroup($value) {
			$this->groups_idgroup = $value;
		}
		function getgroups_idgroup() {
			return $this->groups_idgroup;
		}
		function setprofile_idprofile($value) {
			$this->profile_idprofile = $value;
		}
		function getprofile_idprofile() {
			return $this->profile_idprofile;
		}
		function setdataCreate($value) {
			$this->dataCreate = $value;
		}
		function getdataCreate() {
			return $this->dataCreate;
		}
		function setdataModify($value) {
			$this->dataModify = $value;
		}
		function getdataModify() {
			return $this->dataModify;
		}
		function setenable($value) {
			$this->enable = $value;
		}
		function getenable() {
			return $this->enable;
		}
		function listacl($groups_idgroup,$profile_idprofile) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->debug(1);
			$db->settable ( "acl" );
			$db->addkey("groups_idgroup",$groups_idgroup);
			$db->addkey("profile_idprofile", $profile_idprofile);
			$db->addkey("enable", 1);
			$db->addorder('page');
			$i = 0;
			while ( $db->getidacl () ) {
				$out ['idacl'] [$i] = $db->getidacl ();
				$out ['page'] [$i] = $db->getpage ();
				$out ['groups_idgroup'] [$i] = $db->getgroups_idgroup ();
				$out ['profile_idprofile'] [$i] = $db->getprofile_idprofile ();
				$out ['dataCreate'] [$i] = $db->getdataCreate ();
				$out ['dataModify'] [$i] = $db->getdataModify ();
				$out ['enable'] [$i] = $db->getenable ();
				$db->next ();
				$i ++;
			}
			return $out;
		}
		function loadAcl($idacl) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			// $db->debug(1);
			$db->settable ( "acl" );
			$db->addkey("enable", 1);
			$db->addkey ( "idacl", $idacl );
			$this->setidacl ( $db->getidacl () );
			$this->setpage ( $db->getpage () );
			$this->setgroups_idgroup ( $db->getgroups_idgroup () );
			$this->setprofile_idprofile ( $db->getprofile_idprofile () );
			$this->setdataCreate ( $db->getdataCreate () );
			$this->setdataModify ( $db->getdataModify () );
			$this->setenable ( $db->getenable () );
		}
		function saveAcl() {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "acl" );
			// $db->debug(1);
			if ($this->idacl) {
				$db->addkey ( "idacl", $this->idacl );
			}
			if ( ! $this->getdataCreate ()) {
				$this->setdataCreate( date('Y-m-d H:i:s'));
			}
			$db->setidacl ( $this->getidacl () );
			$db->setpage ( $this->getpage () );
			$db->setgroups_idgroup ( $this->getgroups_idgroup () );
			$db->setprofile_idprofile ( $this->getprofile_idprofile () );
			$db->setdataCreate ( $this->getdataCreate () );
			$db->setdataModify ( date('Y-m-d H:i:s') );
			$db->setenable ( $this->getenable () );
			$db->save ();
			return $db->getlastinsertid ();
		}
		public function valideAcl($obj, $userLogin) {
			$sql = "
			select idacl,idusers, login from acl 
			inner join userProfileGroup on ( userProfileGroup.profile_idprofile = acl.profile_idprofile and 
			userProfileGroup.groups_idgroup = acl.groups_idgroup )
			inner join users on ( users.idusers = userProfileGroup.users_idusers )
			where page = '$obj' and users.login = '$userLogin' and acl.enable=1";
			
			$db = new \mydataobj ();
			//$db->debug(1);
			$db->setconn ( \database::kolibriDB () );
			$db->query ( $sql );
			if ($db->getidacl ()) {
				return true;
			} else {
				return false;
			}
		}
	}
}
