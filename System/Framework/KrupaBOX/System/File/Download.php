<?php

namespace File
{
    class Download
    {
        public static function getSize($url)
        {
            $url = stringEx($url)->toString();
            $data = \get_headers($url);

            if ($data == null)
                return null;

            $redirectUrl = null;

            do
            {
                $redirectUrl = null;
                $data = Arr($data);

                foreach ($data as $value)
                {
                    $valueLower = stringEx($value)->toLower();
                    if (stringEx($valueLower)->startsWith("location: "))
                    {
                        $redirectUrl = stringEx($value)->subString(10);
                        $redirectUrl = stringEx($redirectUrl)->trim("\r\n\t");
                        break;
                    }
                }


                if ($redirectUrl != null)
                {
                    $data = \get_headers($redirectUrl);
                    if ($data == null) return null;
                }
            }
            while ($redirectUrl != null);

            $data = Arr($data);
            $length = null;

            foreach ($data as $value)
            {
                $valueLower = stringEx($value)->toLower();
                if (stringEx($valueLower)->startsWith("content-length: "))
                {
                    $length = stringEx($value)->subString(16);
                    $length = stringEx($length)->trim("\r\n\t");
                    break;
                }
            }

            if ($length != null)
                return \File\Size::fromBytes($length);
            return null;
        }

        public static function save($url, $savePath, $limitBytes = 1048576, $delegate = null)
        {
            $size = self::getSize($url);
            if ($size == null) return null;

            $limitBytes = \intEx($limitBytes)->toInt();
            if ($limitBytes <= 0) $limitBytes = 1048576;

            $totalBytes = $size->toBytes();
            $savePath = \File\Wrapper::parsePath($savePath);

            if (\File::exists($savePath))
                \File::delete($savePath);

            $externalFile = @\fopen($url, "r");
            if ($externalFile == null || $externalFile == false)
                return null;

            $saveFile = @\fopen($savePath, "w+");
            if ($saveFile == null || $saveFile == false) {
                @\fclose($externalFile);
                return null;
            }

            $delegate = ((\FunctionEx::isFunction($delegate) == false) ? $delegate = (function($progress) { return true; }) : $delegate);
            $currentBytes = 0;

            while (!\feof($externalFile))
            {
                $buffer = @\fgets($externalFile, $limitBytes);
                @\fputs($saveFile, $buffer, $limitBytes);

                $bufferBytes = mb_strlen($buffer, '8bit');
                $currentBytes += $bufferBytes;
                unset($buffer);

                $progress = floatEx((100 / $totalBytes) * $currentBytes)->toFloat();
                $return = $delegate($progress);
                if ($return == false) {
                    @\fclose($externalFile);
                    return null;
                }
            }

            @\fclose($externalFile);
            return true;
        }
    }
}