<?php

namespace Garbage
{
    class Cache
    {
        protected static $tmpCachePath = null;

        public static function getCachePath()
        {
//            if (self::$tmpCachePath != null)
//                return self::$tmpCachePath;

            return CACHE_FOLDER;
//            $config = \Config::get();
//            return $config->cache->path;
        }
//
//        public static function setCachePath($path)
//        {
//            $path = stringEx($path)->toString();
//            if (stringEx($path)->isEmpty())
//                self::$tmpCachePath = null;
//            else self::$tmpCachePath = $path;
//        }

        public static function clean()
        {
            $path = "cache://";
            $list = \DirectoryEx::listPaths($path);
            foreach ($list as $file) {
                if (stringEx($file)->startsWith(".internal"))
                    continue;

                \File::delete("cache://" . $file);
            }
            return true;
        }
    }
}