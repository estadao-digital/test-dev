<?php

class Disk
{
    protected static $possibleWindowsFallbackLetters = "CDEFGHIJKLMNOPQRSTUVWXYZ";

    public static function getRootDisk()
    { return self::getDiskByPath(self::getRootDiskPath()); }

    public static function getRootDiskPath()
    {
        if (\System::isLinux() || \System::isMacOSX())
            return "/";

        if (\System::isWindows())
        {
            if (\DirectoryEx::exists("C:")) return "C:";
            $charArray = stringEx(self::$possibleWindowsFallbackLetters)->toCharArr();

            foreach ($charArray as $possibleWindowsFallbackLetter)
                if (\DirectoryEx::exists($possibleWindowsFallbackLetter . ":/"))
                    return ($possibleWindowsFallbackLetter . ":/");

            return null;
        }

        return null;
    }

    public static function getDiskByPath($diskPath)
    {
        if (!\DirectoryEx::exists($diskPath)) return null;

        $diskLetter = null;

        if (stringEx($diskPath)->startsWith("/"))
            $diskLetter = "/";
        elseif (stringEx($diskPath)->startsWith("\\"))
            $diskLetter = "\\";
        else
        {
            $charArray = stringEx($diskPath)->toCharArr();
            if ($charArray[1] == ":")
            {
                $diskLetter = ($charArray[0] . ":/");
                $diskPath  = $diskLetter;
            }
        }

        $totalSpace = intEx(disk_total_space($diskPath))->toInt();
        $freeSpace  = intEx(disk_free_space($diskPath))->toInt();

        if ($totalSpace == 0) return null;

        return Arr([
            disk       => $diskLetter,
            total => \File\Size::fromBytes($totalSpace),
            free  => \File\Size::fromBytes($freeSpace),
            using => \File\Size::fromBytes($totalSpace - $freeSpace)
        ]);
    }

    public static function getMountedDisks()
    {
        $rootDisk = self::getRootDisk();
        if ($rootDisk == null) return null;

        $mountedDisksLetters = Arr();

        if (\System::isLinux() || \System::isMacOSX())
        {
            $cleanMountedDisksLetters = Arr();

            $isMountDir = \DirectoryEx::isDirectory("/mnt");
            if ($isMountDir == true)
            {
                $mountDirList = \DirectoryEx::listDirectory("/mnt", false);

                if ($mountDirList != null)
                    foreach ($mountDirList as $mount)
                    {
                        $disk = \Disk::getDiskByPath("/mnt/" . $mount);
                        if ($disk != null)
                        {
                            $disk->disk = ("/mnt/" . $mount);
                            $cleanMountedDisksLetters->add($disk);
                        }
                    }
            }

            return $cleanMountedDisksLetters;
        }

        if (\System::isWindows())
        {
            $charArray = stringEx(self::$possibleWindowsFallbackLetters)->toCharArr();

            foreach ($charArray as $possibleWindowsFallbackLetter)
                if (\DirectoryEx::exists($possibleWindowsFallbackLetter . ":/"))
                    $mountedDisksLetters->add($possibleWindowsFallbackLetter . ":/");

            $cleanMountedDisksLetters = Arr();

            foreach ($mountedDisksLetters as $mountedDisksLetter) {
                $disk = self::getDiskByPath($mountedDisksLetter);
                if ($disk != null && $disk->disk != $rootDisk->disk)
                    $cleanMountedDisksLetters->add($disk);
            }

            return $cleanMountedDisksLetters;
        }

        return null;

    }

}