<?php

namespace KrupaBOX\Internal\Polyfill
{
    class PHP72
    {
        public static function utf8_encode($s)
        {
            $s .= $s;
            $len = strlen($s);
            for ($i = $len >> 1, $j = 0; $i < $len; ++$i, ++$j) {
                switch (true) {
                    case $s[$i] < "\x80": $s[$j] = $s[$i]; break;
                    case $s[$i] < "\xC0": $s[$j] = "\xC2"; $s[++$j] = $s[$i]; break;
                    default: $s[$j] = "\xC3"; $s[++$j] = chr(ord($s[$i]) - 64); break;
                }
            }
            return substr($s, 0, $j);
        }

        public static function utf8_decode($s)
        {
            $s .= '';
            $len = strlen($s);
            for ($i = 0, $j = 0; $i < $len; ++$i, ++$j) {
                switch ($s[$i] & "\xF0") {
                    case "\xC0":
                    case "\xD0":
                        $c = (ord($s[$i] & "\x1F") << 6) | ord($s[++$i] & "\x3F");
                        $s[$j] = $c < 256 ? chr($c) : '?';
                        break;
                    case "\xF0": ++$i;
                    case "\xE0":
                        $s[$j] = '?';
                        $i += 2;
                        break;
                    default:
                        $s[$j] = $s[$i];
                }
            }
            return substr($s, 0, $j);
        }

        public static function php_os_family()
        {
            if ('\\' === DIRECTORY_SEPARATOR) {
                return 'Windows';
            }
            $map = array(
                'Darwin' => 'Darwin',
                'DragonFly' => 'BSD',
                'FreeBSD' => 'BSD',
                'NetBSD' => 'BSD',
                'OpenBSD' => 'BSD',
                'Linux' => 'Linux',
                'SunOS' => 'Solaris',
            );
            return isset($map[PHP_OS]) ? $map[PHP_OS] : 'Unknown';
        }
    }
}

namespace
{
    use KrupaBOX\Internal\Polyfill;


    if (PHP_VERSION_ID < 70200)
    {
        if (!function_exists('sapi_windows_vt100_support')) {
            function sapi_windows_vt100_support() { return false; }
        }

        if (!function_exists('stream_isatty')) {
            function stream_isatty($stream) { return function_exists('posix_isatty') && @posix_isatty($stream); }
        }

        if (!function_exists('utf8_encode')) {
            function utf8_encode($s) { return Polyfill\PHP72::utf8_encode($s); }
            function utf8_decode($s) { return Polyfill\PHP72::utf8_decode($s); }
        }

        if (!defined('PHP_OS_FAMILY')) {
            define('PHP_OS_FAMILY', Polyfill\PHP72::php_os_family());
        }
    }
}
