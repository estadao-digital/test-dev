<?php

namespace Indentification\BRA
{
    class RG
    {
        const FORMAT_ONLY_NUMBERS_AND_X  = "FORMAT_ONLY_NUMBERS_AND_X";
        const FORMAT_MASK                = "FORMAT_MASK";

        public static function format($rg, $format = self::FORMAT_ONLY_NUMBERS_AND_X)
        {
            if ($format == self::FORMAT_ONLY_NUMBERS_AND_X)
            {
                $rg = stringEx($rg)->toLower();

                $containsDigitX = stringEx($rg)->endsWith("x");
                $rg = ereg_replace('[^0-9]', '', $rg);

                if ($containsDigitX == true)
                    $rg = $rg . "X";

                $rg = str_pad($rg, 9, '0', STR_PAD_LEFT);
                $rg = (stringEx($rg)->length > 9)
                    ? stringEx($rg)->subString(0, 9)
                    : $rg;

                return $rg;
            }
            elseif ($format == self::FORMAT_MASK)
            {
                $rg = self::format($rg);

                return  stringEx($rg)->subString(0, 2) . "." .
                stringEx($rg)->subString(2, 3) . "." .
                stringEx($rg)->subString(5, 3) . "-" .
                stringEx($rg)->subString(8, 1);
            }

            return null;
        }

        public static function isValid($rg)
        {
            $rg = self::format($rg);

            $number = stringEx($rg)->subString(0, 8);
            $digit = stringEx($rg)->Substring(8, 1);

            $calcRg = 0;

            for ($i = 9; $i >= 2; $i--)
                $calcRg += (intEx($number[(9 - $i)])->toInt() * $i);

            $validDigit = $calcRg % 11;

            if ($validDigit == 10 && $digit == "X")
                return true;
            elseif ($validDigit == intEx($digit)->toInt())
                return true;

            return false;
        }

        public static function getNumbers($rg)
        { return self::format($rg, self::FORMAT_ONLY_NUMBERS_AND_X); }

        public static function getMasked($rg)
        { return self::format($rg, self::FORMAT_MASK); }

        public static function getValue($rg)
        {
            $rg = self::format($rg, self::FORMAT_ONLY_NUMBERS_AND_X);
            return stringEx($rg)->subString(0, 8);
        }

        public static function getDigit($rg)
        {
            $rg = self::format($rg, self::FORMAT_ONLY_NUMBERS_AND_X);

            if (stringEx($rg)->endsWith("X"))
                return "X";

            return stringEx($rg)->subString(8, 1);
        }
    }
}