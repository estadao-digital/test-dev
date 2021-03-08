<?php

namespace Geolocation\BR
{
    class CEP
    {
        const FORMAT_ONLY_NUMBERS   = "FORMAT_ONLY_NUMBERS";
        const FORMAT_MASK           = "FORMAT_MASK";

        public static function format($cep, $format = self::FORMAT_ONLY_NUMBERS)
        {
            if ($format == self::FORMAT_ONLY_NUMBERS)
            {
                $cep = stringEx($cep)->toString();

                $cep = ereg_replace('[^0-9]', '', $cep);
                $cep = str_pad($cep, 8, '0', STR_PAD_LEFT);
                $cep = (stringEx($cep)->length > 8)
                    ? stringEx($cep)->subString(0, 8)
                    : $cep;

                return $cep;
            }
            elseif ($format == self::FORMAT_MASK)
            {
                $cep = self::format($cep);

                return  stringEx($cep)->subString(0, 5) . "-" .
                stringEx($cep)->subString(5, 8);
            }

            return null;
        }

        public static function isValid($cep)
        {
            $cep = stringEx($cep)->toString();
            $cep = ereg_replace('[^0-9]', '', $cep);

            if (stringEx($cep)->length != 8)
                return false;

            return true;
        }

        public static function getNumbers($cep)
        { return self::format($cep, self::FORMAT_ONLY_NUMBERS); }

        public static function getMasked($cep)
        { return self::format($cep, self::FORMAT_MASK); }
    }
}