<?php

class Crypto
{    
    const RIJNDAEL_128_DEFAULT_KEY = "KRUPA_PHP_RIJNDAEL_128_DEFAULT_KEY";
    
    public static function toMd5($stringValue, $salt = null)
    {
        $stringValue = stringEx($stringValue)->toString();
        
        if ($salt != null)
        {
            $salt = stringEx($salt)->toString();
            return md5($salt . $stringValue);
        }

        return md5($stringValue);
    }
    
    public static function toSha1($stringValue)
    {
        $stringValue = stringEx($stringValue)->toString();
        return sha1($stringValue);
    }
    
    public static function toRijndael128($stringValue, $key = RIJNDAEL_128_DEFAULT_KEY)
    {
        $stringValue = stringEx($stringValue)->toString();
        $key = self::__fixRijndael128Key($key);
        
        return base64_encode(
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_128,
                $key,
                $stringValue,
                MCRYPT_MODE_CBC,
                "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
            )
        );
    }
    
    public static function fromRijndael128($stringValue, $key = RIJNDAEL_128_DEFAULT_KEY)
    {
        $decode = base64_decode($stringValue);
        $key = self::__fixRijndael128Key($key);

        return mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $key,
            $decode,
            MCRYPT_MODE_CBC,
            "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
        );
    }
    
    public static function randomPassword($length = 10)
    {
        $length = intEx($length)->toInt();
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";

        $charsLength = (strlen($chars) - 1);
        $string = $chars{rand(0, $charsLength)};

        for ($i = 1; $i < $length; $i = strlen($string))
        {
            $r = $chars{rand(0, $charsLength)};
            if ($r != $string{$i - 1})
                $string .=  $r;
        }

        return $string;
    }        
    
    private static function __fixRijndael128Key($key)
    {
        $key = stringEx($key)->toString();
        
        $size = 16;
        
        if (stringEx($key)->count > 16)
            $size = 24;
        if (stringEx($key)->count > 24)
            $size = 32;
            
        while (stringEx($key)->count < $size)
            $key .= $key;
            
        $key = stringEx($key)->subString(0, $size);
        return $key;
    }
}