<?php

namespace Connection
{
    class Output
    {
        protected $contentData = null;
        protected $contentLength = null;

        protected function __construct($contentData, $contentLength)
        {
            $this->contentData   = $contentData;
            $this->contentLength = $contentLength;
        }

        public static function execute($stringData = null, $mimeType = null, $contentLength = null, $zip = true, $cacheAgeInSeconds = null, $forceDownload = false, $downloadFileName = null)
        {
            //$stringData    = stringEx($stringData)->toString();
            $mimeType      = stringEx($mimeType)->toString();
            $contentLength = intEx($contentLength)->toInt();
            $zip           = boolEx($zip)->toBool();
            $cache         = intEx($cacheAgeInSeconds)->toInt();
            $isDumped      = \Dumpper::isPageDumped();
            
            if (stringEx($mimeType)->isEmpty()) $mimeType = "text/html";
            if ($contentLength <= 0) $contentLength = null;

            \Header::setContentType($mimeType);
            if ($cache > 0) \Header::setCache($cache);

            if ($forceDownload == true && $isDumped == false)
            {
                \Header::setContentType("application/octet-stream");
                $downloadFileName = stringEx($downloadFileName)->toString();
                \Header::setContentDisposition("attachment; filename", "\"" . $downloadFileName . "\"");
            }

            if ($zip == true && $isDumped == false && self::executeZip($stringData) == true)
                \KrupaBOX\Internal\Kernel::exit();

            if ($contentLength != null)
                \Header::setContentLength($contentLength);
            if ($isDumped == false)
                \Header::sendHeader();

            echo $stringData;
            \KrupaBOX\Internal\Kernel::exit();
        }

        public static function download($stringData = null, $downloadFileName = null, $contentLength = null, $zip = true)
        { self::execute($stringData, null, $contentLength, $zip, null, true, $downloadFileName); }

        protected static function executeZip($stringData)
        {
            $config = \Config::get();
            $canGzip = (\Dumpper::isPageDumped() == false && $config->output->gzip == true && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && stripos($_SERVER['HTTP_ACCEPT_ENCODING'], "gzip") !== false && function_exists("gzencode") && (!((ini_get('zlib.output_compression') == 'On' || ini_get('zlib.output_compression_level') > 0) || ini_get('output_handler') == 'ob_gzhandler')) == true);

            if ($canGzip == true)
            {
                $dataHash = \Security\Hash::toSha1($stringData);
                $dataPath = ("cache://.tmp/gzip/output/" . $dataHash . ".blob.gz");

                if (\File::exists($dataPath) == false)
                    \File::setContents($dataPath, gzencode($stringData));

                $encodeData = \File::getContents($dataPath);
                \Header::setContentEncoding("gzip");
                \Header::setContentLength(stringEx($encodeData)->length);

                \Header::sendHeader();
                echo $encodeData;

                return true;
            }

            $canDeflate = ($config->output->deflate == true && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && stripos($_SERVER['HTTP_ACCEPT_ENCODING'], "deflate") !== false && function_exists("gzdeflate"));
            if ($canDeflate == true)
            {
                $encodeData = gzdeflate($stringData);

                \Header::setContentEncoding("deflate");
                \Header::setContentLength(stringEx($encodeData)->length);

                \Header::sendHeader();
                echo $encodeData;

                return true;
            }

            return false;
        }
    }
}