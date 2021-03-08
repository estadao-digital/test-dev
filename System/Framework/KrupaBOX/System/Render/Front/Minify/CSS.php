<?php

namespace Render\Front\Minify
{
    class CSS
    {
        public static function toMinified($css)
        {
            $css = stringEx($css)->toString();

            $hashCss = \Security\Hash::toSha1($css);
            $hashPath = ("cache://.tmp/render/minifycss/" . $hashCss . ".blob");
            if (\File::exists($hashPath))
                return \File::getContents($hashPath);

            $regex = array(
                "`^([\t\s]+)`ism"=>'',
                "`^\/\*(.+?)\*\/`ism"=>"",
                "`([\n\A;]+)\/\*(.+?)\*\/`ism"=>"$1",
                "`([\n\A;\s]+)//(.+?)[\n\r]`ism"=>"$1\n",
                "`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism"=>"\n"
            );
            $css = preg_replace(array_keys($regex),$regex, $css);
            $css = stringEx($css)->remove("\r", false)->remove("\n", false)->remove("\t");
            while(stringEx($css)->contains("  "))
                $css = stringEx($css)->replace("  ", " ");

            \File::setContents($hashPath, $css);
            return $css;
        }
    }
}