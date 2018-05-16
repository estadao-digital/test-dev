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
class login extends controller
{
    
    function __construct()
    {
        
        if (is_https()) {
            
            $requesAddress = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $_SERVER['REQUEST_URI'];
        } else {
            $requesAddress = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $_SERVER['REQUEST_URI'];
            if (config::https()) {
                header("location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            }
            debug::log("cometendo suicidio pois location nao é https ?");
            //die();
        }
        
        
        
        parent::__construct();
        $requesAddress = $_SERVER[REQUEST_URI];
        
        if (strpos($requesAddress, "login") === false) {
            session::set('requesAddress', $requesAddress);
            debug::log(" Link : " . $requesAddress);
            
        }
    }
    
    function index($msg = '')
    {
        debug::log("carregando login");
        debug::log(print_r($this->request,true));
        if ((! $this->request['pass']) and (! $this->request['login']) or ($msg)) {
            debug::log("xaxaxaxaxaxa");
            // echo session::get ( 'login' );
            if (! session::get('login')) {
                $out = new loginForm();
                if ($msg) {
                    $out->addMsg($msg);
                }
                $out->index();
            } else {
                $out = new loginForm();
                
                if (strpos(session::get('requestAddress'), "login") === false) {
                    $out->goPage();
                } else {
                    $out->goPage(session::get('requestAddress'), "login");
                }
            }
        } else {
            $this->autenticar();
        }
    }
    
    function autenticar()
    {
        if ($this->request['login'] and $this->request['pass']) {
            
            $s = new autenticator();
            $result = $s->authentic($this->request['login'], $this->request['pass']);
            debug::log("Autenticado -: " . $result);
            if ($result) {
                debug::log("processando redirect");
                $s->register();
                //$out = new loginForm();
                //$out->goPage(session::get('requestAddress'), "login");
                page::addBody('<meta http-equiv="refresh" content="0"; url=' . session::get('requestAddress') . ">");
                page::addCode('MSG', '<meta http-equiv="refresh" content="0">');
                page::renderAjax();
                debug::log("codigo ajax enviado");
            } else {
                debug::log("Login e senha incorretos");
                $this->index("Login e senha incorretos !");
            }
        } else {
            debug::log("Login e senha em branco");
            $this->index("Login e senha em branco");
        }
    }
    
    function logout($loginAgain = '')
    {
        session::destroy();
        
        if ( $loginAgain) {
            $this->index();
            
        }else{
            $site = config::siteRoot();
            $cod = '"<meta http-equiv="refresh" content="0; url=' . $site. '">"';
            page::addBody($cod);
            page::renderAjax();
        }
    }
}