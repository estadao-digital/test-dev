<?php

namespace KrupaBOX\Internal\Polyfill
{
    class PHP71
    {
        public static function is_iterable($var)
        { return is_array($var) || $var instanceof \Traversable; }
    }
}

namespace
{
    use KrupaBOX\Internal\Polyfill;

    if (PHP_VERSION_ID < 70100)
    {
        if (!function_exists('is_iterable')) {
            function is_iterable($var) { return Polyfill\PHP71::is_iterable($var); }
        }
    }
}
