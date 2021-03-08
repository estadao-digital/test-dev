<?php

namespace Security
{
    class Cryptography
    {
        const RIJNDAEL_128_DEFAULT_KEY = "KRUPA_PHP_RIJNDAEL_128_DEFAULT_KEY";

        public static function toRijndael128($stringValue, $key = RIJNDAEL_128_DEFAULT_KEY)
        {
            $stringValue = stringEx($stringValue)->toString();
            $key = self::__fixRijndael128Key($key);

            return \base64_encode(
                @\mcrypt_encrypt(
                    \MCRYPT_RIJNDAEL_128,
                    $key,
                    $stringValue,
                    \MCRYPT_MODE_CBC,
                    "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
                )
            );
        }

        public static function fromRijndael128($stringValue, $key = RIJNDAEL_128_DEFAULT_KEY)
        {

            $stringValue = stringEx($stringValue)->decode(true);
            $decode = \base64_decode($stringValue);

            $key = self::__fixRijndael128Key($key);

            return @\mcrypt_decrypt(
                \MCRYPT_RIJNDAEL_128,
                $key,
                $decode,
                \MCRYPT_MODE_CBC,
                "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
            );
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
}
