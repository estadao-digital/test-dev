<?php

class DirectoryEx
{    
    public static function exists($dirPath)
    {
        $dirPath = \File\Wrapper::parsePath($dirPath);
        if (!self::isDirectory($dirPath))
            return false;
            
        return @file_exists($dirPath);
    }
    
    public static function isDirectory($dirPath)
    {
        $dirPath = \File\Wrapper::parsePath($dirPath);
        return is_dir($dirPath);
    }

    public static function create($dirPath, $mode = 0777)
    { return self::createDirectory($dirPath, $mode); }

    public static function createDirectory($dirPath, $mode = 0777)
    {
        $dirPath = \File\Wrapper::parsePath($dirPath);
        if (self::exists($dirPath))
            return true;

        if (stringEx($dirPath)->isEmpty()) return false;
        return @mkdir($dirPath, $mode, true);
    }

    public static function rename($dirPath, $newFileName, $validatePath = false)
    {
        $dirPath = \File\Wrapper::parsePath($dirPath);
        $dirPath = self::getInsensitivePath($dirPath);
        if ($validatePath == true) $dirPath = self::getRealPath($dirPath);

        if (!\DirectoryEx::exists($dirPath) || stringEx($newFileName)->isEmpty())
            return false;

        if (stringEx($newFileName)->startsWith("/"))
            $newFileName = stringEx($newFileName)->subString(1);

        $directory = \File::getDirectoryPath($dirPath, $validatePath);
        $newPath   = ($directory . "/" . $newFileName);

        return self::move($dirPath, $newPath, $validatePath);
    }
    public static function listDirectory($dirPath, $recursive = true)
    {
        $dirPath = \File\Wrapper::parsePath($dirPath);
        if (!self::isDirectory($dirPath))
            return null;
            
        $result = \Arr(); 
  
        $cdir = scandir($dirPath); 
        foreach ($cdir as $key => $value)
        {
            if (!in_array($value, array(".", "..")))
            {
                if ($recursive == true && self::isDirectory($dirPath . DIRECTORY_SEPARATOR . $value))
                    $result[$value] = self::listDirectory($dirPath . DIRECTORY_SEPARATOR . $value);
                else $result[] = $value;
            }
        }

        if ($result->count <= 0)
            return null;
            
        return $result;
    }

    public static function getLastModifiedDateTimeEx($dirPath)
    {
        $dirPath = \File\Wrapper::parsePath($dirPath);
        if (!self::isDirectory($dirPath))
            return null;

        if (!stringEx($dirPath)->endsWith("/") && !stringEx($dirPath)->endsWith("\\"))
            $dirPath .= "/";
        $dirPath .= ".";

        $timestamp = filemtime($dirPath);
        $date = new \DateTimeEx();
        $date->setTimestamp($timestamp);
        return $date;
    }

    public static function listPaths($dirPath)
    { return self::listDirectoryPaths($dirPath); }

    public static function listDirectoryPaths($dirPath, $includeDir = false)
    {
        $dirPath = \File\Wrapper::parsePath($dirPath);
        $listDir = self::listDirectory($dirPath);
        if ($listDir == null) return null;

        $listFiles = Arr();
        self::appendListDirectoryPaths($listDir, $listFiles);

        if ($includeDir == true)
            foreach ($listFiles as $_file)  {
                $dirPath = \File::getDirectoryPath($_file);
                if (!$listFiles->contains($dirPath))
                    $listFiles[] = $dirPath;
            }

        return $listFiles;
    }

    protected static function appendListDirectoryPaths($listDir, &$listFiles, $prePath = "")
    {
        foreach ($listDir as $key => $value)
            if ($key == "0" || intEx($key)->toInt() > 0)
                $listFiles->add($prePath . $value);

        foreach ($listDir as $key => $value)
            if ($key != "0" && intEx($key)->toInt() == 0 && $value != null)
                self::appendListDirectoryPaths($value, $listFiles, ($prePath . ($key . "/")));
    }

    public static function move($directoryPath, $newDirectoryPath, $validatePath = false)
    {
        $directoryPath = \File\Wrapper::parsePath($directoryPath);
        $directoryPath = self::getInsensitivePath($directoryPath);
        if ($validatePath == true) $directoryPath = self::getRealPath($directoryPath);

        if (!\DirectoryEx::exists($directoryPath)) return false;

        $newDirectoryPath = \File\Wrapper::parsePath($newDirectoryPath);
        $newDirectoryPath = self::getInsensitivePath($newDirectoryPath);
        if (stringEx($newDirectoryPath)->isEmpty()) return false;

        $return = @rename($directoryPath, $newDirectoryPath);
        return boolEx($return)->toBool();
    }
    
    public static function getRootPath()
    { return stringEx($_SERVER['DOCUMENT_ROOT'])->toString(); }

    public static function getRealPath($directoryPath, $rightBarOnly = false)
    {
        $directoryPath = \File\Wrapper::parsePath($directoryPath);
        $directoryPath = self::getInsensitivePath($directoryPath);

        $directoryPath = stringEx($directoryPath)->toString();
        $realPath = stringEx(realpath($directoryPath))->toString();

        $validatePath = ($rightBarOnly == true)
            ? stringEx($realPath)->replace("\\", "/")
            : $realPath;

        return (stringEx($validatePath)->isEmpty() ? null : $validatePath);
    }

    public static function getInsensitivePath($filePath)
    { return \KrupaBOX\Internal\Engine::getInsensitivePathFix($filePath); }

    public static function delete($directoryPath)
    {
        $directoryPath = \File\Wrapper::parsePath($directoryPath);
        if (stringEx($directoryPath)->endsWith("/") == false)
            $directoryPath .= "/";

        if (self::isDirectory($directoryPath) == false) return false;
        $paths = self::listPaths($directoryPath);
        if ($paths != null)
            foreach ($paths as $path)
                \File::delete($directoryPath . $path);

        if (stringEx($directoryPath)->endsWith("/") == false)
            $directoryPath .= "/";
        return @rmdir($directoryPath);
    }

    public static function copy($directoryPath, $newDirectoryPath)
    {
        $directoryPath = \File\Wrapper::parsePath($directoryPath);
        if (self::isDirectory($directoryPath) == false) return false;

        if (stringEx($directoryPath)->endsWith("/") == false)
            $directoryPath .= "/";

        $newDirectoryPath = \File\Wrapper::parsePath($newDirectoryPath);
        if (stringEx($newDirectoryPath)->endsWith("/") == false)
            $newDirectoryPath .= "/";

        $return = true;
        $paths = self::listPaths($directoryPath);
        if ($paths != null)
            foreach ($paths as $path) {
                $copy = \File::copy($directoryPath . $path, $newDirectoryPath . $path);
                if ($return == true && $copy == false)
                    $return = false;
            }
        return $return;
    }
}