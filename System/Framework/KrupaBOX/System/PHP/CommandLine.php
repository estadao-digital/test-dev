<?php

namespace PHP
{
    class CommandLine
    {
        protected static function getCliPath()
        {
            $config  = \Config::get();
            $cliPath = \File::getRealPath($config->commandLine->path);

            if ($cliPath != null && \File::getFileName($cliPath) != "php.exe")
                $cliPath = null;

            if ($cliPath == null) {
                $phpBin = PHP_BINDIR;
                if (\DirectoryEx::exists($phpBin))
                    $cliPath = \File::getRealPath($phpBin . "/php.exe");
            }

            if ($cliPath == null) {
                $phpBinary = PHP_BINARY;
                if (\File::getFileName($phpBinary) == "php.exe")
                    $cliPath = \File::getRealPath($phpBinary);
            }

            return $cliPath;
        }

        public static function execute($command)
        {
            $command = stringEx($command)->toString();
            if (stringEx($command)->isEmpty()) return false;

            $cliPath = self::getCliPath();
            if ($cliPath == null && (\System::isLinux() || \System::isMacOSX()))
                $cliPath = "php";

            if ($cliPath != null)
            {
                $output = null;

                if (\System::isWindows())
                    $output = shell_exec($cliPath . " " . $command);
                elseif (\System::isLinux())
                    $output = shell_exec($cliPath . " " . $command . " &> /dev/null &");
                elseif (\System::isMacOSX())
                    $output = shell_exec($cliPath . " " . $command);

                if (stringEx($output)->isEmpty() && $output !== false && $output !== true)
                    return true;

                return $output;
            }

            return false;
        }

        public static function executeAsync($command)
        {
            $command = stringEx($command)->toString();
            if (stringEx($command)->isEmpty()) return false;

            $cliPath = self::getCliPath();
            if ($cliPath == null && (\System::isLinux() || \System::isMacOSX()))
                $cliPath = "php";

            if ($cliPath != null)
            {
                $process = new \Symfony\Component\Process\Process($cliPath . " " . $command);
                $process->start();
            }
        }
    }
}