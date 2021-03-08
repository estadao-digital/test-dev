<?php

namespace KrupaBOX\Internal\Polyfill
{
    class PHP73
    {
        public static $startAt = 1533462603;

        public static function hrtime($asNum = false)
        {
            $ns = microtime(false);
            $s = substr($ns, 11) - self::$startAt;
            $ns = 1E9 * (float) $ns;

            if ($asNum) {
                $ns += $s * 1E9;

                return \PHP_INT_SIZE === 4 ? $ns : (int) $ns;
            }

            return array($s, (int) $ns);
        }
    }
}

namespace
{
    use KrupaBOX\Internal\Polyfill;

    if (PHP_VERSION_ID < 70300)
    {
        if (!function_exists('is_countable')) {
            function is_countable($var) { return is_array($var) || $var instanceof Countable || $var instanceof ResourceBundle || $var instanceof SimpleXmlElement; }
        }

        if (!function_exists('hrtime')) {
            Polyfill\PHP73::$startAt = (int) microtime(true);
            function hrtime($asNum = false) { return Polyfill\PHP73::hrtime($asNum); }
        }

        if (!function_exists('array_key_first')) {
            function array_key_first(array $array) { foreach ($array as $key => $value) { return $key; } }
        }

        if (!function_exists('array_key_last')) {
            function array_key_last(array $array) { end($array); return key($array); }
        }

        class JsonException extends \Exception {}
    }
}
