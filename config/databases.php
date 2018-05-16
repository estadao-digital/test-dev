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
					
					
					/*
					* Here add connection to mysql using the above syntax
					* datababase::add(conectionName, host, port, user, pass, database);
					*/
					
					database::add("kolibriDB","mysql" , "127.0.0.1", "3306", "root", "minard", "carro");
					#database::add("kolibriDB","sqlite" , __DIR__ . "../data/menu.sqlite", "", "", "", "kolibri");