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
class userModel extends model {
	function listGroups() {
		$sys = new auth ();
		
		return $sys->group->listgroups ();
	}
	function userList($groupId) {
		$sys = new auth ();
		
		return $sys->groupsprofiles->listMembersGroup ( $groupId );
	}
	function userEdit($iduser) {
		$sysUsers = new auth ();
		$sysUsers->users->load ( $iduser );
		$out ['login'] = $sysUsers->users->getlogin ();
		$out ['userid'] = $sysUsers->users->getidusers ();
		$out ['userName'] = $sysUsers->users->getuserName ();
		$sysUsers->groupsprofiles->load ( $iduser );
		$out ['groupid'] = $sysUsers->groupsprofiles->getgroups_idgroup ();
		$out ['profileid'] = $sysUsers->groupsprofiles->getprofile_idprofile ();
		$s = new auth ();
		$s->group->load ( $out ['groupid'] );
		$out ['groupName'] = $s->group->getname ();
		unset ( $s );
		$s = new auth ();
		$s->profile->load ( $out ['profileid'] );
		$out ['profileName'] = $s->profile->getname ();
		unset ( $s );
		$out ['dataCreated'] = $sysUsers->users->getdataCreate ();
		$out ['dataModified'] = $sysUsers->users->getdateModify ();
		return $out;
	}
	function getgroupList() {
		$sys = new auth ();
		
		return $sys->group->listgroups ();
	}
	function getprofileList($idGroup) {
		$sys = new auth ();
		return $sys->profile->listprofile ( $idGroup );
	}
	function saveUser($login, $userName, $groupId, $profileId, $oldPass, $newPass, $userId = '') {
		$sys = new auth ();
		
		if (($sys->userLoginExist ( $login ) and $userId) or (! $sys->userLoginExist ( $login ) and ! $userId)) {
			
			if ($userId) {
				$sys->users->setidusers ( $userId );
			}
			
			$sys->users->setlogin(str_replace(' ', '', $login));
			$sys->users->setuserName($userName);
			$sys->users->setPassword($newPass);
			$sys->users->setenable(1);
			$userId = $sys->users->save();
			
			$sys->groupsprofiles->setusers_idusers($userId);
			$sys->groupsprofiles->setgroups_idgroup($groupId);
			$sys->groupsprofiles->setprofile_idprofile($profileId);
			$sys->groupsprofiles->save();
			
			
			return true;
		} else {
			return false;
		}
	}
}
