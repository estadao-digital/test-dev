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

	class groups {
		private $idgroup;
		private $name;
		private $enable;
		
		public function install() {
			$sql = "CREATE TABLE `groups` (
			  `idgroup` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(300) COLLATE utf8_bin DEFAULT NULL,
			  `enable` int(11) DEFAULT NULL,
			  PRIMARY KEY (`idgroup`)
			) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

		";
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->query ( $sql );
			unset ( $db );
		}
		
		function setidgroup($value) {
			$this->idgroup = $value;
		}
		function getidgroup() {
			return $this->idgroup;
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
		function listgroups() {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "groups" );
			$db->addkey("enable", 1);
			$i = 0;
			while ( $db->getidgroup () ) {
				$out ['idgroup'] [$i] = $db->getidgroup ();
				$out ['name'] [$i] = $db->getname ();
				$out ['enable'] [$i] = $db->getenable ();
				$db->next ();
				$i ++;
			}
			return $out;
		}
		function load($idgroup) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			// $db->debug(1);
			$db->settable ( "groups" );
			$db->addkey("enable", 1);
			// $db->addkey("ativo", 1);
			$db->addkey ( "idgroup", $idgroup );
			$this->setidgroup ( $db->getidgroup () );
			$this->setname ( $db->getname () );
			$this->setenable ( $db->getenable () );
		}
		function save() {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "groups" );
			$db->debug(1);
			if ($this->idgroup) {
				$db->addkey ( "idgroup", $this->idgroup );
			}
			$db->setidgroup ( $this->getidgroup () );
			$db->setname ( $this->getname () );
			$db->setenable ( $this->getenable () );
			$db->save ();
			return $db->getlastinsertid ();
		}
		
	}
}
