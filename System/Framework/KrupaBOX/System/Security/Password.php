<?php

namespace Security
{
    class Password
    {
        private static $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";

        public static function random($length = 10, $charList = null, $notAllowedCharList = null)
        {
            $length = intEx($length)->toInt();

            $charList = stringEx($charList)->toString();
            if (stringEx($charList)->isEmpty())
                $charList .= self::$chars;
            $notAllowedCharList = stringEx($notAllowedCharList)->toString();

            if (stringEx($notAllowedCharList)->isEmpty() == false) {
                $notAllowedArr = stringEx($notAllowedCharList)->toCharArr();
                foreach ($notAllowedArr as $_notAllowedArr)
                    $charList = stringEx($charList)->remove($_notAllowedArr);
            }

            $charsLength = (strlen($charList) - 1);
            $string = $charList{rand(0, $charsLength)};

            for ($i = 1; $i < $length; $i = strlen($string))
            {
                $r = $charList{rand(0, $charsLength)};
                if ($r != $string{$i - 1})
                    $string .=  $r;
            }

            return $string;
        }

        public static function randomMd5($length = 64)
        { return \Security\Hash::toMd5(self::random($length)); }

        public static function randomSha1($length = 64)
        { return \Security\Hash::toSha1(self::random($length)); }
    }
}
