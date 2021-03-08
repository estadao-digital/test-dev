<?php

namespace Identification\BRA
{
    class CNPJ
    {
        const FORMAT_ONLY_NUMBERS   = "FORMAT_ONLY_NUMBERS";
        const FORMAT_MASK           = "FORMAT_MASK";

        public static function format($cnpj, $format = self::FORMAT_ONLY_NUMBERS)
        {
            if ($format == self::FORMAT_ONLY_NUMBERS)
            {
                $cnpj = stringEx($cnpj)->toString();

                $cnpj = stringEx($cnpj)->getOnlyNumbers();
                $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);
                $cnpj = (stringEx($cnpj)->length > 14)
                    ? stringEx($cnpj)->subString(0, 14)
                    : $cnpj;

                return $cnpj;
            }
            elseif ($format == self::FORMAT_MASK)
            {
                $cnpj = self::format($cnpj);
                $cnpj = (substr($cnpj, 0, 2) . "." . substr($cnpj, 2, 3) . "." . substr($cnpj, 5, 3) . "/" . substr($cnpj, 8, 4) . "-" . substr($cnpj, 12, 2));

                return $cnpj;
            }

            return null;
        }

        public static function isValid($cnpj)
        {
            $cnpj = self::format($cnpj);

            if (strlen($cnpj) != 14)
                return false;

            if ($cnpj == "00000000000000" ||
                $cnpj == "11111111111111" ||
                $cnpj == "22222222222222" ||
                $cnpj == "33333333333333" ||
                $cnpj == "44444444444444" ||
                $cnpj == "55555555555555" ||
                $cnpj == "66666666666666" ||
                $cnpj == "77777777777777" ||
                $cnpj == "88888888888888" ||
                $cnpj == "99999999999999")
                return false;

            for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
                $soma += $cnpj{$i} * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }
            $resto = $soma % 11;
            if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
                return false;

            for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
                $soma += $cnpj{$i} * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }
            $resto = $soma % 11;
            return ($cnpj{13} == ($resto < 2 ? 0 : 11 - $resto));
        }

        public static function getNumbers($cnpj)
        { return self::format($cnpj, self::FORMAT_ONLY_NUMBERS); }

        public static function getMasked($cnpj)
        { return self::format($cnpj, self::FORMAT_MASK); }

        public static function getValue($cnpj)
        {
            $cnpj = self::format($cnpj, self::FORMAT_ONLY_NUMBERS);
            return stringEx($cnpj)->subString(0, 12);
        }

        public static function getDigits($cnpj)
        {
            $cnpj = self::format($cnpj, self::FORMAT_ONLY_NUMBERS);
            return stringEx($cnpj)->subString(12, 2);
        }
    }
}