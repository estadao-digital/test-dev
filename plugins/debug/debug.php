<?php
/*
 * Copyright (C) 2017 vagner
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
final class debug {
	private function get_caller_info() {
		$c = '';
		$file = '';
		$func = '';
		$class = '';
		$trace = debug_backtrace ();
		if (isset ( $trace [2] )) {
			$file = $trace [1] ['file'];
			$func = $trace [2] ['function'];
			if ((substr ( $func, 0, 7 ) == 'include') || (substr ( $func, 0, 7 ) == 'require')) {
				$func = '';
			}
		} else if (isset ( $trace [1] )) {
			$file = $trace [1] ['file'];
			$func = '';
		}
		if (isset ( $trace [3] ['class'] )) {
			$class = $trace [3] ['class'];
			$func = $trace [3] ['function'];
			$file = $trace [2] ['file'];
		} else if (isset ( $trace [2] ['class'] )) {
			$class = $trace [2] ['class'];
			$func = $trace [2] ['function'];
			$file = $trace [1] ['file'];
		}
		if ($file != '')
			$file = basename ( $file );
		$c = $file . ": ";
		$c .= ($class != '') ? ":" . $class . "->" : "";
		$c .= ($func != '') ? $func . "(): " : "";
		return ($c);
	}
	public static function log($msg, $loglevel = 0) {
		if ( ! config::get ( 'loglevel' )) {
			config::set('loglevel', '0');
		}
		if ($loglevel <= config::get ( 'loglevel' )) {
			if ( is_array($msg)) {
				$msg = print_r($msg,true);
			}
			$msgOut = "===============================================================\n";
			$msgOut .= date ( 'Y-m-d H:i:s' ) . " " . self::get_caller_info () . " \n";
			$msgOut .= "===============================================================\n";
			$msgOut .= $msg . "\n";
			$msgOut .= "===============================================================\n";
			// $msgOut .= print_r(debug_backtrace(),true);
			if (is_writable ( __dir__ . "/../../log/Kolibri_debug.log" )) {
				$handle = fopen ( __dir__ . "/../../log/Kolibri_debug.log", "a+" );
				fwrite ( $handle, $msgOut . "\n" );
				fclose ( $handle );
			}
		}
	}
}