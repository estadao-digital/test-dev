<?php

namespace File
{
    class Size
    {
        const FORMAT_BYTES     = "B";
        const FORMAT_KILOBYTES = "KB";
        const FORMAT_MEGABYTES = "MB";
        const FORMAT_GIGABYTES = "GB";
        const FORMAT_TERABYTES = "TB";
        const FORMAT_PETABYTES = "PB";
        const FORMAT_EXABYTES  = "EB";

        protected static $fallBack = [
            YB => YiB, ZB => ZiB, EB => EiB, PB => PiB, TB => TiB, GB => GiB, MB => MiB, KB => KiB
        ];

        protected static $__isInitialized = false;
        protected static function __initialize()
        {
            if (self::$__isInitialized == true) return;

            \KrupaBOX\Internal\Library::load("ByteUnits");
            self::$fallBack = Arr(self::$fallBack);
            self::$__isInitialized = true;

            if (function_exists("bcpow") == false)
            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing BCMATH extension."]); \KrupaBOX\Internal\Kernel::exit(); }
        }

        protected $bytesUnit = null;

        public function __construct($fileSize)
        {
            self::__initialize();

            $fileSize = stringEx($fileSize)->toString();
            foreach (self::$fallBack as $key => $value)
                $fileSize = stringEx($fileSize)->replace($key, $value);

            $this->bytesUnit =  \ByteUnits\parse($fileSize);
            $this->bytesUnit->asBinary();
        }

        public function format($format = self::FORMAT_BYTES, $limitDigits = 2)
        {
            if ($format != self::FORMAT_BYTES && $format != self::FORMAT_KILOBYTES && $format != self::FORMAT_MEGABYTES && $format != self::FORMAT_GIGABYTES && $format != self::FORMAT_TERABYTES && $format != self::FORMAT_PETABYTES &&  $format != self::FORMAT_EXABYTES)
                $format = self::FORMAT_BYTES;

            foreach (self::$fallBack as $key => $value)
                $format = stringEx($format)->replace($key, $value);

            $limitDigits = intEx($limitDigits)->toInt();

            $formated = $this->bytesUnit->format($format . "/" . $limitDigits);
            foreach (self::$fallBack as $key => $value)
                $formated = stringEx($formated)->replace($value, $key);

            return $formated;
        }

        public function toBytes()
        { return intEx($this->bytesUnit->numberOfBytes())->toInt(); }

        public function toKiloBytes()
        {
            $formated = $this->format(self::FORMAT_KILOBYTES, 20);
            return floatEx(stringEx($formated)->remove("KB"))->toFloat();
        }

        public function toMegaBytes()
        {
            $formated = $this->format(self::FORMAT_MEGABYTES, 20);
            return floatEx(stringEx($formated)->remove("MB"))->toFloat();
        }

        public function toGigaBytes()
        {
            $formated = $this->format(self::FORMAT_GIGABYTES, 20);
            return floatEx(stringEx($formated)->remove("GB"))->toFloat();
        }

        public function toTeraBytes()
        {
            $formated = $this->format(self::FORMAT_TERABYTES, 20);
            return floatEx(stringEx($formated)->remove("TB"))->toFloat();
        }

        public function toPetaBytes()
        {
            $formated = $this->format(self::FORMAT_PETABYTES, 20);
            return floatEx(stringEx($formated)->remove("PB"))->toFloat();
        }

        public function toExaBytes()
        {
            $formated = $this->format(self::FORMAT_EXABYTES, 20);
            return floatEx(stringEx($formated)->remove("EB"))->toFloat();
        }

        public function toString()
        { return stringEx($this->toBytes())->toString();  }

        public function __toString()
        { return $this->toString(); }

        public static function fromBytes($bytes)
        {
            $bytes = intEx($bytes)->toInt();
            $size = new Size(0);
            $size->bytesUnit =  \ByteUnits\Binary::bytes($bytes);

            return $size;
        }

        public static function fromKiloBytes($kiloBytes)
        {
            $kiloBytes = intEx($kiloBytes)->toInt();
            return new Size($kiloBytes . "KiB");
        }

        public static function fromMegaBytes($megaBytes)
        {
            $megaBytes = intEx($megaBytes)->toInt();
            return new Size($megaBytes . "MiB");
        }

        public static function fromGigaBytes($gigaBytes)
        {
            $gigaBytes = intEx($gigaBytes)->toInt();
            return new Size($gigaBytes . "GiB");
        }

        public static function fromTeraBytes($teraBytes)
        {
            $teraBytes = intEx($teraBytes)->toInt();
            return new Size($teraBytes . "TiB");
        }

        public static function fromPetaBytes($petaBytes)
        {
            $petaBytes = intEx($petaBytes)->toInt();
            return new Size($petaBytes . "PiB");
        }

        public static function fromExaBytes($exaBytes)
        {
            $exaBytes = intEx($exaBytes)->toInt();
            return new Size($exaBytes . "EiB");
        }
    }

}