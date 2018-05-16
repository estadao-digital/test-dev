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
class acl extends controller {
	function profileAccess() {
		$m = new aclModel ();
		$v = new aclView ();
		$arrayLst = $m->listAcl ( $this->request ['idprofile']);
		$i=0;
		foreach ( $arrayLst['groups_idgroup'] as $groupId ) {
			$sys = new auth();
			$sys->group->load($groupId);
			$sys->profile->load($arrayLst['profile_idprofile'][$i]);
			$arrayLst['Group'][$i] = $sys->group->getname();
			$arrayLst['Profile'][$i] = $sys->profile->getname();
			$i++;
		}
		$v->listAcl ( $arrayLst , $this->request ['idprofile'] );
	}
	function newAcl() {
		$v = new aclView ();
		$m = new groupModel ();
		$m1 = new aclModel ();
		$tmp = $m->listGroup ();
		$i = 0;
		foreach ( $tmp ['idgroup'] as $k ) {
			$groupList [$i] [0] = $k;
			$groupList [$i] [1] = $tmp ['name'] [$i];
			$i ++;
		}
		
		$v->newAcl ( $m1->getpages (), $groupList );
	}
	function saveAcl() {
		$v = new aclView ();
		$m = new aclModel ();
		$m->setpage ( $this->request ['page'] );
		$m->setidgroup ( $this->request ['group'] );
		$m->setidprofile ( $this->request ['idprofile'] );
		$m->save ();
		$this->profileAccess ();
	}
	function aclRemove() {
		$m = new aclModel ();
		$m->delIdacl ( $this->request ['idacl'] );
		$this->profileAccess ();
	}
}