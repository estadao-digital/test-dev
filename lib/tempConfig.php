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


//config::set("theme","default");
config::set("theme","material");


$spliter = explode('index.php', $_SERVER['REQUEST_URI']);

//Website URL
#config::set("siteRoot",'http://' . $_SERVER['HTTP_HOST'] .  $spliter[0]);


// Default Controller
config::set("defaultController","setup");



// Default Metlhod
config::set("defaultMethod", "index");


//Default Security
config::set("defaultAccess","open");

