<?php

namespace
{
    class PHP
    {
        protected static $version = null;

        public static function getFullVersion()
        {
            $phpVersion = stringEx(phpversion())->toString();
            if (self::$version == null)
                self::$version = stringEx($phpVersion)->split(".");
            return $phpVersion;
        }

        public static function getVersion()
        { return floatEx(self::getMajorVersion() . "." . self::getMinorVersion())->toFloat(); }

        public static function getMajorVersion()
        {
            self::getFullVersion();

            if (self::$version->count <= 0)
                return null;

            return intEx(self::$version[0])->toInt();
        }

        public static function getMinorVersion()
        {
            self::getFullVersion();

            if (self::$version->count <= 1)
                return 0;

            return intEx(self::$version[1])->toInt();
        }

        public static function getReleaseVersion()
        {
            self::getFullVersion();

            if (self::$version->count <= 2)
                return null;

            $releaseVersion = "";

            for ($i = 2; $i < self::$version->count; $i++)
                $releaseVersion .= (self::$version[$i] . ".");
            if ($releaseVersion != "")
                $releaseVersion = stringEx($releaseVersion)->subString(0, stringEx($releaseVersion)->length - 1);

            return $releaseVersion;
        }

        public static function getInfo($html = false)
        {
            if ($html == true) {
                @ob_start(); phpinfo(-1);
                return stringEx(@ob_get_clean())->toString();
            }

            $entitiesToUtf8 = function($input) {
                // http://php.net/manual/en/function.html-entity-decode.php#104617
                return preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $input);
            };
            $plainText = function($input) use ($entitiesToUtf8) {
                return trim(html_entity_decode($entitiesToUtf8(strip_tags($input))));
            };
            $titlePlainText = function($input) use ($plainText) {
                return '# '.$plainText($input);
            };

            ob_start();
            phpinfo(-1);

            $phpinfo = array('phpinfo' => array());

            // Strip everything after the <h1>Configuration</h1> tag (other h1's)
            if (!preg_match('#(.*<h1[^>]*>\s*Configuration.*)<h1#s', ob_get_clean(), $matches)) {
                return array();
            }

            $input = $matches[1];
            $matches = array();

            if(preg_match_all(
                '#(?:<h2.*?>(?:<a.*?>)?(.*?)(?:<\/a>)?<\/h2>)|'.
                '(?:<tr.*?><t[hd].*?>(.*?)\s*</t[hd]>(?:<t[hd].*?>(.*?)\s*</t[hd]>(?:<t[hd].*?>(.*?)\s*</t[hd]>)?)?</tr>)#s',
                $input,
                $matches,
                PREG_SET_ORDER
            )) {
                foreach ($matches as $match) {
                    $fn = strpos($match[0], '<th') === false ? $plainText : $titlePlainText;
                    if (strlen($match[1])) {
                        $phpinfo[$match[1]] = array();
                    } elseif (isset($match[3])) {
                        $keys1 = array_keys($phpinfo);
                        $phpinfo[end($keys1)][$fn($match[2])] = isset($match[4]) ? array($fn($match[3]), $fn($match[4])) : $fn($match[3]);
                    } else {
                        $keys1 = array_keys($phpinfo);
                        $phpinfo[end($keys1)][] = $fn($match[2]);
                    }

                }
            }

            return Arr($phpinfo);
        }

        public static function renderInfo()
        {
            @\ob_start();
            \phpinfo();
            $buffer = @\ob_get_contents();
            @\ob_clean();

            $injectCSS = "body { background-color: #1f1f1f !important; color:#ffffff; } ";
            $injectCSS .= ".e { background: linear-gradient(to bottom, #434343 0, #434343 100%); color: #FF7F00; }";
            $injectCSS .= ".v { background: linear-gradient(to bottom, #434343 0, #434343 100%); color: #ffffff; }";
            $injectCSS .= "table { box-shadow: none !important; }";
            $injectCSS .= ".h th { background-color: #FF7F00; }";
            $injectCSS .= ".h td { background-color: #FF7F00; }";
            $injectCSS .= "h2 { font-size: 200% !important; color: #FF7F00; }";

            $buffer = stringEx($buffer)->
                replace("</style>", $injectCSS . "</style>", false)->
                replace("PHP License", "Powered by KrupaBOX", false)->
                replace("This program is free software; you can redistribute it and/or modify it under the terms of the Powered by KrupaBOX as published by the PHP Group and included in the distribution in the file:  LICENSE", "<center>Author: Gabriel Kazz Morgado</center>", false)->
                remove("If you did not receive a copy of the PHP license, or have any questions about PHP licensing, please contact license@php.net.", false)->
                remove("This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.");

            echo $buffer; \KrupaBOX\Internal\Kernel::exit();
        }
    }
}