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

	class profile {
		private $idprofile;
		private $groups_idgroup;
		private $name;
		private $enable;
		private $adminProfile;
		private $dataCreate;
		private $dataModify;
		
		public function install() {
			$sql = "CREATE TABLE `profile` (
  `idprofile` int(11) NOT NULL AUTO_INCREMENT,
  `groups_idgroup` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `enable` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `adminProfile` int(11) DEFAULT NULL,
  `dataCreate` datetime DEFAULT NULL,
  `dataModify` datetime DEFAULT NULL,
  PRIMARY KEY (`idprofile`),
  KEY `fk_profile_groups_idx` (`groups_idgroup`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
					
		";
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->query ( $sql );
			unset ( $db );
		}
		
		function setidprofile($value) {
			$this->idprofile = $value;
		}
		function getidprofile() {
			return $this->idprofile;
		}
		function setgroups_idgroup($value) {
			$this->groups_idgroup = $value;
		}
		function getgroups_idgroup() {
			return $this->groups_idgroup;
		}
		function setname($value) {
			$this->name = $value;
		}
		function getname() {
			return $this->name;
		}
		function setenable($value) {
			$this->enable = $value;
		}
		function getenable() {
			return $this->enable;
		}
		function setadminProfile($value) {
			$this->adminProfile = $value;
		}
		function getadminProfile() {
			return $this->adminProfile;
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
		function listprofile($idgroup='') {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "profile" );
			$db->addkey('enable', 1);
			if ( $idgroup ) {
				$db->addkey("groups_idgroup",$idgroup);
			}
			// $db->addkey("ativo", 1);
			$i = 0;
			while ( $db->getidprofile () ) {
				$out ['idprofile'] [$i] = $db->getidprofile ();
				$out ['groups_idgroup'] [$i] = $db->getgroups_idgroup ();
				$out ['name'] [$i] = $db->getname ();
				$out ['enable'] [$i] = $db->getenable ();
				$out ['adminProfile'] [$i] = $db->getadminProfile ();
				$out ['dataCreate'] [$i] = $db->getdataCreate ();
				$out ['dataModify'] [$i] = $db->getdataModify ();
				$db->next ();
				$i ++;
			}
			return $out;
		}
		function load($idprofile) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			// $db->debug(1);
			$db->settable ( "profile" );
			// $db->addkey("ativo", 1);
			$db->addkey ( "idprofile", $idprofile );
			$this->setidprofile ( $db->getidprofile () );
			$this->setgroups_idgroup ( $db->getgroups_idgroup () );
			$this->setname ( $db->getname () );
			$this->setenable ( $db->getenable () );
			$this->setadminProfile ( $db->getadminProfile () );
			$this->setdataCreate ( $db->getdataCreate () );
			$this->setdataModify ( $db->getdataModify () );
		}
		function save() {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "profile" );
			// $db->debug(1);
			if ($this->idprofile) {
				$db->addkey ( "idprofile", $this->idprofile );
			}
			$db->setidprofile ( $this->getidprofile () );
			$db->setgroups_idgroup ( $this->getgroups_idgroup () );
			$db->setname ( $this->getname () );
			$db->setenable ( $this->getenable () );
			if ( ! $this->getadminProfile () ) {
				$this->setadminProfile(0);
			}
			$db->setadminProfile ( $this->getadminProfile () );
			if ( ! $this->getdataCreate ()) {
				$this->setdataCreate( date("Y-m-d H:i:s") );
			}
			
			$db->setdataCreate ( $this->getdataCreate () );
			 
			$db->setdataModify ( date("Y-m-d H:i:s") );
			$db->save ();
			return $db->getlastinsertid ();
		}
	}
}
