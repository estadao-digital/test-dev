<?php

namespace Security
{
    class Hash
    {
        const TYPE_MD5 = "md5";
        const TYPE_SHA1 = "sha1";

        public static function toMd5($value, $salt = null, $formatted = false)
        {
            $value = stringEx($value)->toString();
            $md5 = null;
            if ($salt != null)
            {
                $salt = stringEx($salt)->toString();
                $md5 = \md5($salt . $value);
            }
            else $md5 = \md5($value);

            if ($formatted == true)
                $md5 = (
                    stringEx($md5)->subString(0, 8) . "-" .
                    stringEx($md5)->subString(8, 4) . "-" .
                    stringEx($md5)->subString(12, 4) . "-" .
                    stringEx($md5)->subString(16, 4) . "-" .
                    stringEx($md5)->subString(20)
                );

            return $md5;
        }

        public static function toSha1($value, $salt = null)
        {
            $value = stringEx($value)->toString();

            if ($salt != null)
            {
                $salt = stringEx($salt)->toString();
                return \sha1($salt . $value);
            }

            return \sha1($value);
        }

        public static function isMd5($value)
        {
            $value = stringEx($value)->toString();
            return (stringEx($value)->length == 32 && ctype_xdigit($value));
        }

        public static function isSha1($value)
        {
            $value = stringEx($value)->toString();
            return (stringEx($value)->length == 40 && ctype_xdigit($value));
        }
    }
}
