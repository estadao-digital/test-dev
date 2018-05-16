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
class users extends controller {
	function index() {
		
		$m = new userModel ();
		$v = new usersView ();
		$v->listaGroups ( $m->listGroups () );
	}
	private function profileName($idprofile) {
		$sys = new auth ();
		
		$sys->loadProfile ( $idprofile );
		return $sys->getprofileName ();
	}
	function listUser() {
		$m = new userModel ();
		$v = new usersView ();
		$list = $m->userList ( $this->request ['idgroup'] );
		$i = 0;
		if (is_array ( $list )) {
			foreach ( $list ['iduser'] as $iduser) {
				$sys = new auth();
				$sys->group->load($list ['groups_idgroup'][$i]);
				$sys->users->load($iduser);
				$sys->groupsprofiles->load($iduser);
				$sys->group->load($sys->groupsprofiles->getgroups_idgroup());
				$sys->profile->load($sys->groupsprofiles->getprofile_idprofile());
				
				$out ['group'] [$i] = $sys->group->getname();
				$out['iduser'][$i] = $iduser;
				$out['login'][$i] = $sys->users->getlogin();
				$out['username'][$i] = $sys->users->getuserName();
				$out['profile'] [$i] = $sys->profile->getname();
				$out['datacreate'][$i] = $sys->users->getdataCreate();
				$out['datemodify'][$i] = $sys->users->getdateModify();
				$i ++;
				unset($sys);
			}
		}
		
		unset ( $list ['idProfile'] );
		$v->listUsers ( $out);
	}
	function userEdit() {
		$m = new userModel ();
		$v = new usersView ();
		$editArray = $m->userEdit ( $this->request ['iduser'] );
		
		$tmp = $m->getgroupList ();
		$i = 0;
		foreach ( $tmp ['idgroup'] as $k ) {
			$groupList [$i] [0] = $k;
			$groupList [$i] [1] = $tmp ['name'] [$i];
			$i ++;
		}
		
		unset ( $tmp );
		$tmp = $m->getprofileList ( $editArray ['groupid'] );
		$i = 0;
		if (is_array ( $tmp )) {
			foreach ( $tmp ['idprofile'] as $k ) {
				$profileList [$i] [0] = $k;
				$profileList [$i] [1] = $tmp ['name'] [$i];
				$i ++;
			}
		}
		unset ( $tmp );
		$v->userEdit ( $editArray, $groupList, $profileList );
	}
	function ajaxGroup() {
		$m = new userModel ();
		$v = new usersView ();
		$v->groupAjax ( $m->getgroupList () );
	}
	function ajaxProfile() {
		$m = new userModel ();
		$v = new usersView ();
		
		$v->profilesAjax ( $m->getprofileList ( $this->request ['group'] ) );
	}
	function saveUser() {
		$m = new userModel ();
		
		$login = $this->request ['login'];
		$userName = $this->request ['userName'];
		$groupId = $this->request ['group'];
		$profileId = $this->request ['profile'];
		$oldPass = $this->request [''];
		$newPass = $this->request ['password'];
		$userId = $this->request ['userid'];
		$this->request ['idgroup'] = $this->request ['group'];
		if ($m->saveUser ( $login, $userName, $groupId, $profileId, $oldPass, $newPass, $userId )) {
			//$v = new usersView ();
			//$v->listUsers ( $m->userList ( $this->request ['group'] ) );
			$this->listUser();
		} else {
			page::addJsScript ( "alert('Usuario ja existente');" );
			//$v = new usersView ();
			//$v->listUsers ( $m->userList ( $this->request ['group'] ) );
			$this->listUser();
		}
	}
}
