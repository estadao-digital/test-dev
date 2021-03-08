<?php

class Blob
{
    protected $sid      = null;
    protected $data     = null;
    protected $mimeType = null;
    protected $isLoaded = false;

    protected $isSavedLocal  = false;
    protected $isSavedPublic = false;

    public function __construct($data = null, $mimeType = null)
    {
        $data = stringEx($data)->toString();
        $mimeType = stringEx($mimeType)->toString();

        if (stringEx($data)->isEmpty() == false)
            $this->data = $data;
        if (stringEx($mimeType)->isEmpty() == false)
            $this->mimeType = $mimeType;

        $this->isLoaded = true;
    }

    public function __get($key) {
        if ($key == data)     return $this->data;
        if ($key == mimeType) return $this->mimeType;
        if ($key == mimeType) return $this->mimeType;
        return null;
    }

    protected function getSid()
    {
        $md5 = \Security\Hash::toMd5($this->data, "BLOB_KRUPABOX_239867832846123");
        if (stringEx($md5)->isEmpty()) $md5 = \Security\Hash::toMd5("", "BLOB_KRUPABOX_239867832846123");
        return self::parseMd5($md5);
    }

    protected static function parseMd5($md5)
    {
        return (
            stringEx($md5)->subString(0, 8) . "-" .
            stringEx($md5)->subString(8, 4) . "-" .
            stringEx($md5)->subString(12, 4) . "-" .
            stringEx($md5)->subString(16, 4) . "-" .
            stringEx($md5)->subString(20)
        );
    }

    public function toLocalUrl()
    {
        if ($this->sid == null)
            $this->sid = $this->getSid();

        \File::setContents("datadb://Blob/" . $this->sid . ".blob.mt", $this->mimeType);

        if ($this->isSavedLocal == false && $this->isSavedPublic == true) {
            if (\File::exists("cache://.blob/" . $this->sid . ".blob") == false)
                \File::copy("datadb://Blob/" . $this->sid . ".blob", "cache://.blob/" . $this->sid . ".blob");
        }
        elseif  ($this->isSavedLocal == false) {
            if (\File::exists("datadb://Blob/" . $this->sid . ".blob") == false)
                \File::setContents("datadb://Blob/" . $this->sid . ".blob", $this->data);
        }

        $this->isSavedLocal = true;
        return ("blob://" . $this->sid);
    }

    public function toPublicUrl()
    {
        if ($this->sid == null)
            $this->sid = $this->getSid();

        \File::setContents("datadb://Blob/" . $this->sid . ".blob.mt", $this->mimeType);

        if ($this->isSavedPublic == false && $this->isSavedLocal == true) {
            if (\File::exists("datadb://Blob/" . $this->sid . ".blob") == false)
                \File::copy("cache://.blob/" . $this->sid . ".blob", "datadb://Blob/" . $this->sid . ".blob");
        }
        elseif  ($this->isSavedPublic == false) {
            if (\File::exists("datadb://Blob/" . $this->sid . ".blob") == false)
                \File::setContents("datadb://Blob/" . $this->sid . ".blob", $this->data);
        }

        $this->isSavedPublic = true;
        return ("blob://" . $this->sid);
    }

    public function output($cacheControl = true)
    {
        if ($this->isLoaded == true)
            \Connection\Output::execute($this->data, $this->mimeType, null, true, (($cacheControl == true) ? (60 * 60 * 24 * 30) : null));

        if (stringEx($this->mimeType)->isEmpty() == false)
            \Header::setContentType($this->mimeType);
        if ($cacheControl == true)
            \Header::setCache(60 * 60 * 24 * 30);
        if (\Dumpper::isPageDumped() == false)
            \Header::sendHeader();

        if ($this->isSavedLocal == true)
            \File::output("cache://.blob/" . $this->sid . ".blob");
        elseif ($this->isSavedPublic == true)
            \File::output("datadb://Blob/" . $this->sid . ".blob");
        \KrupaBOX\Internal\Kernel::exit();
    }

    public static function fromLocalUrl($url)
    {
        if (stringEx($url)->startsWith("blob://") == false)
            return null;

        $sid = stringEx($url)->subString(7);
        if (stringEx($sid)->count != 36)
            return null;

        if (\File::exists("cache://.blob/" . $sid . ".blob"))
        {
            $blob = new Blob();
            $blob->sid = $sid;
            $blob->isLoaded = false;
            $blob->isSavedLocal = true;
            $blob->mimeType = \File::getContents("cache://.blob/" . $sid . ".blob.mt");
            return $blob;
        }

        return null;
    }

    public static function fromPublicUrl($url)
    {
        if (stringEx($url)->startsWith("blob://") == false)
            return null;

        $sid = stringEx($url)->subString(7);
        if (stringEx($sid)->count != 36)
            return null;

        if (\File::exists("datadb://Blob/" . $sid . ".blob"))
        {
            $blob = new Blob();
            $blob->sid = $sid;
            $blob->isLoaded = false;
            $blob->isSavedPublic = true;
            $blob->mimeType = \File::getContents("datadb://Blob/" . $sid . ".blob.mt");
            return $blob;
        }

        return null;
    }

    public static function createFromPath($path, $mimeType = null, $localBlob = true)
    {
        $path = \File\Wrapper::parsePath($path);
        if (\File::exists($path) == false)
            return null;

        $md5 = \File::toMd5($path);
        if (stringEx($md5)->isEmpty()) return null;
        $sid = self::parseMd5($md5);

        $_localBlob = \Blob::fromLocalUrl("blob://" . $sid);
        if ($_localBlob != null) return $_localBlob;
        $publicBlob = \Blob::fromPublicUrl("blob://" . $sid);
        if ($publicBlob != null) return $publicBlob;

        $mimeType = stringEx($mimeType)->toString();
        if (stringEx($mimeType)->isEmpty()) {
            $extension = \File::getFileExtension($path);
            if (stringEx($extension)->isEmpty() == false) {
                $fileMimes = \File\MIME::getMIMEsByExtension($extension);
                if ($fileMimes != null && $fileMimes->count > 0) $mimeType = $fileMimes[0];
            }
        }

        if ($localBlob == true) {
            if (\File::exists("cache://.blob/" . $sid . ".blob") == false)
                \File::copy($path, "cache://.blob/" . $sid . ".blob");
            \File::setContents("cache://.blob/" . $sid . ".blob.mt", $mimeType);
            return \Blob::fromLocalUrl("blob://" . $sid);
        }

        if (\File::exists("datadb://Blob/" . $sid . ".blob") == false)
            \File::copy($path, "datadb://Blob/" . $sid . ".blob");
        \File::setContents("datadb://Blob/" . $sid . ".blob.mt", $mimeType);

        return \Blob::fromPublicUrl("blob://" . $sid);
    }
}