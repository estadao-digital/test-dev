<?php

namespace Garbage\Cache
{
    class Database
    {
        public static function cleanAll()
        {
            $path = ("cache://.krupabox/database/");
            \DirectoryEx::delete($path);
            \Model\Link::cleanMemoryCache();
        }

        public static function cleanByModel($model)
        {
            $structure = $model->getMetadata();
            if ($structure == null) return null;
            self::cleanByTable($structure->structure->table);
        }

        public static function cleanByTable($table)
        {
            $table = stringEx($table)->toString();
            if (stringEx($table)->isEmpty()) return null;

            $path = ("cache://.krupabox/database/" . $table . "/");
            \DirectoryEx::delete($path);
            \Model\Link::cleanMemoryCacheByTable($table);
        }
    }
}