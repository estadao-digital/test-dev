<?php

namespace Render
{
    class FrontEngine
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

        public static function isPublicHTML($htmlPath)
        {
            if (!\File::exists($htmlPath)) return false;
            $fileHtml = \Render\HTML::getFromPath($htmlPath);

            $contentHtml = $fileHtml->getElementsByTagName("html")->item(0);
            if ($contentHtml == null) return false;

            $visibility = $contentHtml->attributes->getNamedItem("visibility");
            if ($visibility == null || stringEx($visibility->value)->toString() != "public")
                return false;

            return true;
        }

        public static function addHTMLFromView($view, $show = false, $data = null)
        {
            try
            {
                $compilerInfo = $view->getCompilerInformation();
                $compilerInfo = Arr($compilerInfo);
                
                if ($compilerInfo->containsKey(path) && $compilerInfo->containsKey("namespace"))
                    return self::addHTMLFromPathAndNamespace($compilerInfo->path, $compilerInfo->namespace, $show, $data);
            }
            catch (\Exception $e) {}

            return null;
        }

        public static function addHTMLFromPathAndNamespace($path, $namespace, $show = false, $data = null)
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

            /*
            if (!\File::exists($path)) return;
            $fileHTML = null;

            $modifiedDate = \File::getLastModifiedDateTimeEx($path);
            $modifiedHash = \Security\Hash::toSha1(($modifiedDate != null) ? $modifiedDate->toString() : null);

            $cacheMofidiedHash = \Cache\Render::get("view.namespace." . $namespace . ".hash");
            if ($cacheMofidiedHash == $modifiedHash)
            {
                $fileData = \Cache\Render::get("view.namespace." . $namespace . ".content");
                if ($fileData != null)
                    $fileHTML = \Render\HTML::getFromString($fileData);
            }

            if ($fileHTML == null)
            {
                $fileData = \File::getContents($path);
                \Cache\Render::set("view.namespace." . $namespace . ".content", $fileData);
                $fileHTML = \Render\HTML::getFromString($fileData);
            }

            if ($fileHTML == null) return;*/

            //self::$filesHTML->addKey($namespace, $fileHTML);
            self::$filesHTML->addKey($namespace, null);
            self::$filesHTMLExtras[$namespace] = Arr([show => $show, data => Arr($data), filePath => $path]);
            self::$filesHTMLOrder->add($namespace);
        }

        public static function getMultiFilesDataHTML()
        {
            $exports = [];
            $exportsOrder = Arr();

            foreach (self::$filesHTMLOrder as $namespace)
            {
                $dataExtras = self::$filesHTMLExtras->containsKey($namespace) ? self::$filesHTMLExtras[$namespace] : null;
                if ($dataExtras == null) continue;
                if (!\File::exists($dataExtras->filePath)) continue;

                $fileHTML = null;

                $modifiedDate = \File::getLastModifiedDateTimeEx($dataExtras->filePath);
                $modifiedHash = \Security\Hash::toSha1(($modifiedDate != null) ? $modifiedDate->toString() : null);

                $cacheMofidiedHash = \Cache\Render::get("view.namespace." . $namespace . ".hash");
                if ($cacheMofidiedHash == $modifiedHash)
                {
                    $fileData = \Cache\Render::get("view.namespace." . $namespace . ".content");
                    if ($fileData != null)
                        $fileHTML = \Render\HTML::getFromString($fileData);
                }

                if ($fileHTML == null)
                {
                    $fileData = \File::getContents($dataExtras->filePath);
                    \Cache\Render::set("view.namespace." . $namespace . ".content", $fileData);
                    $fileHTML = \Render\HTML::getFromString($fileData);
                }

                if ($fileHTML == null) continue;
                self::$filesHTML[$namespace] = $fileHTML;

                $data = self::$filesHTML[$namespace];
                if ($data == null) continue;

                $export = \Render\FrontEngine\ExtractSingle::extractFull($data, self::$filesHTMLExtras[$namespace]);
                $exports[$namespace] = $export;
                $exportsOrder->add($namespace);
            }

            return (object)[exports => $exports, exportsOrder => $exportsOrder];
        }

        /*
        protected static function renderClientSideCachedHTML($functionalMount, $cachedViewRenderCode)
        {
            $body = $functionalMount->getElementsByTagName("body")[0];
            $body->nodeValue = "";

            $cliendSideCache = $functionalMount->createElement("script");
            $cliendSideCache->setAttribute("component", "KrupaBOX");
            $cliendSideCache->setAttribute("type", "text/javascript");

            $compiledClientSide = \File::getContents(__KRUPA_PATH_INTERNAL__ . "System/Render/FrontEngine/Compilation/Cache/ClientSide.js");
            $compiledClientSide = stringEx($compiledClientSide)->
                replace("{{cache-key-route}", (\KrupaBOX\Internal\Routes::getRoute() . "-hash"), false)->
                replace("{{cache-key-data}", (\KrupaBOX\Internal\Routes::getRoute() . "-data"), false)->
                replace("{{route-original}}", \KrupaBOX\Internal\Routes::getRouteOriginal(), false)->
                replace("{{cache-key-hash}", $cachedViewRenderCode);

            $cliendSideCache->setAttribute("src", "data:text/javascript;base64," . stringEx($compiledClientSide)->toBase64());
            $body->appendChild($cliendSideCache);

            return $functionalMount->saveIdentedHTML();
        }*/

        public static function run()
        {
            $input = \Input::get([javascript => bool]);
            $allowJavascript = (!($input->javascript === false));

            $inputPost = \Input::post([render => bool]);
            $input->render = $inputPost->render;

            //if ($allowJavascript == false || \Connection::isRobot())
            //{ dump("NO JS"); exit; }

            /*
            if ($input->render == false) // try get HTML from client cache
            {
                $dataJoined = self::getDataJoined();
                $functionalMount = \Render\FrontEngine\Mount::getRenderFunctionalMount($dataJoined);
                $cachedViewRenderCode = \Render\FrontEngine\Mount::getCachedViewRenderCode($functionalMount, $dataJoined);

                if ($functionalMount != null)
                {
                    echo (self::renderClientSideCachedHTML($functionalMount, $cachedViewRenderCode));
                    exit;
                }
            }*/

            echo (self::getRenderedHTML()); \KrupaBOX\Internal\Kernel::exit();
        }

        public static function getDataJoined()
        {
            $multiFilesData = self::getMultiFilesDataHTML();
            return \Render\FrontEngine\MultiJoiner::joinByMultiFilesDataHTML($multiFilesData);
        }
        
        public static function getRenderedHTML($fullOutput = false)
        {
            self::initialize();

            $dataJoined  = self::getDataJoined();
            $mountData = \Render\FrontEngine\Mount::mountByDataJoined($dataJoined);
            $mountHTML = null;

            $mountHTML = $mountData;

            /*if ($mountData->containsKey(cachedRenderPath) && $mountData->cachedRenderPath != null)
                $mountHTML = \File::getContents($mountData->cachedRenderPath);
            else $mountHTML = $mountData->HTML;
*/

            /*
            $HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"];
            if( headers_sent() ){
                $encoding = false;
            }elseif( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ){
                $encoding = 'x-gzip';
            }elseif( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ){
                $encoding = 'gzip';
            }else{
                $encoding = false;
            }

            if( $encoding ){
                $contents = $mountHTML;
                header('Content-Encoding: '.$encoding);
                print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
                $size = strlen($contents);
                $contents = gzcompress($contents, 9);
                $contents = substr($contents, 0, $size);
                print($contents);
                exit();
            }else{
                echo ($mountHTML);
                exit();
            }
*/
            if (\Connection::isRobot() == true)
            {
                $remount = \Render\HTML::getFromString($mountHTML);
                $toRemove = Arr();

                $findList = $remount->getElementsByTagName("style");
                for ($i = 0; $i < $findList->length; $i++) {
                    $finded = $findList->item($i);
                    $findData = $finded->getAttribute("x-component"); if (!stringEx($findData)->isEmpty()) $toRemove->add(" x-component=\"" . $findData . "\"");
                    $findData = $finded->getAttribute("x-virtual-src"); if (!stringEx($findData)->isEmpty()) $toRemove->add(" x-virtual-src=\"" . $findData . "\"");
                }

                $findList = $remount->getElementsByTagName("script");
                for ($i = 0; $i < $findList->length; $i++) {
                    $finded = $findList->item($i);
                    $findData = $finded->getAttribute("x-component"); if (!stringEx($findData)->isEmpty()) $toRemove->add(" x-component=\"" . $findData . "\"");
                    $findData = $finded->getAttribute("x-virtual-src"); if (!stringEx($findData)->isEmpty()) $toRemove->add(" x-virtual-src=\"" . $findData . "\"");
                }

                $findList = $remount->getElementsByTagName("html");
                for ($i = 0; $i < $findList->length; $i++) {
                    $finded = $findList->item($i);
                    $findData = $finded->getAttribute("x-powered-by"); if (!stringEx($findData)->isEmpty()) $toRemove->add(" x-powered-by=\"" . $findData . "\"");
                    $findData = $finded->getAttribute("x-krupabox"); if (!stringEx($findData)->isEmpty()) $toRemove->add(" x-krupabox=\"" . $findData . "\"");
                }

                $findList = $remount->getElementsByTagName("x-view");
                for ($i = 0; $i < $findList->length; $i++) {
                    $finded = $findList->item($i);
                    $findData = $finded->getAttribute("x-namespace");
                        if (!stringEx($findData)->isEmpty())
                        {
                            $mountHTML = stringEx($mountHTML)->replace(
                                " x-namespace=\"" . $findData . "\"",
                                " id=\"namespace." . $findData . "\""
                            );
                        }
                }

                foreach ($toRemove as $_toRemove)
                    $mountHTML = stringEx($mountHTML)->replace($_toRemove, "");

                $mountHTML = stringEx($mountHTML)->
                replace("<x-contents>", "<div id=\"x-contents\">", false)->
                replace("<x-contents ", "<div id=\"x-contents\"" , false)->
                replace("</x-contents>", "</div>", false)->
                replace("<x-view>", "<div>", false)->
                replace("<x-view ", "<div ", false)->
                replace("</x-view>", "</div>", false)->
                replace("<x-scripts>", "<div>", false)->
                replace("<x-scripts ", "<div ", false)->
                replace("</x-scripts>", "</div>");
            }

            if ($fullOutput == false)
                return $mountHTML;

            return ("<!DOCTYPE HTML>\r\n" . $mountHTML);
            \KrupaBOX\Internal\Kernel::exit(); return;

            $asyncExportJson = self::renderFullAsyncExportJson($dataJoined);
            $dataJoined->asyncJson = $asyncExportJson;
            $plainExport = self::renderFullPlainExport($dataJoined);


            dump($dataJoined); \KrupaBOX\Internal\Kernel::exit();
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
    }
}