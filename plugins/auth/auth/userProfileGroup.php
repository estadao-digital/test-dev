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

	class userProfileGroup {
		private $users_idusers;
		private $profile_idprofile;
		private $groups_idgroup;
		
		public function install() {
			$sql = "CREATE TABLE `userProfileGroup` (
				  `users_idusers` int(11) NOT NULL,
				  `profile_idprofile` int(11) NOT NULL,
				  `groups_idgroup` int(11) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;					
						";
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->query ( $sql );
			unset ( $db );
		}
		
		function setusers_idusers($value) {
			$this->users_idusers = $value;
		}
		function getusers_idusers() {
			return $this->users_idusers;
		}
		function setprofile_idprofile($value) {
			$this->profile_idprofile = $value;
		}
		function getprofile_idprofile() {
			return $this->profile_idprofile;
		}
		function setgroups_idgroup($value) {
			$this->groups_idgroup = $value;
		}
		function getgroups_idgroup() {
			return $this->groups_idgroup;
		}
		function listuserProfileGroup($groups_idgroup,$profile_idprofile='') {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "userProfileGroup" );
			$db->addkey("groups_idgroup", $groups_idgroup);
			if ( $profile_idprofile) {
				$db->addkey("profile_idprofile", $profile_idprofile);
			}
			$i = 0;
			while ( $db->getusers_idusers() ) {
				$out ['users_idusers'] [$i] = $db->getusers_idusers ();
				$out ['profile_idprofile'] [$i] = $db->getprofile_idprofile ();
				$out ['groups_idgroup'] [$i] = $db->getgroups_idgroup ();
				$db->next ();
				$i ++;
			}
			return $out;
		}
		function load($users_idusers) 
		{
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			//$db->debug(1);
			$db->settable ( "userProfileGroup" );
        //$db->addkey("ativo", 1);
			$db->addkey("users_idusers", $users_idusers);
			$this->setusers_idusers ( $db->getusers_idusers () );
			$this->setprofile_idprofile ( $db->getprofile_idprofile () );
			$this->setgroups_idgroup ( $db->getgroups_idgroup () );
		}
		
		function delete($users_idusers,$groups_idgroup,$profile_idprofile) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "userProfileGroup" );
			$db->addkey('users_idusers',$users_idusers);
			$db->addkey('groups_idgroup',$groups_idgroup);
			$db->addkey('profile_idprofile',$profile_idprofile);
			$db->delete();
		}
		
		function save() {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "userProfileGroup" );
        //$db->debug(1);
			$this->delete($this->getusers_idusers (),$this->getgroups_idgroup (),$this->getprofile_idprofile () );
			$db->setusers_idusers ( $this->getusers_idusers () );
			$db->setprofile_idprofile ( $this->getprofile_idprofile () );
			$db->setgroups_idgroup ( $this->getgroups_idgroup () );
			$db->save ();
			return $db->getlastinsertid ();
		}
		
		function listMembersGroup($group_idgroup) {
			$db = new \mydataobj ();
			$db->debug(1);
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "userProfileGroup" );
			$db->addkey('groups_idgroup',$group_idgroup);
			while ( $db->getusers_idusers() ) {
				$out['iduser'][] =  $db->getusers_idusers();
				$db->next();
				
			}
			return $out;
		}
	}
}
