<?php

class File
{
    const FORMAT_UNKNOWN = "unknown";
    
    const FORMAT_TXT       =  "txt";
    const FORMAT_PNG        = "png";
    const FORMAT_JPG        = "jpg";
    const FORMAT_JPEG       = "jpeg";
    const FORMAT_BMP        = "bmp";
    const FORMAT_CVS        = "cvs";
    const FORMAT_XLS        = "xls";
    const FORMAT_XLSX       = "xlsx";

    protected $filePath = null;
    protected $fileLink = null;

    protected $isOpen = false;

    public function __construct($filePath, $open = true)
    {
        $filePath = stringEx($filePath)->toString();
        $filePath = \File\Wrapper::parsePath($filePath);
        if (!stringEx($filePath)->isEmpty()) $this->filePath = $filePath;

        if ($open == true) $this->open();
    }

    public function open($readOnly = false)
    {
        if ($this->isOpen == true)   return true;
        if ($this->filePath == null) return false;

        $this->fileLink = @fopen($this->filePath, (($readOnly == true) ? "r" : "a+"));
        if ($this->fileLink == false || $this->fileLink == null)
            $this->fileLink = null;

        if ($this->fileLink != null)
        {
            $this->isOpen = true;
            return true;
        }

        return false;
    }

    public function isValid()
    { return ($this->fileLink != null); }

    public function close()
    {
        if ($this->isOpen == true)
        {
            @fclose($this->fileLink);
            $this->fileLink = null;
            $this->isOpen   = false;
            return true;
        }

        return false;
    }

    protected function openAndValidate()
    {
        $this->open();
        return $this->isValid();
    }

    public function resetPointer()
    {
        if ($this->openAndValidate() == false)
            return false;

        @rewind($this->fileLink);
    }

    public function getPointer()
    {
        if ($this->openAndValidate() == false)
            return false;

        return @ftell($this->fileLink);
    }

    public function setPointer($pointer)
    {
        if ($this->openAndValidate() == false)
            return false;

        $pointer = intEx($pointer)->toInt();
        fseek($this->fileLink, $pointer);

        return true;
    }

    // 1048576 = 1024 x 1024
    public function readBinary($limitBytes = 1048576)
    {
        if ($this->openAndValidate() == false)
            return false;

        if (!feof($this->fileLink))
        {
            $limitBytes = intEx($limitBytes)->toInt();
            if ($limitBytes <= 0) $limitBytes = 1;
            return @fread($this->fileLink, $limitBytes);
        }

        return false;
    }

    // 1048576 = 1024 x 1024
    public function readSingleLine($limitBytes = 1048576)
    {
        if ($this->openAndValidate() == false)
            return false;

        if (!feof($this->fileLink))
        {
            $limitBytes = intEx($limitBytes)->toInt();
            if ($limitBytes <= 0) $limitBytes = 1;
            return @fgets($this->fileLink, $limitBytes);
        }

        return false;
    }

    public function readSingleCharacter()
    {
        if ($this->openAndValidate() == false)
            return false;

        if (!feof($this->fileLink))
            return @fgetc($this->fileLink);

        return false;
    }

    public function readAll()
    {
        if ($this->openAndValidate() == false)
            return null;

        $pointer = $this->getPointer();
        $this->resetPointer();

        $data = "";
        while($this->isEndOfFile() == false)
            $data .= $this->readBinary();

        $this->setPointer($pointer);
        return $data;
    }

    public function isEndOfFile()
    {
        if ($this->openAndValidate() == false)
            return false;

        return @feof($this->fileLink);
    }

    public function write($data = null, $resetPointer = false)
    {
        if ($data == null || $this->openAndValidate() == false)
            return false;

        $return = @fwrite($this->fileLink, $data);

        if ($resetPointer == true)
            $this->resetPointer();

        return $return;
    }

    // 1048576 = 1024 x 1024
    public static function output($filePath, $limitBytes = 104857600, $breakOnFinish = false, $validatePath = false)
    {
        $canGzip = (\Config::get()->output->gzip == true && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && stripos($_SERVER['HTTP_ACCEPT_ENCODING'], "gzip") !== false && (stringEx($filePath)->endsWith(".gz") == false));
        if ($canGzip == true && (\Dumpper::isPageDumped() == true || \function_exists("gzencode") != true || \function_exists("deflate_init") == false)) $canGzip = false;

        if ($canGzip == true && stringEx($filePath)->startsWith(APPLICATION_FOLDER))
        {
            $gzFileDir = null;

            if (stringEx($filePath)->startsWith(\Garbage\Cache::getCachePath()))
                $gzFileDir  = ("cache://.tmp/gzip/" . stringEx($filePath)->subString(stringEx(\Garbage\Cache::getCachePath())->count) . "/");
            else $gzFileDir  = ("cache://.krupabox/gzip/" . stringEx($filePath)->subString(stringEx(APPLICATION_FOLDER)->count) . "/");

            $gzFilePath = ($gzFileDir . \Security\Hash::toSha1(\File::getLastModifiedDateTimeEx($filePath)->toString()) . ".blob.gz");

            if (\File::exists($gzFilePath) == false)
            {
                // Force create dir & clean possible other versions
                \File::setContents($gzFilePath . ".dat", "");
                $files = \DirectoryEx::listPaths($gzFileDir);
                foreach ($files as $file)
                    if (\File::exists($gzFileDir . $file))
                        \File::delete($gzFileDir . $file);

                $gzFilePath = \File\Wrapper::parsePath($gzFilePath);
                $handler = @\fopen($gzFilePath, 'w');

                $deflateContext = deflate_init(ZLIB_ENCODING_GZIP, ['level' => 6]);

                $file = new \File($filePath);
                $file->open(true);

                $buffer = $file->readBinary($limitBytes);

                while ($buffer !== false) {
                    fwrite($handler, deflate_add($deflateContext, $buffer, ZLIB_NO_FLUSH));
                    $buffer = $file->readBinary($limitBytes);
                }

                fwrite($handler, deflate_add($deflateContext, '', ZLIB_FINISH));
                fclose($handler);
            }

            \Header::setContentEncoding("gzip");
            $filePath = $gzFilePath;
        }
        elseif (stringEx($filePath)->endsWith(".gz") == true)
            \Header::setContentEncoding("gzip");

        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);

        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        if (!self::exists($filePath))
            return null;

        $fileSize = \File::getSize($filePath, true);
        $fileSize = (($fileSize != null) ? $fileSize : 0);

        $limitBytes = \intEx($limitBytes)->toInt();
        if ($limitBytes <= 0) $limitBytes = 104857600;

        $file = new \File($filePath);
        $file->open(true);

        $pointerStart = 0;
        $pointerEnd   = ($fileSize - 1);

        \Header::setContentLength($fileSize);
        \Header::setAcceptRanges(0, $fileSize);

        $requestHeaders = \Connection::getRequestHeaders();
        if ($requestHeaders->containsKey("Range"))
        {
            $range = stringEx($requestHeaders["Range"])->toString();
            $range = stringEx($range)->split("=");
            $range = (($range->count > 1) ? $range[1] : (($range->count == 0) ? "" : $range[0]));

            if (stringEx($range)->isEmpty() == false)
            {
                $split = stringEx($range)->split("-");
                $pointerStart = intEx($split[0])->toInt();
                if ($pointerStart > $pointerEnd) {
                    \Header::setHttpCode(\Header::HTTP_CODE_RANGE_NOT_SATISFIABLE);
                    if (\Dumpper::isPageDumped() == false)
                        \Header::sendHeader();

                    if ($breakOnFinish == true)
                        \KrupaBOX\Internal\Kernel::exit();
                    return null;
                }
            }

            if ($pointerStart > 0)
            {
                $file->setPointer($pointerStart);
                \Header::setHttpCode(\Header::HTTP_CODE_PARTIAL_CONTENT);
                \Header::setContentRange($pointerStart, $pointerEnd, $fileSize);
            }
        }

        if (\Dumpper::isPageDumped() == false)
            \Header::sendHeader();

        $buffer = $file->readBinary($limitBytes);

        while ($buffer !== false) {
            echo $buffer;
            if (\Connection::isEstablished() == false) \KrupaBOX\Internal\Kernel::exit();
            $buffer = $file->readBinary($limitBytes);
        }

        $file->close();

        if ($breakOnFinish == true)
            \KrupaBOX\Internal\Kernel::exit();
        return true;
    }

    public static function getContents($filePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);
        
        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        if (!self::exists($filePath))
            return null;
        
        $content = null;
        
        try
        { $content = @file_get_contents($filePath); }
        catch (Exception $e) {}
        
        return $content; 
    }

    public static function setContents($filePath, $value, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);

        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        $dirPath = self::getDirectoryPath($filePath);

        if (!DirectoryEx::isDirectory($dirPath))
            DirectoryEx::createDirectory($dirPath);

        try { @file_put_contents($filePath, $value); return true; }
        catch (Exception $e) {}

        return false;
    }

    public static function getLastModifiedDateTimeEx($filePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);

        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        if (!\File::exists($filePath)) return null;

        $timestamp = filemtime($filePath);
        $date = new \DateTimeEx();
        
        $date->setTimestamp($timestamp);
        return $date;
    }

    public static function toSha1($filePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);

        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        if (!\File::exists($filePath)) return null;

        $sha1File = @sha1_file($filePath);
        return (stringEx($sha1File)->isEmpty() ? null : $sha1File);
    }

    public static function toMd5($filePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);

        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        if (!\File::exists($filePath)) return null;

        $sha1File = @md5_file($filePath);
        return (stringEx($sha1File)->isEmpty() ? null : $sha1File);
    }

    public static function addContents($filePath, $value, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);

        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        $dirPath = self::getDirectoryPath($filePath);

        if (!DirectoryEx::isDirectory($dirPath))
            DirectoryEx::createDirectory($dirPath);

        if (!self::exists($filePath))
        { return self::setContents($filePath, $value); }

        try { @file_put_contents($filePath, $value, FILE_APPEND); return true; }
        catch (Exception $e) {}

        return false;
    }

    public static function getInsensitivePath($filePath)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        return \KrupaBOX\Internal\Engine::getInsensitivePathFix($filePath);
    }

    public static function exists($filePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);

        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        if (!self::isFile($filePath))
            return false;
            
        return @file_exists($filePath);
    }

    public static function isReadable($filePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        if (self::exists($filePath, $validatePath) == false || self::isFile($filePath, $validatePath) == false)
            return false;

        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        return @is_readable($filePath);
    }
    
    public static function isFile($filePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);

        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        return @is_file($filePath);
    }
    
    public static function getDirectoryPath($filePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        return @dirname($filePath);
    }
    
    public static function getFileName($filePath, $removeExtension = false, $removeAllExtension = false, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);

        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        $name = @basename($filePath);
        
        if ($removeExtension == false)
            return $name;
            
        $split = stringEx($name)->split(".");
        $nameNoExtension = "";
    
        if (count($split) >= 2)
        {
            if ($removeAllExtension == false)
            {
                foreach ($split as $_split)
                    if ($_split != $split[count($split) - 1])
                        $nameNoExtension .= "." . $_split;
            }
            else $nameNoExtension = $split[0];       
        }    
        
        if (stringEx($nameNoExtension)->startsWith("."))
            $nameNoExtension = stringEx($nameNoExtension)->subString(1, stringEx($nameNoExtension)->count);
        
        return ($nameNoExtension != "")
            ? $nameNoExtension
            : $name;
    }

    public static function rename($filePath, $newFileName, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);
        if ($validatePath == true) $filePath = self::getRealPath($filePath);

        if (!\File::exists($filePath) || stringEx($newFileName)->isEmpty())
            return false;

        $directory = \File::getDirectoryPath($filePath, $validatePath);
        $newPath   = ($directory . "/" . $newFileName);

        return self::move($filePath, $newPath, $validatePath);
    }

    public static function move($filePath, $newFilePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);
        if ($validatePath == true) $filePath = self::getRealPath($filePath);

        $newFilePath = \File\Wrapper::parsePath($newFilePath);
        $newFilePath = self::getInsensitivePath($newFilePath);
        if (stringEx($newFilePath)->isEmpty()) return false;

        $dirPath = self::getDirectoryPath($newFilePath);
        if (!DirectoryEx::isDirectory($dirPath))
            DirectoryEx::createDirectory($dirPath);

        $return = @rename($filePath, $newFilePath);
        return boolEx($return)->toBool();
    }

    public static function copy($filePath, $copyFilePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);
        if ($validatePath == true) $filePath = self::getRealPath($filePath);

        $copyFilePath = \File\Wrapper::parsePath($copyFilePath);
        $copyFilePath = self::getInsensitivePath($copyFilePath);
        if (stringEx($copyFilePath)->isEmpty()) return false;

        $dirPath = self::getDirectoryPath($copyFilePath);
        $dirPath = \File\Wrapper::parsePath($dirPath);
        if (!DirectoryEx::isDirectory($dirPath))
            DirectoryEx::createDirectory($dirPath);

        $return = @copy($filePath, $copyFilePath);
        return boolEx($return)->toBool();
    }
    
    public static function getFileExtension($filePath, $onlyLast = true, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);

        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        $name = basename($filePath);
        
        $split = stringEx($name)->split(".");
        $extension = "";
    
        if (count($split) >= 2)
        {
            if ($onlyLast == false)
            {
                foreach ($split as $_split)
                    if ($_split != $split[0])
                        $extension .= "." . $_split;
            }
            else $extension = $split[count($split) - 1];
        }
 
        if (stringEx($extension)->startsWith("."))
            $extension = stringEx($extension)->subString(1, stringEx($extension)->count);
            
        $extension = stringEx($extension)->toUpper();
    
        return ($extension != "")
            ? $extension
            : null;
    }

    public static function getRealPath($filePath, $rightBarOnly = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        $filePath = self::getInsensitivePath($filePath);

        $filePath = stringEx($filePath)->toString();
        $realPath = stringEx(realpath($filePath))->toString();

        $validatePath = ($rightBarOnly == true)
            ? stringEx($realPath)->replace("\\", "/")
            : $realPath;

        return (stringEx($validatePath)->isEmpty() ? null : $validatePath);
    }

    public static function delete($filePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        @unlink($filePath);
    }

    public static function getSize($filePath, $onlyBytes = false, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        if (\File::exists($filePath) == false) return null;

        $fileBytes = @filesize($filePath);
        $fileBytes = intEx($fileBytes)->toInt();

        if ($onlyBytes == true)
            return $fileBytes;
        return \File\Size::fromBytes($fileBytes);
    }

    public static function getPermission($filePath, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        if (\File::exists($filePath) == false) return null;

        $permission = intEx(substr(sprintf('%o', fileperms($filePath)), -4))->toInt();
        if ($permission <= 0) return null;
        return $permission;
    }

    public static function setPermission($filePath, $permission, $validatePath = false)
    {
        $filePath = \File\Wrapper::parsePath($filePath);
        if ($validatePath == true)
            $filePath = self::getRealPath($filePath);

        if (\File::exists($filePath) == false) return null;

        $permission = intEx($permission)->toInt();
        if ($permission <= 0) return null;

        \chmod(APPLICATION_FOLDER, $permission);
        if (self::getPermission($filePath, $validatePath) != $permission && (\System::isLinux() || \System::isMacOSX())) {
            \System\Shell::execute("chmod " . $permission . " \"" . $filePath . "\"");
            if (self::getPermission($filePath, $validatePath) != $permission)
                \System\Shell::execute("sudo chmod " . $permission . " \"" . $filePath . "\"");
        }
        return (self::getPermission($filePath, $validatePath) == $permission);
    }
}
    
    