<?php

/*
 *  Copyright (C) 2016 vagner
 *
 *    This file is part of Kolibri.
 *
 *    Kolibri is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    Kolibri is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with Kolibri.  If not, see <http://www.gnu.org/licenses/>.
 */

class treeview {
	function __construct(){
		debug::log("Loading treeview");
		page::addCssFile("::siteroot::/plugins/treeview/src/css/bootstrap-treeview.css");
		page::addJsFile("::siteroot::/plugins/treeview/src/js/bootstrap-treeview.js");
		debug::log("loaded treeview ");
	}
}