<?php

namespace Identification\BRA\Vehicle
{
    class Plate
    {
        protected static $validLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        const FORMAT_ONLY_NUMBERS             = "FORMAT_ONLY_NUMBERS";
        const FORMAT_ONLY_LETTERS             = "FORMAT_ONLY_LETTERS";
        const FORMAT_ONLY_LETTERS_AND_NUMBERS = "FORMAT_ONLY_LETTERS_AND_NUMBERS";
        const FORMAT_MASK                     = "FORMAT_MASK";

        public static function format($plate, $format = self::FORMAT_MASK)
        {
            $plate = stringEx($plate)->toString();

            if ($format == self::FORMAT_ONLY_NUMBERS)
            {
                $numbers = stringEx($plate)->getOnlyNumbers();
                while (stringEx($numbers)->length < 4)
                    $numbers .= "0";
                return $numbers;
            }
            elseif ($format == self::FORMAT_ONLY_LETTERS)
            {
                $letters = stringEx($plate)->getOnlyLetters();
                while (stringEx($letters)->length < 3)
                    $letters .= "A";
                return stringEx($letters)->toUpper();
            }
            elseif ($format == self::FORMAT_ONLY_LETTERS_AND_NUMBERS)
            { return (self::format($plate, self::FORMAT_ONLY_LETTERS) . self::format($plate, self::FORMAT_ONLY_NUMBERS)); }
            elseif ($format == self::FORMAT_MASK)
            { return (self::format($plate, self::FORMAT_ONLY_LETTERS) . "-" . self::format($plate, self::FORMAT_ONLY_NUMBERS)); }

            return null;
        }

        public static function isValid($plate)
        { return (stringEx($plate)->getOnlyNumbers(null, false)->length >= 4 && stringEx($plate)->getOnlyLetters(false)->length >= 3); }

        public static function getNumbers($plate)
        { return self::format($plate, self::FORMAT_ONLY_NUMBERS); }

        public static function getMasked($plate)
        { return self::format($plate, self::FORMAT_MASK); }

        public static function getLetters($plate)
        { return self::format($plate, self::FORMAT_ONLY_LETTERS); }

        public static function getNextPlate($oldPlate)
        {
            $oldPlate = stringEx($oldPlate)->toString();

            $nextNumbers = stringEx(intEx(self::getNumbers($oldPlate))->toInt() + 1)->toString();
            while(stringEx($nextNumbers)->length < 4)
                $nextNumbers = ("0" . $nextNumbers);

            if ($nextNumbers != "10000")
                return self::getMasked(self::getLetters($oldPlate) . $nextNumbers);

            $nextNumbers = "0000";
            $nextLetters = self::getLetters($oldPlate);

            if ($nextLetters[2] == "Z")
            {
                $nextLetters[2] = "A";
                if ($nextLetters[1] == "Z")
                {
                    $nextLetters[1] = "A";
                    if ($nextLetters[0] == "Z")
                        return null;

                    for ($i = 0; stringEx(self::$validLetters)->length; $i++)
                        if ($nextLetters[0] == self::$validLetters[$i])
                        { $nextLetters[0] = self::$validLetters[($i + 1)]; break; }
                }
                else
                    for ($i = 0; stringEx(self::$validLetters)->length; $i++)
                        if ($nextLetters[1] == self::$validLetters[$i])
                        { $nextLetters[1] = self::$validLetters[($i + 1)]; break; }
            }
            else
                for ($i = 0; stringEx(self::$validLetters)->length; $i++)
                    if ($nextLetters[2] == self::$validLetters[$i])
                    { $nextLetters[2] = self::$validLetters[($i + 1)]; break; }

            return self::getMasked($nextLetters . $nextNumbers);
        }
    }
}