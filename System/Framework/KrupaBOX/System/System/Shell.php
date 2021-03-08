<?php

namespace System
{
    class Shell
    {
        public static function canExecute()
        { return function_exists("shell_exec"); }

        public static function execute($executeString)
        {
            if (self::canExecute() == false) return null;
            $executeString = stringEx($executeString)->toString();

            $buffer = shell_exec($executeString);
            if ($buffer == null) return null;
            $buffer = stringEx($buffer)->toUTF8(true, false)->trim("\r\n\t");
            return $buffer;
        }

        public static function async($executeString, $delegate = null)
        {
            $executeString = stringEx($executeString)->toString();
            $delegate = ((\FunctionEx::isFunction($delegate) && $delegate != null) ? $delegate : (function($data) { return true; }));

            set_time_limit(0);
            $process = @popen($executeString, "r");
            @ob_start();

            $totalBuffer = "";

            while(!feof($process))
            {
                $buffer = @fgets($process); @ob_flush(); //@flush();
                $buffer = stringEx($buffer)->toUTF8(true, false)->trim("\r\n\t");
                if (stringEx($buffer)->isEmpty() == false)
                    $totalBuffer .= ($buffer . "\n");
                $responseDelegate = $delegate($buffer);
                if ($responseDelegate === false)  break;

                // Because PHP can "stop" process (but is not a really stop, is just a freeze)
                while (!feof($process)) {
                    $buffer = @fgets($process); @ob_flush(); //@flush();
                    $buffer = stringEx($buffer)->toUTF8(true, false)->trim("\r\n\t");
                    if (stringEx($buffer)->isEmpty() == false)
                        $totalBuffer .= ($buffer . "\n");
                    $responseDelegate = $delegate($buffer);
                    if ($responseDelegate === false) break;
                }

                // Because PHP can "stop" process (but is not a really stop, is just a freeze)
                \Time::sleep(1, false);
            }

            @pclose($process);
            @ob_end_clean(); //@ob_end_flush();

            if (stringEx($totalBuffer)->isEmpty())
                return null;

            return $totalBuffer;
        }
    }
}