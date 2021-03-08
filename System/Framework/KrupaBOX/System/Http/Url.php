<?php

namespace Http;

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

        if (!@function_exists("curl_init"))
        { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing CURL extension."]); \KrupaBOX\Internal\Kernel::exit(); }

        self::$__isInitialized = true;
    }

    protected $url = null;
    protected $urlParser = null;

    public function __construct($url)
    {
        self::__initialize();

        $this->url       = stringEx($url)->toString();
        $this->urlParser = new \Purl\Url($this->url);
    }

    public function __set($key, $value)
    {
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

        elseif ($key == host) {
            $host = "";
            if (!stringEx($this->subdomain)->isEmpty())
                $host .= ($this->subdomain . ".");
            return ($host . $this->domain);
        }

        return null;
    }

    public function removeParameter($key)
    { $this->urlParser->query->set($key, null); }

    public function setParameter($key, $value)
    { $this->urlParser->query->set($key, (($value != null) ? \stringEx($value)->toString() : null)); }

    public function removeAllParameters()
    {
        $parameters = $this->getParameters();
        foreach ($parameters as $key => $_)
            $this->removeParameter($key);
    }

    public function setParameters($parameters)
    {
        if ($parameters == null) $parameters = Arr();
        $parameters = Arr($parameters);

        foreach ($parameters as $key => $value)
            $this->setParameter($key, $value);
    }
    public function getParameters()
    {
        $parameters = $this->urlParser->query->getData();
        if ($parameters == null) $parameters = Arr();
        return Arr($parameters);
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
    }

    public static function getCurrent()
    {
        self::__initialize();

        if (\Connection::isCommandLineRequest())
            return new \Http\Url("cli://127.0.0.1");

        $current = \Purl\Url::fromCurrent();
        $url = $current->getUrl();
        return new \Http\Url($url);
    }
    public static function getCurrentUrl()
    {
        self::__initialize();
        $current = self::getCurrent();
        if ($current != null) return $current->toString();

        return null;
    }
}