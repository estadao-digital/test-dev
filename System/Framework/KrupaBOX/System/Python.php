<?php

namespace
{
    class Python
    {
        protected static function getCliPath()
        {
            $config  = \Config::get();
            $cliPath = \File::getRealPath($config->python->path);

            if ($cliPath != null && \File::getFileName($cliPath) != "python.exe")
                $cliPath = null;

            return $cliPath;
        }

        public static function execute($filePath, $parameters = null)
        {
            $filePath = stringEx($filePath)->toString();
            if (stringEx($filePath)->isEmpty()) return false;

            $filePath = \File::getRealPath($filePath);
            if ($filePath == null) return false;

            $cliPath = self::getCliPath();
            if ($cliPath == null && (\System::isLinux() || \System::isMacOSX()))
                $cliPath = "python";

            if ($cliPath != null)
            {
                $output = null;

                $parameters = stringEx($parameters)->toString();
                if (!stringEx($parameters)->isEmpty())
                    $parameters = (" " . $parameters);

                if (\System::isWindows())
                    $output = shell_exec($cliPath . " " . $filePath . $parameters);
                elseif (\System::isLinux())
                    $output = shell_exec($cliPath . " " . $filePath . $parameters);
                elseif (\System::isMacOSX())
                    $output = shell_exec($cliPath . " " . $filePath . $parameters);

                if (stringEx($output)->isEmpty() && $output !== false && $output !== true && $output !== null)
                    return true;

                return $output;
            }

            return false;
        }
    }
}