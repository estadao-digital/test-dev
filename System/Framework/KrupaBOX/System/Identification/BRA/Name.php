<?php

namespace Identification\BRA
{
    class Name
    {
        public static function format($name)
        {
            $name = \stringEx($name)->format(\stringEx::FORMAT_NAME);

            foreach (self::$preps as $prep) {
                $_prep = " " . $prep . " ";
                $name = \stringEx($name)->replace($_prep, \stringEx($_prep)->toLower());
            }

            return $name;
        }

        private static $preps = ["Da", "Das", "De", "Do", "Dos", "E"];
    }
}