<?php

namespace Identification\BRA
{
    class CPF
    {
        const FORMAT_ONLY_NUMBERS   = "FORMAT_ONLY_NUMBERS";
        const FORMAT_MASK           = "FORMAT_MASK";

        public static function format($cpf, $format = self::FORMAT_ONLY_NUMBERS)
        {
            if ($format == self::FORMAT_ONLY_NUMBERS)
            {
                $cpf = stringEx($cpf)->toString();

                $cpf = stringEx($cpf)->getOnlyNumbers();
                $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
                $cpf = (stringEx($cpf)->length > 11)
                    ? stringEx($cpf)->subString(0, 11)
                    : $cpf;

                return $cpf;
            }
            elseif ($format == self::FORMAT_MASK)
            {
                $cpf = self::format($cpf);
                $split = str_split($cpf, 3);
                $cpf = $split[0] . "." . $split[1] . "." . $split[2] . "-" . $split[3];

                return $cpf;
            }

            return null;
        }

        public static function isValid($cpf)
        {
            $cpf = self::format($cpf);

            if (strlen($cpf) != 11)
                return false;

            elseif ($cpf == '00000000000' || $cpf == '11111111111' ||
                $cpf == '22222222222' || $cpf == '33333333333' ||
                $cpf == '44444444444' || $cpf == '55555555555' ||
                $cpf == '66666666666' || $cpf == '77777777777' ||
                $cpf == '88888888888' || $cpf == '99999999999')
                return false;

            for ($t = 9; $t < 11; $t++)
            {
                for ($d = 0, $c = 0; $c < $t; $c++)
                    $d += $cpf{$c} * (($t + 1) - $c);

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d)
                    return false;
            }

            return true;
        }

        public static function getNumbers($cpf)
        { return self::format($cpf, self::FORMAT_ONLY_NUMBERS); }

        public static function getMasked($cpf)
        { return self::format($cpf, self::FORMAT_MASK); }

        public static function getValue($cpf)
        {
            $cpf = self::format($cpf, self::FORMAT_ONLY_NUMBERS);
            return stringEx($cpf)->subString(0, 9);
        }

        public static function getDigits($cpf)
        {
            $cpf = self::format($cpf, self::FORMAT_ONLY_NUMBERS);
            return stringEx($cpf)->subString(9, 2);
        }
    }
}