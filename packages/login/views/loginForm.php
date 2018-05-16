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

class loginForm {
	private $message;
	function __construct() {
		$menu = new modelMenu ();
		page::addCode ( 'menu', $menu->getMenu () );
	}
	
	function addMsg($msg) {
		$this->message = $msg;
	}
	
	function index(){
		
			
		$action = config::siteRoot() . "/index.php/login/autenticar/";
		$cod = ' <form id="signupform" class="form-horizontal" method="post" action="' . $action . '" role="form">
              <h1>Login Form </h1>
              <div>
                <input type="text" class="form-control"  name="login" placeholder="login@provider.com" required="1" />
              </div>
              <div>
                <input type="password"  name="pass" class="form-control" placeholder="Password" required="1" />
              </div>
              <div>
                <a class="btn btn-default submit" onclick=\'document.getElementById("signupform").submit();\'>Log in</a>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                 <p class="change_link">New to site?
                 <a href="#" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                   <img width="15%" src="::siteroot::/media/kolibriName.png">
                 
                </div>
              </div>
            </form>';
		
		
		page::addCssFile('aquivo.css');
		page::addCssScript('csscode!!!!!');
		page::addJsFile('arquivos.js');
		
		page::addBody($cod);
		page::render();
	}
	
	function goPage($url = '') {
		if ( ! $url  ) {
			$url = config::siteRoot();
			page::addBody("<meta http-equiv=\"refresh\" content=\"0; url=$url\">");
			page::render();
		}else {
			
			page::addBody("<meta http-equiv=\"refresh\" content=\"0; url=$url\">");
			page::render();
		}
	}
	
}