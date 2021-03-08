<?php

class Connection
{    
    protected static $CI = null;
    protected static $CIAgent = null;

    protected static $timeLimit = null;
    protected static $isKeepAlive = false;

    protected static function getCI()
    {
        if (self::$CI == null)
            self::$CI = \CodeIgniter::getInstance();

        return self::$CI;      
    }
   
    protected static function getCIAgent()
    {
        if (self::$CIAgent == null)
        {
            self::getCI()->load->library('user_agent');
            self::$CIAgent = self::getCI()->agent;
        }
        
        return self::$CIAgent;    
    }
    
    public static function isLocal()
    { return self::getIpAddress() == "127.0.0.1"; }
    
    public static function isExternal()
    { return !self::isLocal(); }
    
    public static function getHost()
    {
        $hostName = "";
        if(array_key_exists('HTTP_HOST', $_SERVER)) {
            $hostName = $_SERVER['HTTP_HOST'];
            $strpos = strpos($hostName, ':');
            if($strpos !== false)
                $hostName = substr($hostName, $strpos);    
        }
        return stringEx($hostName)->toString();
    }

    public static function getProtocol()
    {
        if (\Connection::isCommandLine())
            return "cli";

        $current = \Http\Url::getCurrent();
        $protocol = ("" . $current->protocol);
        $protocol = stringEx($protocol)->toLower();
        return $protocol;
    }


    public static function getLocation()
    {
        $ipAddress = self::getIpAddress();
        if ($ipAddress == "127.0.0.1")
            $ipAddress = \Server::getIpAddress();
        if ($ipAddress == null) return null;
        return \Location::getByIpAddress($ipAddress);
    }

    public static function isSecure()
    { return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443); }

    public static function getIpAddress()
    {
        $ipAddress = self::getCI()->input->ip_address();
        return $ipAddress;
    }
    
    public static function isValidIpAddress($ipAddress)
    {
        $ipAddress = stringEx($ipAddress)->toString();
        return self::getCI()->input->valid_ip($ipAddress);
    }
    
    public static function getUserAgent()
    {
        return self::getCI()->input->user_agent();
    }
    
    public static function getRequestHeaders()
    {
        $requestHeaders = self::getCI()->input->request_headers();
        if ($requestHeaders == null) return null;
        return Arr($requestHeaders);
    }
    
    public static function isAjaxRequest()
    {
        return self::getCI()->input->is_ajax_request();
    }

    public static function isCommandLine()
    { return self::isCommandLineRequest(); }

    public static function isCommandLineRequest()
    {
        return (stringEx(php_sapi_name())->toLower() == cli);
        //return self::getCI()->input->is_cli_request();
    }
    
    public static function isBrowser()
    { return \Browser::isBrowser(); }
    
    public static function getBrowser()
    { return \Browser::getBrowser(); }
 
    public static function getBrowserVersion($returnNumber = true)
    { return \Browser::getBrowserVersion($returnNumber); }


//    public static function getBrowserEngine()
//    {
//        $browser = self::getBrowser();
//
//        if ($browser == "opera")
//            return ((self::getBrowserVersion() <= 12) ? "presto" : "blink");
//
//        if (stringEx($browser)->equalsAny(["360securebrowser", "bentobrowser", "greenbrowser", "internetexplorer", "menubox", "realplayer", "slimbrowser", "tencenttraveler", "webbie"]))
//            return "trident";
//        elseif (stringEx($browser)->equalsAny(["conkeror", "k-meleon", "kmeleon", "mozillafirefox", "yahoo", "yahoo!"]))
//            return "gecko";
//        elseif (stringEx($browser)->equalsAny(["palemoon", "basilisk"]))
//            return "gonna";
//        elseif (stringEx($browser)->equalsAny(["baidu", "maxthon", "avantbrowser", "lunascape"]))
//            return "blink";
//        elseif (stringEx($browser)->equalsAny(["konqueror", "konquerorembedded"]))
//            return "khtml";
//        elseif (stringEx($browser)->equalsAny(["internetchannel", "nintentodsbrowser"]))
//            return "presto";
//    }

    public static function isRobot()
    {
        $CIAgent = self::getCIAgent();

        return (
            $CIAgent->is_robot() == true ||
            \Input::post([robot => bool])->robot == true ||
            \Input::get([robot => bool])->robot == true
        );
    }
    
    public static function getRobot()
    {
        $CIAgent = self::getCIAgent();

        $robot = $CIAgent->robot();
        if (stringEx($robot)->isEmpty() && (\Input::post([robot => bool])->robot == true || \Input::get([robot => bool])->robot == true))
            $robot = "forced";

        return $robot;
    }
    
    public static function getPlatformName()
    { return \Browser::getPlatformName(); }

    public static function getPlatform()
    { return \Browser::getPlatform(); }
    
    public static function isMobile()
    { return \Browser::isMobile(); }
    
    public static function getMobileDevice()
    {
//        $CIAgent = self::getCIAgent();
//        return $CIAgent->mobile();
    }
    
    public static function isReferral()
    {
        $CIAgent = self::getCIAgent();
        return $CIAgent->is_referral();
    }
    
    public static function getReferral()
    {
        $CIAgent = self::getCIAgent();
        return $CIAgent->referrer();
    }

    public static function getOrigin()
    {
        $origin = @$_SERVER['HTTP_ORIGIN'];
        $origin = \stringEx($origin)->toString();

        if (stringEx($origin)->isEmpty())
            return null;

        return new \Http\Url($origin);
    }

    public static function getOriginUrl()
    {
        $origin = @$_SERVER['HTTP_ORIGIN'];
        return \stringEx($origin)->toString();
    }
    
    public static function getRequestMethod()
    {
        $method = @$_SERVER['REQUEST_METHOD'];
        return \stringEx($method)->toLower();
    }

    public static function isEstablished()
    {
        if (@\connection_aborted() === 1)
            return false;
        return true;
    }

    public static function keepAlive($timeLimit = true)
    {
        if (self::$isKeepAlive === true)
            return;

        if (self::$timeLimit === null)
            self::$timeLimit = intEx(\ini_get('max_execution_time'))->toInt();

        \ini_set('max_execution_time', 0);
        \ignore_user_abort(true);
        if ($timeLimit == true)
            \set_time_limit(0);
    }

    public static function normalize()
    {
        if (self::$isKeepAlive === false)
            return;

        \ini_set('max_execution_time', self::$timeLimit);
        \ignore_user_abort(false);
        \set_time_limit(self::$timeLimit);
    }

    public static function getUniqueId()
    {
        return \Security\Hash::toSha1(
            \Browser::getHash() . "-" .
            \Connection::getIpAddress() . "-" .
            \Config::get()->server->cryptographyKey
        );
    }

    const METHOD_POST = "post";
    const METHOD_GET  = "get";
}