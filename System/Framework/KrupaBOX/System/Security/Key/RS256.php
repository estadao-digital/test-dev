<?php

namespace Security\Key
{
    class RS256 extends \Security\Key
    {
        protected $type = \Security\Key::TYPE_RS256;

        protected static $defaultPrivateKeyRS256 = null;
        protected static $defaultPublicKeyRS256  = null;

        protected $privateKey = null;
        protected $publicKey  = null;

        public function isValidKey()
        { return ($this->isValidPublicKey() && $this->isValidPrivateKey()); }

        public function isValidPublicKey()
        { return ($this->publicKey != null); }

        public function isValidPrivateKey()
        { return ($this->privateKey != null); }

        public function setPrivateKey($path)
        {
            $key = \File::getContents($path);
            if (!string($key)->isEmpty())
                $this->privateKey = $key;
        }

        public function setPublicKey($path)
        {
            $key = \File::getContents($path);
            if (!string($key)->isEmpty())
                $this->publicKey = $key;
        }

        public function setPrivateKeyByString($keyString)
        {
            if (!string($keyString)->isEmpty())
                $this->privateKey = $keyString;
        }

        public function setPublicKeyByString($keyString)
        {
            if (!string($keyString)->isEmpty())
                $this->publicKey = $keyString;
        }

        public function getPublicKey($fallbackToDefault = false)
        {
            if ($fallbackToDefault == true && $this->publicKey == null)
                return self::getDefaultPublicKey();
            return $this->publicKey;
        }

        public function getPrivateKey($fallbackToDefault = false)
        {
            if ($fallbackToDefault == true && $this->privateKey == null)
                return self::getDefaultPrivateKey();
            return $this->privateKey;
        }

        public function getDefaultPublicKey()
        {
            if (self::$defaultPublicKeyRS256 != null)
                return self::$defaultPublicKeyRS256;

            $key = \File::getContents(__KRUPA_PATH_INTERNAL__ . "System/Security/Key/RS256/default.public.pem");
            self::$defaultPublicKeyRS256 = $key;
            return self::$defaultPublicKeyRS256;
        }

        public function getDefaultPrivateKey()
        {
            if (self::$defaultPrivateKeyRS256 != null)
                return self::$defaultPrivateKeyRS256;

            $key = \File::getContents(__KRUPA_PATH_INTERNAL__ . "System/Security/Key/RS256/default.private.pem");
            self::$defaultPrivateKeyRS256 = $key;
            return self::$defaultPrivateKeyRS256;
         }

        public function getKey()
        { return null; }

    }
}