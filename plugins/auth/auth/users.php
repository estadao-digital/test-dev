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

	class users {
		private $idusers;
		private $login;
		private $userName;
		private $secret;
		private $dataCreate;
		private $dateModify;
		private $enable;
		private $passChanged = 0;
		public function install() {
			$sql = "CREATE TABLE `users` (
		  `idusers` int(11) NOT NULL AUTO_INCREMENT,
		  `login` varchar(500) COLLATE utf8_bin DEFAULT NULL,
		  `userName` varchar(500) COLLATE utf8_bin DEFAULT NULL,
		  `secret` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
		  `dataCreate` datetime DEFAULT NULL,
		  `dateModify` datetime DEFAULT NULL,
		  `enable` int(11) DEFAULT NULL,
		  PRIMARY KEY (`idusers`)
		) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		";
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->query ( $sql );
			unset ( $db );
		}
		function setidusers($value) {
			$this->idusers = $value;
		}
		function getidusers() {
			return $this->idusers;
		}
		function setlogin($value) {
			$this->login = $value;
		}
		function getlogin() {
			return $this->login;
		}
		function setuserName($value) {
			$this->userName = $value;
		}
		function getuserName() {
			return $this->userName;
		}
		function setsecret($value) {
			$this->passChanged = 1;
			$this->secret = $value;
		}
		function getsecret() {
			return $this->secret;
		}
		function setdataCreate($value) {
			$this->dataCreate = $value;
		}
		function getdataCreate() {
			return $this->dataCreate;
		}
		function setdateModify($value) {
			$this->dateModify = $value;
		}
		function getdateModify() {
			return $this->dateModify;
		}
		function setenable($value) {
			$this->enable = $value;
		}
		function getenable() {
			return $this->enable;
		}
		function listusers() {
			$db = new mydataobj ();
			$db->setconn ( database::kolibriDB () );
			$db->settable ( "users" );
			// $db->addkey("ativo", 1);
			$i = 0;
			while ( $db->getidusers () ) {
				$out ['idusers'] [$i] = $db->getidusers ();
				$out ['login'] [$i] = $db->getlogin ();
				$out ['userName'] [$i] = $db->getuserName ();
				$out ['secret'] [$i] = $db->getsecret ();
				$out ['dataCreate'] [$i] = $db->getdataCreate ();
				$out ['dateModify'] [$i] = $db->getdateModify ();
				$out ['enable'] [$i] = $db->getenable ();
				$db->next ();
				$i ++;
			}
			return $out;
		}
		function load($idusers) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			// $db->debug(1);
			$db->settable ( "users" );
			// $db->addkey("ativo", 1);
			$db->addkey ( "idusers", $idusers );
			$this->setidusers ( $db->getidusers () );
			$this->setlogin ( $db->getlogin () );
			$this->setuserName ( $db->getuserName () );
			$this->setsecret ( $db->getsecret () );
			$this->setdataCreate ( $db->getdataCreate () );
			$this->setdateModify ( $db->getdateModify () );
			$this->setenable ( $db->getenable () );
		}
		function save() {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "users" );
			// $db->debug(1);
			if ($this->idusers) {
				$db->addkey ( "idusers", $this->idusers );
			}
			$db->setidusers ( $this->getidusers () );
			$db->setlogin ( $this->getlogin () );
			$db->setuserName ( $this->getuserName () );
			if ($this->passChanged) {
				$db->setsecret ( md5 ( $this->getsecret () ) );
			} else {
				$db->setsecret ( $this->getsecret () );
			}
			if (! $this->getdataCreate ()) {
				$this->setdataCreate ( date ( 'Y-m-d H:i:s' ) );
			}
			$db->setdataCreate ( $this->getdataCreate () );
			$db->setdateModify ( date ( 'Y-m-d H:i:s' ) );
			$db->setenable ( $this->getenable () );
			$db->save ();
			if ($this->idusers) {
				return $this->idusers;
			} else {
				return $db->getlastinsertid ();
			}
		}
		function userLoginExist($userLogin) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( 'users' );
			$db->addkey ( 'login', $userLogin );
			if ($db->getlogin ()) {
				return true;
			} else {
				return false;
			}
			unset ( $db );
		}
		function authUser($userLogin, $clearPassword) {
			$db = new \mydataobj ();
			// $db->debug(1);
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( 'users' );
			$db->addkey ( 'login', $userLogin );
			$db->addkey ( 'secret', md5 ( $clearPassword ) );
			if ($db->getidusers ()) {
				
				return true;
			} else {
				\debug::log ( "user/pass Fail $userLogin" . md5 ( $clearPassword ) );
				return false;
			}
			unset ( $db );
		}
		function setPassword($passClean) {
			$this->setsecret ( $passClean );
		}
		function loadLogin($login) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			// $db->debug(1);
			$db->settable ( "users" );
			$db->addkey ( "enable", 1 );
			$db->addkey ( "login", $login );
			$this->setidusers ( $db->getidusers () );
			$this->setlogin ( $db->getlogin () );
			$this->setuserName ( $db->getuserName () );
			$this->setsecret ( $db->getsecret () );
			$this->setdataCreate ( $db->getdataCreate () );
			$this->setdateModify ( $db->getdateModify () );
			$this->setenable ( $db->getenable () );
		}
		function changePassword($login, $pass, $newPass) {
			if ($this->authUser ( $login, $pass )) {
				$this->loadLogin ( $login );
				$this->setsecret ( $newPass );
				$this->save ();
				return true;
			} else {
				return false;
			}
		}
	}
}
