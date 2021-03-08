<?php

namespace Security\Hash
{
    class Hashid
    {
        protected static $__isInitialized = false;
        protected static function __initialize()
        {
            if (self::$__isInitialized == true)
                return true;

            \KrupaBOX\Internal\Library::load("Hashids");
            if (@function_exists("gmp_add") != true && @function_exists("bcadd") != true)
            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing BCMATH or GMP extension."]); \KrupaBOX\Internal\Kernel::exit(); }

            self::$__isInitialized = true;
            return true;
        }

        public static function toHashid($intValue, $lengthMin = 11, $salt = "KRUPABOX_DEFAULT_HASHID_SALT")
        {
            self::__initialize();

            $intValue = intEx($intValue)->toInt();
            if ($intValue <= 0) return null;
            $lengthMin = intEx($lengthMin)->toInt();
            if ($lengthMin <= 0) $lengthMin = 11;
            $salt    = stringEx($salt)->toString();

            $hashids = new \Hashids\Hashids($salt, $lengthMin);
            $hash = $hashids->encode($intValue);

            if (stringEx($hash)->isEmpty())
                return null;
            return stringEx($hash)->toString();
        }

        public static function fromHashid($hashidValue, $lengthMin = 11, $salt = "KRUPABOX_DEFAULT_HASHID_SALT")
        {
            self::__initialize();

            $hashidValue = stringEx($hashidValue)->toString();
            $lengthMin = intEx($lengthMin)->toInt();
            if ($lengthMin <= 0) $lengthMin = 11;
            $salt = stringEx($salt)->toString();

            $hashids = new \Hashids\Hashids($salt, $lengthMin);
            $decode = $hashids->decode($hashidValue);

            if ($decode == null) return null;
            $decode = Arr($decode);
            if ($decode->count <= 0) return null;

            return intEx($decode[0])->toInt();
        }
    }
}