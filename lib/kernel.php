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
require_once ('lib/charConverter.php');
require_once ('lib/functions.php');
require_once ('lib/register.php');
require_once ('lib/security.php');
require_once ('lib/database.php');
if (file_exists ( 'config/config.php' )) {
	require_once ('config/config.php');
	if (file_exists ( 'config/databases.php' )) {
		require_once ('config/databases.php');
	}
	require_once ('lib/mvcMain.php');
	session::set ( 'installMode', '0' );
} else {
	require_once ('lib/tempConfig.php');
	// require_once ('config/databases.php');
	require_once ('lib/mvcMain.php');
	session::set ( 'installMode', '1' );
}
class kernel {
	private static $_execute = '';
	private static $_method = '';
	private static $pkg = '';
	public static function init() {
		debug::log ( "init !!!!" );
		session::init();
		self::httpsVerify ();
		self::urlParser ();
	}
	static function pkg() {
		return self::$pkg;
	}
	static function execute() {
		return self::$_execute;
	}
	static function method() {
		return self::$_method;
	}
	private static function urlParser() {
		$pathURI = explode ( '/index.php', $_SERVER ['REQUEST_URI'] );
		$urlSession = $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
		$_met = getUrlTarget ( $urlSession );
		self::$_execute = $_met ['controller'];
		self::$_method = $_met ['method'];
		
		if (session::get ( 'installMode' )) {
			self::$_execute = config::defaultController ();
			self::$_method = config::defaultMethod ();
		} else {
			if (! self::$_execute) {
				self::$_execute = config::defaultController ();
			}
			
			if (! self::$_method) {
				self::$_method = config::defaultMethod ();
			}
		}
		
		self::$pkg = getPackageName ( self::$_execute );
		debug::log ( "PKGTARGET : " . self::$pkg . "/" . self::$_execute );
	}
	private static function httpsVerify() {
		if (is_https ()) {
			config::set ( "siteRoot", str_replace ( 'index.php/', '', 'https://' . $_SERVER ['HTTP_HOST'] . $pathURI [0] ) );
		} else {
			config::set ( "siteRoot", str_replace ( 'index.php/', '', 'http://' . $_SERVER ['HTTP_HOST'] . $pathURI [0] ) );
			if (config::https ()) {
				header ( "location: https://" . $_SERVER ['HTTP_HOST'] . $pathURI [0] );
			}
		}
	}
	private static function accessLevel($pkg) {
		$runlevel = 0;
		
		
		debug::log("accessLevel: " . $pkg . " = "  . self::$_execute . "/" . self::$_method);
		if ((accesspkg::{$pkg} () == "closed") or (access::{self::$_execute} () == "closed"))
			$runlevel = 0;
		if ((accesspkg::$pkg () == "open") or (access::{self::$_execute} () == "open"))
			$runlevel = 1;
		if ((accesspkg::$pkg () == "login") or (access::{self::$_execute} () == "login"))
			$runlevel = 2;
		if ((accesspkg::$pkg () == "admin") or (access::{self::$_execute} () == "admin"))
			$runlevel = 3;
		if ((config::defaultAccess () == "open") and ($runlevel == 0))
			$runlevel = 1;
		if ((config::defaultAccess () == "login") and ($runlevel == 0))
			$runlevel = 2;
		if ((config::defaultAccess () == "closed") and ($runlevel == 0))
			$runlevel = 0;
		return $runlevel;
	}
	private static function runlevel0() {
		boot::init ( "sys", "errors", "closed" );
	}
	private static function runlevel1($pkg) {
		if (! $pkg) {
			$pkg = self::$pkg;
		}
		
		if (! boot::init ( $pkg, self::$_execute, self::$_method )) {
			debug::log ( "Kernel panic" );
		}
	}
	private static function runlevel2($pkg) {
		if ($pkg) {
			self::$pkg = $pkg;
		}
		debug::log("RUNLEVEL 2 logged=" . session::get ( "logged" ));
		if ((getVar ( 'login' ) or getVar ( 'pass' )) and ! (session::get ( "logged" ) == "on")) {
			debug::log("vamos autenticar ???");
			
			$security = new auth ();
			//$oauth = new oauth();
			//$id = $oauth->verify();
			if ($security->users->authUser ( getVar ( 'login' ), getVar ( 'pass' ) )) {
				debug::log("usuario valido ");
				session::init ();
				session::set ( "login", getVar ( 'login' ));
				session::set('authorized',true);
				session::set ( "logged","on");
			} elseif ($id) {
				//$security->loadUser($id);
				$security->user->load($id);
				session::init ();
				session::set ( "login", $security->user->getuserLogin());
				session::set('authorized',true);
				session::set ( "logged","on");
			}
		}
		
		//Oauth
		if ( getvar('access_token') ) {
			$security = new auth ();
			$data = $security->userObj->search(getvar('access_token'),'oauth');
			debug::log("OAUTH ativado");
			if ( $data['idusers'][0] ) {
				debug::log("OAUTH PARA: " . $data['idusers'][0]);
				$security->users->load($data['idusers'][0]);
				session::init ();
				session::set ( "login", $security->users->getlogin());
				debug::log("OAUTH PARA: " . $security->users->getlogin());
				session::set('authorized',true);
				session::set ( "logged","on");
			}
		}
		
		if (session::get ( "logged" ) == "on") {
			$security = new auth ();
			if ($security->acl->valideAcl ( self::$_execute . "/" . self::$_method, session::get ( 'login' ) )) {
				
				boot::init ( self::$pkg, self::$_execute, self::$_method );
			} else {
				self::$pkg= "sys";
				boot::init ( "sys", "denied", "index" );
			}
		} else {
			debug::log("Nao logado " . session::get ( "logged" ));
			session::set ( '_execute', self::$_execute );
			session::set ( '_method', self::$_method );
			self::$_execute = 'login';
			self::$_method = 'index';
			self::$pkg = 'login';
			boot::init ( "login", "login", "index" );
		}
	}
	private static function runlevel3($pkg) {
		if ((session::get ( "logged" ) == "on")) {
			if ($security->acl->valideAcl ( self::$_execute . "/" . self::$_method, session::get ( 'login' ) )) {
				
				boot::init ( $pkg, self::$_execute, self::$_method );
			} else {
				$pkg = "system";
				boot::init ( "sys", "denied", "index" );
			}
		} else {
			
			self::$pkg = 'login';
			boot::init ( "login", "login", "index" );
		}
	}
	static function run() {
		/*
		 * if (! $pkg) {
		 * boot::init ( "sys", "errors", "notFound" );
		 * // die();
		 * }
		 */
		$executerTimer = microtime ( true );
		self::init ();
		debug::log ( "Running " . self::$pkg . "/" . self::$_execute . "/" . self::$_method );
		self::{'runlevel' . self::accessLevel ( self::$pkg )} ( self::$pkg );
		$finish = microtime ( true );
		debug::log ( "Executado em " . ($finish - $executerTimer) );
	}
}