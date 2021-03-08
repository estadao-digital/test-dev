<?php

class System
{
    const PLATFORM_WINDOWS = "windows";
    const PLATFORM_LINUX   = "linux";
    const PLATFORM_MACOSX  = "macosx";

    public static function getPlatform()
    {
        $platform = null;
        $phpOs = stringEx(PHP_OS)->toLower();

        if (stringEx($phpOs)->contains("win"))
            $platform = self::PLATFORM_WINDOWS;
        elseif (stringEx($phpOs)->contains("linux"))
            $platform = self::PLATFORM_LINUX;
        elseif (stringEx($phpOs)->contains("mac"))
            $platform = self::PLATFORM_MACOSX;

        if ($platform == null)
        {
            $phpOs = php_uname();

            if (stringEx($phpOs)->contains("win"))
                $platform = self::PLATFORM_WINDOWS;
            elseif (stringEx($phpOs)->contains("linux"))
                $platform = self::PLATFORM_LINUX;
            elseif (stringEx($phpOs)->contains("mac"))
                $platform = self::PLATFORM_MACOSX;
        }

        return $platform;
    }

    public static function isWindows()
    { return (self::getPlatform() == self::PLATFORM_WINDOWS); }

    public static function isLinux()
    { return (self::getPlatform() == self::PLATFORM_LINUX); }

    public static function isMacOSX()
    { return (self::getPlatform() == self::PLATFORM_MACOSX); }

    public static function getMemory($onlyBytes = false)
    {
        $memoryUsage = self::getServerMemoryUsage();
        if ($memoryUsage == null) return null;

        if ($onlyBytes == true)
            return Arr([
                total => \intEx($memoryUsage["total"])->toInt(),
                free  => \intEx($memoryUsage["free"])->toInt(),
                using => \intEx($memoryUsage["total"] - $memoryUsage["free"])->toInt()
            ]);
        return Arr([
            total => \File\Size::fromBytes($memoryUsage["total"]),
            free  => \File\Size::fromBytes($memoryUsage["free"]),
            using => \File\Size::fromBytes($memoryUsage["total"] - $memoryUsage["free"])
        ]);
    }

    public static function getCPU()
    {
        $cpuLoad = self::getServerLoad();
        if ($cpuLoad == null) return null;
        if ($cpuLoad > 0) return floatEx($cpuLoad / 100)->toFloat();
        return floatEx($cpuLoad)->toFloat();
    }

    protected static function getServerMemoryUsage()
    {
        $memoryTotal = null;
        $memoryFree = null;
        if (stristr(PHP_OS, "win")) {
            $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
            @exec($cmd, $outputTotalPhysicalMemory);
            $cmd = "wmic OS get FreePhysicalMemory";
            @exec($cmd, $outputFreePhysicalMemory);
            if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
                foreach ($outputTotalPhysicalMemory as $line)
                    if ($line && preg_match("/^[0-9]+\$/", $line))
                    { $memoryTotal = $line; break; }
                foreach ($outputFreePhysicalMemory as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $memoryFree = $line;
                        $memoryFree *= 1024;
                        break;
                    }
                }
            }
        } else if (is_readable("/proc/meminfo")) {
            $stats = @file_get_contents("/proc/meminfo");
            if ($stats !== false) {
                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                $stats = explode("\n", $stats);
                foreach ($stats as $statLine) {
                    $statLineData = explode(":", trim($statLine));
                    if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                        $memoryTotal = trim($statLineData[1]);
                        $memoryTotal = explode(" ", $memoryTotal);
                        $memoryTotal = $memoryTotal[0];
                        $memoryTotal *= 1024;
                    }
                    if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                        $memoryFree = trim($statLineData[1]);
                        $memoryFree = explode(" ", $memoryFree);
                        $memoryFree = $memoryFree[0];
                        $memoryFree *= 1024;
                    }
                }
            }
        }

        if (is_null($memoryTotal) || is_null($memoryFree)) return null;
        else return array("total" => $memoryTotal, "free" => $memoryFree, );
    }

    protected static function getServerLoadLinuxData()
    {
        if (is_readable("/proc/stat")) {
            $stats = @file_get_contents("/proc/stat");
            if ($stats !== false) {
                $stats = preg_replace("/[[:blank:]]+/", " ", $stats);
                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                $stats = explode("\n", $stats);
                foreach ($stats as $statLine) {
                    $statLineData = explode(" ", trim($statLine));
                    if ((count($statLineData) >= 5) && ($statLineData[0] == "cpu"))
                        return array($statLineData[1],  $statLineData[2], $statLineData[3], $statLineData[4]);
                }
            }
        }
        return null;
    }

    protected static function getServerLoad()
    {
        $load = null;
        if (stristr(PHP_OS, "win")) {
            $cmd = "wmic cpu get loadpercentage /all";
            @exec($cmd, $output);
            if ($output)
                foreach ($output as $line)
                    if ($line && preg_match("/^[0-9]+\$/", $line)) { $load = $line; break; }
        } else {
            if (is_readable("/proc/stat")) {
                $statData1 = self::getServerLoadLinuxData(); sleep(1);
                $statData2 = self::getServerLoadLinuxData();
                if ((!is_null($statData1)) &&  (!is_null($statData2))) {
                    $statData2[0] -= $statData1[0];
                    $statData2[1] -= $statData1[1];
                    $statData2[2] -= $statData1[2];
                    $statData2[3] -= $statData1[3];
                    $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];
                    $load = 100 - ($statData2[3] * 100 / $cpuTime);
                }
            }
        }
        return $load;
    }
}