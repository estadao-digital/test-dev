<?php

namespace Input;

class Cookie extends \ArrayObject
{
    protected static $CI = null;

    protected static function getCI()
    {
        if (self::$CI == null)
            self::$CI = \CodeIgniter::getInstance();

        self::$CI->load->helper('cookie');
        return self::$CI;      
    }

    public function __construct($name = null, $value = null)
    {
        parent::__construct([], \ArrayObject::ARRAY_AS_PROPS);

        $this->key   = stringEx($name)->toString();
        $this->value = stringEx($value)->toString();

        $this->expire   = -1;
        $this->domain   = "";
        $this->path     = "/";
        $this->secure   = false;
        $this->httpOnly = false;
    }

    public function save()
    {
        $key = stringEx($this->key)->toString();
        if (stringEx($key)->isEmpty()) return;

        self::set(
            $this->key,
            stringEx($this->value)->toString(),
            $this->expire,
            stringEx($this->domain)->toString(),
            stringEx($this->path)->toString(),
            boolEx($this->secure)->toBool(),
            boolEx($this->httpOnly)->toBool()
        );
    }

    public static function get($key, $type = string)
    {
        $CI = self::getCI();
        $value = $CI->input->cookie($key, true);

        $_type = \Variable::getPreferredTypeByType($type);
        $type = ($_type != null) ? $_type : $type;

        return \Variable::get($value)->convert($type);
    }

    public static function delete($key, $domain = "", $path = "/")
    {
        $domain     = stringEx($domain)->toString();
        $path       = stringEx($path)->toString();

        $CI = self::getCI();
        \delete_cookie($key, $domain, $path);
        return true;
    }

    public static function set($key, $value = null, $expire = null, $domain = "", $path = "/", $secure = false, $httpOnly = false)
    {
        $CI = self::getCI();

        $key        = stringEx($key)->toString();
        $value      = stringEx($value)->toString();
        if (stringEx($value)->isEmpty()) $value = null;
//        $expire     = intEx($expire)->toInt();
        $domain     = stringEx($domain)->toString();
        $path       = stringEx($path)->toString();
        $secure     = boolEx($secure)->toBool();
        $httpOnly   = boolEx($httpOnly)->toBool();

        if ($expire instanceof \DateTimeEx)
        { $expire = $expire->toTimeStamp(true); }
        elseif ($expire instanceof \DateTime)
        { $expire = (new \DateTimeEx($expire))->toTimeStamp(true); }
        $expire = intEx($expire)->toInt();

        $timestampNow = \Timestamp::now(true);
        if ($expire >= $timestampNow)
            $expire = ($expire - $timestampNow);
        if ($expire <= 0) $expire = -1;

        if ($value == null || stringEx($value)->isEmpty() == true)
            return self::delete($key, $domain, $path);

        $CI->input->set_cookie($key, $value, $expire, $domain, $path, "", $secure, $httpOnly);
        return true;
    }

    public static function remove($key, $domain = "", $path = "/")
    {
        $key    = stringEx($key)->toString();
        $domain = stringEx($domain)->toString();
        $path   = stringEx($path)->toString();

        self::set($key, null, -1, $domain, $path);
    }

    public static function getAll($typeArray = Arr)
    {
        if ($typeArray != Arr)
            $typeArray = \Arr($typeArray);

        $inputValue = \Arr();

        if (count($_COOKIE) > 0)
            foreach ($_COOKIE as $key => $_)
                $inputValue[$key] = self::get($key);

        $inputValue->setTypeByArray($typeArray, true);
        return $inputValue;
    }
}