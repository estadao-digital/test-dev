<?php

namespace KrupaBOX\Internal\Polyfill
{
    class PHP55
    {
        public static function boolval($val)
        {
            return (bool) $val;
        }

        public static function json_last_error_msg()
        {
            switch (json_last_error()) {
                case JSON_ERROR_NONE: return 'No error';
                case JSON_ERROR_DEPTH: return 'Maximum stack depth exceeded';
                case JSON_ERROR_STATE_MISMATCH: return 'State mismatch (invalid or malformed JSON)';
                case JSON_ERROR_CTRL_CHAR: return 'Control character error, possibly incorrectly encoded';
                case JSON_ERROR_SYNTAX: return 'Syntax error';
                case JSON_ERROR_UTF8: return 'Malformed UTF-8 characters, possibly incorrectly encoded';
                default: return 'Unknown error';
            }
        }

        public static function hash_pbkdf2($algorithm, $password, $salt, $iterations, $length = 0, $rawOutput = false)
        {
            // Number of blocks needed to create the derived key
            $blocks = ceil($length / strlen(hash($algorithm, null, true)));
            $digest = '';
            for ($i = 1; $i <= $blocks; ++$i) {
                $ib = $block = hash_hmac($algorithm, $salt.pack('N', $i), $password, true);
                // Iterations
                for ($j = 1; $j < $iterations; ++$j) {
                    $ib ^= ($block = hash_hmac($algorithm, $block, $password, true));
                }
                $digest .= $ib;
            }
            if (!$rawOutput) {
                $digest = bin2hex($digest);
            }
            return substr($digest, 0, $length);
        }

        public static function array_column(array $input, $columnKey, $indexKey = null)
        {
            $output = array();
            foreach ($input as $row) {
                $key = $value = null;
                $keySet = $valueSet = false;
                if ($indexKey !== null && array_key_exists($indexKey, $row)) {
                    $keySet = true;
                    $key = (string) $row[$indexKey];
                }
                if ($columnKey === null) {
                    $valueSet = true;
                    $value = $row;
                } elseif (is_array($row) && array_key_exists($columnKey, $row)) {
                    $valueSet = true;
                    $value = $row[$columnKey];
                }
                if ($valueSet) {
                    if ($keySet) {
                        $output[$key] = $value;
                    } else {
                        $output[] = $value;
                    }
                }
            }
            return $output;
        }
    }
}

namespace
{
    use KrupaBOX\Internal\Polyfill;

    if (PHP_VERSION_ID < 50500) {
        if (!function_exists('boolval')) {
            function boolval($val) { return Polyfill\PHP55::boolval($val); }
        }
        if (!function_exists('json_last_error_msg')) {
            function json_last_error_msg() { return Polyfill\PHP55::json_last_error_msg(); }
        }
        if (!function_exists('array_column')) {
            function array_column($array, $columnKey, $indexKey = null) { return Polyfill\PHP55::array_column($array, $columnKey, $indexKey); }
        }
        if (!function_exists('hash_pbkdf2')) {
            function hash_pbkdf2($algorithm, $password, $salt, $iterations, $length = 0, $rawOutput = false) { return Polyfill\PHP55::hash_pbkdf2($algorithm, $password, $salt, $iterations, $length, $rawOutput); }
        }
    }
}