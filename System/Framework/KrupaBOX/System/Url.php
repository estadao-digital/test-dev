<?php

/**
 * @property integer $port
 * @property string $user
 * @property string $password
 * @property string $protocol
 * @property string $path
 * @property string $parameters
 * @property string $suffix
 * @property string $domain
 * @property string $subdomain
 * @property string $canonical
 */
class Url
{
    protected static $lastResponseHeader = null;
    protected static $__isInitialized    = false;

    protected static function __initialize()
    {
        if (self::$__isInitialized == true) return;

        \KrupaBOX\Internal\Library::load("Pdp");
        \KrupaBOX\Internal\Library::load("Purl");

        //\Import::PHP(__KRUPA_PATH_LIBRARY__ . "Pdp/Autoloader.php");
//        \Import::PHP(__KRUPA_PATH_LIBRARY__ . "Purl/Autoloader.php");
//
//        //\Pdp\Autoloader::register();
//        \Purl\Autoloader::register();

        self::$__isInitialized = true;
    }

    protected $url = null;
    protected $urlParser = null;

    public function __construct($url)
    {
        self::__initialize();

        $this->url       = stringEx($url)->toString();
        if (!stringEx($this->url)->isEmpty())
            $this->urlParser = new \Purl\Url($this->url);
    }

    public function __set($key, $value)
    {
        if ($this->urlParser == null)
            return null;

        if ($key == port)
            $this->urlParser->set(port, (($value != null) ? \intEx($value)->toInt() : null));
        elseif ($key == user)
            $this->urlParser->set(user, (($value != null) ? \stringEx($value)->toString() : null));
        elseif ($key == password)
            $this->urlParser->set(pass, (($value != null) ? \stringEx($value)->toString() : null));
        elseif ($key == protocol)
            $this->urlParser->set(scheme, (($value != null) ? \stringEx($value)->toString() : null));
        elseif ($key == path)
            $this->urlParser->set(path, (($value != null) ? \stringEx($value)->toString() : null));
        elseif ($key == parameters)
            $this->urlParser->set(query, (($value != null) ? \stringEx($value)->toString() : null));
    }

    public function __get($key)
    {
        if ($this->urlParser == null)
            return null;
        
        if ($key == port)
            return $this->urlParser->port;
        elseif ($key == user)
            return $this->urlParser->user;
        elseif ($key == password)
            return $this->urlParser->pass;
        elseif ($key == protocol)
            return $this->urlParser->scheme;
        elseif ($key == path)
            return $this->urlParser->path;
        elseif ($key == parameters)
            return $this->urlParser->query;

        elseif ($key == suffix)
            return $this->urlParser->publicSuffix;
        elseif ($key == domain)
            return $this->urlParser->registerableDomain;
        elseif ($key == subdomain)
            return $this->urlParser->subdomain;
        elseif ($key == canonical)
            return $this->urlParser->canonical;

        return null;
    }

    public function removeParameter($key)
    { $this->urlParser->query->set($key, null); return $this; }

    public function setParameter($key, $value)
    { $this->urlParser->query->set($key, (($value != null) ? \stringEx($value)->toString() : null)); return $this; }

    public function removeAllParameters()
    {
        $parameters = $this->getParameters();
        foreach ($parameters as $key => $_)
            $this->removeParameter($key);
        return $this;
    }

    public function setParameters($parameters)
    {
        if ($parameters == null) $parameters = Arr();
        $parameters = Arr($parameters);

        foreach ($parameters as $key => $value)
            $this->setParameter($key, $value);
        return $this;
    }
    public function getParameters()
    {
        $parameters = $this->urlParser->query->getData();
        if ($parameters == null) $parameters = Arr();
        return $parameters;
    }

    public function __toString()
    { return $this->urlParser->getUrl(); }

    public function toUrl()
    { return $this->__toString(); }

    public function toString()
    { return $this->__toString(); }

    public static function getJson($url)
    {
        $url = stringEx($url)->toString();
        
        $data = @file_get_contents($url);
        $data = stringEx($data)->toString();
        
        return Json::decode($data);
    }

    public static function start($value)
    {
        $data = null;
        
        if (!isset($value[url]) || stringEx($value[url])->isEmpty())
            return (object)["error" => "EMPTY_URL"];
        
        $url      = stringEx($value[url])->toString();
        $method   = get;
        $dataType = text;
        
        $cookies  = null;
        $postPlainHeader = "";
        
        if (isset($value[method]))
        {
            $method = stringEx($value[method])->toString();
            
            if ($method != get && $method != post)
               $method = get;
        }
  
        if (isset($value[dataType]))
        {
            $dataType = stringEx($value[dataType])->toString();
            
            if ($dataType != text && $dataType != json)
               $dataType = text;
        }
        
        if (isset($value[cookies]) && $value[cookies] != null)
            $cookies = $value[cookies];
            
        if (isset($value[data]) && $value[data] != null && \Variable::get($value[data])->isArray() && count($value[data]) > 0)
           foreach ($value[data] as $key => &$_value)
               $_value = stringEx($_value)->encode(true);
        else $value[data] = [];

        $params = "";
        
         if (count($value[data]) > 0)
         {
            foreach ($value[data] as $key => &$_value)
               $params .= stringEx($key)->encode(true) . "=" . $_value . "&";
    
            if (stringEx($params)->length > 0)
               $params = stringEx($params)->subString(0, stringEx($params)->length - 1, true);
         }
         
        if (isset($value[postPlainHeader]))
            $postPlainHeader = stringEx($value[postPlainHeader])->toString();
        
        if ($method == get)
        {
            $url .= "?" . $params;
            $data = @file_get_contents($url);
            self::$lastResponseHeader = $http_response_header;
        }
        elseif ($method == post)
        {
            $cookieStr = "";
        
            if ($cookies != null && \arrayk($cookies)->length > 0)
            {
                $cookieStr = "Cookie: ";
                
                foreach ($cookies as $key => $value)
                    $cookieStr .= $key . "=" . stringEx($value)->toString() . "; ";

                $cookieStr .= "\r\n";
            }

            $options = array(
                    'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n" . $cookieStr . $postPlainHeader,
                    'method'  => 'POST',
                    'content' => $params,
                )
            );

            $context  = stream_context_create($options);
            $data = @file_get_contents($url, false, $context);
            self::$lastResponseHeader = $http_response_header;
        }

         if ($dataType == text)
            return $data;
         elseif ($dataType == json)
            return Json::decode($data);
    }
    
    public static function getLastResponseHeader()
    { return self::$lastResponseHeader; }
    
    public static function getLastCookies()
    {
        $response =  self::getLastResponseHeader();
        $cookies = [];
        
        foreach ($response as $value)
        {
            if (!stringEx($value)->startsWith("Set-Cookie:"))
                continue;

            $cookie = stringEx($value)->subString(stringEx("Set-Cookie:")->length, stringEx($value)->length, false)->trim();
            
            $cookieSplit = stringEx($cookie)->split(";", true);
            $cookieValue = $cookieSplit[0];
            
            $cookieValueSplit = stringEx($cookieValue)->split("=", true);
            
            $key = stringEx($cookieValueSplit[0])->toString();
            $value = (\arrayk($cookieValueSplit)->length >= 2)
                ? stringEx($cookieValueSplit[1])->toString()
                : "";

            $cookies[$key] = $value;
        }
        
        return (\arrayk($cookies)->length > 0)
            ? $cookies : null;
    }


    public static function getHost($urlString)
    {
        $url = new \Url($urlString);
        return $url->host;
    }

    public static function getDomain($urlString)
    {
        $url = new \Url($urlString);
        return $url->domain;

//        $urlString = stringEx($urlString)->toString();
//
//        if (stringEx($urlString)->contains("://"))
//        {
//            $indexOf = stringEx($urlString)->indexOf("://");
//            $urlString = stringEx($urlString)->subString($indexOf + 3, stringEx($urlString)->length);
//        }
//
//        if (stringEx($urlString)->contains("@"))
//        {
//            $indexOf = stringEx($urlString)->indexOf("@");
//            $urlString = stringEx($urlString)->subString($indexOf + 1, stringEx($urlString)->length);
//        }
//
//        while (stringEx($urlString)->contains("/"))
//        {
//            $indexOf = stringEx($urlString)->indexOf("/");
//            $urlString = stringEx($urlString)->subString(0, $indexOf);
//        }
//
//        while (stringEx($urlString)->contains(":"))
//        {
//            $indexOf = stringEx($urlString)->indexOf(":");
//            $urlString = stringEx($urlString)->subString(0, $indexOf);
//        }
//
//        return $urlString;
    }

    public static function extractUrlsFromString($stringWithUrls)
    {
        self::__initialize();

        $extract = \Purl\Url::extract(stringEx($stringWithUrls)->toString());
        if ($extract == null) $extract = Arr();

        $parseExtract = Arr();

        $extract = Arr($extract);
        foreach ($extract as $_extract)
            $parseExtract->add(new \Url($_extract->getUrl()));
        return $parseExtract;
    }

    public static function getProtocol($url)
    {
        $url = new \Url($url);
        return $url->protocol;

//        $urlString = stringEx($urlString)->toString();
//        $protocol = "";
//
//        if (stringEx($urlString)->contains("://"))
//        {
//            $indexOf = stringEx($urlString)->indexOf("://");
//            $protocol = stringEx($urlString)->subString(0, $indexOf + 3);
//        }
//
//        if (stringEx($protocol)->isEmpty() && stringEx($urlString)->contains(":?"))
//        {
//            $indexOf = stringEx($urlString)->indexOf(":?");
//            $protocol = stringEx($urlString)->subString(0, $indexOf + 2);
//        }
//
//        if (stringEx($protocol)->endsWith("://"))
//            $protocol = stringEx($protocol)->subString(0, stringEx("://")->length + 2);
//
//        if (stringEx($protocol)->endsWith("/"))
//            $protocol = stringEx($protocol)->subString(0, stringEx($protocol)->length - 1);
//        if (stringEx($protocol)->endsWith("/"))
//            $protocol = stringEx($protocol)->subString(0, stringEx($protocol)->length - 1);
//        if (stringEx($protocol)->endsWith(":"))
//            $protocol = stringEx($protocol)->subString(0, stringEx($protocol)->length - 1);
//
//        return (!stringEx($protocol)->isEmpty())
//            ? $protocol : null;
    }
    
}