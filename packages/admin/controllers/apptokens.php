<?php

/*
 * Copyright (C) 2018 vagner
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
class apptokens extends controller {

	function index() {
		if ( $this->request['iduser']) {
			$x = new auth();
			$obj = $x->userObj->load($this->request['iduser'],'oauth');
			$v = new apptokensView();
			$v->index((array)$obj->tokenApps,$this->request['iduser']);

		}
	}

	function newtoken() {
		$v = new apptokensView();
		$v->newToken($this->request['iduser']);
	}


	function delToken() {
		$x = new auth();
		$obj = $x->userObj->load($this->request['iduser'],'oauth');
		$list = (array)$obj->tokenApps;
		$v = array_search($this->request['token'],$list['token']);
		debug::log($list);
		unset($list['AppName'][$v]);
		unset($list['token'][$v]);
		
		$out = array();
		if ( count($list['token'])) {
			
			
			foreach ($list['AppName'] as $ap) {
				$out['AppName'][] = $ap;
			}
			foreach ($list['token'] as $tk) {
				$out['token'][] = $tk;
			}
		}
		debug::log($out);
		$obj->tokenApps = $out;
		$x->userObj->save($this->request['iduser'],'oauth',$obj);
		$this->index();
	}
	
	
	private function generateHash($base_string) {
		//$s  .= '&'.$request->urlencode($consumer_secret).'&'.$request->urlencode($token_secret);
		$md5 = md5($base_string);
		$bin = '';
		
		for ($i = 0; $i < strlen($md5); $i += 2)
		{
			$bin .= chr(hexdec($md5{$i+1}) + hexdec($md5{$i}) * 16);
		}
		return md5($bin);
	}
	
	
	function getHash($string) {
		
		$result = ''; 
		
		$x = new auth();
		while ( $result == '' ) {
			$hash = $this->generateHash($string . rand(1000,9999));
			$obj = $x->userObj->search($hash,'oauth');
			if ( ! $obj['idusers'] ) {
				$result = $hash;
			}
		}	
		debug::log($result);
		return $result;
	}

	function saveToken() {
		$x = new auth();
		$obj = $x->userObj->load($this->request['iduser'],'oauth');
		$list = (array)$obj->tokenApps;
		$list['AppName'][] = $this->request['appname'];
		$list['token'][] = $this->getHash($this->request['appname']);
		$obj->tokenApps = $list;
	
		$x->userObj->save($this->request['iduser'],'oauth',$obj);
		
		$this->index();
	}

}
