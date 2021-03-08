<?php

namespace KrupaBOX\Internal\Polyfill
{
    class PHP70
    {
        public static function intdiv($dividend, $divisor)
        {
            $dividend = self::intArg($dividend, __FUNCTION__, 1);
            $divisor = self::intArg($divisor, __FUNCTION__, 2);
            if (0 === $divisor) {
                throw new \DivisionByZeroError('Division by zero');
            }
            if (-1 === $divisor && ~PHP_INT_MAX === $dividend) {
                throw new \ArithmeticError('Division of PHP_INT_MIN by -1 is not an integer');
            }
            return ($dividend - ($dividend % $divisor)) / $divisor;
        }

        public static function preg_replace_callback_array(array $patterns, $subject, $limit = -1, &$count = 0)
        {
            $count = 0;
            $result = ''.$subject;
            if (0 === $limit = self::intArg($limit, __FUNCTION__, 3)) {
                return $result;
            }
            foreach ($patterns as $pattern => $callback) {
                $result = preg_replace_callback($pattern, $callback, $result, $limit, $c);
                $count += $c;
            }
            return $result;
        }

        public static function error_clear_last()
        {
            static $handler;
            if (!$handler) {
                $handler = function() { return false; };
            }
            set_error_handler($handler);
            @trigger_error('');
            restore_error_handler();
        }

        public static function intArg($value, $caller, $pos)
        {
            if (is_int($value)) {
                return $value;
            }
            if (!is_numeric($value) || PHP_INT_MAX <= ($value += 0) || ~PHP_INT_MAX >= $value) {
                throw new \TypeError(sprintf('%s() expects parameter %d to be integer, %s given', $caller, $pos, gettype($value)));
            }
            return (int) $value;
        }
    }
}

namespace
{
    use KrupaBOX\Internal\Polyfill;

    if (!defined('PHP_INT_MIN')) { define('PHP_INT_MIN', ~PHP_INT_MAX); }

    if (!class_exists("Error"))               { class Error extends Exception {} }
    if (!class_exists("ArithmeticError"))     { class ArithmeticError extends Error {} }
    if (!class_exists("AssertionError"))      { class AssertionError extends Error {} }
    if (!class_exists("DivisionByZeroError")) { class DivisionByZeroError extends Error {} }
    if (!class_exists("ParseError"))          { class ParseError extends Error {} }
    if (!class_exists("TypeError"))           { class TypeError extends Error {} }

    if (!function_exists('intdiv')) {
        function intdiv($dividend, $divisor) { return Polyfill\PHP70::intdiv($dividend, $divisor); }
    }
    if (!function_exists('preg_replace_callback_array')) {
        function preg_replace_callback_array(array $patterns, $subject, $limit = -1, &$count = 0) { return Polyfill\PHP70::preg_replace_callback_array($patterns, $subject, $limit, $count); }
    }
    if (!function_exists('error_clear_last')) {
        function error_clear_last() { return Polyfill\PHP70::error_clear_last(); }
    }
}
