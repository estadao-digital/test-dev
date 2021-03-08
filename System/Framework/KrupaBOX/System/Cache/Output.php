<?php

namespace Cache
{
    class Output
    {
        protected static $__isInitialized = false;

        protected static $cacheType   = null;
        protected static $cacheServer = null;

        public static function __onInitialize()
        {
            if (self::$__isInitialized == true) return;
            self::$__isInitialized = true;

            $config = \Config::get();

            if ($config->output->cache == true)
            {
                $type = $config->output->cacheType;

                if ($type == memcached || $type == memcache)
                {
                    if ($type == memcached && extension_loaded(memcached))
                        self::$cacheType = memcached;
                    elseif ($type == memcache && extension_loaded(memcache))
                        self::$cacheType = memcache;
                    elseif (extension_loaded(memcached))
                        self::$cacheType = memcached;
                    elseif (extension_loaded(memcache))
                        self::$cacheType = memcache;
                }

                if (self::$cacheType == memcache)
                {
                    self::$cacheServer = new \Memcache();
                    self::$cacheServer->connect($config->output->cacheHost, $config->output->cachePort);
                }
                elseif (self::$cacheType == memcached)
                {
                    self::$cacheServer = new \Memcached();
                    self::$cacheServer->addServer($config->output->cacheHost, $config->output->cachePort);
                }

            }
        }

        protected static function keyToHash($key)
        {
            self::__onInitialize();

            $key = stringEx($key)->toString();
            if (stringEx($key)->isEmpty()) return null;

            //$hash = \Security\Hash::toSha1($key, "KRUPABOX_HASH_203781293697210123092187382137021");
            $hash = $key;
            return $hash;
        }

        public static function isCached($key)
        {
            self::__onInitialize();

            if (self::$cacheServer != null)
            {
                $hash = self::keyToHash($key);
                $data = self::$cacheServer->get($hash);
                return ($data != null && $data !== false);
            }

            return \Cache::isCached($key);
        }

        public static function get($key)
        {
            self::__onInitialize();

            if (self::$cacheServer != null)
            {
                $hash = self::keyToHash($key);
                $data = self::$cacheServer->get($hash);

                if ($data != null && $data !== false);
                {
                    $serialize = \Serialize::fromSerialized($data);
                    return $serialize->toInstance();
                }

                return null;
            }

            return \Cache::get($key);
        }

        public static function set($key, $value)
        {
            self::__onInitialize();

            if (self::$cacheServer != null)
            {
                $hash = self::keyToHash($key);
                $serialize = \Serialize::fromInstance($value);
                $isReplaced = self::$cacheServer->replace($hash, $serialize->toSerialized());

                if ($isReplaced == null || $isReplaced === false)
                    self::$cacheServer->set($hash, $serialize->toSerialized());

                return null;
            }

            return \Cache::set($key, $value);
        }

        public static function remove($key)
        {
            self::__onInitialize();

            if (self::$cacheServer != null) {
                $hash = self::keyToHash($key);
                self::$cacheServer->delete($hash);

                return null;
            }

            return \Cache::remove($key);
        }
    }
}