<?php

namespace Render\Front
{
    class View
    {
        protected $path   = null;
        protected $buffer = null;
        protected $order  = null;

        protected $bufferScripts     = null;
        protected $bufferStylesheets = null;
        protected $bufferBundles     = null;
        protected $bufferHead        = null;
        protected $bufferData        = null;
        protected $includeData       = null;

        protected $includedScripts    = null;
        protected $includedStyleshets = null;
        protected $includedBundles    = null;
        protected $includedHead       = null;
        protected $includedData       = null;
        protected $tagsData           = null;

        protected $scripts     = null;
        protected $stylesheets = null;
        protected $head        = null;
        protected $data        = null;
        protected $include     = null;
        protected $tags        = null;
        protected $bundles     = null;

        protected $lastBuffer    = null;
        protected $cleanBodyHTML = null;

        protected static $tagTypes = null;
        protected static $tagViews = null;

        public function __construct($path)
        {
            if (!\File::exists($path))
                return;

            $this->path = $path;
        }

        public static function fromPath($path)
        {
            $path  = \File\Wrapper::parsePath($path);
            $iPath = \KrupaBOX\Internal\Engine::getInsensitivePathFix($path);
            if (\File::exists($iPath)) return new View($iPath);
            return null;
        }

        public static function fromNamespace($namespace)
        {
            $path = (CLIENT_FOLDER . "View/" . stringEx($namespace)->
                replace("\\", "/", false)->
                replace("//", "/", false)->
                replace(".", "/", false)
            );

            if (stringEx($path)->endsWith("/html"))      $path = (stringEx($path)->subString(0, stringEx($path)->count - 5) . ".html");
            if (stringEx($path)->endsWith("/html/twig"))      $path = (stringEx($path)->subString(0, stringEx($path)->count - 10) . ".html.twig");
            elseif (stringEx($path)->endsWith("/php"))   $path = (stringEx($path)->subString(0, stringEx($path)->count - 4) . ".php");
            elseif (stringEx($path)->endsWith("/htm"))   $path = (stringEx($path)->subString(0, stringEx($path)->count - 4) . ".htm");
            elseif (stringEx($path)->endsWith("/xhtml")) $path = (stringEx($path)->subString(0, stringEx($path)->count - 6) . ".xhtml");
            elseif (stringEx($path)->endsWith("/hml"))   $path = (stringEx($path)->subString(0, stringEx($path)->count - 4) . ".hml");

            $iPath = null;
            if (!stringEx($path)->endsWith(".html.twig") && !stringEx($path)->endsWith(".html") && !stringEx($path)->endsWith(".htm") && !stringEx($path)->endsWith(".xhtml") && !stringEx($path)->endsWith(".hml") && !stringEx($path)->endsWith(".php")) {
                $iPath = \KrupaBOX\Internal\Engine::getInsensitivePathFix($path . ".html");
                if (\File::exists($iPath) == false) { $iPath = \KrupaBOX\Internal\Engine::getInsensitivePathFix($path . ".php"); }
            } else $iPath = \KrupaBOX\Internal\Engine::getInsensitivePathFix($path);

            if (\File::exists($iPath)) return new View($iPath);

            $path = (CLIENT_FOLDER . "Public/" . stringEx($namespace)->
                replace("\\", "/", false)->
                replace("//", "/", false)->
                replace(".", "/", false)
            );

            if (!stringEx($path)->endsWith(".html.twig") && !stringEx($path)->endsWith(".html") && !stringEx($path)->endsWith(".htm") && !stringEx($path)->endsWith(".xhtml") && !stringEx($path)->endsWith(".hml") && !stringEx($path)->endsWith(".php"))
                $path = ($path . ".html");


            $iPath = \KrupaBOX\Internal\Engine::getInsensitivePathFix($path);
            if (\File::exists($iPath)) return new View($iPath);

            return null;
        }

        public function getContent()
        {
            if ($this->buffer != null) return $this->buffer;
            if ($this->path == null) { $this->buffer = ""; return $this->buffer; }

            ob_start(); include($this->path);
            $this->buffer = ob_get_contents();
            ob_end_clean();

            $this->includeFiles();

            return $this->buffer;
        }

        protected function includeFiles()
        {
            $buffer = $this->buffer;

            $includes = Arr();

            // TITLE
            $tagIncludeOpen  = "<_include";
            $tagIncludeClose = "</_include>";

            // Match includes
            preg_match_all("#<include(.*?)</include>#is", $buffer, $matches);

            foreach ($matches[0] as $value)
            {
                $plainHTML = $value;
                $plainHTML = str_replace("<include", $tagIncludeOpen, $plainHTML);   // test
                $plainHTML = str_replace("</include>", $tagIncludeClose, $plainHTML); // test

                $includeTagIndexOf = strpos($plainHTML, ">");
                if ($includeTagIndexOf === false)
                    continue;

                $includeTag = substr($plainHTML, 0, $includeTagIndexOf);

                $isSingleQuote = false;
                $indexOfAttrSrc = strpos($includeTag, "src=\"");
                if ($indexOfAttrSrc === false) {
                    $indexOfAttrSrc = strpos($includeTag, "src='");
                    if ($indexOfAttrSrc !== false) $isSingleQuote = true;
                }

                if ($indexOfAttrSrc === false) continue;
                $attrSrc = substr($includeTag, $indexOfAttrSrc + 5);

                $indexOfEndAttrSrc = (($isSingleQuote == false) ? strpos($attrSrc, "\"") : strpos($attrSrc, "'"));
                if ($indexOfEndAttrSrc == false) continue;

                $attrSrc = substr($attrSrc, 0, $indexOfEndAttrSrc);
                if (empty($attrSrc)) continue;

                if (stringEx($attrSrc)->startsWith('view://'))
                    $attrSrc = stringEx($attrSrc)->subString(7);
                if (stringEx($attrSrc)->startsWith('public://'))
                    $attrSrc = stringEx($attrSrc)->subString(9);

                $namespace = stringEx($attrSrc)->replace("\\", ".", false)->replace("/", ".");
                while (stringEx($namespace)->contains(".."))
                    $namespace = stringEx($attrSrc)->replace("..", ".");

                if (stringEx($namespace)->startsWith("."))
                    $namespace = stringEx($namespace)->subString(1);

                $includes->add([plainHTML => $value, src => $attrSrc, "namespace" => $namespace, "buffer" => ""]);
            }

            // Render & merge or remove
            foreach ($includes as $include)
            {
                $include->buffer = '';

                $path = (CLIENT_FOLDER . "View/" . stringEx($include->namespace)->
                    replace("\\", "/", false)->
                    replace("//", "/", false)->
                    replace(".", "/", false)
                );

                if (stringEx($path)->endsWith("/html"))      $path = (stringEx($path)->subString(0, stringEx($path)->count - 5) . ".html");
                if (stringEx($path)->endsWith("/html/twig"))      $path = (stringEx($path)->subString(0, stringEx($path)->count - 10) . ".html.twig");
                elseif (stringEx($path)->endsWith("/php"))   $path = (stringEx($path)->subString(0, stringEx($path)->count - 4) . ".php");
                elseif (stringEx($path)->endsWith("/htm"))   $path = (stringEx($path)->subString(0, stringEx($path)->count - 4) . ".htm");
                elseif (stringEx($path)->endsWith("/xhtml")) $path = (stringEx($path)->subString(0, stringEx($path)->count - 6) . ".xhtml");
                elseif (stringEx($path)->endsWith("/hml"))   $path = (stringEx($path)->subString(0, stringEx($path)->count - 4) . ".hml");

                $iPath = null;
                if (!stringEx($path)->endsWith(".html.twig") && !stringEx($path)->endsWith(".html") && !stringEx($path)->endsWith(".htm") && !stringEx($path)->endsWith(".xhtml") && !stringEx($path)->endsWith(".hml") && !stringEx($path)->endsWith(".php")) {
                    $iPath = \KrupaBOX\Internal\Engine::getInsensitivePathFix($path . ".html");
                    if (\File::exists($iPath) == false) { $iPath = \KrupaBOX\Internal\Engine::getInsensitivePathFix($path . ".php"); }
                } else $iPath = \KrupaBOX\Internal\Engine::getInsensitivePathFix($path);

                if (\File::exists($iPath) === false) {
                    $path = (CLIENT_FOLDER . "Public/" . stringEx($namespace)->
                        replace("\\", "/", false)->
                        replace("//", "/", false)->
                        replace(".", "/", false)
                    );

                    if (!stringEx($path)->endsWith(".html.twig") && !stringEx($path)->endsWith(".html") && !stringEx($path)->endsWith(".htm") && !stringEx($path)->endsWith(".xhtml") && !stringEx($path)->endsWith(".hml") && !stringEx($path)->endsWith(".php"))
                        $path = ($path . ".html");

                    $iPath = \KrupaBOX\Internal\Engine::getInsensitivePathFix($path);
                }

                if (\File::exists($iPath)) {
                    \ob_start(); include($iPath);
                    $include->buffer = \ob_get_contents();
                    \ob_end_clean();
                }

                $indexOf = stringEx($include->buffer)->indexOf('<html');
                if ($indexOf !== null) {
                    $_remove = stringEx($include->buffer)->subString($indexOf + 5);
                    $indexOf = stringEx($_remove)->indexOf('>');
                    if ($indexOf !== null) {
                        $_remove = stringEx($_remove)->subString(0, $indexOf + 1);
                        $include->buffer = stringEx($include->buffer)->remove('<html' . $_remove);
                    }
                }

                $indexOf = stringEx($include->buffer)->indexOf('<body');
                if ($indexOf !== null) {
                    $_remove = stringEx($include->buffer)->subString($indexOf + 5);
                    $indexOf = stringEx($_remove)->indexOf('>');
                    if ($indexOf !== null) {
                        $_remove = stringEx($_remove)->subString(0, $indexOf + 1);
                        $include->buffer = stringEx($include->buffer)->remove('<body' . $_remove);
                    }
                }

                $indexOf = stringEx($include->buffer)->indexOf('</body');
                if ($indexOf !== null) {
                    $_remove = stringEx($include->buffer)->subString($indexOf + 6);
                    $indexOf = stringEx($_remove)->indexOf('>');
                    if ($indexOf !== null) {
                        $_remove = stringEx($_remove)->subString(0, $indexOf + 1);
                        $include->buffer = stringEx($include->buffer)->remove('</body' . $_remove);
                    }
                }

                $indexOf = stringEx($include->buffer)->indexOf('</html');
                if ($indexOf !== null) {
                    $_remove = stringEx($include->buffer)->subString($indexOf + 6);
                    $indexOf = stringEx($_remove)->indexOf('>');
                    if ($indexOf !== null) {
                        $_remove = stringEx($_remove)->subString(0, $indexOf + 1);
                        $include->buffer = stringEx($include->buffer)->remove('</html' . $_remove);
                    }
                }

                $this->buffer = stringEx($this->buffer)->replace($include->plainHTML, $include->buffer);
            }

            preg_match_all("#<include(.*?)</include>#is", $this->buffer, $matches);
            if (count($matches[0]) > 0)
                $this->includeFiles();
        }

        public function getOrder()
        {
            if ($this->order != null)
                return $this->order;

            $content = $this->getContent();
            if (stringEx($content)->contains("<html") == false)
                return null;

            $splitContent = stringEx($content)->split("<html");
            if ($splitContent->count <= 1) return null;

            $htmlTag = $splitContent[1];
            $htmlTagEndIndex = stringEx($htmlTag)->indexOf(">");
            if ($htmlTagEndIndex === null) return null;
            $htmlTag = stringEx($htmlTag)->subString(0, $htmlTagEndIndex);

            if (stringEx($htmlTag)->contains("order=") == false)
                return null;

            $htmlOrderSplit = stringEx($htmlTag)->split("order=");
            if ($htmlOrderSplit->count <= 1) return null;

            $htmlOrder = $htmlOrderSplit[1];

            $htmlOrderInitIndex = stringEx($htmlOrder)->indexOf("\"");
            if ($htmlOrderInitIndex === null) return null;
            $htmlOrder = stringEx($htmlOrder)->subString($htmlOrderInitIndex + 1);

            $htmlOrderEndIndex = stringEx($htmlOrder)->indexOf("\"");
            if ($htmlOrderEndIndex === null) return null;
            $htmlOrder = stringEx($htmlOrder)->subString(0, $htmlOrderEndIndex);

            $this->order = intEx($htmlOrder)->toInt();
            return $this->order;
        }

        protected function getLastBuffer($current)
        {
            $buffer = null;

            if ($this->lastBuffer == null) {
                $this->lastBuffer = $current;
                $buffer = $this->getContent();
            }
            elseif ($this->lastBuffer == "scripts") {
                $this->lastBuffer = $current;
                $buffer = $this->bufferScripts;
            }
            elseif ($this->lastBuffer == "stylesheets") {
                $this->lastBuffer = $current;
                $buffer = $this->bufferStylesheets;
            }
            elseif ($this->lastBuffer == "bundles") {
                $this->lastBuffer = $current;
                $buffer = $this->bufferBundles;
            }
            elseif ($this->lastBuffer == "head") {
                $this->lastBuffer = $current;
                $buffer = $this->bufferHead;
            }
            elseif ($this->lastBuffer == "data") {
                $this->lastBuffer = $current;
                $buffer = $this->bufferData;
            }
            elseif ($this->lastBuffer == "include") {
                $this->lastBuffer = $current;
                $buffer = $this->includeData;
            }
            elseif ($this->lastBuffer == "tags") {
                $this->lastBuffer = $current;
                $buffer = $this->tagsData;
            }

            if ($buffer == null)
                $buffer = $this->getContent();

            return $buffer;
        }


        public function getScriptsMetadata()
        {
            if ($this->bufferScripts != null)
                return $this->scripts;

            $this->getTagsMetadata();
            $buffer = $this->getLastBuffer("scripts");

            $scripts = $this->includedScripts;

            $tagScriptOpen = "<_script";
            $tagScriptClose = "/_script>";

            // Match scripts
            preg_match_all("#<script(.*?)</script>#is", $buffer, $matches);

            foreach ($matches[0] as $value)
            {
                $plainHTML = $value;
                $plainHTML = str_replace("<script", $tagScriptOpen, $plainHTML);   // test
                $plainHTML = str_replace("/script>", $tagScriptClose, $plainHTML); // test

                $script = Arr();
                $script->plainHTML  = $plainHTML;
                $script->scriptURL  = null;
                $script->scriptBody = null;

                $script->scriptFileURL = null;
                $script->scriptHashURL = null;
                $script->order         = 0;
                $script->bundle        = true;
                $script->minify        = true;
                $script->babel         = false;

                $scriptTagIndexOf = strpos($script->plainHTML, ">");
                if ($scriptTagIndexOf !== false)
                {
                    $extractScriptTag     = substr($script->plainHTML, 0, $scriptTagIndexOf);

                    $isDoubleQuote        = true;
                    $scriptSrcAttrIndexOf = strpos($extractScriptTag, "src=\"");
                    if ($scriptSrcAttrIndexOf === false) {
                        $scriptSrcAttrIndexOf = strpos($extractScriptTag, "src='");
                        if ($scriptSrcAttrIndexOf !== false) $isDoubleQuote = false;
                    }

                    if ($scriptSrcAttrIndexOf !== false)
                    {
                        $extractScriptSrcAttr = substr($extractScriptTag, $scriptSrcAttrIndexOf + 5);

                        $scriptSrcAttrEndIndexOf = strpos($extractScriptSrcAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                        if ($scriptSrcAttrEndIndexOf !== false)
                            $extractScriptSrcAttr = substr($extractScriptSrcAttr, 0, $scriptSrcAttrEndIndexOf);

                        $script->scriptURL = $extractScriptSrcAttr;
                    }

                    if ($script->scriptURL == null)
                    {
                        $afterScriptBody = substr($script->plainHTML, $scriptTagIndexOf + 1);

                        $endScriptBodyTagIndexOf = strpos($afterScriptBody, $tagScriptClose);
                        if ($endScriptBodyTagIndexOf !== false)
                            $afterScriptBody = substr($afterScriptBody, 0, $endScriptBodyTagIndexOf - 1);

                        $script->scriptBody = $afterScriptBody;
                        $script->enabled    = true;
                    }

                    // Get type info
                    $scriptTypeAttrIndexOf = strpos($extractScriptTag, "type=\"");
                    if ($scriptTypeAttrIndexOf === false) {
                        $scriptTypeAttrIndexOf = strpos($extractScriptTag, "type='");
                        if ($scriptTypeAttrIndexOf !== false) $isDoubleQuote = false;
                    }

                    if ($scriptTypeAttrIndexOf !== false)
                    {
                        $extractScriptTypeAttr = substr($extractScriptTag, $scriptTypeAttrIndexOf + 6);

                        $scriptTypeAttrEndIndexOf = strpos($extractScriptTypeAttr, (($isDoubleQuote == true) ? "\"" : "'"));

                        if ($scriptTypeAttrEndIndexOf !== false)
                            $extractScriptTypeAttr = substr($extractScriptTypeAttr, 0, $scriptTypeAttrEndIndexOf);

                        $extractScriptTypeAttr = stringEx($extractScriptTypeAttr)->toLower();
                        $script->type = $extractScriptTypeAttr;
                        if ($script->type === 'text/babel')
                            $script->babel = true;
                    }

                    // Get order
                    $scriptOrderAttrIndexOf = strpos($extractScriptTag, "order=\"");
                    if ($scriptOrderAttrIndexOf === false) {
                        $scriptOrderAttrIndexOf = strpos($extractScriptTag, "order='");
                        if ($scriptOrderAttrIndexOf !== false) $isDoubleQuote = false;
                    }

                    if ($scriptOrderAttrIndexOf !== false)
                    {
                        $extractScriptOrderAttr = substr($extractScriptTag, $scriptOrderAttrIndexOf + 7);

                        $scriptOrderAttrEndIndexOf = strpos($extractScriptOrderAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                        if ($scriptOrderAttrEndIndexOf !== false)
                            $extractScriptOrderAttr = substr($extractScriptOrderAttr, 0, $scriptOrderAttrEndIndexOf);

                        $script->order = intEx($extractScriptOrderAttr)->toInt();
                    }

                    // Get bundle info
                    $scriptBundleAttrIndexOf = strpos($extractScriptTag, "app-bundle=\"");
                    if ($scriptBundleAttrIndexOf === false) {
                        $scriptBundleAttrIndexOf = strpos($extractScriptTag, "app-bundle='");
                        if ($scriptBundleAttrIndexOf !== false) $isDoubleQuote = false;
                    }

                    if ($scriptBundleAttrIndexOf !== false)
                    {
                        $extractScriptBundleAttr = substr($extractScriptTag, $scriptBundleAttrIndexOf + 12);

                        $scriptBundleAttrEndIndexOf = strpos($extractScriptBundleAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                        if ($scriptBundleAttrEndIndexOf !== false)
                            $extractScriptBundleAttr = substr($extractScriptBundleAttr, 0, $scriptBundleAttrEndIndexOf);

                        $extractScriptBundleAttr = stringEx($extractScriptBundleAttr)->toLower();
                        if ($extractScriptBundleAttr == "0" || $extractScriptBundleAttr == "false" || $extractScriptBundleAttr == "no")
                            $script->bundle = false;
                    }

                    // Get minify info
                    $scriptBundleAttrIndexOf = strpos($extractScriptTag, "app-minify=\"");
                    if ($scriptBundleAttrIndexOf === false) {
                        $scriptBundleAttrIndexOf = strpos($extractScriptTag, "app-minify='");
                        if ($scriptBundleAttrIndexOf !== false) $isDoubleQuote = false;
                    }

                    if ($scriptBundleAttrIndexOf !== false)
                    {
                        $extractScriptBundleAttr = substr($extractScriptTag, $scriptBundleAttrIndexOf + 12);

                        $scriptBundleAttrEndIndexOf = strpos($extractScriptBundleAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                        if ($scriptBundleAttrEndIndexOf !== false)
                            $extractScriptBundleAttr = substr($extractScriptBundleAttr, 0, $scriptBundleAttrEndIndexOf);

                        $extractScriptBundleAttr = stringEx($extractScriptBundleAttr)->toLower();
                        if ($extractScriptBundleAttr == "0" || $extractScriptBundleAttr == "false" || $extractScriptBundleAttr == "no")
                            $script->minify = false;
                    }
                }

                $scripts[] = $script;
            }

            $buffer = preg_replace("#<script(.*?)<\/script>#is", "", $buffer);
            $buffer = str_replace("<script-ignore-optimizer ", "<script ", $buffer);
            $buffer = str_replace("</script-ignore-optimizer>", "</script>", $buffer);

//            $buffer = preg_replace("#<body(.*?)</body>#is", "<body$1" .
//                "<!--script src=\"{{ scriptsCompiledURL }}\" async></script-->" .
//                "</body>", $buffer);

            $this->scripts = $scripts;
            $this->bufferScripts = $buffer;

            return $this->scripts;
        }

        public function getBundleMetadata()
        {
            if ($this->bufferBundles != null)
                return $this->bundles;
            ;
            $this->getTagsMetadata();
            //$this->getLinksMetadata();
            $buffer = $this->getLastBuffer("bundles");

            // Match scripts
            preg_match_all("#<bundle(.*?)</bundle>#is", $buffer, $__matches);

            $bundles = $this->includedBundles;

            $tagScriptOpen = "<_link";
            foreach ($__matches[0] as $__value)
            {
                $bundle = Arr();
                $bundle->stylesheets = null;
                $bundle->__indexOf__ = stringEx($buffer)->indexOf($__value);

                // Match scripts
                preg_match_all("#<link(.*?)>#is", $__value, $matches);
                $stylesheets = Arr();

                foreach ($matches[0] as $value)
                {
                    $plainHTML = $value;
                    $plainHTML = str_replace("<link", $tagScriptOpen, $plainHTML);   // test
//                $plainHTML = str_replace("/link>", $tagScriptClose, $plainHTML); // test

                    if (strpos($plainHTML, "rel=\"stylesheet\"") === false && strpos($plainHTML, "rel='stylesheet'") == false &&
                        strpos($plainHTML, "type=\"text/css\"") === false && strpos($plainHTML, "type='text/css'") === false)
                        continue;

                    $stylesheet = Arr();
                    $stylesheet->plainHTML  = $plainHTML;
                    $stylesheet->stylesheetURL  = null;

                    $stylesheet->stylesheetFileURL = null;
                    $stylesheet->stylesheetHashURL = null;
                    $stylesheet->order             = 0;
                    $stylesheet->bundle            = true;
                    $stylesheet->minify            = true;
                    $stylesheet->__indexOf__       = stringEx($buffer)->indexOf($value);

                    $stylesheetTagIndexOf = strpos($stylesheet->plainHTML, ">");
                    if ($stylesheetTagIndexOf !== false)
                    {
                        $extractStylesheetTag   = substr($stylesheet->plainHTML, 0, $stylesheetTagIndexOf);

                        $isDoubleQuote          = true;
                        $stylesheetHrefAttrIndexOf = strpos($extractStylesheetTag, "href=\"");
                        if ($stylesheetHrefAttrIndexOf === false) {
                            $stylesheetHrefAttrIndexOf = strpos($extractStylesheetTag, "href='");
                            if ($stylesheetHrefAttrIndexOf !== false) $isDoubleQuote = false;
                        }

                        if ($stylesheetHrefAttrIndexOf !== false)
                        {
                            $extractStylesheetHrefAttr = substr($extractStylesheetTag, $stylesheetHrefAttrIndexOf + 6);

                            $stylesheetHrefAttrEndIndexOf = strpos($extractStylesheetHrefAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                            if ($stylesheetHrefAttrEndIndexOf !== false)
                                $extractStylesheetHrefAttr = substr($extractStylesheetHrefAttr, 0, $stylesheetHrefAttrEndIndexOf);

                            $stylesheet->stylesheetURL = $extractStylesheetHrefAttr;
                        }

                        // Get order
                        $stylesheetOrderAttrIndexOf = strpos($extractStylesheetTag, "order=\"");
                        if ($stylesheetOrderAttrIndexOf === false) {
                            $stylesheetOrderAttrIndexOf = strpos($extractStylesheetTag, "order='");
                            if ($stylesheetOrderAttrIndexOf !== false) $isDoubleQuote = false;
                        }

                        if ($stylesheetOrderAttrIndexOf !== false)
                        {
                            $extractStylesheetOrderAttr = substr($extractStylesheetTag, $stylesheetOrderAttrIndexOf + 7);

                            $stylesheetOrderAttrEndIndexOf = strpos($extractStylesheetOrderAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                            if ($stylesheetOrderAttrEndIndexOf !== false)
                                $extractStylesheetOrderAttr = substr($extractStylesheetOrderAttr, 0, $stylesheetOrderAttrEndIndexOf);

                            $stylesheet->order = intEx($extractStylesheetOrderAttr)->toInt();
                        }

                        // Get bundle info
                        $stylesheetBundleAttrIndexOf = strpos($extractStylesheetTag, "app-bundle=\"");
                        if ($stylesheetBundleAttrIndexOf === false) {
                            $stylesheetBundleAttrIndexOf = strpos($extractStylesheetTag, "app-bundle='");
                            if ($stylesheetBundleAttrIndexOf !== false) $isDoubleQuote = false;
                        }

                        if ($stylesheetBundleAttrIndexOf !== false)
                        {
                            $extractStylesheetBundleAttr = substr($extractStylesheetTag, $stylesheetBundleAttrIndexOf + 12);

                            $stylesheetBundleAttrEndIndexOf = strpos($extractStylesheetBundleAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                            if ($stylesheetBundleAttrEndIndexOf !== false)
                                $extractStylesheetBundleAttr = substr($extractStylesheetBundleAttr, 0, $stylesheetBundleAttrEndIndexOf);

                            $extractStylesheetBundleAttr = stringEx($extractStylesheetBundleAttr)->toLower();
                            if ($extractStylesheetBundleAttr == "0" || $extractStylesheetBundleAttr == "false" || $extractStylesheetBundleAttr == "no")
                                $stylesheet->bundle = false;
                        }

                        // Get minify info
                        $stylesheetBundleAttrIndexOf = strpos($extractStylesheetTag, "app-minify=\"");
                        if ($stylesheetBundleAttrIndexOf === false) {
                            $stylesheetBundleAttrIndexOf = strpos($extractStylesheetTag, "app-minify='");
                            if ($stylesheetBundleAttrIndexOf !== false) $isDoubleQuote = false;
                        }

                        if ($stylesheetBundleAttrIndexOf !== false)
                        {
                            $extractStylesheetBundleAttr = substr($extractStylesheetTag, $stylesheetBundleAttrIndexOf + 12);

                            $stylesheetBundleAttrEndIndexOf = strpos($extractStylesheetBundleAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                            if ($stylesheetBundleAttrEndIndexOf !== false)
                                $extractStylesheetBundleAttr = substr($extractStylesheetBundleAttr, 0, $stylesheetBundleAttrEndIndexOf);

                            $extractStylesheetBundleAttr = stringEx($extractStylesheetBundleAttr)->toLower();
                            if ($extractStylesheetBundleAttr == "0" || $extractStylesheetBundleAttr == "false" || $extractStylesheetBundleAttr == "no")
                                $stylesheet->minify = false;
                        }
                    }

                    $stylesheets[] = $stylesheet;
                }

                foreach ($stylesheets as $stylesheet) {
                    $plainHTML = str_replace("<_link", "<link", $stylesheet->plainHTML);
                    $buffer    = str_replace($plainHTML, "", $buffer);
                }

                $bundle->stylesheets = $stylesheets;

                if ($bundle->stylesheets != null && $bundle->stylesheets->count > 0)
                    $bundles->add($bundle);
            }

            $this->bundles = $bundles;

            $buffer = preg_replace("#<bundle(.*?)<\/bundle>#is", "", $buffer);
            $this->bufferBundles = $buffer;
            return $this->bundles;
        }

        public function getStylesheetsMetadata()
        {
            if ($this->bufferStylesheets != null)
                return $this->stylesheets;

            $this->getTagsMetadata();
            $this->getBundleMetadata();
            //$this->getLinksMetadata();
            $buffer = $this->getLastBuffer("stylesheets");
            $stylesheets = $this->includedStyleshets;

            $tagScriptOpen = "<_link";
//            $tagScriptClose = ">";

            // Match scripts
            preg_match_all("#<link(.*?)>#is", $buffer, $matches);

            foreach ($matches[0] as $value)
            {
                $plainHTML = $value;
                $plainHTML = str_replace("<link", $tagScriptOpen, $plainHTML);   // test
//                $plainHTML = str_replace("/link>", $tagScriptClose, $plainHTML); // test

                if (strpos($plainHTML, "rel=\"stylesheet\"") === false && strpos($plainHTML, "rel='stylesheet'") == false &&
                    strpos($plainHTML, "type=\"text/css\"") === false && strpos($plainHTML, "type='text/css'") === false)
                    continue;

                $stylesheet = Arr();
                $stylesheet->plainHTML  = $plainHTML;
                $stylesheet->stylesheetURL  = null;

                $stylesheet->stylesheetFileURL = null;
                $stylesheet->stylesheetHashURL = null;
                $stylesheet->order             = 0;
                $stylesheet->bundle            = true;
                $stylesheet->minify            = true;
                $stylesheet->__indexOf__       = stringEx($buffer)->indexOf($value);

                $stylesheetTagIndexOf = strpos($stylesheet->plainHTML, ">");
                if ($stylesheetTagIndexOf !== false)
                {
                    $extractStylesheetTag   = substr($stylesheet->plainHTML, 0, $stylesheetTagIndexOf);

                    $isDoubleQuote          = true;
                    $stylesheetHrefAttrIndexOf = strpos($extractStylesheetTag, "href=\"");
                    if ($stylesheetHrefAttrIndexOf === false) {
                        $stylesheetHrefAttrIndexOf = strpos($extractStylesheetTag, "href='");
                        if ($stylesheetHrefAttrIndexOf !== false) $isDoubleQuote = false;
                    }

                    if ($stylesheetHrefAttrIndexOf !== false)
                    {
                        $extractStylesheetHrefAttr = substr($extractStylesheetTag, $stylesheetHrefAttrIndexOf + 6);

                        $stylesheetHrefAttrEndIndexOf = strpos($extractStylesheetHrefAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                        if ($stylesheetHrefAttrEndIndexOf !== false)
                            $extractStylesheetHrefAttr = substr($extractStylesheetHrefAttr, 0, $stylesheetHrefAttrEndIndexOf);

                        $stylesheet->stylesheetURL = $extractStylesheetHrefAttr;
                    }

                    // Get order
                    $stylesheetOrderAttrIndexOf = strpos($extractStylesheetTag, "order=\"");
                    if ($stylesheetOrderAttrIndexOf === false) {
                        $stylesheetOrderAttrIndexOf = strpos($extractStylesheetTag, "order='");
                        if ($stylesheetOrderAttrIndexOf !== false) $isDoubleQuote = false;
                    }

                    if ($stylesheetOrderAttrIndexOf !== false)
                    {
                        $extractStylesheetOrderAttr = substr($extractStylesheetTag, $stylesheetOrderAttrIndexOf + 7);

                        $stylesheetOrderAttrEndIndexOf = strpos($extractStylesheetOrderAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                        if ($stylesheetOrderAttrEndIndexOf !== false)
                            $extractStylesheetOrderAttr = substr($extractStylesheetOrderAttr, 0, $stylesheetOrderAttrEndIndexOf);

                        $stylesheet->order = intEx($extractStylesheetOrderAttr)->toInt();
                    }

                    // Get bundle info
                    $stylesheetBundleAttrIndexOf = strpos($extractStylesheetTag, "app-bundle=\"");
                    if ($stylesheetBundleAttrIndexOf === false) {
                        $stylesheetBundleAttrIndexOf = strpos($extractStylesheetTag, "app-bundle='");
                        if ($stylesheetBundleAttrIndexOf !== false) $isDoubleQuote = false;
                    }

                    if ($stylesheetBundleAttrIndexOf !== false)
                    {
                        $extractStylesheetBundleAttr = substr($extractStylesheetTag, $stylesheetBundleAttrIndexOf + 12);

                        $stylesheetBundleAttrEndIndexOf = strpos($extractStylesheetBundleAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                        if ($stylesheetBundleAttrEndIndexOf !== false)
                            $extractStylesheetBundleAttr = substr($extractStylesheetBundleAttr, 0, $stylesheetBundleAttrEndIndexOf);

                        $extractStylesheetBundleAttr = stringEx($extractStylesheetBundleAttr)->toLower();
                        if ($extractStylesheetBundleAttr == "0" || $extractStylesheetBundleAttr == "false" || $extractStylesheetBundleAttr == "no")
                            $stylesheet->bundle = false;
                    }

                    // Get minify info
                    $stylesheetBundleAttrIndexOf = strpos($extractStylesheetTag, "app-minify=\"");
                    if ($stylesheetBundleAttrIndexOf === false) {
                        $stylesheetBundleAttrIndexOf = strpos($extractStylesheetTag, "app-minify='");
                        if ($stylesheetBundleAttrIndexOf !== false) $isDoubleQuote = false;
                    }

                    if ($stylesheetBundleAttrIndexOf !== false)
                    {
                        $extractStylesheetBundleAttr = substr($extractStylesheetTag, $stylesheetBundleAttrIndexOf + 12);

                        $stylesheetBundleAttrEndIndexOf = strpos($extractStylesheetBundleAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                        if ($stylesheetBundleAttrEndIndexOf !== false)
                            $extractStylesheetBundleAttr = substr($extractStylesheetBundleAttr, 0, $stylesheetBundleAttrEndIndexOf);

                        $extractStylesheetBundleAttr = stringEx($extractStylesheetBundleAttr)->toLower();
                        if ($extractStylesheetBundleAttr == "0" || $extractStylesheetBundleAttr == "false" || $extractStylesheetBundleAttr == "no")
                            $stylesheet->minify = false;
                    }
                }

                $stylesheets[] = $stylesheet;
            }

            foreach ($stylesheets as $stylesheet) {
                $plainHTML = str_replace("<_link", "<link", $stylesheet->plainHTML);
                $buffer    = str_replace($plainHTML, "", $buffer);
            }

            $buffer = str_replace("<link-ignore-optimizer ", "<link ", $buffer);

//            $buffer = preg_replace("#<head(.*?)</head>#is", "<head$1" .
//                "<!--link href=\"{{ stylesheetsCompiledURL }}\" rel=\"stylesheet\" type=\"text/css\"-->" .
//                "</head>", $buffer);

            $this->stylesheets = $stylesheets;
            $this->bufferStylesheets = $buffer;

            return $this->stylesheets;
        }

        public function getHeadMetadata()
        {
            if ($this->bufferHead != null)
                return $this->head;

            $this->getTagsMetadata();
            $buffer = $this->getLastBuffer("head");

            $head = $this->includedHead;

            // META
            $tagMetaOpen = "<_meta";
//            $tagScriptClose = ">";

            // Match scripts
            preg_match_all("#<meta(.*?)>#is", $buffer, $matches);

            foreach ($matches[0] as $value)
            {
                $plainHTML = $value;
                $plainHTML = str_replace("<meta", $tagMetaOpen, $plainHTML);   // test
//                $plainHTML = str_replace("/link>", $tagScriptClose, $plainHTML); // test

                $meta = Arr();
                $meta->type      = null;
                $meta->plainHTML = $plainHTML;
                $meta->name      = null;
                $meta->httpEquiv = null;
                $meta->content   = null;

                $metaTagIndexOf = strpos($meta->plainHTML, ">");
                if ($metaTagIndexOf !== false)
                {
                    $extractMetaTag = substr($meta->plainHTML, 0, $metaTagIndexOf);

                    // Check if is charset
                    $isDoubleQuote          = true;
                    $metaCharsetAttrIndexOf = strpos($extractMetaTag, "charset=\"");
                    if ($metaCharsetAttrIndexOf === false) {
                        $metaCharsetAttrIndexOf = strpos($extractMetaTag, "charset='");
                        if ($metaCharsetAttrIndexOf !== false) $isDoubleQuote = false;
                    }

                    if ($metaCharsetAttrIndexOf === false)
                    {
                        // Extract Name
                        $metaNameAttrIndexOf = strpos($extractMetaTag, "name=\"");
                        if ($metaNameAttrIndexOf === false) {
                            $metaNameAttrIndexOf = strpos($extractMetaTag, "name='");
                            if ($metaNameAttrIndexOf !== false) $isDoubleQuote = false;
                        }

                        if ($metaNameAttrIndexOf !== false)
                        {
                            $extractMetaNameAttr = substr($extractMetaTag, $metaNameAttrIndexOf + 6);

                            $metaNameAttrEndIndexOf = strpos($extractMetaNameAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                            if ($metaNameAttrEndIndexOf !== false)
                                $extractMetaNameAttr = substr($extractMetaNameAttr, 0, $metaNameAttrEndIndexOf);

                            $meta->name = $extractMetaNameAttr;
                            $meta->type = "name";
                        }

                        // Extract HttpEquiv
                        $metaHttpEquivAttrIndexOf = strpos($extractMetaTag, "http-equiv=\"");
                        if ($metaHttpEquivAttrIndexOf === false) {
                            $metaHttpEquivAttrIndexOf = strpos($extractMetaTag, "http-equiv='");
                            if ($metaHttpEquivAttrIndexOf !== false) $isDoubleQuote = false;
                        }

                        if ($metaHttpEquivAttrIndexOf !== false)
                        {
                            $extractMetaHttpEquivAttr = substr($extractMetaTag, $metaHttpEquivAttrIndexOf + 12);

                            $metaHttpEquivAttrEndIndexOf = strpos($extractMetaHttpEquivAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                            if ($metaHttpEquivAttrEndIndexOf !== false)
                                $extractMetaHttpEquivAttr = substr($extractMetaHttpEquivAttr, 0, $metaHttpEquivAttrEndIndexOf);

                            $meta->httpEquiv = $extractMetaHttpEquivAttr;
                            $meta->type      = "httpEquiv";
                        }

                        // Extract Content
                        $metaContentAttrIndexOf = strpos($extractMetaTag, "content=\"");
                        if ($metaContentAttrIndexOf === false) {
                            $metaContentAttrIndexOf = strpos($extractMetaTag, "content='");
                            if ($metaContentAttrIndexOf !== false) $isDoubleQuote = false;
                        }

                        if ($metaContentAttrIndexOf !== false)
                        {
                            $extractMetaContentAttr = substr($extractMetaTag, $metaContentAttrIndexOf + 9);

                            $metaContentAttrEndIndexOf = strpos($extractMetaContentAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                            if ($metaContentAttrEndIndexOf !== false)
                                $extractMetaContentAttr = substr($extractMetaContentAttr, 0, $metaContentAttrEndIndexOf);

                            $meta->content = $extractMetaContentAttr;
                        }
                    }
                }

                $head->metas[] = $meta;
            }

            foreach ($head->metas as $meta) {
                $plainHTML = str_replace("<_meta", "<meta", $meta->plainHTML);
                $buffer    = str_replace($plainHTML, "", $buffer);
            }

            // Match links
            preg_match_all("#<link(.*?)>#is", $buffer, $matches);
            $tagLinkOpen = "<_link";

            foreach ($matches[0] as $value)
            {
                $plainHTML = $value;
                $plainHTML = str_replace("<link", $tagLinkOpen, $plainHTML);   // test
//                $plainHTML = str_replace("/link>", $tagScriptClose, $plainHTML); // test

                if (strpos($plainHTML, "rel=\"stylesheet\"") === false && strpos($plainHTML, "rel='stylesheet'") == false &&
                    strpos($plainHTML, "type=\"text/css\"") === false && strpos($plainHTML, "type='text/css'") === false)
                {
                    $linkTagIndexOf = strpos($plainHTML, ">");
                    $extractLinkTag   = substr($plainHTML, 0, $linkTagIndexOf);

                    $isDoubleQuote          = true;
                    $linkRelAttrIndexOf = strpos($extractLinkTag, "rel=\"");
                    if ($linkRelAttrIndexOf === false) {
                        $linkRelAttrIndexOf = strpos($extractLinkTag, "rel='");
                        if ($linkRelAttrIndexOf !== false) $isDoubleQuote = false;
                    }

                    if ($linkRelAttrIndexOf !== false)
                    {
                        $extractLinkRelAttr = substr($extractLinkTag, $linkRelAttrIndexOf + 5);

                        $linkRelAttrEndIndexOf = strpos($extractLinkRelAttr, (($isDoubleQuote == true) ? "\"" : "'"));
                        if ($linkRelAttrEndIndexOf !== false)
                            $extractLinkRelAttr = substr($extractLinkRelAttr, 0, $linkRelAttrEndIndexOf);

                        //$stylesheet->stylesheetURL = $extractLinkHrefAttr;
                    }

                    $plainHTML = str_replace("<_link", "<link", $plainHTML);
                    $buffer    = str_replace($plainHTML, "", $buffer);

                    while (stringEx($plainHTML)->contains("  "))
                        $plainHTML = stringEx($plainHTML)->replace("  ", " ");
                    $plainHTML = stringEx($plainHTML)->replace(" />", "/>");
                    $plainHTML = stringEx($plainHTML)->replace(" >", ">");

                    $head->links[] = Arr([type => $extractLinkRelAttr, plainHTML => $plainHTML]);
                }
            }

            // TODO: BASE HREF

            // TITLE
            $tagTitleOpen  = "<_title>";
            $tagTitleClose = "</_title>";

            // Match scripts
            preg_match_all("#<title>(.*?)</title>#is", $buffer, $matches);

            foreach ($matches[0] as $value)
            {
                $plainHTML = $value;
                $plainHTML = str_replace("<title>", $tagTitleOpen, $plainHTML);   // test
                $plainHTML = str_replace("</title>", $tagTitleClose, $plainHTML); // test

                $title = Arr();
                $title->plainHTML = $plainHTML;
                $title->title     = null;

                $titleTagIndexOf = strpos($title->plainHTML, $tagTitleOpen);

                if ($titleTagIndexOf !== false)
                {
                    $extractTitleTag = substr($title->plainHTML, $titleTagIndexOf + 8);
                    $titleTagEndIndexOf = strpos($extractTitleTag, $tagTitleClose);

                    if ($titleTagEndIndexOf !== false)
                    {
                        $extractTitleTag = substr($extractTitleTag, 0, $titleTagEndIndexOf);
                        $title->title    = $extractTitleTag;
                    }
                }

                $head->titles[] = $title;
            }

            foreach ($head->titles as $title) {
                $plainHTML = str_replace("<_title>", "<title>", $title->plainHTML);
                $plainHTML = str_replace("</_title>", "</title>", $plainHTML);
                $buffer    = str_replace($plainHTML, "", $buffer);
            }

            $this->head = $head;
            $this->bufferHead = $buffer;

            return $head;
        }

        public function getDataMetadata()
        {
            if ($this->bufferData != null)
                return $this->data;

            $this->getTagsMetadata();
            $buffer = $this->getLastBuffer("data");

            $data = $this->includedData;

            $tagDataOpen = "<_data";
            $tagDataClose = "/_data>";
            $tagVarOpen = "<_var";
            $tagVarClose = "/_var>";

            // Match Data
            preg_match_all("#<data(.*?)</data>#is", $buffer, $_matches);

            foreach ($_matches[0] as $_value)
            {
                $_plainHTML = $_value;
                $_plainHTML = str_replace("<data", $tagDataOpen, $_plainHTML);   // test
                $_plainHTML = str_replace("/data>", $tagDataClose, $_plainHTML); // test

                // Match Vars
                preg_match_all("#<var(.*?)</var>#is", $buffer, $matches);

                foreach ($matches[0] as $value)
                {
                    $plainHTML = $value;
                    $plainHTML = str_replace("<var", $tagVarOpen, $plainHTML);   // test
                    $plainHTML = str_replace("/var>", $tagVarClose, $plainHTML); // test

                    $attributesTagsIndexOf = strpos($plainHTML, ">");
                    if ($attributesTagsIndexOf === false)
                        continue;

                    $attributesTags = substr($plainHTML, 0, $attributesTagsIndexOf);

                    $isSingleQuote = false;
                    $indexOfAttrName = strpos($attributesTags, "name=\"");
                    if ($indexOfAttrName === false) {
                        $indexOfAttrName = strpos($attributesTags, "name='");
                        if ($indexOfAttrName !== false) $isSingleQuote = true;
                    }

                    if ($indexOfAttrName === false) continue;
                    $attrName = substr($attributesTags, $indexOfAttrName + 6);

                    $indexOfEndAttrName = (($isSingleQuote == false) ? strpos($attrName, "\"") : strpos($attrName, "'"));
                    if ($indexOfEndAttrName == false) continue;

                    $attrName = substr($attrName, 0, $indexOfEndAttrName);
                    if (empty($attrName)) continue;

                    $varValue = stringEx($plainHTML)->subString($attributesTagsIndexOf + 1);
                    $varValue = stringEx($varValue)->subString(0, stringEx($varValue)->count - 7);

                    $data[$attrName] = $varValue;
                }
            }

            $buffer = preg_replace("#<data(.*?)<\/data>#is", "", $buffer);

            foreach ($data as $name => &$content)
                if ($content == "true" || $content == "false")
                    $content = boolEx($content)->toBool();

            // Parse data to wwwform/wwwurlencoded syntax
            $dataParsed = Arr();
            foreach ($data as $name => &$content) {
                $nameSplit = stringEx($name)->split(".");
                if ($nameSplit->count > 1)  {
                    $name = "";
                    foreach ($nameSplit as $_nameSplit)
                        if ($_nameSplit != $nameSplit[0]) {
                            if (stringEx($_nameSplit)->contains("[")) {
                                $conSplit = stringEx($_nameSplit)->split("[");
                                if ($conSplit->count == 1)
                                    $name .= ("[" . $_nameSplit . "]");
                                else {
                                    foreach ($conSplit as $_conSplit)
                                        if ($_conSplit != $conSplit[0])
                                            $name .= ("[" . $_conSplit);
                                        else $name .= ("[" . $_conSplit . "]");
                                }
                            } else $name .= ("[" . $_nameSplit . "]");
                        } else $name .= $_nameSplit;
                }
                $dataParsed->addKey($name, $content);
            }
            $data = $dataParsed;

            $this->data = $data;
            $this->bufferData = $buffer;

            return $data;
        }

        public function getTagsMetadata()
        {
            if ($this->tagsData != null)
                return $this->tags;

            $buffer = $this->getLastBuffer("tags");
            $tags = Arr();

            $tagTypes = self::$tagTypes;

            if ($tagTypes == null)
            {
                $tagTypes = Arr();

                if (\DirectoryEx::exists("client://Tags") == true)
                    $tagTypes = \DirectoryEx::listDirectory("client://Tags");
                if ($tagTypes->count <= 0)   {
                    $this->tags = $tags;
                    $this->tagsData = $buffer;
                    return $tags;
                }
                $cleanTagTypes = Arr();
                foreach ($tagTypes as $tagType)
                    if (stringEx($tagType)->endsWith(".html"))
                        $cleanTagTypes->addKey(stringEx($tagType)->subString(0, stringEx($tagType)->count - 5), $tagType);
                $tagTypes = $cleanTagTypes;

                self::$tagTypes = $tagTypes;
            }


            //dump($tagTypes);

            foreach ($tagTypes as $tagType => $tagFile)
            {
                $matches = null;
                preg_match_all("#<" . $tagType . "(.*?)</" . $tagType . ">#is", $buffer, $matches);

                // TITLE
                $tagCustomOpen  = "<_" . $tagType;
                $tagCustomClose = "</" . $tagType . ">";

                foreach ($matches[0] as $value)
                {
                    $plainHTML = $value;
//                    $plainHTML = str_replace("<" . $tagType, $tagCustomOpen, $plainHTML);   // test
//                    $plainHTML = str_replace("</" . $tagType . ">", $tagCustomClose, $plainHTML); // test

                    $includeTagIndexOf = strpos($plainHTML, ">");
                    if ($includeTagIndexOf === false)
                        continue;

                    $plainHTML = stringEx($plainHTML)->subString(0, stringEx($plainHTML)->count - stringEx($tagType)->count - 3);

                    $extractContentIndex = stringEx($plainHTML)->indexOf(">");
                    if ($extractContentIndex === false) continue;

                    $tagBody = stringEx($plainHTML)->subString(0, $extractContentIndex);
                    $content = stringEx($plainHTML)->subString($extractContentIndex + 1);

                    $tagBody = stringEx($tagBody)->subString(stringEx($tagType)->count + 1);
                    $tagBody = stringEx($tagBody)->trim("\r\n\t");

                    $tagParameters = stringEx($tagBody)->split(" ");
                    $parseTagParameters = Arr();

                    foreach ($tagParameters as $tagParameter)
                    {
                        $parameterSplit = stringEx($tagParameter)->split("=");
                        $parameterKey   = $parameterSplit[0];
                        $parameterValue = "";
                        
                        if ($parameterSplit->count >= 2) {
                            $parameterValue = $parameterSplit[1];
                            $parameterValue = stringEx($parameterValue)->subString(1);
                            $parameterValue = stringEx($parameterValue)->subString(0, stringEx($parameterValue)->count - 1);
                            $parameterValue = stringEx($parameterValue)->decode(true);
                        }
                        
                        if (stringEx($parameterKey)->contains(".")) {
                            $parameterKeySplit = stringEx($parameterKey)->split(".");
                            $remountKey = "";
                            for ($i = 0; $i < $parameterKeySplit->count; $i++) {
                                if ($i != 0) $remountKey .= "[";
                                $remountKey .= $parameterKeySplit[$i];
                                if ($i != 0) $remountKey .= "]";
                            }
                            $parameterKey = $remountKey;
                        } elseif ($parameterValue == "")
                            $parameterValue = $parameterKey;

                        $parseTagParameters->addKey($parameterKey, $parameterValue);
                    }

                    // Parse to real recursive array
                    $parametersQueryString = "";
                    foreach ($parseTagParameters as $field => $_data)
                        $parametersQueryString .= ($field . "=" . stringEx($_data)->encode(true) . "&");
                    if (stringEx($parametersQueryString)->endsWith("&"))
                        $parametersQueryString = stringEx($parametersQueryString)->subString(0, stringEx($parametersQueryString)->count - 1);
                    $parametersParsed = [];
                    parse_str($parametersQueryString, $parametersParsed);
                    $parameters = \Arr($parametersParsed);

                    if ($parameters->containsKey(content) == false)
                        $parameters->content = $content;

                    $tags->add([plainHTML => $value, "tag" => $tagType, "tagBody" => $tagBody, parameters => $parameters]);
                }
            }

            if (self::$tagViews == null)
                self::$tagViews = Arr();

            // Render & merge or remove
            foreach ($tags as $tag)
            {
                $tagView = null;

                if (self::$tagViews->containsKey($tag->tag))
                    $tagView = self::$tagViews[$tag->tag];
                else {
                    $tagView = View::fromPath("tags://" . $tag->tag . ".html");
                    if ($tagView != null) self::$tagViews[$tag->tag] = $tagView;
                }

                if ($tagView == null)
                { $buffer = stringEx($buffer)->replace($tag->plainHTML, ""); continue; }

                $this->includedHead       = $this->includedHead->merge($tagView->getHeadMetadata());
                $this->includedScripts    = $this->includedScripts->merge($tagView->getScriptsMetadata());
                $this->includedStyleshets = $this->includedStyleshets->merge($tagView->getStylesheetsMetadata());
                $this->includedBundles    = $this->includedBundles->merge($tagView->getBundleMetadata());
                $this->includedData       = $this->includedData->merge($tagView->getDataMetadata());

                $cleanBody = $tagView->getCleanBodyHTML();

                $dataBody = ("<!--" . $tag->tag . " " . $tag->tagBody . " -->\n");
                foreach ($tag->parameters as $key => $value)
                    $dataBody .= ("\t{% set __" . $key . "__ = " . $key . " %}\n");
                foreach ($tag->parameters as $key => $value)
                    $dataBody .= ("\t{% set " . $key . " = " . \Serialize\Json::encode($value) . " %}\n");

                $dataBody .= $cleanBody;
                foreach ($tag->parameters as $key => $value)
                    $dataBody .= ("\t{% set " . $key . " = __" . $key . "__ %}\n");
                $dataBody .= ("<!--/" . $tag->tag . "-->");

                $buffer = stringEx($buffer)->replace($tag->plainHTML, $dataBody);
            }


            $this->tags = $tags;
            $this->tagsData = $buffer;
            return $tags;
        }

        public function getCleanBodyHTML()
        {
            if ($this->cleanBodyHTML != null)
                return $this->cleanBodyHTML;

            $this->getHeadMetadata();
            $this->getScriptsMetadata();
            $this->getBundleMetadata();
            $this->getStylesheetsMetadata();
            $this->getDataMetadata();

            $cleanBodyHTML = "";
            $buffer = $this->getLastBuffer("head");

            // Try get body
            preg_match_all("#<body(.*?)</body>#is", $buffer, $matches);

            foreach ($matches[0] as $value)
            {
                $plainHTML = $value;

                $bodyTagOpenEndIndexOf = strpos($plainHTML, ">");
                if ($bodyTagOpenEndIndexOf !== null)
                    $plainHTML = substr($plainHTML, $bodyTagOpenEndIndexOf + 1);

                $bodyTagCloseEndIndexOf = strpos($plainHTML, "/body>");
                if ($bodyTagCloseEndIndexOf !== null)
                    $plainHTML = substr($plainHTML, 0, $bodyTagCloseEndIndexOf - 1);

                $cleanBodyHTML .= ($plainHTML . "\n\n");
            }

            // If fail, try get html and remove head
            if (stringEx($cleanBodyHTML)->isEmpty())
            {
                preg_match_all("#<html(.*?)</html>#is", $buffer, $matches);

                foreach ($matches[0] as $value)
                {
                    $plainHTML = $value;

                    $bodyTagOpenEndIndexOf = strpos($plainHTML, ">");
                    if ($bodyTagOpenEndIndexOf !== null)
                        $plainHTML = substr($plainHTML, $bodyTagOpenEndIndexOf + 1);

                    $bodyTagCloseEndIndexOf = strpos($plainHTML, "/html>");
                    if ($bodyTagCloseEndIndexOf !== null)
                        $plainHTML = substr($plainHTML, 0, $bodyTagCloseEndIndexOf - 1);

                    $plainHTML = preg_replace("#<head(.*?)<\/head>#is", "", $plainHTML);
                    $plainHTML = preg_replace("#<script(.*?)<\/script>#is", "", $plainHTML);
                    $plainHTML = preg_replace("#<meta (.*?)>#is", "", $plainHTML);
                    $plainHTML = preg_replace("#<link (.*?)>#is", "", $plainHTML);
                    $plainHTML = preg_replace("#<data>(.*?)</data>#is", "", $plainHTML);

                    $cleanBodyHTML .= ($plainHTML . "\n\n");
                }
            }

            // If fail, try get directly
            if (stringEx($cleanBodyHTML)->isEmpty())
            {
                $plainHTML = preg_replace("#<head(.*?)<\/head>#is", "", $buffer);
                $plainHTML = preg_replace("#<script(.*?)<\/script>#is", "", $plainHTML);
                $plainHTML = preg_replace("#<meta (.*?)>#is", "", $plainHTML);
                $plainHTML = preg_replace("#<link (.*?)>#is", "", $plainHTML);
                $plainHTML = preg_replace("#<data>(.*?)</data>#is", "", $plainHTML);

                $cleanBodyHTML .= ($plainHTML . "\n\n");
            }

            $matches = null;
            preg_match_all("#{%(.*?)%}#is", $cleanBodyHTML, $matches);
            if ($matches !== null && count($matches) > 0 && $matches[0] !== null && is_array($matches[0]) && count($matches[0]) > 0)
                foreach ($matches[0] as $match)
                    if (stringEx($match)->contains('==='))
                        $cleanBodyHTML = stringEx($cleanBodyHTML)->replace('===', '==');

            $this->cleanBodyHTML = $cleanBodyHTML;
            return $this->cleanBodyHTML;
        }
    }
}