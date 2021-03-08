<?php

namespace Security\Authentication
{
    class Cookie extends \Arr
    {
        const DEFAULT_COOKIES_SALT          = "2ac7d3ab3c19a40914004a3fec2b8914";
        const DEFAULT_COOKIES_ENCRYPT_KEY   = "6c220805d3ad54b9a5b5ffd5e54eab2a";

        const DEFAULT_TOKEN_ENCRYPT_KEY = "6c220805d3ad54b9a5b5ffd5e54eab2a";

        protected $salt       = null;
        protected $encryptKey = null;

        protected $includeUserAgentHash = true;
        protected $includeIpAddressHash = false;

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

        public function &getValidSessionsList()
        {
            $sessions = \Arr();

            foreach ($this as $authId => &$value)
                if ($value != null && $value->key == $this->getCurrentCookieKey() && $value->valid == true)
                { $sessions->add($value); break;  }

            return $sessions;
        }

        public function createSession($select = false)
        {
            $session = $this->createSessionArr(
                $this->getCurrentCookieKey(),
                \Arr(),
                true,
                boolEx($select)->toBool(),
                \Connection::getIpAddress()
            );

            $authId = 0;
            foreach ($this as $_authId => $_)
                $authId = $_authId;

            $authId++;

            $this[$authId] = $session;
            return $this[$authId];
        }

        public function getSelectedSession()
        {
            $validSessions = &$this->getValidSessionsList();

            $validSession = null;

            foreach ($validSessions as $_validSession)
                if ($_validSession->selected == true)
                    $validSession = $_validSession;

            return $validSession;
        }

        public function getSession($createIfNoneSelected = true)
        {
            $selectedSession = $this->getSelectedSession();

            if ($selectedSession == null && $createIfNoneSelected == true)
                $selectedSession = $this->createSession(true);

            return $selectedSession;

            /* //if ($createIfNoneSelected == )
            dump($validSessions);
            exit;

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
                    key      => $this->getCurrentCookieKey(),
                    data     => \Arr(),
                    valid    => true,
                    selected => false
                ];

                $session = $this[$authId];
            }

            return $session;*/
        }

        public function save()
        {
            foreach ($this as $authId => $value)
            {
                $authIdPad = intEx($authId)->toPad(\intEx::PAD_LEFT, 19);
                $authIdHex = stringEx($authIdPad)->toHex();

                $cookie = new \Input\Cookie();
                $cookie->key    = $value->key . $authIdHex;
                $cookie->value  = $this->encodeCookieDataByAuthId($authId);

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

        protected function decodeData($data)
        { return \Serialize\Php::decode($data); }

        protected function decodeCookieDataByCookieKey($cookieKey)
        {
            $value = \Input\Cookie::get($cookieKey);
            $data = $this->decodeData($value);

            return $data;
            //$value = (object)[selected => false, value => "valor -> " . $cookieKey, ipAddress => "12.453.5.35"]; // test
            //return $value;
        }

        protected function encodeCookieDataByAuthId($authId)
        {
            $sessionAuth = null;

            if ($this->containsKey($authId))
                $sessionAuth = $this[$authId];

            $sessionObject = (object)[selected => false, value => null, ipAddress => null];

            if ($sessionAuth != null)
            {
                $sessionObject->selected    = $sessionAuth->selected;
                $sessionObject->value       = $sessionAuth->data;
                $sessionObject->ipAddress   = $sessionAuth->ipAddress;
            }

            return \Serialize\Php::encode($sessionObject);
        }

        // TODO: split to Token.php file (remove frm Cookie.php)
        public function getTokenFromSession($session)
        {
            $sessionId = null;

            foreach($this as $key => $value)
                if ($value->key == $session->key)
                { $sessionId = $key; break; }

            $sessionId = intEx($sessionId)->toInt();
            if ($sessionId <= 0) return null;

            $session = $this->containsKey($sessionId) ? $this[$sessionId] : null;
            if ($session == null) return;

            $session->data->__token__ = (object)[
                key       => $session->key,
                valid     => $session->valid,
                selected  => $session->selected,
                ipAddress => $session->ipAddress
            ];

            $encodeSession  = $this->encodeCookieDataByAuthId($sessionId);
            $session->data->removeKey(__token__);
            $encryptToToken = \Security\Cryptography::toRijndael128($encodeSession, self::DEFAULT_TOKEN_ENCRYPT_KEY);
            return $encryptToToken;
        }

        public function getSessionFromToken($token)
        {
            $decryptFromToken = \Security\Cryptography::fromRijndael128($token, self::DEFAULT_TOKEN_ENCRYPT_KEY);
            $decodeSession    = $this->decodeData($decryptFromToken);

            if ($decodeSession == null || $decodeSession->value->__token__->key != $this->getCurrentCookieKey()) return null;

            $injectSession = $this->createSessionArr(
                $decodeSession->value->__token__->key,
                $decodeSession->value,
                true,
                $decodeSession->value->__token__->selected,
                $decodeSession->value->__token__->ipAddress
            );

            $injectSession->data->removeKey(__token__);
            return $injectSession;
        }

        protected function createSessionArr($key, $data, $valid, $selected, $ipAddress)
        {
            return \Arr([
                key       => $key, //$parseKey->authKey,
                data      => $data, // $data->value,
                valid     => $valid, //($parseKey->authKey == $cookieKey),
                selected  => $selected, //$data->selected,
                ipAddress => $ipAddress
            ]);
        }

        protected function injectCookies()
        {
            $cookieKey = $this->getCurrentCookieKey();
            $cookies = \Input\Cookie::getAll();

            foreach ($cookies as $key => $value)
            {
                $parseKey = self::parseCookieKey($key);
                if ($parseKey == null) continue;

                $data = $this->decodeCookieDataByCookieKey($key);

                $this[$parseKey->authId] = $this->createSessionArr(
                    $parseKey->authKey,
                    $data->value,
                    ($parseKey->authKey == $cookieKey),
                    $data->selected,
                    $data->ipAddress
                );
            }
        }

        public static function isCookieKey($authCookieKey)
        { return (self::parseCookieKey($authCookieKey) != null); }

        public static function parseCookieKey($authCookieKey)
        {
            $authCookieKey = stringEx($authCookieKey)->toString();
            if (stringEx($authCookieKey)->length != 78) return null;

            $authKey = stringEx($authCookieKey)->subString(0, 40);
            $authIdHex = stringEx($authCookieKey)->subString(40);

            if (!\Security\Hash::isSha1($authKey))
                return null;

            $authId = \stringEx::fromHex($authIdHex);
            $authId = intEx($authId)->toInt();

            if ($authId < 0) return null;

            return \Arr([authKey => $authKey, authId => $authId]);
        }
    }
}
