<?php

namespace Render\Front\Minify
{
    class HTML
    {
        public static function toMinified($html)
        {
            $html = stringEx($html)->toString();
            $html = preg_replace_callback('/<!--([\\s\\S]*?)-->/u' ,
                (function($m) { return (0 === strpos($m[1], '[') || false !== strpos($m[1], '<![')) ? $m[0] : ''; }), $html);
            $html = stringEx($html)->remove("\r", false)->remove("\n", false)->remove("\t");
            while (stringEx($html)->contains("  "))
                $html = stringEx($html)->replace("  ", " ");
            return $html;
        }
    }
}