<?php

namespace Database
{
    class Table
    {
        protected static $__CI = null;
        protected static function __initialize()
        {
            self::$__CI = \CodeIgniter::getInstance();
            self::$__CI->load->dbutil();
            self::$__CI->load->dbforge();
            \KrupaBOX\Internal\Loader::loadLinkDB();
        }

        public static function getAll()
        {
            self::__initialize();
            return Arr(self::$__CI->db->list_tables());
        }

        public static function exists($table)
        {
            $table = toString($table);
            if (stringEx($table)->isEmpty()) return null;
            return self::getAll()->contains($table);
        }

        public static function add($table)
        {
            self::__initialize();

            $table = toString($table);
            if (stringEx($table)->isEmpty()) return null;

            $dbConfig = \Database::getConfig();
            if (self::getAll()->contains($table) == false) {
                $query = ("CREATE TABLE `" . $dbConfig->sid . "`.`" . $table . "` ( `__krupabox__` VARCHAR(1) NOT NULL ) ENGINE = InnoDB, COLLATE = utf8mb4_unicode_ci;");
                self::$__CI->db->query($query);
                if (self::getAll()->contains($table) == true)
                    return true;
                $query = ("CREATE TABLE `" . $dbConfig->sid . "`.`" . $table . "` ( `__krupabox__` VARCHAR(1) NOT NULL ) ENGINE = InnoDB, COLLATE = utf8_unicode_ci;");
                self::$__CI->db->query($query);
                return (self::getAll()->contains($table));
            }

            return true;
        }
    }
}