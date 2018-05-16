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

/**
 * Description of databases
 *
 * @author vagner
 */
class database {
	private static $connections = array ();
	public static function add($conectionName, $type = 'mysql', $host, $port = '3306', $user, $pass, $database) {
		self::$connections [$conectionName] ['type'] = $type;
		self::$connections [$conectionName] ['host'] = $host;
		self::$connections [$conectionName] ['user'] = $user;
		self::$connections [$conectionName] ['pass'] = $pass;
		self::$connections [$conectionName] ['database'] = $database;
	}
	
	private static function failMysqlConnection ($link) {
	      debug::log(mysqli_error($link));
	      page::addBody("Fails !");
	      
	}
	
	public static function __callstatic($conectionName, $arg) {
		/*
	    if ((self::$connections [$conectionName] ['type']) == 'mysql') {
			if (function_exists ( "mysqli_connect" )) {
				if ((self::$connections [$conectionName] ['host'])) {
					$link = mysqli_connect ( self::$connections [$conectionName] ['host'], self::$connections [$conectionName] ['user'], self::$connections [$conectionName] ['pass'], self::$connections [$conectionName] ['database'], self::$connections [$conectionName] ['port'] ) or self::failMysqlConnection( $link );
				}
			} else {
				//page::addBody ( "<h1>ERROR</h1> <p>Mysqli not avaliable !</p>" );
				//page::render ();
				die('<h1>ERROR</h1> <p>Mysqli not avaliable !</p>');
				//debug::log('ERROR: Mysqli not avaliable !');
			}
			
			if ((self::$connections [$conectionName] ['host'])) {
				if (! $link) {
					echo "Error: Unable to connect to MySQL." . PHP_EOL;
					echo "Debugging errno: " . mysqli_connect_errno () . PHP_EOL;
					echo "Debugging error: " . mysqli_connect_error () . PHP_EOL;
					exit ();
				}
			}
		}
		if ((self::$connections [$conectionName] ['type']) == 'sqlite') {
			if (function_exists ( "sqlite_open" )) {
				$link = sqlite_open(self::$connections [$conectionName] ['host'], 0666, $sqliteerror);
				if ( ! $link ) {
					echo ($sqliteerror);
					exit();
				}
			}else{
				//page::addBody ( "<h1>ERROR</h1> <p>SQLite not avaliable !</p>" );
				//debug::log('ERROR: SQLite not avaliable !');
				die('<h1>ERROR</h1> <p>SQLite not avaliable !</p>');
				//page::render ();
			}
		}
		*/
	    if ((self::$connections [$conectionName] ['host'])) {
	        #database::add("kolibriDB","mysql" , "192.168.1.4", "3306", "root", "123456", "kolibri");
	        #database::add("kolibriDB","sqlite" , __DIR__ . "../data/menu.sqlite", "", "", "", "kolibri");
	        try {
	        $link = new PDO( self::$connections [$conectionName] ['type'] . ':host=' . self::$connections [$conectionName] ['host'] . ';port='  . self::$connections [$conectionName] ['port']  . ';dbname=' . self::$connections [$conectionName] ['database'], self::$connections [$conectionName] ['user'], self::$connections [$conectionName] ['pass'] );
	        } catch (PDOException $e) {
	            debug::log("Database Error: " . $e->getMessage());
	            debug::log("Database info:" .  self::$connections [$conectionName] ['type'] . ':host=' . self::$connections [$conectionName] ['host'] . ';port='  . self::$connections [$conectionName] ['port']  . ';dbname=' . self::$connections [$conectionName] ['database'], self::$connections [$conectionName] ['user'], self::$connections [$conectionName] ['pass'] );
	        }
	    }
	    
	    
		return $link;
	}
	public static function getType($conectionName) {
		return self::$connections [$conectionName] ['type'];
	}
}
