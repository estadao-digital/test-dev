<?php

namespace System
{
    class Proccess
    {
        public static function canExecute()
        { return function_exists("exec"); }

        public static function execute($executeString)
        {
            $executeString = stringEx($executeString)->toString();
            return @exec($executeString);
        }
    }
}