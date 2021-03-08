<?php

namespace Render
{
    class CSS
    {
        private static $__isInitialized = false;
        private static function __initialize()
        {
            if (self::$__isInitialized == true) return;
            \KrupaBOX\Internal\Library::load("Sabberworm");
            self::$__isInitialized = true;
        }

        public $document = null;

        public static function getFromString($stringValue)
        {
            $stringValue = stringEx($stringValue)->toString();

            $css = new CSS();
            $css->loadCSS($stringValue);
            return $css;
        }

        public static function getFromPath($path)
        {
            if (\File::exists($path))
            {
                $content = \File::getContents($path);
                return self::getFromString($content);
            }

            return null;
        }

        public function __construct()
        { self::__initialize(); }

       public function loadCSS($stringValue)
       {
           $stringValue = stringEx($stringValue)->toString();
           $parser = new \Sabberworm\CSS\Parser($stringValue);
           $this->document = $parser->parse();
       }

        public function saveCSS($type = idented)
        {
            if ($this->document == null)
                return null;

            $outputFormat = null;

            if ($type == compact)
                $outputFormat = \Sabberworm\CSS\OutputFormat::createCompact();
            elseif ($type == idented)
                $outputFormat = \Sabberworm\CSS\OutputFormat::createPretty();

            return $this->document->render($outputFormat);
        }

        public function setBaseDirectoryFullUrl($directoryPath, $realFilePath, $importAssetsToBase64 = false, $recursiveToTop = true)
        {
            $realFilePath = stringEx($realFilePath)->replace("\\", "/");

            foreach($this->document->getAllValues() as $mValue)
                if ($mValue instanceof \Sabberworm\CSS\Value\URL)
                {
                    $url = stringEx($mValue->getURL()->getString())->trim();
                    $urlExtras = null;

                    if (stringEx($url)->contains("?")) {
                        $split = stringEx($url)->split("?");
                        $url       = $split[0];
                        $urlExtras = "?" . $split[1];
                    }
                    elseif (stringEx($url)->contains("#")) {
                        $split = stringEx($url)->split("#");
                        $url       = $split[0];
                        $urlExtras = "#" . $split[1];
                    }

                    $fixPath = stringEx($directoryPath . "/" . $url)->
                        replace("/", "\\", false)->
                        replace("\\\\", "\\", false)->
                        replace("\\\\", "\\");

                    $realUrlPath = \File::getRealPath($directoryPath . "/" . $url);
                    $finalUrl  = null;

                    if ($realUrlPath == null)
                    {
                        if ($recursiveToTop == true)
                        {
                            $currentDirectoryRecursivePath = $directoryPath;

                            do {
                                $directoryRecursivePath = stringEx($currentDirectoryRecursivePath)->
                                    replace("\\", "/", false)->
                                    replace("//", "/");

                                $startBar = stringEx($directoryRecursivePath)->startsWith("/");
                                $endBar   = stringEx($directoryRecursivePath)->startsWith("/");

                                $split = stringEx($directoryRecursivePath)->split("/");
                                $directoryRecursivePath = "";

                                foreach ($split as $_split)
                                    if ($_split != $split[($split->count) - 1])
                                        $directoryRecursivePath .= $_split . "/";

                                if (stringEx($directoryRecursivePath)->endsWith("/"))
                                    $directoryRecursivePath = stringEx($directoryRecursivePath)->subString(0, -1);

                                if ($startBar == true) $directoryRecursivePath = ("/" . $directoryRecursivePath);
                                if ($endBar   == true) $directoryRecursivePath .= "/";

                                $insideClientFolder = false;
                                $realRecursivePath = stringEx(\File::getRealPath($directoryRecursivePath))->replace("\\", "/");
                                if (!stringEx($realRecursivePath)->endsWith("/")) $realRecursivePath .= "/";

                                if (stringEx($realRecursivePath)->startsWith(CLIENT_FOLDER)) {
                                    $insideClientFolder = true;
                                    $currentDirectoryRecursivePath = $realRecursivePath;
                                }

                                if ($insideClientFolder && $realRecursivePath != null)
                                    $realUrlPath = \File::getRealPath($realRecursivePath . $url);
                            }
                            while($insideClientFolder == true && $realUrlPath == null);
                        }
                    }
                    
                    if ($realUrlPath != null && stringEx($realFilePath)->startsWith(CLIENT_FOLDER)) {
                        $finalUrl = stringEx($realUrlPath)->subString(stringEx(CLIENT_FOLDER)->length);
                        $finalUrl = stringEx($finalUrl)->replace("\\", "/");
                    }

                    if ($importAssetsToBase64 == true)
                    {
                        if ($finalUrl != null && \File::exists(CLIENT_FOLDER . $finalUrl) &&
                            ($urlExtras == null || ($urlExtras != "?#no-import" && $urlExtras != "?no-import" && $urlExtras != "#no-import")))
                        {
                            $fileUrlData = \File::getContents(CLIENT_FOLDER . $finalUrl);

                            $fileExtension = \File::getFileExtension(CLIENT_FOLDER . $finalUrl, true);
                            $mimeTypes = \File\MIME::getMIMEsByExtension($fileExtension);
                            $mimeType = (($mimeTypes->length > 0) ? $mimeTypes[0] : "text/plain");
                            $finalUrl = ("data:" . $mimeType . ";base64,". stringEx($fileUrlData)->toBase64());
                        }
                        else $finalUrl = ("File '" . $finalUrl . "' does not exists.");
                    }
                    else
                    {
                        if ($finalUrl != null && \File::exists(CLIENT_FOLDER . $finalUrl))
                        {
                            $absoluteUrl = (
                                (\Connection::isSecure() ? https : http) . "://" .
                                \Connection::getHost() . "/" .
                                \KrupaBOX\Internal\Routes::getSubfolderPathDiff()
                            );

                            $finalUrl = ($absoluteUrl . $finalUrl . $urlExtras);
                        }
                        else $finalUrl = ("File '" . $fixPath . "' does not exists (can be case-sensitive OS problem.");
                    }

                    $mValue->getURL()->setString($finalUrl);
                }

        }
    }
}