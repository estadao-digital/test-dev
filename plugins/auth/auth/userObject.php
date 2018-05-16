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

	class userObject {
		private $users_idusers;
		private $objectName;
		private $jsonObject;
		public function install() {
			$sql = "CREATE TABLE `userObject` (
			  `users_idusers` int(11) NOT NULL,
			  `objectName` varchar(100) DEFAULT NULL,
			  `jsonObject` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;


						";
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->query ( $sql );
			unset ( $db );
		}
		function search($value,$objectName='') {
			if ($value) {
				if ( $objectName ) {
					$sql2 = " objectName = '$objectName' and ";
				}
				$sql = "SELECT * FROM kolibri.userObject where $sql2 JSON_SEARCH(jsonObject, 'one', '%$value%') IS NOT NULL;";
				$db = new \mydataobj ();
				$db->setconn ( \database::kolibriDB () );
				$db->query ( $sql );
				$i = 0;
				while ( $db->getusers_idusers () ) {
					$out ['idusers'] [$i] = $db->getusers_idusers ();
					$out ['objectName'] [$i] = $db->getobjectName ();
					$db->next ();
					$i ++;
				}
			}
			return $out;
		}
		function setusers_idusers($value) {
			$this->users_idusers = $value;
		}
		function getusers_idusers() {
			return $this->users_idusers;
		}
		function setobjectName($value) {
			$this->objectName = $value;
		}
		function getobjectName() {
			return $this->objectName;
		}
		private function setjsonObject($value) {
			$this->jsonObject = $value;
		}
		private function getjsonObject() {
			return $this->jsonObject;
		}
		function listuserObject() {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "userObject" );
			$this->setusers_idusers ( $db->getusers_idusers () );
			if ($this->getusers_idusers ()) {
				$db->addkey ( 'users_idusers', $this->getusers_idusers () );
			}
			if ($this->getobjectName ()) {
				$db->addkey ( 'objectName', $this->getobjectName () );
			}
			$i = 0;
			while ( $db->getusers_idusers () ) {
				$out ['users_idusers'] [$i] = $db->getusers_idusers ();
				$out ['objectName'] [$i] = $db->getobjectName ();
				$out ['jsonObject'] [$i] = $db->getjsonObject ();
				$db->next ();
				$i ++;
			}
			return $out;
		}
		function load($users_idusers, $objectName) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			// $db->debug(1);
			$db->settable ( "userObject" );
			$db->addkey ( "users_idusers", $users_idusers );
			$db->addkey ( "objectName", $objectName );
			
			$this->setusers_idusers ( $db->getusers_idusers () );
			$this->setobjectName ( $db->getobjectName () );
			$this->setjsonObject ( $db->getjsonObject () );
			$out = new \stdClass();
			$out = json_decode($this->getjsonObject());
			return $out;
		}
		private function delete($users_idusers, $objectName) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "userObject" );
			$db->addkey ( 'users_idusers', $users_idusers );
			$db->addkey ( 'objectName', $objectName );
			$db->delete ();
		}
		private function saveData() {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "userObject" );
			$this->delete ( $this->getusers_idusers (), $this->getobjectName () );
			$db->setusers_idusers ( $this->getusers_idusers () );
			$db->setobjectName ( $this->getobjectName () );
			$db->setjsonObject ( $this->getjsonObject () );
			$db->save ();
		}
		function save($users_idusers, $objectName, $obj) {
			$this->setusers_idusers ( $users_idusers );
			$this->setobjectName ( $objectName );
			$this->setjsonObject ( json_encode ( $obj ) );
			$this->saveData ();
		}
	}
}
