<?php

namespace Security\Authentication
{
    class Data extends \Arr
    {

        public function __construct($salt = self::DEFAULT_COOKIES_SALT, $encryptKey = self::DEFAULT_COOKIES_ENCRYPT_KEY, $includeUserAgentHash = true, $includeIpAddressHash = false)
        {
            parent::__construct([], \ArrayObject::ARRAY_AS_PROPS);

            $this->salt = stringEx($salt)->toString();
            $this->encryptKey = stringEx($encryptKey)->toString();

            if ($this->salt == null || stringEx($this->salt)->isEmpty())
                $this->salt = self::DEFAULT_COOKIES_SALT;

            if ($this->encryptKey == null || stringEx($this->encryptKey)->isEmpty())
                $this->encryptKey = self::DEFAULT_COOKIES_SALT;

            $this->includeUserAgentHash = $includeUserAgentHash;
            $this->includeIpAddressHash = $includeIpAddressHash;

            $this->injectCookies();
        }

        public function getSession($createIfNotExists = true)
        {
            $session = null;

            foreach ($this as $authId => $value)
                if ($value != null && $value->key == $this->getCurrentCookieKey() && $value->valid == true)
                { $session = $value; break;  }

            if ($session == null)
            {
                $authId = 1;
                while ($this->containsKey($authId) && $this[$authId] != null)
                    $authId++;

                $this[$authId] = (object)[
                    key     => $this->getCurrentCookieKey(),
                    data    => new \Security\Authentication\Data(),
                    valid   => true
                ];

                $session = $this[$authId];
            }

            return $session;
        }

        public function save()
        {
            foreach ($this as $authId => $value)
            {
                $authIdPad = intEx($authId)->toPad(\intEx::PAD_LEFT, 19);
                $authIdHex = stringEx($authIdPad)->toHex();

                $cookie = new \Input\Cookie();
                $cookie->key = $value->key . $authIdHex;
                $cookie->value = $value->data; // TO DO: crypto
                $cookie->save();
            }
        }

        public function getCurrentCookieKey()
        {
            $keyHash = \Security\Hash::toSha1("auth");
            $keyHash = \Security\Hash::toSha1($this->salt . $this->encryptKey);

            if ($this->includeUserAgentHash == true) $keyHash = \Security\Hash::toSha1(\Connection::getUserAgent() . $keyHash);
            if ($this->includeIpAddressHash == true) $keyHash = \Security\Hash::toSha1(\Connection::getIpAddress() . $keyHash);

            return $keyHash;
        }

        protected function decodeCookieDataByCookieKey($cookieKey)
        {
            $value = \Input\Cookie::get($cookieKey);

            dump($value);
            return $value;
        }

        protected function injectCookies()
        {
            $cookieKey = $this->getCurrentCookieKey();
            $cookies = \Input\Cookie::getAll();

            foreach ($cookies as $key => $value)
            {
                $parseKey = self::parseCookieKey($key);
                if ($parseKey == null) continue;

                $this[$parseKey->authId] = \Arr([
                    key     => $parseKey->authKey,
                    data    => $this->decodeCookieDataByCookieKey($key),
                    valid   => ($parseKey->authKey == $cookieKey)
                ]);
            }
        }

        public function isCookieKey($authCookieKey)
        { return ($this->parseCookieKey($authCookieKey) != null); }

        public function parseCookieKey($authCookieKey)
        {
            $authCookieKey = stringEx($authCookieKey)->toString();
            if (stringEx($authCookieKey)->length != 78) return null;

            $authKey = stringEx($authCookieKey)->subString(0, 40);
            $authIdHex = stringEx($authCookieKey)->subString(40);

            if (!\Security\Hash::isSha1($authKey))
                return null;

            $authId = \stringEx::fromHex($authIdHex);
            $authId = intEx($authId)->toInt();

            if ($authId <= 0) return null;

            return \Arr([authKey => $authKey, authId => $authId]);
        }
    }
}
