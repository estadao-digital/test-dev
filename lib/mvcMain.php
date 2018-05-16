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

define('kversion',20180308);

function templateCall($pluginClass, $pluginMethod)
{
    $string = explode('(', $pluginMethod);
    
    $method = $string[0];
    $string = explode(")", $string[1]);
    $param = $string[0];
    $param = str_replace("'", '', $param);
    $param = str_replace('"', '', $param);
    $obj = new $pluginClass();
    $out = $obj->$method($param);
    return $out;
}

class boot
{

    public static function init($package, $controller, $method)
    {
    	if ($package) {
    		
    		$pkg = $package;
            session::init();
            // require_once ("controllers/$pkg/" . $controller . ".php"); # Codigo depreciado para vers������o 0.4
            require_once ("packages/$package/controllers/" . $controller . ".php");
            debug::log("include file packages/$package/controllers/" . $controller . ".php");
            debug::log("Loading $package/ $method");
            ob_start();
            $control = new $controller();
            if (method_exists($control, $method)) {
                $control->{$method}();
            } elseif (method_exists($control, '__call')) {
                $control->{$method}();
            } else {
                boot::init("sys", "errors", "notFound");
            }
            ob_end_clean();
        } else {
            return false;
        }
    }
}

class controller
{

    // private $view;
    public $request;

    public $requestType;

    public $cookie;

    function __construct()
    {
        // $this->view = new view ();
        $this->requestType = $_SERVER['REQUEST_METHOD'];
        
        foreach ($_GET as $key => $value) {
            
            $this->request[$key] = addslashes($value);
        }
        
        foreach ($_POST as $key => $value) {
            if (! is_array($value)) {
                $this->request[$key] = addslashes($value);
            } else {
                $this->request[$key] = $value;
            }
            // $this->request [$key] = $value ;
        }
    }
}

class model
{

    function __construct()
    {
        // $this->view = new view ();
        $this->requestType = $_SERVER['REQUEST_METHOD'];
        
        foreach ($_GET as $key => $value) {
            
            $this->request[$key] = addslashes($value);
        }
        
        foreach ($_POST as $key => $value) {
            
            $this->request[$key] = addslashes($value);
            // $this->request [$key] = $value ;
        }
    }
}

final class page
{

    private static $theme;

    private static $body;

    private static $jsfile = array();

    private static $cssfile = array();

    private static $jscode = array();

    private static $csscode = array();

    private static $code = array();

    private static $title;

    private static $lang;

    private static $description;

    private static $robots;

    private static $keywords;

    private static $page;

    private static $callme = array();

    public static function initialize()
    {
        self::$theme = config::theme();
        // ob_start ();
        // $this->page = ob_get_contents ();
        // ob_end_clean ();
        self::$body = array();
    }

    public static function addCssFile($filePath)
    {
        self::$cssfile[] = $filePath;
    }

    public static function addJsFile($filePath)
    {
        self::$jsfile[] = $filePath;
    }

    public static function addJsScript($script)
    {
        self::$jscode[] = $script;
    }

    public static function addCssScript($script)
    {
        self::$csscode[] = $script;
    }

    public static function addBody($body)
    {
        $idx = md5($body);
        self::$body[$idx] .= $body;
        // self::$body [] .= $body;
    }

    public static function addCode($position, $cod)
    {
        self::$code[$position] .= $cod;
    }

    public static function setTheme($theme)
    {
        if (is_dir("themes/$theme")) {
            self::$private = $theme;
        }
    }

    public static function render($body = "index")
    {
        $idx = md5(debug_backtrace()[1]['file']);
        // debug::log ( debug_backtrace () [1] ['file'] );
        // debug::log ( debug_backtrace () [1] ['line'] );
        if (! self::$callme[$idx]) {
            self::$callme[$idx] = 1;
            
            if (! self::$theme) {
                self::$theme = config::theme();
            }
            
            self::$cssfile = array_unique(self::$cssfile);
            self::$jsfile = array_unique(self::$jsfile);
            // arsort( self::$jsfile );
            self::$jscode = array_unique(self::$jscode);
            self::$csscode = array_unique(self::$csscode);
            
            if (file_exists("themes/" . self::$theme . "/head.html")) {
                $header = file("themes/" . self::$theme . "/head.html");
                
                foreach ($header as $line) {
                    
                    $line = str_replace("::title::", self::$title, $line);
                    $line = str_replace("::lang::", self::$lang, $line);
                    $line = str_replace("::description::", self::$description, $line);
                    $line = str_replace("::keywords::", self::$keywords, $line);
                    $line = str_replace("::robots::", self::$robots, $line);
                    $line = str_replace("::siteroot::", config::siteRoot(), $line);
                    $line = str_replace("::siteRoot::", config::siteRoot(), $line);
                    $line = str_replace("::sitename::", config::siteName(), $line);
                    
                    // Loading CSS
                    $fcss = '';
                    foreach (self::$cssfile as $cssf) {
                        $cssf = str_replace("::siteroot::", config::siteRoot(), $cssf);
                        $fcss .= "<link rel='stylesheet' href='$cssf'>\n";
                    }
                    $line = str_replace("::cssfile::", $fcss, $line);
                    $fcssCode = '';
                    foreach (self::$csscode as $csscode) {
                        
                        $fcssCode .= "
							<style>
								$csscode
							</style>
							";
                    }
                    $line = str_replace("::csscode::", $fcssCode, $line);
                    
                    // End
                    // Loading JS
                    $fjs = '';
                    foreach (self::$jsfile as $jsfil) {
                        
                        $jsfil = str_replace("::siteroot::", config::siteRoot(), $jsfil);
                        $fjs .= "<script  src='$jsfil'></script>\n";
                    }
                    $line = str_replace("::jsfile::", $fjs, $line);
                    $jCode = '';
                    foreach (self::$jscode as $jscode) {
                        
                        $jCode .= "
				<script type=\"text/javascript\">
				$jscode
				</script>
				";
                    }
                    $line = str_replace("::jscode::", $jCode, $line);
                    
                    echo charConverter($line);
                }
            }
            
            /*
             * Body process
             */
            
            if ($body != 'index') {
                if (file_exists("themes/" . self::$theme . "/$body.html")) {
                    
                    $bodyFile = file("themes/" . self::$theme . "/$body.html");
                } else {
                    $bodyFile = file("themes/" . self::$theme . "/index.html");
                }
            } else {
                
                $_execute = kernel::execute();
                if (file_exists("themes/" . self::$theme . "/$_execute.html")) {
                    $bodyFile = file("themes/" . self::$theme . "/$_execute.html");
                } else {
                    $bodyFile = file("themes/" . self::$theme . "/index.html");
                }
            }
            // debug::log ( "themes/" . self::$theme . "/$body.html" );
            // debug::log ( count ( self::$body ) );
            if (is_array(self::$body)) {
                foreach (self::$body as $b) {
                    $myBody .= $b;
                }
            }
            // debug::log("-----------------------------");
            // debug::log ( "executando bodyfile : " . count ( $bodyFile ) );
            $i = 0;
            foreach ($bodyFile as $line) {
                
                $i ++;
                
                // Loading CSS
                $fcss = '';
                // debug::log("ccsfile " . print_r(self::$cssfile,true));
                foreach (self::$cssfile as $cssf) {
                    $cssf = str_replace("::siteroot::", config::siteRoot(), $cssf);
                    $fcss .= "<link rel='stylesheet' href='$cssf'>\n";
                    // debug::log("executando ccsfile ");
                }
                $line = str_replace("::cssfile::", $fcss, $line);
                $fcssCode = '';
                foreach (self::$csscode as $csscode) {
                    // debug::log("executando csscode ");
                    $fcssCode .= "
					<style>
					$csscode
					</style>
					";
                }
                $line = str_replace("::csscode::", $fcssCode, $line);
                
                // End
                // Loading JS
                $fjs = '';
                foreach (self::$jsfile as $jsfil) {
                    // debug::log("executando jsfile ");
                    $jsfil = str_replace("::siteroot::", config::siteRoot(), $jsfil);
                    $fjs .= "<script  src='$jsfil'></script>\n";
                }
                $line = str_replace("::jsfile::", $fjs, $line);
                $jCode = '';
                foreach (self::$jscode as $jscode) {
                    // debug::log("executando jscode ");
                    $jCode .= "
					<script type=\"text/javascript\">
					$jscode
					</script>
					";
                }
                $line = str_replace("::jscode::", $jCode, $line);
                
                // debug::log($i);
                /*
                 * Este trecho experimental visa permitir que o template nao apenas indique locais de input de conteudo como
                 * possa especificar parametros como chamar uma classe e um metodo em especifico
                 */
                
                $pattern = '/::(.*)::(.*):(.*):/';
                preg_match_all($pattern, $line, $matches, PREG_OFFSET_CAPTURE);
                // echo count($matches[0]);
                $out = $matches[0];
                foreach ($out as $item) {
                    
                    $tag = explode(":", $item[0]);
                    
                    // if (self::$code [$tag[]]) {
                    $line = str_replace($item[0], templateCall($tag[4], $tag[5]), $line);
                    
                    $line = str_replace("::siteroot::", config::siteRoot(), $line);
                    /*
                     * } else {
                     * $line = str_replace($item [0], '', $line);
                     * $line = str_replace("::siteroot::", config::siteRoot(), $line);
                     * }
                     */
                }
                
                /*
                 * FIM
                 */
                
                $line = str_replace("::title::", self::$title, $line);
                $line = str_replace("::lang::", self::$lang, $line);
                $line = str_replace("::description::", self::$description, $line);
                $line = str_replace("::keywords::", self::$keywords, $line);
                $line = str_replace("::robots::", self::$robots, $line);
                $line = str_replace("::siteroot::", config::siteRoot(), $line);
                $line = str_replace("::siteRoot::", config::siteRoot(), $line);
                $line = str_replace("::sitename::", config::siteName(), $line);
                
                $line = str_replace("::BODY::", $myBody, $line);
                $line = str_replace("::body::", $myBody, $line);
                $line = str_replace("::siteroot::", config::siteRoot(), $line);
                $line = str_replace("::sitename::", config::siteName(), $line);
                
                $pattern = '/::+[a-zA-Z0-9]+::/';
                
                preg_match_all($pattern, $line, $matches, PREG_OFFSET_CAPTURE);
                
                // echo count($matches[0]);
                $out = $matches[0];
                
                foreach ($out as $item) {
                    
                    $tag = str_replace(":", "", $item[0]);
                    if (self::$code[$tag]) {
                        $line = str_replace($item[0], self::$code[$tag], $line);
                        $line = str_replace("::siteroot::", config::siteRoot(), $line);
                    } else {
                        $line = str_replace($item[0], '', $line);
                        $line = str_replace("::siteroot::", config::siteRoot(), $line);
                    }
                }
                
                echo charConverter($line);
            }
            
            // die(date('H:i:s'));
            if (file_exists("themes/" . self::$theme . "/foot.html")) {
                
                $foot = file("themes/" . self::$theme . "/foot.html");
                foreach ($foot as $line) {
                    foreach (self::$jsfile as $jsfile) {
                        $fjs .= "<script type='javascript' src='$jsfile'>\n";
                    }
                    $line = str_replace("::jsfile::", $fjs, $line);
                    foreach (self::$jscode as $jscode) {
                        $fcssCode .= "
				<script>
				$jscode
				</script>
				";
                    }
                    $line = str_replace("::jscode::", $jscode, $line);
                    $line = str_replace("::siteroot::", config::siteRoot(), $line);
                    
                    $pattern = '/::+[a-zA-Z0-9]+::/';
                    preg_match_all($pattern, $line, $matches, PREG_OFFSET_CAPTURE);
                    $out = $matches[0];
                    foreach ($out as $item) {
                        $tag = str_replace(":", "", $item[0]);
                        if (self::$code[$tag]) {
                            $line = str_replace($item[0], self::$code[$tag], $line);
                            $line = str_replace("::siteroot::", config::siteRoot(), $line);
                        } else {
                            $line = str_replace($item[0], '', $line);
                            $line = str_replace("::siteroot::", config::siteRoot(), $line);
                        }
                    }
                    
                    echo charConverter($line);
                }
            }
            // die();
            global $executerTimer;
            if (config::showexectime()) {
                echo $time_elapsed_secs = round(microtime(true) - $executerTimer, 3);
            }
        }
        exit();
    }

    public static function renderAjax()
    {
    	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    	header("Cache-Control: post-check=0, pre-check=0", false);
    	header("Pragma: no-cache");
   
    	foreach (self::$body as $b) {
            echo $b;
        }
        die();
    }
}

class session
{

    //private $openAllController;
    private static $ses;
   

    public static function init()
    {
        if ( database::kolibriDB()) {
            self::$ses = new sessionDB();
        }
        session_start();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return $_SESSION[$key];
    }

    public static function destroy()
    {
        session_start();
        $_SESSION = array();
        unset($_SESSION);
    }
}

class sessionDB
{

    private $db;

    function __construct()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `sessions` (
                  `id` varchar(32) NOT NULL,
                  `access` int(10) unsigned DEFAULT NULL,
                  `data` text,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        $this->db = new mydataobj();
        $this->db->setconn(database::kolibriDB());
        $this->db->query($sql);
        
        session_set_save_handler(array(
            $this,
            "_open"
        ), array(
            $this,
            "_close"
        ), array(
            $this,
            "_read"
        ), array(
            $this,
            "_write"
        ), array(
            $this,
            "_destroy"
        ), array(
            $this,
            "_gc"
        ));
    }

    function _open()
    {
        if ($this->db) {
            // Return True
            return true;
        }
        // Return False
        return false;
    }

    function _close()
    {
        unset($this->db);
        return true;
    }

    function _read($id)
    {
        $this->db->query("SELECT data FROM sessions WHERE id = '$id'");
        return $this->db->getdata();
    }

    function _write($id, $data)
    {
        
        // Create time stamp
        $access = time();
        
        // Set query
        $this->db->query("REPLACE INTO sessions VALUES ('$id', '$access', '$data')");
    }

    function _destroy($id)
    {
        $this->db->query("DELETE FROM sessions WHERE id = '$id'");
        return true;
    }

    function _gc($max)
    {
        $old = time() - $max;
        
        // Set query
        $this->db->query("DELETE * FROM sessions WHERE access < '$old'");
    }
}
