<?php

class Cache
{
    protected static function keyToHashPath($key)
    {
        $key = stringEx($key)->toString();
        if (stringEx($key)->isEmpty()) return null;

        //$hash = \Security\Hash::toSha1($key, "KRUPABOX_HASH_203781293697210123092187382137021");
        $hash = $key;
        return (\Garbage\Cache::getCachePath() . $hash . ".dat");
    }

    public static function isCached($key)
    {
        $hashPath = self::keyToHashPath($key);
        if ($hashPath == null) return null;
        return \File::exists($hashPath);
    }
    
    public static function get($key)
    {
        $hashPath = self::keyToHashPath($key);
        if ($hashPath == null) return null;

        if (self::isCached($key) == false)
            return null;

        $data = \File::getContents($hashPath);
        $serialize = \Serialize::fromSerialized($data);
        if ($serialize == null) return null;
        return $serialize->toInstance();
    }
    
    public static function set($key, $value)
    {
        $hashPath = self::keyToHashPath($key);
        if ($hashPath == null) return null;

        $serialize = \Serialize::fromInstance($value);
        \File::setContents($hashPath, $serialize->toSerialized());
    }
    
    public static function remove($key)
    {
        $hashPath = self::keyToHashPath($key);
        if ($hashPath == null) return null;

        if (self::isCached($key) == false) return null;
        \File::delete($hashPath);
    }
}