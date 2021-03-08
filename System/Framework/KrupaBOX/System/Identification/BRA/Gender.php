<?php

namespace Identification\BRA
{
    class Gender
    {
        const GENDER_MALE   = "male";
        const GENDER_FEMALE = "female";

        public static function isValid($gender)
        {
            $gender = stringEx($gender)->
            toLower(false)->
            remove(" ", false)->
            remove(".");

            $gender = trim($gender);

            foreach (self::$genders as $_gender)
                if ($_gender["search"] == $gender)
                    return true;

            return false;
        }

        public static function format($gender)
        {
            $gender = stringEx($gender)->
            toLower(false)->
            remove(" ", false)->
            remove(".");

            $gender = trim($gender);

            foreach (self::$genders as $_gender)
                if ($_gender["search"] == $gender)
                    return $_gender["gender"];

            if (stringEx($gender)->startsWith("m"))
                return self::GENDER_MALE;
            if (stringEx($gender)->startsWith("f"))
                return self::GENDER_FEMALE;

            return null;
        }

        private static $genders = [
            ["gender" => self::GENDER_MALE, "search" => "m"],
            ["gender" => self::GENDER_MALE, "search" => "male"],
            ["gender" => self::GENDER_MALE, "search" => "homem"],
            ["gender" => self::GENDER_MALE, "search" => "masc"],
            ["gender" => self::GENDER_MALE, "search" => "masculino"],
            ["gender" => self::GENDER_FEMALE, "search" => "f"],
            ["gender" => self::GENDER_FEMALE, "search" => "female"],
            ["gender" => self::GENDER_FEMALE, "search" => "mulher"],
            ["gender" => self::GENDER_FEMALE, "search" => "fem"],
            ["gender" => self::GENDER_FEMALE, "search" => "feminino"]
        ];
    }
}