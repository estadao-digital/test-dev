<?php

namespace Serialize
{
    class Php
    {
        public static function isSerialized($value = null) {
            $value = stringEx($value)->toString();
            return ($value == serialize(false) || @unserialize($value) !== false);
        }

        public static function decode($value = null)
        {
            if ($value == null || $value == "null")
                return null;

            if (self::isSerialized($value) == false)
                return null;

            return unserialize($value);
        }

        public static function encode($value = null)
        {
            if ($value == null || $value == "null")
                return "null";

            return serialize($value);
        }
    }
}