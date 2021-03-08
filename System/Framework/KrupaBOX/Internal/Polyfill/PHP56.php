<?php

namespace KrupaBOX\Internal\Polyfill
{
    class PHP56
    {
        const LDAP_ESCAPE_FILTER = 1;
        const LDAP_ESCAPE_DN = 2;
        public static function hash_equals($knownString, $userInput)
        {
            if (!is_string($knownString)) {
                trigger_error('Expected known_string to be a string, '.gettype($knownString).' given', E_USER_WARNING);
                return false;
            }
            if (!is_string($userInput)) {
                trigger_error('Expected user_input to be a string, '.gettype($userInput).' given', E_USER_WARNING);
                return false;
            }
            $knownLen = mb_strlen($knownString);
            $userLen = mb_strlen($userInput);
            if ($knownLen !== $userLen) {
                return false;
            }
            $result = 0;
            for ($i = 0; $i < $knownLen; ++$i) {
                $result |= ord($knownString[$i]) ^ ord($userInput[$i]);
            }
            return 0 === $result;
        }

        public static function ldap_escape($subject, $ignore = '', $flags = 0)
        {
            static $charMaps = null;
            if (null === $charMaps) {
                $charMaps = array(
                    self::LDAP_ESCAPE_FILTER => array('\\', '*', '(', ')', "\x00"),
                    self::LDAP_ESCAPE_DN => array('\\', ',', '=', '+', '<', '>', ';', '"', '#', "\r"),
                );
                $charMaps[0] = array();
                for ($i = 0; $i < 256; ++$i) {
                    $charMaps[0][chr($i)] = sprintf('\\%02x', $i);
                }
                for ($i = 0, $l = count($charMaps[self::LDAP_ESCAPE_FILTER]); $i < $l; ++$i) {
                    $chr = $charMaps[self::LDAP_ESCAPE_FILTER][$i];
                    unset($charMaps[self::LDAP_ESCAPE_FILTER][$i]);
                    $charMaps[self::LDAP_ESCAPE_FILTER][$chr] = $charMaps[0][$chr];
                }
                for ($i = 0, $l = count($charMaps[self::LDAP_ESCAPE_DN]); $i < $l; ++$i) {
                    $chr = $charMaps[self::LDAP_ESCAPE_DN][$i];
                    unset($charMaps[self::LDAP_ESCAPE_DN][$i]);
                    $charMaps[self::LDAP_ESCAPE_DN][$chr] = $charMaps[0][$chr];
                }
            }
            // Create the base char map to escape
            $flags = (int) $flags;
            $charMap = array();
            if ($flags & self::LDAP_ESCAPE_FILTER) {
                $charMap += $charMaps[self::LDAP_ESCAPE_FILTER];
            }
            if ($flags & self::LDAP_ESCAPE_DN) {
                $charMap += $charMaps[self::LDAP_ESCAPE_DN];
            }
            if (!$charMap) {
                $charMap = $charMaps[0];
            }
            // Remove any chars to ignore from the list
            $ignore = (string) $ignore;
            for ($i = 0, $l = strlen($ignore); $i < $l; ++$i) {
                unset($charMap[$ignore[$i]]);
            }
            // Do the main replacement
            $result = strtr($subject, $charMap);
            // Encode leading/trailing spaces if self::LDAP_ESCAPE_DN is passed
            if ($flags & self::LDAP_ESCAPE_DN) {
                if ($result[0] === ' ') {
                    $result = '\\20'.substr($result, 1);
                }
                if ($result[strlen($result) - 1] === ' ') {
                    $result = substr($result, 0, -1).'\\20';
                }
            }
            return $result;
        }
    }
}

namespace
{
    use KrupaBOX\Internal\Polyfill;

    if (PHP_VERSION_ID < 50600) {
        if (!function_exists('hash_equals')) {
            function hash_equals($knownString, $userInput) { return Polyfill\PHP56::hash_equals($knownString, $userInput); }
        }
        if (extension_loaded('ldap') && !function_exists('ldap_escape')) {
            define('LDAP_ESCAPE_FILTER', 1);
            define('LDAP_ESCAPE_DN', 2);
            function ldap_escape($subject, $ignore = '', $flags = 0) { return Polyfill\PHP56::ldap_escape($subject, $ignore, $flags); }
        }
        if (50509 === PHP_VERSION_ID && 4 === PHP_INT_SIZE) {
            // Missing functions in PHP 5.5.9 - affects 32 bit builds of Ubuntu 14.04LTS
            // See https://bugs.launchpad.net/ubuntu/+source/php5/+bug/1315888
            if (!function_exists('gzopen') && function_exists('gzopen64')) {
                function gzopen($filename, $mode, $use_include_path = 0) { return gzopen64($filename, $mode, $use_include_path); }
            }
            if (!function_exists('gzseek') && function_exists('gzseek64')) {
                function gzseek($zp, $offset, $whence = SEEK_SET) { return gzseek64($zp, $offset, $whence); }
            }
            if (!function_exists('gztell') && function_exists('gztell64')) {
                function gztell($zp) { return gztell64($zp); }
            }
        }
    }
}
