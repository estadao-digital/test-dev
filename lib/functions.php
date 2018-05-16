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
function getPackageName($target) {
	
	if ($target) {
		$ctrl = getcwd () . "/packages/";
		// echo $ctrl;
		// debug::log ( "Opening dir $ctrl" );
		$fl = opendir ( $ctrl );
		while ( false !== ($folder = readdir ( $fl )) ) {
			if (! ($folder == ".") xor ($folder == "..")) {
				
				if (is_dir ( $ctrl . "/" . $folder )) {
					// echo "Abrindo " . $ctrl . $folder . "/controllers/<br>";
					// debug::log ( "Openning " . $ctrl . $folder . "/controllers/" );
					if (is_dir ( $ctrl . $folder . "/controllers/" )) {
						$pkg = opendir ( $ctrl . $folder . "/controllers/" );
						while ( false !== ($folderSub = readdir ( $pkg )) ) {
							// debug::log ( "finding " . $ctrl . $folder . "/controllers/$target" );
							if (! ($folderSub == ".") xor ($folderSub == "..")) {
								list ( $file, $type ) = explode ( '.', $folderSub );
								if ($file == $target) {
									// debug::log ( "$target found in $folder" );
									$package = $folder;
								}
							}
						}
					} else {
						mkdir ( $ctrl . $folder . "/controllers/", 0700 );
						mkdir ( $ctrl . $folder . "/models/", 0700 );
						mkdir ( $ctrl . $folder . "/views/", 0700 );
					}
				}
			}
		}
	}
	
	return $package;
}

spl_autoload_register ( function ($classname) {
	$pkg = kernel::pkg();
	$class = str_replace ( '\\', DIRECTORY_SEPARATOR, $classname );
	$p = explode ( DIRECTORY_SEPARATOR, $class );
	$plugin = $p [0];
	
	if (file_exists ( "packages/$pkg/models/$class" . ".php" )) {
		// echo "classe $class carregada<br>";
		
		require_once ("packages/$pkg/models/$class" . ".php");
		debug::log ( "Carregando packages/$pkg/models/$class" . ".php" );
	} elseif (file_exists ( "packages/$pkg/views/$class" . ".php" )) {
		
		require_once ("packages/$pkg/views/$class" . ".php");
		debug::log ( "Carregando packages/$pkg/views/$class" . ".php" );
		// echo "classe $class carregada<br>";
	} elseif (file_exists ( "plugins/$plugin/$class" . ".php" )) {
		
		require_once ("plugins/$plugin/$class" . ".php");
		debug::log ( "Carregando plugins/$plugin/$class" . ".php" );
		// echo "classe $class carregada<br>";
	} else {
		debug::log ( "Tentei carretar  packages/$pkg/models/$class" . ".php" );
		debug::log ( "Tentei carretar  packages/$pkg/views/$class" . ".php" );
		debug::log ( "Tentei carretar plugins/$plugin/$class" . ".php" );
	}
} );
function is_https() {
	if (isset ( $_SERVER ['HTTPS'] ) and $_SERVER ['HTTPS'] == 1) {
		return TRUE;
	} elseif (isset ( $_SERVER ['HTTPS'] ) and $_SERVER ['HTTPS'] == 'on') {
		return TRUE;
	} else {
		return FALSE;
	}
}
function getUrlTarget($url) {
	
	$urlSite = explode ( "index.php", $url );
	$out ['siteRoot'] = $urlSite [0];
	$url = str_ireplace($out ['siteRoot'], '', $url);
	$url = str_ireplace('index.php', '', $url);
	$url = str_ireplace('//', '/', $url);
	$getArgs = explode('?', $url);
	$url = str_ireplace('?' . $getArgs[1], '', $url);
	debug::log($url);
	
	
	$aux = explode('/', $url);
	
	if ($aux [2]) {
		$out ['method'] = $aux [2];
		
	} else {
		$out ['method'] = config::defaultMethod ();
	}
	if ($aux [1]) {
		$out ['controller'] = $aux [1];
	} else {
		$out ['controller'] = config::defaultController ();
	}
	
	debug::log ( print_r ( $out, true ) );
	
	return $out;
}
function getVar($varName) {
	if ($_GET [$varName]) {
		$out = addslashes ( $_GET [$varName] );
	}
	if ($_POST [$varName]) {
		$out = addslashes ( $_POST [$varName] );
	}
	return $out;
}
