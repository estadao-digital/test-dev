<?php

namespace Serialize
{
    class Base64
    {
        public static function isBase64($stringValue = null)
        {
            if ($stringValue == null) return false;
            $decode = stringEx($stringValue)->decode(true, false)->replace(" ", "+");
            return (stringEx(base64_encode(base64_decode($decode, true)))->decode(true, false)->replace(" ", "+") === $decode);
        }

        public static function encode($stringValue = null)
        {
            if ($stringValue == null || $stringValue == "null")
                return null;

            $stringValue = stringEx($stringValue)->toString();
            return base64_encode($stringValue);
        }

        public static function decode($stringValue = null)
        {
            if ($stringValue == null || $stringValue == "null")
                return null;

            $decode = stringEx($stringValue)->decode(true, false)->replace(" ", "+");
            $decode64 = stringEx(base64_decode($decode))->toString();

            return $decode64;
        }

        public static function plainDecode($stringValue = null)
        { return base64_decode($stringValue); }
    }
}