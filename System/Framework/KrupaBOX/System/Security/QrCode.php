<?php

namespace Security
{
    class QrCode
    {
        protected static $qrCachePath = null;

        protected $text     = " ";
        protected $ecc      = "default";
        protected $size     = 6;
        protected $padding  = 4;

        protected $image = null;

        protected static function initialize()
        {
            \KrupaBOX\Internal\Library::load("PhpQrCode");

            self::$qrCachePath = (\Garbage\Cache::getCachePath() . ".qrcode/");
            if (\DirectoryEx::exists(self::$qrCachePath) == false)
                \DirectoryEx::createDirectory(self::$qrCachePath);
        }

        public function __construct($codeText = " ")
        {
            self::initialize();

            if (stringEx($codeText)->isEmpty() == false)
                $this->text = $codeText;
        }

        public function __set($key, $value)
        {
            $key = stringEx($key)->toLower();

            if ($key == ecc) {
                $value = stringEx($value)->toLower();
                if ($value == low || $value == medium || $value == "default" || $value == high) {
                    $this->ecc = $value; $this->image = null;
                }
            } elseif ($key == size) {
                $value = intEx($value)->toInt();
                if ($value > 0) { $this->size = $value; $this->image = null; }
            } elseif ($key == padding) {
                $value = intEx($value)->toInt();
                if ($value > 4) { $this->padding = $value; $this->image = null; }
            } elseif ($key == text)
            {
                $value = stringEx($value)->toString();
                if (stringEx($value)->isEmpty())
                    $this->text = " ";
                else $this->text = $value;
                $this->image = null;
            }
        }

        public function __get($key)
        {
            $key = stringEx($key)->toLower();

            if ($key == ecc) {
                return $this->ecc;
            } elseif ($key == size) {
                return $this->size;
            } elseif ($key == padding) {
                return $this->padding;
            } elseif ($key == text) {
                if ($this->text == " ")
                    return "";
                return $this->text;
            }

            return null;
        }

        protected function getQrCodeHash()
        { return \Security\Hash::toSha1($this->ecc . "." . $this->size . "." . $this->padding . "." . $this->text); }

        public function getImage()
        {
            if ($this->image != null)       return $this->image;
            if (self::$qrCachePath == null) return null;

            $hash = $this->getQrCodeHash();
            $qrCacheFilePath = (self::$qrCachePath . $hash . ".png");

            if (\File::exists($qrCacheFilePath))
                return \File\Image::fromFilePath($qrCacheFilePath);

            $qrEcc = QR_ECLEVEL_Q;
            if ($this->ecc == low) $qrEcc = QR_ECLEVEL_L;
            elseif ($this->ecc == medium) $qrEcc = QR_ECLEVEL_M;
            elseif ($this->ecc == high)   $qrEcc = QR_ECLEVEL_H;

            \QRcode::png($this->text, self::$qrCachePath . $hash . ".png", $qrEcc, $this->size, $this->padding);
            return \File\Image::fromFilePath($qrCacheFilePath);
        }
    }
}