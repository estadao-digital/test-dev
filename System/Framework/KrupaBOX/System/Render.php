<?php

class Render
{
    protected static $filesHTML       = null;
    protected static $filesHTMLExtras = null;
    protected static $filesHTMLOrder  = null;

    protected static function initialize()
    {
        if (self::$filesHTML == null)       self::$filesHTML = Arr();
        if (self::$filesHTMLExtras == null) self::$filesHTMLExtras = Arr();
        if (self::$filesHTMLOrder == null)  self::$filesHTMLOrder = Arr();
    }

    public static function addHTMLFromPathAndNamespace($path, $namespace, $show = false)
    {
        self::initialize();

        $namespace = stringEx($namespace)->
            replace("\\", "/", false)->
            replace("//", "/", false)->
            replace("/", ".", false)->
            replace("..", ".");

        if (self::$filesHTML->containsKey($namespace)) {
            if ($show == true)
                self::$filesHTMLExtras[$namespace]->show = true;
            return;
        }

        $fileHTML = \Render\HTML::getFromPath($path);
        if ($fileHTML == null) return;

        self::$filesHTML->addKey($namespace, $fileHTML);
        self::$filesHTMLExtras[$namespace] = Arr([show => $show]);
        self::$filesHTMLOrder->add($namespace);
    }

    public static function error($error, $message = null, $errorCode = null)
    {
        self::initialize();
        dump($message);
        dump($errorCode);
        \KrupaBOX\Internal\Kernel::exit();
        \Header::redirect("/404?error=" . $error);
    }

    public static function output()
    {
        self::initialize();

        $htmlExport = self::getHtmlsExport();

    }

    protected static function getHtmlsExport()
    {
        $exports = [];
        $exportsOrder = Arr();

        foreach (self::$filesHTMLOrder as $namespace)
        {
            $data = self::$filesHTML[$namespace];
            if ($data == null) continue;
            $export = self::getHtmlExport($data, self::$filesHTMLExtras[$namespace]);
            $exports[$namespace] = $export;
            $exportsOrder->add($namespace);
        }

        $fullExport = (object)[];

        $fullExport->metaTags       = Arr();
        $fullExport->links          = Arr();
        $fullExport->linksAlternate = Arr();

        $fullExport->stylesheets      = Arr();
        $fullExport->stylesheetsOrder = Arr();
        $fullExport->javascripts      = Arr();
        $fullExport->javascriptsOrder = Arr();

        $fullExport->importStylesheets      = Arr();
        $fullExport->importStylesheetsOrder = Arr();
        $fullExport->importJavascripts      = Arr();
        $fullExport->importJavascriptsOrder = Arr();

        $fullExport->titles      = Arr();
        $fullExport->contents    = Arr();

        foreach ($exportsOrder as $namespace) {
            $export = $exports[$namespace];

            foreach ($export->metaTags as $tag => $metaTag)
                if ($fullExport->metaTags->containsKey($tag))
                    $fullExport->metaTags[$tag] = $metaTag;
                else $fullExport->metaTags->add($metaTag);

            foreach ($export->links as $linkSrc => $link)
                if ($fullExport->links->containsKey($linkSrc))
                    $fullExport->links[$linkSrc] = $link;
                else $fullExport->links->addKey($linkSrc, $link);

            foreach ($export->linksAlternate as $linkAlternate)
                $fullExport->linksAlternate->add($linkAlternate);

            foreach ($export->stylesheetsOrder as $stylesheetSrc) {
                $stylesheet = $export->stylesheets[$stylesheetSrc];

                if ($fullExport->stylesheets->containsKey($stylesheetSrc))
                    $fullExport->stylesheets[$stylesheetSrc] = $stylesheet;
                else $fullExport->stylesheets->addKey($stylesheetSrc, $stylesheet);

                if (!$fullExport->stylesheetsOrder->contains($stylesheetSrc))
                    $fullExport->stylesheetsOrder->add($stylesheetSrc);
            }

            foreach ($export->javascriptsOrder as $javascriptSrc) {
                $javascript = $export->javascripts[$javascriptSrc];

                if ($fullExport->javascripts->containsKey($javascriptSrc))
                    $fullExport->javascripts[$javascriptSrc] = $javascript;
                else $fullExport->javascripts->addKey($javascriptSrc, $javascript);

                if (!$fullExport->javascriptsOrder->contains($javascriptSrc))
                    $fullExport->javascriptsOrder->add($javascriptSrc);
            }

            foreach ($export->importJavascriptsOrder as $javascriptSrc) {
                $javascript = $export->importJavascripts[$javascriptSrc];

                if ($fullExport->javascripts->containsKey($javascriptSrc))
                    $fullExport->javascripts->removeKey($javascriptSrc);
                if ($fullExport->javascriptsOrder->contains($javascriptSrc))
                    $fullExport->javascriptsOrder->remove($javascriptSrc);

                if ($fullExport->importJavascripts->containsKey($javascriptSrc))
                    $fullExport->importJavascripts[$javascriptSrc]->component .= $javascript->component;
                else $fullExport->importJavascripts->addKey($javascriptSrc, $javascript);

                if (!$fullExport->importJavascriptsOrder->contains($javascriptSrc))
                    $fullExport->importJavascriptsOrder->add($javascriptSrc);
            }

            foreach ($export->importStylesheetsOrder as $stylesheetSrc) {
                $stylesheet = $export->importStylesheets[$stylesheetSrc];

                if ($fullExport->stylesheets->containsKey($stylesheetSrc))
                    $fullExport->stylesheets->removeKey($stylesheetSrc);
                if ($fullExport->stylesheetsOrder->contains($stylesheetSrc))
                    $fullExport->stylesheetsOrder->remove($stylesheetSrc);

                if ($fullExport->importStylesheets->containsKey($stylesheetSrc))
                    $fullExport->importStylesheets[$stylesheetSrc]->component .= $stylesheet->component;
                else $fullExport->importStylesheets->addKey($stylesheetSrc, $stylesheet);

                if (!$fullExport->importStylesheetsOrder->contains($stylesheetSrc))
                    $fullExport->importStylesheetsOrder->add($stylesheetSrc);
            }

            $fullExport->titles[$namespace]   = $export->title;
            $fullExport->contents[$namespace] = $export->content;
        }

        $asyncExportJson = self::renderFullAsyncExportJson($fullExport);
        $fullExport->asyncJson = $asyncExportJson;
        $plainExport = self::renderFullPlainExport($fullExport);
    }

    protected static function getHtmlExport($data, $extras = null)
    {
        $export = (object)[];

        $export->metaTags       = Arr();
        $export->links          = Arr();
        $export->linksAlternate = Arr();

        $export->stylesheets      = Arr();
        $export->stylesheetsOrder = Arr();

        $export->javascripts      = Arr();
        $export->javascriptsOrder = Arr();

        $export->title   = null;
        $export->content = null;
        $export->contentExtras = $extras;

        $export->importStylesheets      = Arr();
        $export->importStylesheetsOrder = Arr();
        $export->importJavascripts      = Arr();
        $export->importJavascriptsOrder = Arr();

        // EXTRACT
        $head = $data->getElementsByTagName('head')->item(0);
        if ($head != null)
        {
            // HEAD => TITLE
            $title = $head->getElementsByTagName("title")->item(0);
            if ($title != null) $export->title = $data->saveInnerHTML($title);

            // HEAD => META
            $metaTags = $head->getElementsByTagName("meta");

            foreach ($metaTags as $metaTag)
            {
                if ($metaTag->attributes->getNamedItem("name") == null)
                    continue;

                $tagName = $metaTag->attributes->getNamedItem("name")->value;

                if ($export->metaTags->containsKey($tagName))
                    $export->metaTags[$tagName] = $metaTag;
                else $export->metaTags->addKey($tagName, $metaTag);
            }

            // HEAD => LINKS
            $links = $head->getElementsByTagName("link");

            foreach ($links as $link)
            {
                if ($link->attributes->getNamedItem("rel") == null)
                    continue;

                $tagRel = $link->attributes->getNamedItem("rel")->value;

                if ($tagRel != alternate && $tagRel != stylesheet)
                {
                    if ($export->links->containsKey($tagRel))
                        $export->links[$tagRel] = $link;
                    else $export->links->addKey($tagRel, $link);
                }
                else
                {
                    if ($tagRel == alternate)
                        $export->linksAlternate->add($link);
                    else  {
                        $href = $link->attributes->getNamedItem("href");
                        if ($href != null) {
                            $hrefVal = $href->value;

                            if ($export->stylesheets->containsKey($hrefVal))
                                $export->stylesheets[$hrefVal] = $link;
                            else $export->stylesheets->addKey($hrefVal, $link);

                            if (!$export->stylesheetsOrder->contains($hrefVal))
                                $export->stylesheetsOrder->add($hrefVal);
                        }
                        else
                        {
                            $src = $link->attributes->getNamedItem("src");

                            if ($src != null) {
                                $srcVal = $src->value;

                                if ($export->stylesheets->containsKey($srcVal))
                                    $export->stylesheets[$srcVal] = $link;
                                else $export->stylesheets->addKey($srcVal, $link);

                                if (!$export->stylesheetsOrder->contains($srcVal))
                                    $export->stylesheetsOrder->add($srcVal);
                            }
                        }
                    }
                }
            }
        }

        // SCRIPTS
        $scripts = $data->getElementsByTagName('script');

        foreach ($scripts as $script)
        {
            if ($script->attributes->getNamedItem("src") == null) continue;
            $scriptSrc = $script->attributes->getNamedItem("src")->value;

            if ($script->attributes->getNamedItem("type") != null && $script->attributes->getNamedItem("type")->value != "text/javascript") // Only JS
                continue;

            if ($export->javascripts->containsKey($scriptSrc))
                $export->javascripts[$scriptSrc] = $script;
            else $export->javascripts->addKey($scriptSrc, $script);

            if (!$export->javascriptsOrder->containsKey($scriptSrc))
                $export->javascriptsOrder->add($scriptSrc);
        }

        $body = $data->getElementsByTagName('body')->item(0);
        if ($body != null) $export->content = $body;

        for ($i = 0; $i < 2; $i++)
        {
            $scripts = $body->getElementsByTagName('script');
            foreach ($scripts as $script) $script->parentNode->removeChild($script);
            $links = $body->getElementsByTagName('link');
            foreach ($links as $link) $link->parentNode->removeChild($link);
            $metas = $body->getElementsByTagName('meta');
            foreach ($metas as $meta) $meta->parentNode->removeChild($meta);
            $imports = $body->getElementsByTagName('import');
            foreach ($imports as $import) $import->parentNode->removeChild($import);
            $datas = $body->getElementsByTagName('data');
            foreach ($datas as $data) $import->parentNode->removeChild($data);
        }

        // IMPORTS
        $imports = $data->getElementsByTagName('import');
        foreach ($imports as $import)
        {
            if ($import->attributes->getNamedItem("stylesheet") != null)
            {
                $stylesheetSrc = $import->attributes->getNamedItem("stylesheet")->value;
                if ($export->stylesheets->containsKey($stylesheetSrc))
                    $export->stylesheets->removeKey($stylesheetSrc);
                if ($export->stylesheetsOrder->contains($stylesheetSrc))
                    $export->stylesheetsOrder->remove($stylesheetSrc);

                if (!$export->importStylesheets->containsKey($stylesheetSrc))
                    $export->importStylesheets[$stylesheetSrc] = Arr([src => $stylesheetSrc, component => ""]);
                if (!$export->importStylesheetsOrder->contains($stylesheetSrc))
                    $export->importStylesheetsOrder->add($stylesheetSrc);
            }

            if ($import->attributes->getNamedItem("javascript") != null)
            {
                $javascriptSrc = $import->attributes->getNamedItem("javascript")->value;
                if ($export->javascripts->containsKey($javascriptSrc))
                    $export->javascripts->removeKey($javascriptSrc);
                if ($export->javascriptsOrder->contains($javascriptSrc))
                    $export->javascriptsOrder->remove($javascriptSrc);

                if (!$export->importJavascripts->containsKey($javascriptSrc))
                    $export->importJavascripts[$javascriptSrc] = Arr([src => $javascriptSrc, component => ""]);
                if (!$export->importJavascriptsOrder->contains($javascriptSrc))
                    $export->importJavascriptsOrder->add($javascriptSrc);
            }

            if ($import->attributes->getNamedItem("component") != null)
            {
                $component = $import->attributes->getNamedItem("component")->value;
                $imports = self::getComponentImports($component);

                if ($imports != null)
                {
                    foreach ($imports->stylesheetsOrder as $stylesheetSrc)
                    {
                        if ($export->stylesheets->containsKey($stylesheetSrc))
                            $export->stylesheets->removeKey($stylesheetSrc);
                        if ($export->stylesheetsOrder->contains($stylesheetSrc))
                            $export->stylesheetsOrder->remove($stylesheetSrc);

                        if (!$export->importStylesheets->containsKey($stylesheetSrc))
                            $export->importStylesheets[$stylesheetSrc] = Arr([src => $stylesheetSrc, component => ""]);

                        $export->importStylesheets[$stylesheetSrc]->component .= $component . " ";
                        if (!$export->importStylesheetsOrder->contains($stylesheetSrc))
                            $export->importStylesheetsOrder->add($stylesheetSrc);
                    }

                    foreach ($imports->javascriptsOrder as $javascriptSrc)
                    {
                        if ($export->javascripts->containsKey($javascriptSrc))
                            $export->javascripts->removeKey($javascriptSrc);
                        if ($export->javascriptsOrder->contains($javascriptSrc))
                            $export->javascriptsOrder->remove($javascriptSrc);

                        if (!$export->importJavascripts->containsKey($javascriptSrc))
                            $export->importJavascripts[$javascriptSrc] = Arr([src => $javascriptSrc, component => ""]);

                        $export->importJavascripts[$javascriptSrc]->component .= $component . " ";
                        if (!$export->importJavascriptsOrder->contains($javascriptSrc))
                            $export->importJavascriptsOrder->add($javascriptSrc);
                    }
                }
            }
        }

        return $export;
    }

    protected static function getComponentImports($component)
    {
        $component = stringEx($component)->replace("\\", "/");
        $componentBase = ("Component/" . stringEx($component)->replace(".", "/") . "/");

        $configSplit = stringEx($componentBase)->split("/");
        $componentConfig = (($configSplit->length > 0) ? $configSplit[($configSplit->length - 1)] : "");

        $componentPath = (CLIENT_FOLDER . $componentBase . $componentConfig . ".xml");

        if (!\File::exists($componentPath)) return null;

        $componentXml  = \File::getContents($componentPath);
        $componentJson = \Serialize\Json::encodeFromXmlString($componentXml);

        $component = Arr(\Serialize\Json::decode($componentJson));
        if (!$component->containsKey(import)) return null;

        $imports = Arr([
            stylesheetsOrder  => Arr(),
            javascriptsOrder  => Arr()
        ]);

        foreach ($component->import as $import)
        {
            $attributes = (($import->containsKey("@attributes")) ? $import["@attributes"] : $import);

            if ($attributes->containsKey(stylesheet)) {
                if (!$imports->stylesheetsOrder->contains($componentBase . $attributes[stylesheet]))
                    $imports->stylesheetsOrder->add($componentBase . $attributes[stylesheet]);
            }

            if ($attributes->containsKey(javascript)) {
                if (!$imports->javascriptsOrder->contains($componentBase . $attributes[javascript]))
                    $imports->javascriptsOrder->add($componentBase . $attributes[javascript]);
            }

            if ($attributes->containsKey(component))
            {
                $extraImport    = $attributes[component];
                $extraComponent = self::getComponentImports($extraImport);

                if ($extraComponent != null)
                {
                    foreach ($extraComponent->stylesheetsOrder as $stylesheet)
                        if (!$imports->stylesheetsOrder->contains($stylesheet))
                            $imports->stylesheetsOrder->add($stylesheet);

                    foreach ($extraComponent->javascriptsOrder as $javascript)
                        if (!$imports->javascriptsOrder->contains($javascript))
                            $imports->javascriptsOrder->add($javascript);
                }
            }
        }

        return $imports;
    }

    protected static function renderFullAsyncExportJson($fullExport)
    {
        $tmpRender = \Render\HTML::getFromString("<html></html>");

        $async = Arr();
        $async->titles          = $fullExport->titles;
        $async->metaTags        = Arr();
        $async->links           = Arr();
        $async->linksAlternate  = Arr();
        $async->stylesheets     = Arr();
        $async->contents        = Arr();
        $async->javascripts     = Arr();

        foreach ($fullExport->metaTags as $metaTag)  {
            $metaTag = $tmpRender->importNode($metaTag, true);
            $metaTagBase64 = stringEx($tmpRender->saveHTML($metaTag))->toBase64();
            $async->metaTags->add($metaTagBase64);
        }
        foreach ($fullExport->links as $link)  {
            $link = $tmpRender->importNode($link, true);
            $linkBase64 = stringEx($tmpRender->saveHTML($link))->toBase64();
            $async->links->add($linkBase64);
        }
        foreach ($fullExport->linksAlternate as $linkAlternate)  {
            $linkAlternate = $tmpRender->importNode($linkAlternate, true);
            $linkAlternateBase64 = stringEx($tmpRender->saveHTML($linkAlternate))->toBase64();
            $async->linksAlternate->add($linkAlternateBase64);
        }

        foreach ($fullExport->stylesheets as $stylesheetSrc => $stylesheet)
        {
            $realFilePath = \File::getRealPath(CLIENT_FOLDER . $stylesheetSrc, true);
            if (!stringEx($realFilePath)->startsWith(CLIENT_FOLDER))
                continue; //TODO: send error on fail don't find

            $stylesheetData = null;
            if (!\File::exists($realFilePath))
                continue; //TODO: send error on fail don't find

            $stylesheetData = \Render::getCompiledCSS($realFilePath, true);

            $stylesheet = $tmpRender->importNode($stylesheet, true);
            $stylesheetBase64 = stringEx($tmpRender->saveHTML($stylesheet))->toBase64();
            $async->stylesheets->addKey(stringEx($stylesheetSrc)->toBase64(), Arr([
                element => $stylesheetBase64,
                data    => stringEx($stylesheetData)->toBase64()
            ]));
        }

        foreach ($fullExport->contents as $contentNamespace => $content)  {
            $content = $tmpRender->importNode($content, true);
            $innerContent = $tmpRender->saveInnerHTML($content);
            $newContentView = $tmpRender->createElement("view");
            $newContentView->setAttribute("namespace", $contentNamespace);

            if ($content->hasAttributes())
                foreach ($content->attributes as $attrName => $attribute)
                    $newContentView->setAttribute($attrName, $attribute->value);

            $newContentView->setAttribute("namespace", $contentNamespace);
            $class = $newContentView->attributes->getNamedItem("class");
            $classes = ($class != null) ? ("body " . $class->value) : "body";
            $newContentView->setAttribute("class", $classes);

            $newContentView->nodeValue = $innerContent;
            $contentViewBase64 = stringEx($tmpRender->saveHTML($newContentView))->toBase64();
            $async->contents->addKey($contentNamespace, $contentViewBase64);
        }

        foreach ($fullExport->javascripts as $javascriptSrc => $javascript)
        {
            $realFilePath = \File::getRealPath(CLIENT_FOLDER . $javascriptSrc, true);
            if (!stringEx($realFilePath)->startsWith(CLIENT_FOLDER))
                continue; //TODO: send error on fail don't find

            $javascriptData = null;
            if (!\File::exists($realFilePath))
                continue; //TODO: send error on fail don't find

            $javascriptData = \File::getContents($realFilePath);

            $javascript = $tmpRender->importNode($javascript, true);
            $javascriptBase64 = stringEx($tmpRender->saveHTML($javascript))->toBase64();
            $async->javascripts->addKey(stringEx($javascriptSrc)->toBase64(), Arr([
                element => $javascriptBase64,
                data    => stringEx($javascriptData)->toBase64()
            ]));
        }

        $asyncJson = \Serialize\Json::encode($async);
        return $asyncJson;
    }

    protected static function renderFullPlainExport($fullExport)
    {
        $render = \Render\HTML::getFromString("<html></html>");
        $render->preserveWhiteSpace = false;
        $render->formatOutput = true;

        $head    = $render->createElement("head");
        $charset = $render->createElement("meta");
        $charset->setAttribute("http-equiv", 'Content-Type');
        $charset->setAttribute("content", 'text/html; charset=UTF-8');
        $head->appendChild($charset);

        $title = "";
        foreach ($fullExport->titles as $_title)
            if ($_title != null && !stringEx($_title)->isEmpty())
                $title = $_title;

        $title = $render->createElement("title", $title);
        $head->appendChild($title);

        foreach ($fullExport->metaTags as $metaTag)             { $metaTag       = $render->importNode($metaTag, true);       $head->appendChild($metaTag); }
        foreach ($fullExport->links as $link)                   { $link          = $render->importNode($link, true);          $head->appendChild($link); }
        foreach ($fullExport->linksAlternate as $linkAlternate) { $linkAlternate = $render->importNode($linkAlternate, true); $head->appendChild($linkAlternate); }

        foreach ($fullExport->importStylesheetsOrder as $stylesheetSrc)
        {
            $stylesheet = $render->createElement("link");

            $component = $fullExport->importStylesheets[$stylesheetSrc]->component;
            $component = stringEx($component)->trim();
            $component = stringEx($component)->replace("  ", " ");
            $component = stringEx($component)->replace("  ", " ");

            if (!stringEx($component)->isEmpty())
                $stylesheet->setAttribute("component", $component);

            $stylesheet->setAttribute("rel", "stylesheet");
            $stylesheet->setAttribute("type", "text/css");

            $realFilePath = \File::getRealPath(CLIENT_FOLDER . $stylesheetSrc, true);
            if (!stringEx($realFilePath)->startsWith(CLIENT_FOLDER))
                continue; //TODO: send error on fail don't find

            $stylesheetData = null;
            if (!\File::exists($realFilePath))
                continue; //TODO: send error on fail don't find

            $stylesheetData = \Render::getCompiledCSS($realFilePath, true);

            $stylesheet->setAttribute("virtual-src", $stylesheetSrc);
            $stylesheet->setAttribute("href", "data:text/css;base64, ". stringEx($stylesheetData)->toBase64());

            $head->appendChild($stylesheet);
        }

        foreach ($fullExport->stylesheets as $stylesheetSrc => $stylesheet)
        {
            $stylesheet     = $render->importNode($stylesheet, true);
            $stylesheet->removeAttribute("src");
            $stylesheet->removeAttribute("href");
            //$stylesheetSrc  = $stylesheet->attributes->getNamedItem("href");
            //$stylesheetSrc  = (($stylesheetSrc != null) ? $stylesheetSrc->value : "");

            $realFilePath = \File::getRealPath(CLIENT_FOLDER . $stylesheetSrc, true);
            if (!stringEx($realFilePath)->startsWith(CLIENT_FOLDER))
                continue; //TODO: send error on fail don't find

            $stylesheetData = null;
            if (!\File::exists($realFilePath))
                continue; //TODO: send error on fail don't find

            $stylesheetData = \Render::getCompiledCSS($realFilePath, true);

            $stylesheet->setAttribute("virtual-src", $stylesheetSrc);
            $stylesheet->setAttribute("href", "data:text/css;base64, ". stringEx($stylesheetData)->toBase64());
            $head->appendChild($stylesheet);
        }

        //$export->javascripts = Arr();
        //$export->content     = "";

        $body     = $render->createElement("body");
        $contents = $render->createElement("contents");

        foreach ($fullExport->contents as $contentNamespace => $content)  {
            $content      = $render->importNode($content, true);
            $innerContent = $render->saveInnerHTML($content);
            $newContentView = $render->createElement("view");
            $newContentView->setAttribute("namespace", $contentNamespace);

            if ($content->hasAttributes())
                foreach ($content->attributes as $attrName => $attribute)
                    $newContentView->setAttribute($attrName, $attribute->value);

            $newContentView->setAttribute("namespace", $contentNamespace);
            $class   = $newContentView->attributes->getNamedItem("class");
            $classes = ($class != null) ? ("body " . $class->value) : "body";
            $newContentView->setAttribute("class", $classes);

            $newContentFragment = $render->createDocumentFragment();
            $newContentFragment->appendXML($innerContent);
            $newContentView->appendChild($newContentFragment);
            $newContentView = $render->importNode($newContentView, true);

            //dump($render->saveIdentedHTML($newContent)); exit;
            $contents->appendChild($newContentView);
        }

        $body->appendChild($contents);

        $scripts   = $render->createElement("scripts");
        $asyncJson = $render->createElement("script");

        $asyncJson->setAttribute("type", "text/javascript");
        $asyncJson->setAttribute("src", "data:text/javascript;base64," . stringEx("window.__data__ = \"" . stringEx($fullExport->asyncJson)->toBase64() . "\";")->toBase64());
        $scripts->appendChild($asyncJson);

        foreach ($fullExport->importJavascriptsOrder as $javascriptSrc)
        {
            $javascript = $render->createElement("script");

            $component = $fullExport->importJavascripts[$javascriptSrc]->component;
            $component = stringEx($component)->trim();
            $component = stringEx($component)->replace("  ", " ");
            $component = stringEx($component)->replace("  ", " ");

            if (!stringEx($component)->isEmpty())
                $javascript->setAttribute("component", $component);

            $javascript->setAttribute("type", "text/javascript");

            $realFilePath = \File::getRealPath(CLIENT_FOLDER . $javascriptSrc, true);
            if (!stringEx($realFilePath)->startsWith(CLIENT_FOLDER))
                continue; //TODO: send error on fail don't find

            $javascriptData = null;
            if (!\File::exists($realFilePath))
                continue; //TODO: send error on fail don't find

            $javascriptData = \File::getContents($realFilePath, true);

            $javascript->setAttribute("virtual-src", $javascriptSrc);
            $javascript->setAttribute("src", "data:text/javascript;base64, ". stringEx($javascriptData)->toBase64());

            $scripts->appendChild($javascript);
        }

        foreach ($fullExport->javascripts as $javascriptSrc => $javascript)
        {
            $javascript     = $render->importNode($javascript, true);
            $javascript->removeAttribute("src");

            $realFilePath = \File::getRealPath(CLIENT_FOLDER . $javascriptSrc, true);
            if (!stringEx($realFilePath)->startsWith(CLIENT_FOLDER))
                continue; //TODO: send error on fail don't find

            $javascriptData = null;
            if (!\File::exists($realFilePath))
                continue; //TODO: send error on fail don't find

            $javascriptData = \File::getContents($realFilePath);

            $javascript->setAttribute("virtual-src", $javascriptSrc);
            $javascript->setAttribute("src", "data:text/javascript;base64, ". stringEx($javascriptData)->toBase64());
            $scripts->appendChild($javascript);
        }

        $body->appendChild($scripts);

        $html = $render->getElementsByTagName('html')->item(0);
        $html->appendChild($head);
        $html->appendChild($body);

        $html->setAttribute("powered-by", "KrupaBOX");
        $html->setAttribute("information", "Dynamic & Async HTMLs");

        echo $render->saveIdentedHTML();
        \KrupaBOX\Internal\Kernel::exit();
    }

    public static function getCompiledCSS($filePath, $importUrlAssets = true)
    {
        $filePath = stringEx($filePath)->toString();
        $realFilePath = \File::getRealPath($filePath);
        if ($realFilePath == null) return null;

        $cacheFolderPath = (\Garbage\Cache::getCachePath() . ".tmp/asset/" . stringEx($realFilePath)->subString(stringEx(CLIENT_FOLDER)->length) . "/.tmp/");
        $cacheFilePath = ($cacheFolderPath .
            \File::toSha1($realFilePath) .
            \Security\Hash::toSha1(($importUrlAssets == true) ? ".import" : ".no-import") .
            ".css"
        );

        if (!\File::exists($cacheFilePath))
        {
            $cssData = \File::getContents($realFilePath);
            $css = \Render\CSS::getFromString($cssData);
            $directoryPath = \File::getDirectoryPath($realFilePath);
            $css->setBaseDirectoryFullUrl($directoryPath, $realFilePath, $importUrlAssets);
            $compiledCSS = $css->saveCSS();
            \File::setContents($cacheFilePath, $compiledCSS);
            return $compiledCSS;
        }

        return \File::getContents($cacheFilePath);
    }
}