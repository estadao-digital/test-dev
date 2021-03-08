<?php

namespace Render\Front\Minify
{
    class JS
    {
        protected static $_isInitialized = false;
        protected static function _initialize()
        {
            if (self::$_isInitialized == true) return null;
            \Import::PHP(__KRUPA_PATH_LIBRARY__ . ".plain/Patchwork.JSqueeze.php");
            self::$_isInitialized = true;
        }
        public static function toMinified($js)
        {
            self::_initialize();
            $js = stringEx($js)->toString();
            if (stringEx($js)->isEmpty()) return $js;


            $hashJs = \Security\Hash::toSha1($js);
            $hashPath = ("cache://.tmp/render/minifyjs/" . $hashJs . ".blob");
            if (\File::exists($hashPath))
                return \File::getContents($hashPath);

            $minifier = new \Patchwork\JSqueeze();
            $minifiedJs = $minifier->squeeze(
                $js,
                true,   // $singleLine
                false,   // $keepImportantComments
                false   // $specialVarRx
            );
            if (stringEx($minifiedJs)->isEmpty() == false)
            {
                $js = $minifiedJs;
                \File::setContents($hashPath, $js);
            }

            return $js;

        }
    }
}