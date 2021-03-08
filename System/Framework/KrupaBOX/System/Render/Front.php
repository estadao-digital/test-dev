<?php

namespace Render
{
    class Front
    {
        protected $views = null;

        public function __construct()
        {
            $this->views = Arr();
        }

        public function addView($view, $order = null)
        {
            if ($view == null || ($view instanceof \Render\Front\View) == false)
                return null;

            if ($order != null) $order = intEx($order)->toInt();
            if ($order == null) $order = $view->getOrder();

            if ($order == null) $order = 0;

            if (!$this->views->containsKey($order))
                $this->views[$order] = Arr();

            $this->views[$order]->add($view);
        }

        public function addViewFromPath($path, $order = null)
        {
            $view = \Render\Front\View::fromPath($path);
            if ($view != null) $this->addView($view, $order);
        }

        protected function getOrderedViews()
        {
            $views = Arr();
//            $this->views->ksort();

            foreach ($this->views as $value)
                foreach ($value as $view)
                    $views->add($view);

            return $views;
        }

        public function toHTML($release = true, $dynamicData = null, $includeGlobalData = true, $delegateRenderData = null)
        {
            $includeGlobalData = true; // Force (because now, frontend use informations)
            $dynamicData = Arr($dynamicData);

            $config = \Config::get();

            if ($includeGlobalData == true)
            {
                $globalData = Arr(["global" => []]);
                $globalData->global->app       = $config->app;
                $globalData->global->server    = Arr();
                $globalData->global->server->environment =  $config->server->environment;
                $globalData->global->server->domain      =  $config->server->domain;
                $globalData->global->server->timezone    =  $config->server->timezone;
                $globalData->global->front     = $config->front;

                $dynamicData = $dynamicData->merge($globalData, true);
            }

            //$release = false;
            $views = $this->getOrderedViews();

            $scripts     = Arr();
            $stylesheets = Arr();
            $bundles     = Arr();

            // Join scripts
            foreach ($views as $view) {
                if ($view == null) continue;
                $scriptsMetadata = $view->getScriptsMetadata();
                foreach ($scriptsMetadata as $script) {
                    if (!$scripts->containsKey($script->order))
                        $scripts[$script->order] = Arr();
                    $scripts[$script->order]->add($script);
                }
            }

            $scripts->ksort();

            $scriptsOrdered = Arr();
            foreach ($scripts as $scriptOrder)
                foreach ($scriptOrder as $script)
                    $scriptsOrdered->add($script);
            $scripts = $scriptsOrdered;

            // Join stylesheets
            foreach ($views as $view) {
                if ($view == null) continue;
                $stylesheetsMetadata = $view->getStylesheetsMetadata();
                foreach ($stylesheetsMetadata as $stylesheet) {
                    if (!$stylesheets->containsKey($stylesheet->order))
                        $stylesheets[$stylesheet->order] = Arr();
                    $stylesheets[$stylesheet->order]->add($stylesheet);
                }
            }

            $stylesheets->ksort();

            $stylesheetsOrdered = Arr();
            foreach ($stylesheets as $stylesheetOrder)
                foreach ($stylesheetOrder as $stylesheet)
                    $stylesheetsOrdered->add($stylesheet);
            $stylesheets = $stylesheetsOrdered;


            // Join bundles
            foreach ($views as $view) {
                if ($view == null) continue;
                $bundlesMetadata = $view->getBundleMetadata();
                foreach ($bundlesMetadata as $bundle) {
                    if ($bundle->containsKey(order) == false)
                        $bundle->order = 0;
                    if (!$bundles->containsKey($bundle->order))
                        $bundles[$bundle->order] = Arr();
                    $bundles[$bundle->order]->add($bundle);
                }
            }

            $bundles->ksort();

            $bundlesOrdered = Arr();
            foreach ($bundles as $bundleOrder)
                foreach ($bundleOrder as $bundle)
                    $bundlesOrdered->add($bundle);
            $bundles = $bundlesOrdered;

            // Join Metatags & titles
            $title = null;
            $metas = Arr([ name => Arr(), httpEquiv => Arr()]);
            $links = Arr();

            foreach ($views as $view) {
                if ($view == null) continue;
                $headMetadata = $view->getHeadMetadata();

                foreach ($headMetadata->titles as $_title)
                    if ($_title->title != null)
                        $title = $_title->title;

                foreach ($headMetadata->metas as $meta)
                    if ($meta->type == "name")
                        $metas->name[$meta->name] = $meta->content;
                    elseif ($meta->type == "httpEquiv")
                        $metas->httpEquiv[$meta->httpEquiv] = $meta->content;

                foreach ($headMetadata->links as $link)
                    $links[$link->type] = $link->plainHTML;
            }

            // Kernel scripts
            $kernelScripts = self::getKernelScriptsFiles();
            $applicationEventScripts = self::getApplicationEventScriptsFiles();
            $applicationComponentScripts = self::getApplicationComponentScriptsFiles();
            $applicationScripts = self::getApplicationScriptsFiles();

            // Mount pre-defined classes on root (like Modernizr)
//            $rootHtmlClass = "";
//            $rootClass = Arr();
//            $rootClass->add(\Connection::getBrowser());
//            $rootClass->add(\Connection::getPlatform());
//            $rootClass->add(\Connection::isMobile() ? "mobile" : "desktop");
//
//            foreach ($rootClass as $_rootClass)
//                $rootHtmlClass .= ($_rootClass . " ");

            // Mount HTML
//            $html = "<html class=\"" . $rootHtmlClass . "\">\n\t<head>\n\t\t<meta charset=\"UTF-8\">\n";
            $html = "<html>\n\t<head>\n\t\t<meta charset=\"UTF-8\">\n";

            if ($title != null)
                $html .= ("\t\t<title>" . $title . "</title>\n");

            foreach ($metas->httpEquiv as $httpEquiv => $content)
                $html .= ("\t\t<meta http-equiv=\"" . $httpEquiv . "\" content=\"" . $content . "\">\n");
            foreach ($metas->name as $name => $content)
                $html .= ("\t\t<meta name=\"" . $name . "\" content=\"" . $content . "\">\n");
            foreach ($links as $plainHTML)
                $html .= ("\t\t" . $plainHTML . "\n");

            if ($release == true)
            {
                if ($stylesheets->count > 0 && $bundles > 0)
                {
                    $hashStylesheet = $this->getStylesheetsPackageHash($stylesheets, $bundles);
//                $html .= ("\t\t<link type=\"text/css\" rel=\"stylesheet\" href=\"" . $config->front->base . "/" . $hashStylesheet . ("?v=" . $config->app->versionId) . "\">\n");
                    $html .= ("\t\t<link type=\"text/css\" rel=\"stylesheet\" href=\"" . $config->front->base . "/" . $hashStylesheet . "\">\n");

                    // Add non-bundle stylesheets
                    foreach ($stylesheets as $stylesheet)
                    {
                        if ($stylesheet->bundle == true)
                            continue;

                        if (stringEx($stylesheet->stylesheetURL)->contains("?") == false)
                            $stylesheet->stylesheetURL .= ("?v=" . $config->app->versionId);
                        $html .= ("\t\t<link type=\"text/css\" rel=\"stylesheet\" href=\"" . $stylesheet->stylesheetURL . "\">\n");
                    }
                }
            }
            else
            {
                // Stylesheets
                foreach ($stylesheets as $stylesheet)
                {
                    // Get last modified date and replace config version
                    $modifiedDateVersion = false;
                    if (stringEx($stylesheet->stylesheetURL)->contains("?") == false) {
                        if ($stylesheet->stylesheetFileURL == null && $stylesheet->stylesheetURL != null) {
                            $stylesheetFileURL = (CLIENT_FOLDER . "Public/" . $stylesheet->stylesheetURL);
                            if (\File::exists($stylesheetFileURL))
                                $stylesheet->stylesheetFileURL = $stylesheetFileURL;
                            elseif (stringEx($stylesheet->stylesheetURL)->startsWith($config->front->base)) {
                                $stylesheetFileURL = stringEx($stylesheet->stylesheetURL)->subString(stringEx($config->front->base)->count);
                                $stylesheetFileURL = (CLIENT_FOLDER . "Public/" . $stylesheetFileURL);
                                if (\File::exists($stylesheetFileURL))
                                    $stylesheet->stylesheetFileURL = $stylesheetFileURL;
                            }
                        }

                        if ($stylesheet->stylesheetFileURL != null) {
                            $modifiedDateTimeEx = \File::getLastModifiedDateTimeEx($stylesheet->stylesheetFileURL);
                            if ($modifiedDateTimeEx != null) {
                                $modifiedDate = ($modifiedDateTimeEx->getYear() . "." . $modifiedDateTimeEx->getMonth(true) . "." .
                                    $modifiedDateTimeEx->getDay(true) . $modifiedDateTimeEx->getHour(true) . $modifiedDateTimeEx->getMinute(true) . $modifiedDateTimeEx->getSecond(true));
                                $stylesheet->stylesheetURL .= ("?v=" . $modifiedDate);
                                $modifiedDateVersion = true;
                            }
                        }

                        if ($modifiedDateVersion == false)
                            $stylesheet->stylesheetURL .= ("?v=" . $config->app->versionId);
                    }

                    $html .= ("\t\t<link type=\"text/css\" rel=\"stylesheet\" href=\"" . $stylesheet->stylesheetURL . "\">\n");
                }

                // Bundles
                foreach ($bundles as $bundle) {
                    $hashBundle = $this->getBundlePackageHash($bundle);
                    if ($hashBundle != null)
                        $html .= ("\t\t<link type=\"text/css\" rel=\"stylesheet\" href=\"" . $config->front->base . "/" . $hashBundle . "\">\n");
                }
            }

            if (\Dumpper::isPageDumped())
                $html .= self::getDumppedStylesheetWithRender();

            $html .= "\t</head>\n\t<body>\n";

            foreach ($views as $view)
                if ($view != null)
                    $html .= ($view->getCleanBodyHTML() . "\n\n");

//            $html .= ("\t\t<script type=\"text/javascript\" data-script=\"data\">\"" . "KRUPABOX_INTERNAL_DATA_SCRIPT_REPLACE" . "\"</script>\n");
            $html .= ("\t\t<script type=\"text/javascript\" src=\"/KRUPABOX_INTERNAL_DATA_SCRIPT_REPLACE\" data-internal-script=\"true\"></script>\n");



            if ($release == true && \Browser::getBrowser() != "safari") // FUCKING SAFARI BREAKS POLYFIILS
            {
                $hashScripts = $this->getScriptsPackageHash($scripts, $kernelScripts, $applicationScripts, $applicationComponentScripts, $applicationEventScripts);
//                $html .= ("\t\t<script type=\"text/javascript\" src=\"" . $config->front->base . "/" . $hashScripts . ("?v=" . $config->app->versionId) . "\"></script>\n");
                $html .= ("\t\t<script type=\"text/javascript\" src=\"" . $config->front->base . "/" . $hashScripts . "\"></script>\n");

                // Add non-bundle scripts
                foreach ($scripts as $script)
                {
                    if ($script->bundle == true)
                        continue;

                    if ($script->scriptURL != null)
                    {
                        if (stringEx($script->scriptURL)->contains("?") == false)
                            $script->scriptURL .= ("?v=" . $config->app->versionId);
                        $html .= ("\t\t<script type=\"text/javascript\" src=\"" . $script->scriptURL . "\"></script>\n");
                    }

                    elseif ($script->scriptBody != null)
                        $html .= ("\t\t<script type=\"text/javascript\">" . $script->scriptBody . "</script>\n");
                }
            }
            else
            {
                // Render Pre-Kernel Scripts
                $hashPreKernelScripts = $this->getScriptsPackagePreKernelHash($kernelScripts);
                $html .= ("\t\t<script type=\"text/javascript\" src=\"" . $config->front->base . "/" . $hashPreKernelScripts . "\"></script>\n");

                foreach ($scripts as $script)
                {
                    $type = 'text/javascript';
                    if ($script->babel === true) $type = 'text/babel';

                    if ($script->scriptURL != null)
                    {
                        if (stringEx($script->scriptURL)->contains("?") == false)
                        {
                            $modifiedDateVersion = false;

                            if ($script->scriptFileURL == null && $script->scriptURL != null) {
                                $scriptFileURL = (CLIENT_FOLDER . "Public/" . $script->scriptURL);
                                if (\File::exists($scriptFileURL))
                                    $script->scriptFileURL = $scriptFileURL;
                                elseif (stringEx($script->scriptURL)->startsWith($config->front->base))
                                {
                                    $scriptFileURL = stringEx($script->scriptURL)->subString(stringEx($config->front->base)->count);
                                    $scriptFileURL = (CLIENT_FOLDER . "Public/" . $scriptFileURL);

                                    if (\File::exists($scriptFileURL))
                                        $script->scriptFileURL = $scriptFileURL;
                                }
                            }

                            if ($script->scriptFileURL != null) {
                                $modifiedDateTimeEx = \File::getLastModifiedDateTimeEx($script->scriptFileURL);
                                if ($modifiedDateTimeEx != null)
                                {
                                    $modifiedDate = ($modifiedDateTimeEx->getYear() . "." . $modifiedDateTimeEx->getMonth(true) . "." .
                                        $modifiedDateTimeEx->getDay(true) . $modifiedDateTimeEx->getHour(true) . $modifiedDateTimeEx->getMinute(true) . $modifiedDateTimeEx->getSecond(true));
                                    $script->scriptURL .= ("?v=" . $modifiedDate);
                                    $modifiedDateVersion = true;
                                }
                            }
                        }

                        if ($modifiedDateVersion == false)
                            $script->scriptURL .= ("?v=" . $config->app->versionId);

                        $html .= ("\t\t<script type=\"" . $type . "\" src=\"" . $script->scriptURL . "\"></script>\n");
                    }

                    elseif ($script->scriptBody != null)
                        $html .= ("\t\t<script type=\"" . $type . "\">" . $script->scriptBody . "</script>\n");
                }

                // Render Kernel Scripts
                $hashKernelScripts = $this->getScriptsPackageKernelHash($kernelScripts);
                $html .= ("\t\t<script type=\"text/javascript\" src=\"" . $config->front->base . "/" . $hashKernelScripts . "\"></script>\n");

                // Application Event Scripts
                foreach ($applicationEventScripts as $applicationEventScript) {
                    if (stringEx($applicationEventScript)->endsWith(".php"))
                        $applicationEventScript = stringEx($applicationEventScript)->subString(0, stringEx($applicationEventScript)->length - 4);

                    $modifiedDateString = ("?v=" . $config->app->versionId);
                    $eventPath = (CLIENT_FOLDER . "Event/" . $applicationEventScript . ".php");
                    if (\File::exists($eventPath))
                    {
                        $modifiedDateTimeEx = \File::getLastModifiedDateTimeEx($eventPath);
                        if ($modifiedDateTimeEx != null)
                        {
                            $modifiedDate = ($modifiedDateTimeEx->getYear() . "." . $modifiedDateTimeEx->getMonth(true) . "." .
                                $modifiedDateTimeEx->getDay(true) . $modifiedDateTimeEx->getHour(true) . $modifiedDateTimeEx->getMinute(true)  . $modifiedDateTimeEx->getSecond(true));
                            $modifiedDateString = ("?v=" . $modifiedDate);
                        }
                    }

                    $html .= ("\t\t<script type=\"text/javascript\" src=\"" . $config->front->base . "/Event/" . $applicationEventScript . ".js" . $modifiedDateString . "\"></script>\n");
                }

                // Application Component Scripts
                foreach ($applicationComponentScripts as $applicationComponentScript) {
                    if (stringEx($applicationComponentScript)->endsWith(".php"))
                        $applicationComponentScript = stringEx($applicationComponentScript)->subString(0, stringEx($applicationComponentScript)->length - 4);

                    $modifiedDateString = ("?v=" . $config->app->versionId);
                    $componentPath = (CLIENT_FOLDER . "Component/" . $applicationComponentScript . ".php");
                    if (\File::exists($componentPath))
                    {
                        $modifiedDateTimeEx = \File::getLastModifiedDateTimeEx($componentPath);
                        if ($modifiedDateTimeEx != null)
                        {
                            $modifiedDate = ($modifiedDateTimeEx->getYear() . "." . $modifiedDateTimeEx->getMonth(true) . "." .
                                $modifiedDateTimeEx->getDay(true) . $modifiedDateTimeEx->getHour(true) . $modifiedDateTimeEx->getMinute(true) . $modifiedDateTimeEx->getSecond(true));
                            $modifiedDateString = ("?v=" . $modifiedDate);
                        }
                    }

                    $html .= ("\t\t<script type=\"text/javascript\" src=\"" . $config->front->base . "/Component/" . $applicationComponentScript . ".js" . $modifiedDateString . "\"></script>\n");
                }

                // Application Scripts
                foreach ($applicationScripts as $applicationScript) {
                    if (stringEx($applicationScript)->endsWith(".php"))
                        $applicationScript = stringEx($applicationScript)->subString(0, stringEx($applicationScript)->length - 4);

                    $modifiedDateString = ("?v=" . $config->app->versionId);
                    $eventPath = (CLIENT_FOLDER . "Controller/" . $applicationScript . ".php");
                    if (\File::exists($eventPath))
                    {
                        $modifiedDateTimeEx = \File::getLastModifiedDateTimeEx($eventPath);
                        if ($modifiedDateTimeEx != null)
                        {
                            $modifiedDate = ($modifiedDateTimeEx->getYear() . "." . $modifiedDateTimeEx->getMonth(true) . "." .
                                $modifiedDateTimeEx->getDay(true) . $modifiedDateTimeEx->getHour(true) . $modifiedDateTimeEx->getMinute(true) . $modifiedDateTimeEx->getSecond(true));
                            $modifiedDateString = ("?v=" . $modifiedDate);
                        }
                    }

                    $html .= ("\t\t<script type=\"text/javascript\" src=\"" . $config->front->base . "/Controller/" . $applicationScript . ".js" . $modifiedDateString . "\"></script>\n");
                }

                // Render PostProcess
                $hashPostProcess = $this->getScriptsPackagePostProcessHash($kernelScripts);
                $html .= ("\t\t<script type=\"text/javascript\" src=\"" . $config->front->base . "/" . $hashPostProcess . "\"></script>\n");
            }

            $html .= "\t</body>\n</html>";

            // Data
            $data = Arr();
            foreach ($views as $view)
                $data = $data->merge($view->getDataMetadata());

            // Parse to real recursive array
            $dataQueryString = "";
            foreach ($data as $field => $_data)
                $dataQueryString .= ($field . "=" . stringEx($_data)->encode(true) . "&");
            if (stringEx($dataQueryString)->endsWith("&"))
                $dataQueryString = stringEx($dataQueryString)->subString(0, stringEx($dataQueryString)->count - 1);
            $dataParsed = [];
            parse_str($dataQueryString, $dataParsed);
            $data = \Arr($dataParsed);

            $dynamicData = Arr($dynamicData);
            $data = $data->merge($dynamicData);

//            // Get possible rendered HTML
//            $renderedHash = \Security\Hash::toSha1($html) . "-" . \Security\Hash::toSha1($dynamicData) . "-" . (($release == true) ? "release" : "development");
//            $renderPath   = ("cache://.tmp/render/.html/" . $renderedHash . ".html");
//
//            if (!\File::exists($renderPath)) {
//                $html = $this->renderWithData($html, $data);
//                \File::setContents($renderPath, $html);
//                dump("non-cached");
//            } else $html = \File::getContents($renderPath);

            $html = $this->renderWithData($html, $data, $release);

//            if ($release == true)
//                $html = Front\Minify\HTML::toMinified($html);

            $browserHash          = \Browser::getHash();
            $browserName          = \Browser::getBrowser();
            $browserPlatform      = \Browser::getPlatform();
            $browserPlatformName  = \Browser::getPlatformName();
            $browserVersion       = \Browser::getBrowserVersion(false);
            $browserVersionNumber = \Browser::getBrowserVersion(true);
            $browserMobile        = \Browser::isMobile();
            $connectionIp         = \Connection::getIpAddress();

//            if ($delegateRenderData != null && \FunctionEx::isFunction($delegateRenderData))
//            {
//                if ($delegateRenderData == null) $delegateRenderData = (function() {});
//                $postDynamicData = @$delegateRenderData($dynamicData);
//                if ($postDynamicData === false) {}
//                elseif ($postDynamicData === null)
//                    $dynamicData = Arr();
//                else $dynamicData = Arr($postDynamicData);
//            }

            if ($includeGlobalData == true)
            {
                if (!$dynamicData->containsKey("global"))
                    $dynamicData->global = Arr();

                $dynamicData->global->connection = Arr([ ipAddress => $connectionIp ]);
                $dynamicData->global->browser = Arr([
                    hash                 => $browserHash,
                    browser              => $browserName,
                    platform             => $browserPlatform,
                    platformName         => $browserPlatformName,
                    browserVersion       => $browserVersion,
                    browserVersionNumber => $browserVersionNumber,
                    isMobile             => $browserMobile,
                ]);
            }

            $dataScript = \Serialize\Json::encode($dynamicData);
            //$dataScript = stringEx($dataScript)->replace("'", "\\" . "'");
            $dataScript = @base64_encode($dataScript);

            $mountHash = \Security\Hash::toSha1($dataScript . "v2");

            $mountHashMd5 = \Security\Hash::toMd5($mountHash, false, true);
            $mountHashMd5 = (stringEx($mountHashMd5)->subString(0, 8) . "js" . stringEx($mountHashMd5)->subString(8));
            $dataHashPath = (\Garbage\Cache::getCachePath() . ".tmp/render/packagejs/". $mountHashMd5 . ".blob");

            $dataScriptCompiled = ("window.__KrupaBOX_dataScript__='" . $dataScript . "'; ");

            \File::setContents($dataHashPath, $dataScriptCompiled);

//            if (@function_exists("gzencode") == true)
//                \File::setContents($dataHashPath . ".gz", @gzencode($dataScriptCompiled));

            $html = stringEx($html)->replace("KRUPABOX_INTERNAL_DATA_SCRIPT_REPLACE", $mountHashMd5);

            return $html;
        }

        protected static function getCustomTwig()
        {
            $twig = new \Twig_Environment(new \Twig_Loader_String());

            $stringEx = new Front\Extensions\StringEx();
            $intEx = new Front\Extensions\IntEx();
            $floatEx = new Front\Extensions\FloatEx();
            $boolEx = new Front\Extensions\BoolEx();
            $arrayEx = new Front\Extensions\ArrayEx();

            $twig->addGlobal('string', $stringEx);
            $twig->addGlobal('stringEx', $stringEx);
            $twig->addGlobal('int', $intEx);
            $twig->addGlobal('intEx', $intEx);
            $twig->addGlobal('float', $floatEx);
            $twig->addGlobal('floatEx', $floatEx);
            $twig->addGlobal('bool', $boolEx);
            $twig->addGlobal('boolEx', $boolEx);
            $twig->addGlobal('Arr', $arrayEx);
            $twig->addGlobal('Array', $arrayEx);

//            $function = new \Twig_SimpleFunction('__function_name__', function ($value) { return $value . $value; });
//            $twig->addFunction($function);

            return $twig;
        }

        protected static function parseCustomTag($html)
        {
            $dataHash = \Security\Hash::toSha1($html);
            $dataPath = ("cache://.tmp/render/html/twig/" . $dataHash . ".blob");

            if (\File::exists($dataPath) == false)
            {
                $html = stringEx($html)->
                replace("{% ignore %}", "<!-- IGNORE -->{% verbatim %}", false)->
                replace("{% endignore %}", "{% endverbatim %}<!-- END IGNORE -->");

                while (stringEx($html)->contains("{% template"))
                {
                    $templateInit = stringEx($html)->indexOf("{% template");
                    $templateEnd  = stringEx($html)->indexOf("endtemplate %}");

                    if ($templateEnd === false) // wrong template end
                        break;

                    $extractTemplate = stringEx($html)->subString($templateInit, ($templateEnd - $templateInit) + 14);

                    $extractTemplate = stringEx($extractTemplate)->subString(11);
                    $extractTemplate = stringEx($extractTemplate)->subString(0,stringEx($extractTemplate)->count - 14);
                    $extractTemplate = stringEx($extractTemplate)->trim("\r\n\t");

                    if (stringEx($extractTemplate)->endsWith("{%")) {
                        $extractTemplate = stringEx($extractTemplate)->subString(0, stringEx($extractTemplate)->count - 2);
                        $extractTemplate = stringEx($extractTemplate)->trim("\r\n\t");
                    }

                    $name = "true";
                    $indexOfExtractName = stringEx($extractTemplate)->indexOf("%}");
                    if ($indexOfExtractName !== null)
                    {
                        $extractTemplateName = stringEx($extractTemplate)->subString(0, $indexOfExtractName);
                        $extractTemplateName = stringEx($extractTemplateName)->trim("\r\n\t");

                        if (stringEx($extractTemplateName)->startsWith("\""))
                            $extractTemplateName = stringEx($extractTemplateName)->subString(1);
                        if (stringEx($extractTemplateName)->endsWith("\""))
                            $extractTemplateName = stringEx($extractTemplateName)->subString(0, stringEx($extractTemplateName)->count - 1);
                        $extractTemplateName = stringEx($extractTemplateName)->trim("\r\n\t");

                        if ($extractTemplateName != "")
                            $name = $extractTemplateName;

                        $extractTemplate = stringEx($extractTemplate)->subString($indexOfExtractName + 2);
                        $extractTemplate = stringEx($extractTemplate)->trim("\r\n\t");
                    }

                    $cleanHtml = stringEx($html)->subString(0, $templateInit );
                    $cleanHtml .= "<!-- TEMPLATE --><div app-template=\"" . $name . "\" style=\"display: none;\">";
                    $cleanHtml .= stringEx($extractTemplate)->encode(true);
                    $cleanHtml .= "</div><!-- ENDTEMPLATE -->";
                    $cleanHtml .= stringEx($html)->subString($templateEnd + 14);

                    $html = $cleanHtml;
                }

                \File::setContents($dataPath, $html);
                return $html;
            }

            return \File::getContents($dataPath);
        }

        public static function renderHTML($html, $data, $release = true)
        {
            \KrupaBOX\Internal\Library::load("Twig");
            $twig = self::getCustomTwig();

            $html = self::parseCustomTag($html);

            $data = Arr($data);
            $dataHash = \Security\Hash::toSha1($html . $data);

            $dataDevelopmentPath = ("cache://.tmp/render/html/development/" . $dataHash . ".blob");
            $dataReleasePath = ("cache://.tmp/render/html/release/" . $dataHash . ".blob");


            if ($release == true && \File::exists($dataReleasePath))
                return \File::getContents($dataReleasePath);

            if (\File::exists($dataDevelopmentPath) == false) {

                $html = $twig->render($html, $data->toArray());
                \File::setContents($dataDevelopmentPath, $html);
            } else $html = \File::getContents($dataDevelopmentPath);

            if ($release == true) {
                $html = Front\Minify\HTML::toMinified($html);
                \File::setContents($dataReleasePath, $html);
            }

            return $html;
        }

        protected function renderWithData($html, $data, $release = true)
        { return self::renderHTML($html, $data, $release); }

        protected function downloadExternalStylesheets($stylesheets)
        {
            foreach ($stylesheets as $stylesheet)
            {
                if ($stylesheet->stylesheetURL == null)
                    continue;

                $indexOfExternal = strpos($stylesheet->stylesheetURL, "http://");
                if ($indexOfExternal === false || $indexOfExternal !== 0)
                    $indexOfExternal = strpos($stylesheet->stylesheetURL, "https://");
                if ($indexOfExternal === false || $indexOfExternal !== 0)
                    $indexOfExternal = strpos($stylesheet->stylesheetURL, "//");
                if ($indexOfExternal === false || $indexOfExternal !== 0)
                    $indexOfExternal = strpos($stylesheet->stylesheetURL, "ftp://");

                if ($indexOfExternal === 0)
                {
                    if (strpos($stylesheet->stylesheetURL, "//") === 0)
                        $stylesheet->stylesheetURL = ("https:" . $stylesheet->stylesheetURL);

                    $stylesheet->stylesheetHashURL = sha1($stylesheet->stylesheetURL);
                    $cacheExternalFile = (\Garbage\Cache::getCachePath() . ".tmp/render/externalcss/". $stylesheet->stylesheetHashURL . ".blob");

                    if (!\File::exists($cacheExternalFile)) {
//                        $stylesheetData = @file_get_contents($stylesheet->stylesheetURL);

                        $opts = array(
                            'http' => array(
                                'method' => "GET"
                            ),
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                            )
                        );
                        $context = stream_context_create($opts);
                        $stylesheetData = file_get_contents($stylesheet->stylesheetURL, false, $context);

                        if (!empty($stylesheetData))
                            \File::setContents($cacheExternalFile, $stylesheetData);
                    }

                    $stylesheet->stylesheetFileURL = $cacheExternalFile;
                    $stylesheet->enabled       = true;
                }
            }

            return $stylesheets;
        }

        protected function getBundlePackageHash($bundle)
        {
            if ($bundle->stylesheets == null || $bundle->stylesheets->count <= 0)
                return null;

            $bundleHash = (\Security\Hash::toSha1(\Serialize\Json::encode($bundle->stylesheets)));

            $stylesheetFileURLs = Arr();
            foreach ($bundle->stylesheets as $stylesheet)
                if ($stylesheet->stylesheetFileURL == null && $stylesheet->stylesheetURL != null) {
                    $stylesheetFileURL = (CLIENT_FOLDER . "Public/" . $stylesheet->stylesheetURL);
                    if (\File::exists($stylesheetFileURL)) {
                        $stylesheet->stylesheetFileURL = $stylesheetFileURL;
                        $stylesheetFileURLs->add($stylesheetFileURL);
                    }

                }
            if ($stylesheetFileURLs->count <= 0) return null;

            foreach ($stylesheetFileURLs as $stylesheetFileURL)
                $bundleHash .= ("-" . \Security\Hash::toSha1(\File::getLastModifiedDateTimeEx($stylesheetFileURL)->toString()));

            $mountHashMd5 = \Security\Hash::toMd5($bundleHash, false, true);
            $mountHashMd5 = (stringEx($mountHashMd5)->subString(0, 8) . "bc" . stringEx($mountHashMd5)->subString(8));
            $bundleHashPath = (\Garbage\Cache::getCachePath() . ".tmp/render/bundlecss/". $mountHashMd5 . ".blob");

            if (!\File::exists($bundleHashPath))
            {
                $mountSCSS = "";

                foreach ($bundle->stylesheets as $stylesheet) {

                    $mountSCSS .= ("/* File: '" . (($stylesheet->stylesheetURL != null) ? $stylesheet->stylesheetURL : "**injected**") . "' */\n\n");
                    if ($stylesheet->stylesheetFileURL != null)
                    {
                        $stylesheetFileData = \File::getContents($stylesheet->stylesheetFileURL);
                        $mountSCSS .= $stylesheetFileData;
                    }

//                    elseif ($script->scriptBody != null)
//                        $mountJS .= $script->scriptBody;
                    $mountSCSS .= "\n\n\n";
                }


                $scss = \Scss::fromLessString($mountSCSS);
                $bundleData = $scss->getStylesheet();

                \File::setContents($bundleHashPath, $bundleData);
            }

            return $mountHashMd5;
        }

        protected function getStylesheetsPackageHash($stylesheets, $bundles)
        {
            $config = \Config::get();
            $stylesheets = $this->downloadExternalStylesheets($stylesheets);

            foreach ($stylesheets as $stylesheet)
            {
                if ($stylesheet->bundle == false)
                    continue;

                if ($stylesheet->stylesheetFileURL == null && $stylesheet->stylesheetURL != null) {
                    $stylesheetFileURL = (CLIENT_FOLDER . "Public/" . $stylesheet->stylesheetURL);
                    if (\File::exists($stylesheetFileURL))
                        $stylesheet->stylesheetFileURL = $stylesheetFileURL;
                    elseif (stringEx($stylesheet->stylesheetURL)->startsWith($config->front->base))
                    {
                        $stylesheetFileURL = stringEx($stylesheet->stylesheetURL)->subString(stringEx($config->front->base)->count);
                        $stylesheetFileURL = (CLIENT_FOLDER . "Public/" . $stylesheetFileURL);

                        if (\File::exists($stylesheetFileURL))
                            $stylesheet->stylesheetFileURL = $stylesheetFileURL;
                    }
                }

                if ($stylesheet->stylesheetFileURL != null)
                    $stylesheet->stylesheetHashURL = \Security\Hash::toSha1(\File::getLastModifiedDateTimeEx($stylesheet->stylesheetFileURL)->toString());

//                elseif ($script->scriptBody != null)
//                    $script->scriptHashURL = \Security\Hash::toSha1($script->scriptBody);
            }

            $mountHash = "";
            foreach ($stylesheets as $stylesheet)
                if ($stylesheet->stylesheetHashURL != null && $stylesheet->bundle == true)
                    $mountHash .= ($stylesheet->stylesheetHashURL . "-");

            // Bundles
            $hashBundles = Arr();
            foreach ($bundles as $bundle) {
                $hashBundle = $this->getBundlePackageHash($bundle);
                if ($hashBundle != null) {
                    $hashBundles->add($hashBundle);
                    $mountHash .= ($hashBundle . "-");
                }
            }

            $mountHash .= (($config->front->assets->css->minify == true)     ? "true" : "false");
            $mountHash .= (($config->front->assets->css->autoPrefix == true) ? "true" : "false");

            $mountHash = \Security\Hash::toSha1($mountHash);

            $mountHashMd5 = \Security\Hash::toMd5($mountHash, false, true);
            $mountHashMd5 = (stringEx($mountHashMd5)->subString(0, 8) . "cs" . stringEx($mountHashMd5)->subString(8));

            $packageHashPath = (\Garbage\Cache::getCachePath() . ".tmp/render/packagecss/". $mountHashMd5 . ".blob");

            if (!\File::exists($packageHashPath))
            {
                $mountCSS = "";

                foreach ($stylesheets as $stylesheet) {

                    $mountCSS .= ("/* File: '" . (($stylesheet->stylesheetURL != null) ? $stylesheet->stylesheetURL : "**injected**") . "' */\n\n");
                    if ($stylesheet->stylesheetFileURL != null)
                    {
                        $stylesheetFileData = \File::getContents($stylesheet->stylesheetFileURL);

                        if (stringEx($stylesheet->stylesheetFileURL)->endsWith(".scss")) {
                            $scss = \Scss::fromLessString($stylesheetFileData);
                            $stylesheetFileData = $scss->getStylesheet();
                        }

                        $mountCSS .= $stylesheetFileData;
                    }

//                    elseif ($script->scriptBody != null)
//                        $mountJS .= $script->scriptBody;
                    $mountCSS .= "\n\n\n";
                }

                foreach ($hashBundles as $hashBundle)
                {
                    $bundleHashPath = (\Garbage\Cache::getCachePath() . ".tmp/render/bundlecss/". $hashBundle . ".blob");
                    if (\File::exists($bundleHashPath))
                    {
                        $bundleData = \File::getContents($bundleHashPath);

                        $mountCSS .= ("/* File: '**injected**" . "' */\n\n");
                        $mountCSS .= $bundleData;
                        $mountCSS .= "\n\n\n";
                    }
                }

                // Minify CSS
                if ($config->front->assets->css->minify == true)
                    $mountCSS = Front\Minify\CSS::toMinified($mountCSS);

                \File::setContents($packageHashPath, $mountCSS);
//                if (function_exists("gzencode")) // For GZIP output later
//                    \File::setContents($packageHashPath . ".gz", gzencode($mountCSS));
            }



            return $mountHashMd5;
        }

        // Included KrupaBOX front Kernel
        protected function getKernelScriptsFiles()
        {
            $baseDir = (__KRUPA_PATH_LIBRARY__ . "KrupaBOX/KrupaBOX/");
            $listDir = \DirectoryEx::listDirectoryPaths($baseDir);
            $cleanList = Arr(["KrupaBOX.js", "KrupaBOX/PHP.js"]);
            foreach ($listDir as $filePath)
                if (stringEx($filePath)->toString() != "PHP.js" && stringEx($filePath)->toString() != "PostProcess.js" && stringEx($filePath)->endsWith(".js"))
                    $cleanList->add("KrupaBOX/" . $filePath);
            return $cleanList;
        }

        protected static function getApplicationPreBuild()
        {
            return <<<JAVASCRIPT
//////////////////////////////////////////////////////////////////////////
// KrupaBOX Application
/////////////////////////////////////
// PreBuild

window.KrupaBOX = (window.KrupaBOX || {});

KrupaBOX.__internal__ = (KrupaBOX.__internal__ || {});
KrupaBOX.__internal__.__namespaces__ = {};

window.Application = (window.Application || {});
Application.Server = (Application.Server || {});
Application.Client = (Application.Client || {});

Application.Client.Controller = (Application.Client.Controller || {});
Application.Client.Component  = (Application.Client.Component || {});
Application.Client.Event      = (Application.Client.Event || {});

window.Controller = (window.Controller || {});
window.Component  = (window.Component || {});

// End PreBuild
//////////////////////////////////////////////////////////////////////////
JAVASCRIPT;
        }

        protected static function getApplicationPostProcess()
        {
            $postProcessPath = (__KRUPA_PATH_LIBRARY__ . "KrupaBOX/KrupaBOX/PostProcess.js");
            if (\File::exists($postProcessPath))
            {
                $isDevelopment = (\Config::get()->server->environment == development);

                $postProcessData = \File::getContents($postProcessPath);
                $postProcessData = stringEx($postProcessData)->
                replace("\"{{ development }}\"", (($isDevelopment == true) ? "true" : "false"));

                return (
                    "//////////////////////////////////////////////////////////////////////////\r\n" .
                    "// Post Process Build\r\n" .
                    "/////////////////////////////////////\r\n" .
                    $postProcessData .
                    "/////////////////////////////////////\r\n"
                );
            }

            return null;
        }

        protected static function getApplicationCompiled()
        {
            $cleanList = self::getApplicationScriptsFiles();
            $cleanListComp = self::getApplicationComponentScriptsFiles();

            $applicationCompiled = self::getApplicationPreBuild();

            foreach ($cleanList as $filePath)
                $applicationCompiled .= self::getApplicationFileCompiled($filePath);
            foreach ($cleanListComp as $filePath)
                $applicationCompiled .= self::getApplicationComponentFileCompiled($filePath);

            $applicationCompiled .= self::getApplicationPostProcess();
            return $applicationCompiled;
        }

        public static function getApplicationFileCompiled($filePath)
        {
            $fullPath = (CLIENT_FOLDER . "Controller/" . $filePath);
            $fullPath = \File::getInsensitivePath($fullPath);

            if ($fullPath != null && \File::exists($fullPath))
            {

                $fileLastModifiedDate = \File::getLastModifiedDateTimeEx(CLIENT_FOLDER . "Controller/" . $filePath);
                $fileNamespace = stringEx($filePath)->replace("\\", "/", false)->replace("//", "/", false)->replace("/", ".");

                $fileModifiedHash = \Security\Hash::toSha1(
                    "render.application." .
                    stringEx($fileNamespace)->toLower() . "." .
                    \Security\Hash::toSha1(($fileLastModifiedDate != null) ? $fileLastModifiedDate->toString() : null)
                );

                $config = \Config::get();
                $filePath = (\Garbage\Cache::getCachePath() . ".tmp/render/scriptjs/" . $fileModifiedHash . '.blob');

                $fileData = null;
                if (\File::exists($filePath))
                { $fileData = \File::getContents($filePath);  }
                else
                {
                    $fileData = null;

//                    if ($config->compiler->controller === true) {
                        if (\PHP\Compiler\PHP7::isCompiledToPHP5($fullPath) === false)
                            \PHP\Compiler\PHP7::compileToPHP5($fullPath);

                        $compilePHP5Path = \PHP\Compiler\PHP7::getCompiledCachePathToPHP5($fullPath);

                        if (\PHP\Compiler\PHP7::isCompiledToPHP5($fullPath) === true) {
                            // fix namespace
                            $fileDataFix = \File::getContents($compilePHP5Path);

                            $cleanNamespace = stringEx($fileNamespace)->toString();
                            if (stringEx($cleanNamespace)->toLower(false)->endsWith(".php"))
                                $cleanNamespace = stringEx($cleanNamespace)->subString(0, stringEx($cleanNamespace)->count - 4);

                            $splitNamespaceFix = stringEx($cleanNamespace)->split('.');
                            $splitNamespaceFix = $splitNamespaceFix->limit($splitNamespaceFix->count - 1);

                            $namespaceFullFix = 'namespace Application\Client\Controller';
                            foreach ($splitNamespaceFix as $_splitNamespaceFix)
                                $namespaceFullFix .= ('\\' . $_splitNamespaceFix);

                            if (stringEx($fileDataFix)->contains($namespaceFullFix . ';') === true) {
                                $fileDataFix = stringEx($fileDataFix)->replace($namespaceFullFix . ';', $namespaceFullFix . "\r\n{");
                                $fileDataFix .= "\r\n}";
                            }

                            $fileData = \Render\Front\Extensions\PHP::compile($fileDataFix);
                        }

                        else $fileData = \Render\Front\Extensions\PHP::compile(\File::getContents($fullPath));
//                    }
//                    else $fileData = \Render\Front\Extensions\PHP::compile(\File::getContents($fullPath));

                    if ($fileData != null)
                        \File::setContents($filePath, $fileData);
                }

                if ($fileData != null)
                {
                    $cleanNamespace = stringEx($fileNamespace)->toString();
                    if (stringEx($cleanNamespace)->toLower(false)->endsWith(".php"))
                        $cleanNamespace = stringEx($cleanNamespace)->subString(0, stringEx($cleanNamespace)->count - 4);

                    $preBuildClass = "";

                    $splitNamespace = stringEx($cleanNamespace)->split(".");
                    $lastNamespace = "Application.Client.Controller";

                    foreach ($splitNamespace as $_splitNamespace)
                    {
                        if ($_splitNamespace != $splitNamespace[($splitNamespace->count - 1)])
                            $preBuildClass .= (($lastNamespace . "." . $_splitNamespace) .
                                " = (" . ($lastNamespace . "." . $_splitNamespace) . " || {});" . "\r\n");
                        else $preBuildClass .= (($lastNamespace . "." . $_splitNamespace) .
                            " = Application__Client__Controller__" . stringEx($cleanNamespace)->replace(".", "__") . ";\r\n");
                        $lastNamespace .= ("." . $_splitNamespace);
                    }

                    $fileData = stringEx($fileData)->replace("/" . "* __INIT_KRUPABOX_INJECT_NAMESPACE_SYSTEM__END__ */", $preBuildClass);

                    $classNamespaceFullName = ("Application__Client__Controller__" . stringEx($cleanNamespace)->replace(".", "__"));
                    $finalConstructParams = null;

                    // Extract __construct params e create construct caller
                    if (stringEx($fileData)->indexOf("__javascript_constructor__") !== false)
                    {
                        $indexOfConstruct = stringEx($fileData)->indexOf("__javascript_constructor__");
                        $constructParams = stringEx($fileData)->subString($indexOfConstruct + 26);
                        $constructParams = stringEx($constructParams)->trim();
                        if (stringEx($constructParams)->startsWith("=")) {
                            $constructParams = stringEx($constructParams)->subString(1);
                            $constructParams = stringEx($constructParams)->trim();
                            if (stringEx($constructParams)->startsWith("function")) {
                                $constructParams = stringEx($constructParams)->subString(8);
                                $constructParams = stringEx($constructParams)->trim();
                                if (stringEx($constructParams)->startsWith("(")) {
                                    $constructParams = stringEx($constructParams)->subString(1);
                                    $constructParams = stringEx($constructParams)->trim();
                                    $indexOfCloseParams = stringEx($constructParams)->indexOf(")");
                                    if ($indexOfCloseParams !== null)
                                        $finalConstructParams = stringEx($constructParams)->subString(0, $indexOfCloseParams);
                                }
                            }
                        }
                    }

                    if (stringEx($fileData)->contains("__javascript_constructor__"))
                    {
                        $fileData = stringEx($fileData)->replace("__javascript_constructor__", "__construct");
                        $mountConstructCaller = ("this.__construct(" . $finalConstructParams . "); return this;");
                        $fileData = stringEx($fileData)->replace("function " . $classNamespaceFullName. "()", "function " . $classNamespaceFullName. "(" . $finalConstructParams . ")");
                        $fileData = stringEx($fileData)->replace("/* __INIT_KRUPABOX_INJECT_CONSTRUCT__ */", $mountConstructCaller);
                    } else $fileData = stringEx($fileData)->replace("/* __INIT_KRUPABOX_INJECT_CONSTRUCT__ */", "");

                    $fileData = (
                        "//////////////////////////////////////////////////////////////////////////\r\n" .
                        "// Namespace: Application.Client.Controller." . $cleanNamespace . "\r\n" .
                        "/////////////////////////////////////\r\n" .
                        $fileData .
                        "\r\n\r\n" .
                        "KrupaBOX.__internal__.__namespaces__[\"application.client.controller." . stringEx($cleanNamespace)->toLower() . "\"] = " .
                        $classNamespaceFullName . ";\r\n\r\n"
                    );

                    return $fileData;

                }
            }

            return null;
        }

        public static function getApplicationComponentFileCompiled($filePath)
        {
            $fullPath = (CLIENT_FOLDER . "Component/" . $filePath);
            $fullPath = \File::getInsensitivePath($fullPath);

            if ($fullPath != null && \File::exists($fullPath))
            {
                $fileLastModifiedDate = \File::getLastModifiedDateTimeEx(CLIENT_FOLDER . "Component/" . $filePath);
                $fileNamespace = stringEx($filePath)->replace("\\", "/", false)->replace("//", "/", false)->replace("/", ".");

                $fileModifiedHash = \Security\Hash::toSha1(
                    "render.application.component." .
                    stringEx($fileNamespace)->toLower() . "." .
                    \Security\Hash::toSha1(($fileLastModifiedDate != null) ? $fileLastModifiedDate->toString() : null)
                );

                $config = \Config::get();
                $filePath = (\Garbage\Cache::getCachePath() . ".tmp/render/scriptjs/" . $fileModifiedHash . '.blob');

                $fileData = null;
                if (\File::exists($filePath))
                { $fileData = \File::getContents($filePath);  }
                else
                {
                    $fileData = null;

//                    if ($config->compiler->controller === true) {
                        if (\PHP\Compiler\PHP7::isCompiledToPHP5($fullPath) === false)
                            \PHP\Compiler\PHP7::compileToPHP5($fullPath);

                        $compilePHP5Path = \PHP\Compiler\PHP7::getCompiledCachePathToPHP5($fullPath);

                        if (\PHP\Compiler\PHP7::isCompiledToPHP5($fullPath) === true) {
                            // fix namespace
                            $fileDataFix = \File::getContents($compilePHP5Path);

                            $cleanNamespace = stringEx($fileNamespace)->toString();
                            if (stringEx($cleanNamespace)->toLower(false)->endsWith(".php"))
                                $cleanNamespace = stringEx($cleanNamespace)->subString(0, stringEx($cleanNamespace)->count - 4);

                            $splitNamespaceFix = stringEx($cleanNamespace)->split('.');
                            $splitNamespaceFix = $splitNamespaceFix->limit($splitNamespaceFix->count - 1);

                            $namespaceFullFix = 'namespace Application\Client\Component';
                            foreach ($splitNamespaceFix as $_splitNamespaceFix)
                                $namespaceFullFix .= ('\\' . $_splitNamespaceFix);

                            if (stringEx($fileDataFix)->contains($namespaceFullFix . ';') === true) {
                                $fileDataFix = stringEx($fileDataFix)->replace($namespaceFullFix . ';', $namespaceFullFix . "\r\n{");
                                $fileDataFix .= "\r\n}";
                            }

                            $fileData = \Render\Front\Extensions\PHP::compile($fileDataFix);
                        }

                        else $fileData = \Render\Front\Extensions\PHP::compile(\File::getContents($fullPath));
//                    }
//                    else $fileData = \Render\Front\Extensions\PHP::compile(\File::getContents($fullPath));

                    if ($fileData != null)
                        \File::setContents($filePath, $fileData);
                }

                if ($fileData != null)
                {
                    $cleanNamespace = stringEx($fileNamespace)->toString();
                    if (stringEx($cleanNamespace)->toLower(false)->endsWith(".php"))
                        $cleanNamespace = stringEx($cleanNamespace)->subString(0, stringEx($cleanNamespace)->count - 4);

                    $preBuildClass = "";

                    $splitNamespace = stringEx($cleanNamespace)->split(".");
                    $lastNamespace = "Application.Client.Component";

                    foreach ($splitNamespace as $_splitNamespace)
                    {
                        if ($_splitNamespace != $splitNamespace[($splitNamespace->count - 1)])
                            $preBuildClass .= (($lastNamespace . "." . $_splitNamespace) .
                                " = (" . ($lastNamespace . "." . $_splitNamespace) . " || {});" . "\r\n");
                        else $preBuildClass .= (($lastNamespace . "." . $_splitNamespace) .
                            " = Application__Client__Component__" . stringEx($cleanNamespace)->replace(".", "__") . ";\r\n");
                        $lastNamespace .= ("." . $_splitNamespace);
                    }

                    $fileData = stringEx($fileData)->replace("/" . "* __INIT_KRUPABOX_INJECT_NAMESPACE_SYSTEM__END__ */", $preBuildClass);

                    $classNamespaceFullName = ("Application__Client__Component__" . stringEx($cleanNamespace)->replace(".", "__"));
                    $finalConstructParams = null;

                    // Extract __construct params e create construct caller
                    if (stringEx($fileData)->indexOf("__javascript_constructor__") !== false)
                    {
                        $indexOfConstruct = stringEx($fileData)->indexOf("__javascript_constructor__");
                        $constructParams = stringEx($fileData)->subString($indexOfConstruct + 26);
                        $constructParams = stringEx($constructParams)->trim();
                        if (stringEx($constructParams)->startsWith("=")) {
                            $constructParams = stringEx($constructParams)->subString(1);
                            $constructParams = stringEx($constructParams)->trim();
                            if (stringEx($constructParams)->startsWith("function")) {
                                $constructParams = stringEx($constructParams)->subString(8);
                                $constructParams = stringEx($constructParams)->trim();
                                if (stringEx($constructParams)->startsWith("(")) {
                                    $constructParams = stringEx($constructParams)->subString(1);
                                    $constructParams = stringEx($constructParams)->trim();
                                    $indexOfCloseParams = stringEx($constructParams)->indexOf(")");
                                    if ($indexOfCloseParams !== null)
                                        $finalConstructParams = stringEx($constructParams)->subString(0, $indexOfCloseParams);
                                }
                            }
                        }
                    }

                    if (stringEx($fileData)->contains("__javascript_constructor__"))
                    {
                        $fileData = stringEx($fileData)->replace("__javascript_constructor__", "__construct");
                        $mountConstructCaller = ("this.__construct(" . $finalConstructParams . "); return this;");
                        $fileData = stringEx($fileData)->replace("function " . $classNamespaceFullName. "()", "function " . $classNamespaceFullName. "(" . $finalConstructParams . ")");
                        $fileData = stringEx($fileData)->replace("/* __INIT_KRUPABOX_INJECT_CONSTRUCT__ */", $mountConstructCaller);
                    } else $fileData = stringEx($fileData)->replace("/* __INIT_KRUPABOX_INJECT_CONSTRUCT__ */", "");

                    return (
                        "//////////////////////////////////////////////////////////////////////////\r\n" .
                        "// Namespace: Application.Client.Component." . $cleanNamespace . "\r\n" .
                        "/////////////////////////////////////\r\n" .
                        $fileData .
                        "/////////////////////////////////////\r\n\r\n" .
                        "// Full namespace list\r\n" .
                        "KrupaBOX.__internal__.__namespaces__[\"application.client.component." . stringEx($cleanNamespace)->toLower() . "\"] = " .
                        "Application__Client__Component__" . stringEx($cleanNamespace)->replace(".", "__") . ";\r\n\r\n"
                    );

                }
            }

            return null;
        }

        public static function getApplicationEventFileCompiled($filePath)
        {
            $fullPath = (CLIENT_FOLDER . "Event/" . $filePath);
            $fullPath = \File::getInsensitivePath($fullPath);

            if ($fullPath != null && \File::exists($fullPath))
            {

                $fileLastModifiedDate = \File::getLastModifiedDateTimeEx(CLIENT_FOLDER . "Event/" . $filePath);
                $fileNamespace = stringEx($filePath)->replace("\\", "/", false)->replace("//", "/", false)->replace("/", ".");

                $fileModifiedHash = \Security\Hash::toSha1(
                    "render.application.event." .
                    stringEx($fileNamespace)->toLower() . "." .
                    \Security\Hash::toSha1(($fileLastModifiedDate != null) ? $fileLastModifiedDate->toString() : null)
                );

                $filePath = (\Garbage\Cache::getCachePath() . ".tmp/render/scriptjs/" . $fileModifiedHash . ".blob");

                $fileData = null;
                if (\File::exists($filePath))
                { $fileData = \File::getContents($filePath);  }
                else
                {
                    $fileData = \Render\Front\Extensions\PHP::compile(\File::getContents($fullPath));

                    if ($fileData != null)
                        \File::setContents($filePath, $fileData);
                }

                if ($fileData != null)
                {
                    $cleanNamespace = stringEx($fileNamespace)->toString();
                    if (stringEx($cleanNamespace)->toLower(false)->endsWith(".php"))
                        $cleanNamespace = stringEx($cleanNamespace)->subString(0, stringEx($cleanNamespace)->count - 4);

                    $preBuildClass = "";

                    $splitNamespace = stringEx($cleanNamespace)->split(".");
                    $lastNamespace = "Application.Client.Event";

                    foreach ($splitNamespace as $_splitNamespace)
                    {
                        if ($_splitNamespace != $splitNamespace[($splitNamespace->count - 1)])
                            $preBuildClass .= (($lastNamespace . "." . $_splitNamespace) .
                                " = (" . ($lastNamespace . "." . $_splitNamespace) . " || {});" . "\r\n");
                        else $preBuildClass .= (($lastNamespace . "." . $_splitNamespace) .
                            " = Application__Client__Event__" . stringEx($cleanNamespace)->replace(".", "__") . ";\r\n");
                        $lastNamespace .= ("." . $_splitNamespace);
                    }

                    $fileData = stringEx($fileData)->replace("/" . "* __INIT_KRUPABOX_INJECT_NAMESPACE_SYSTEM__END__ */", $preBuildClass);

                    return (
                        "//////////////////////////////////////////////////////////////////////////\r\n" .
                        "// Namespace: Application.Client.Event." . $cleanNamespace . "\r\n" .
                        "/////////////////////////////////////\r\n" .
                        $fileData .
                        "/////////////////////////////////////\r\n\r\n" .
                        "// Full namespace list\r\n" .
                        "KrupaBOX.__internal__.__namespaces__[\"application.client.event." . stringEx($cleanNamespace)->toLower() . "\"] = " .
                        "Application__Client__Event__" . stringEx($cleanNamespace)->replace(".", "__") . ";\r\n\r\n"
                    );

                }
            }

            return null;
        }

        protected function getApplicationScriptsFiles()
        {
            $cleanList = Arr();

            $baseDir = (CLIENT_FOLDER . "Controller");
            $listDir = \DirectoryEx::listDirectoryPaths($baseDir);
            if ($listDir != null)
                foreach ($listDir as $filePath)
                    if (stringEx($filePath)->endsWith(".php") || stringEx($filePath)->endsWith(".js"))
                        $cleanList->add($filePath);

            return $cleanList;
        }

        protected function getApplicationEventScriptsFiles()
        {
            $cleanList = Arr();

            $baseDir = (CLIENT_FOLDER . "Event");
            $listDir = \DirectoryEx::listDirectoryPaths($baseDir);
            if ($listDir != null)
                foreach ($listDir as $filePath)
                    if (stringEx($filePath)->endsWith(".php") || stringEx($filePath)->endsWith(".js"))
                        $cleanList->add($filePath);

            return $cleanList;
        }

        protected function getApplicationComponentScriptsFiles()
        {
            $cleanList = Arr();

            $baseDir = (CLIENT_FOLDER . "Component");
            $listDir = \DirectoryEx::listDirectoryPaths($baseDir);
            if ($listDir != null)
                foreach ($listDir as $filePath)
                    if (stringEx($filePath)->endsWith(".php") || stringEx($filePath)->endsWith(".js"))
                        $cleanList->add($filePath);

            return $cleanList;
        }

        protected function getScriptsPackagePostProcessHash()
        {
            $applicationPostProccess = $this->getApplicationPostProcess();
            $mountHash = \Security\Hash::toSha1($applicationPostProccess);

            $mountHashMd5 = \Security\Hash::toMd5($mountHash, false, true);
            $mountHashMd5 = (stringEx($mountHashMd5)->subString(0, 8) . "js" . stringEx($mountHashMd5)->subString(8));

            $packageHashPath = (\Garbage\Cache::getCachePath() . ".tmp/render/packagejs/". $mountHashMd5 . ".blob");
            if (!\File::exists($packageHashPath)) {
                $mountJS = $applicationPostProccess;
                \File::setContents($packageHashPath, $mountJS);
//                if (@function_exists("gzencode") == true)
//                    \File::setContents($packageHashPath . ".gz", @gzencode($mountJS));
            }

            return $mountHashMd5;
        }

        protected function getScriptsPackagePreKernelHash($kernelScripts)
        {
            $mountHash = "";

            $config = \Config::get();

            if ($config->front->polyfill->legacyBrowser == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/LegacyBrowser.js")->toString()) . "-");
            if ($config->front->polyfill->ecmaScript5 == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript5.js")->toString()) . "-");
            if ($config->front->polyfill->ecmaScript6 == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript6.js")->toString()) . "-");
            if ($config->front->polyfill->ecmaScript7 == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript7.js")->toString()) . "-");
            if ($config->front->polyfill->html5 == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/HTML5.js")->toString()) . "-");
            if ($config->front->polyfill->typedArray == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/TypedArray.js")->toString()) . "-");
            if ($config->front->polyfill->canvas == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Canvas.js")->toString()) . "-");
            if ($config->front->polyfill->xhr == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/XHR.js")->toString()) . "-");
            if ($config->front->polyfill->url == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/URL.js")->toString()) . "-");
            if ($config->front->polyfill->webAudio == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/WebAudio.js")->toString()) . "-");
            if ($config->front->polyfill->blob == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Blob.js")->toString()) . "-");
            if ($config->front->polyfill->web == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/WEB.js")->toString()) . "-");
            if ($config->front->polyfill->keyboard == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Keyboard.js")->toString()) . "-");
            if ($config->front->polyfill->promise == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Promise.js")->toString()) . "-");

            $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Annyang.js")->toString()) . "-");

            if ($config->front->support->validate == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Modernizr.js")->toString()) . "-");
            if ($config->front->support->render == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Twig.js")->toString()) . "-");
            if ($config->front->support->webgl == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Three.js")->toString()) . "-");
            if ($config->front->support->screenshot == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/HTML2Canvas.js")->toString()) . "-");
            if ($config->front->support->gyroscope == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Gyronorm.js")->toString()) . "-");
            if ($config->front->support->prefix == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/AutoPrefix.js")->toString()) . "-");


            $mountHash = \Security\Hash::toSha1($mountHash);
            $mountHashMd5 = \Security\Hash::toMd5($mountHash, false, true);
            $mountHashMd5 = (stringEx($mountHashMd5)->subString(0, 8) . "js" . stringEx($mountHashMd5)->subString(8));

            $packageHashPath = (\Garbage\Cache::getCachePath() . ".tmp/render/packagejs/". $mountHashMd5 . ".blob");

            if (!\File::exists($packageHashPath))
            {
                $mountJS = "";

                if ($config->front->polyfill->legacyBrowser == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib LegacyBrowser' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/LegacyBrowser.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->ecmaScript5 == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib EcmaScript5' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript5.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->ecmaScript6 == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib EcmaScript6' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript6.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->ecmaScript7 == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib EcmaScript7' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript7.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->html5 == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib HTML5' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/HTML5.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                $mountJS .= ("/* File: 'Annyang Lib' */\n\ntry {\n");
                $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Annyang.js");
                $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";

                if ($config->front->support->validate == true) {
                    $mountJS .= ("/* File: 'Modernizr Lib' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Modernizr.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->support->react == true) {
                    $mountJS .= ("/* File: 'React Lib' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/React.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";

                    $mountJS .= ("/* File: 'ReactDOM Lib' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/ReactDOM.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";

                    $mountJS .= ("/* File: 'Babel Lib' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Babel.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->typedArray == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib TypedArray' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/TypedArray.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->canvas == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib Canvas' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Canvas.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->xhr == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib XHR' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/XHR.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->url == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib URL' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/URL.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->webAudio == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib WebAudio' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/WebAudio.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->blob == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib Blob' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Blob.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->web == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib WEB' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/WEB.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->keyboard == true) {
                    $mountJS .= ("/* File: 'Polyfill Lib Keyboard' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Keyboard.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->polyfill->promise == true) {
                    $mountJS .= ("/* File: 'Promise Lib Keyboard' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Promise.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->support->render == true) {
                    $mountJS .= ("/* File: 'Twig Lib' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Twig.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->support->webgl == true) {
                    $mountJS .= ("/* File: 'Three Lib' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Three.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->support->screenshot == true) {
                    $mountJS .= ("/* File: 'HTML2Canvas Lib' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/HTML2Canvas.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->support->gyroscope == true) {
                    $mountJS .= ("/* File: 'Gyronorm Lib' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Gyronorm.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                if ($config->front->support->prefix == true) {
                    $mountJS .= ("/* File: 'AutoPrefix Lib' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/AutoPrefix.js");
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                \File::setContents($packageHashPath, $mountJS);

//                if (@function_exists("gzencode") == true)
//                    \File::setContents($packageHashPath . ".gz", @gzencode($mountJS));
            }

            return $mountHashMd5;
        }

        protected function getScriptsPackageKernelHash($kernelScripts)
        {
            $applicationPreBuild = $this->getApplicationPreBuild();

            $mountHash = "";
            foreach ($kernelScripts as $kernelScript)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/" . $kernelScript)->toString()) . "-");
            $mountHash .= \Security\Hash::toSha1($applicationPreBuild);
            $mountHash = \Security\Hash::toSha1($mountHash);

            $mountHashMd5 = \Security\Hash::toMd5($mountHash, false, true);
            $mountHashMd5 = (stringEx($mountHashMd5)->subString(0, 8) . "js" . stringEx($mountHashMd5)->subString(8));

            $packageHashPath = (\Garbage\Cache::getCachePath() . ".tmp/render/packagejs/". $mountHashMd5 . ".blob");

            if (!\File::exists($packageHashPath))
            {
                $mountJS = "";

                foreach ($kernelScripts as $kernelScript)
                {
                    $mountJS .= ("/* File: 'Internal" . "/" . $kernelScript . "' */\n\ntry {\n");
                    $mountJS .= \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/" . $kernelScript);
                    $mountJS .= "\n} catch (e) { console.error(e); }\n\n\n";
                }

                $mountJS .= $applicationPreBuild;
                \File::setContents($packageHashPath, $mountJS);

//                if (@function_exists("gzencode") == true)
//                    \File::setContents($packageHashPath . ".gz", @gzencode($mountJS));
            }

            return $mountHashMd5;
        }

        protected function getScriptsPackageHash($scripts, $kernelScripts, $applicationScripts, $applicationComponentScripts, $applicationEventScripts)
        {
            $config = \Config::get();
            $scripts = $this->downloadExternalScripts($scripts);

            foreach ($scripts as $script)
            {
                if ($script->bundle == false)
                    continue;

                if ($script->scriptFileURL == null && $script->scriptURL != null) {
                    $scriptFileURL = (CLIENT_FOLDER . "Public/" . $script->scriptURL);
                    if (\File::exists($scriptFileURL))
                        $script->scriptFileURL = $scriptFileURL;
                    elseif (stringEx($script->scriptURL)->startsWith($config->front->base))
                    {
                        $scriptFileURL = stringEx($script->scriptURL)->subString(stringEx($config->front->base)->count);
                        $scriptFileURL = (CLIENT_FOLDER . "Public/" . $scriptFileURL);

                        if (\File::exists($scriptFileURL))
                            $script->scriptFileURL = $scriptFileURL;
                    }
                }

                if ($script->scriptFileURL != null)
                    $script->scriptHashURL = \Security\Hash::toSha1(\File::getLastModifiedDateTimeEx($script->scriptFileURL)->toString());
                elseif ($script->scriptBody != null)
                    $script->scriptHashURL = \Security\Hash::toSha1($script->scriptBody);
            }

            $mountHash = "";
            foreach ($scripts as $script)
                if ($script->scriptHashURL != null && $script->bundle == true)
                    $mountHash .= ($script->scriptHashURL . "-" . (($script->minify == true) ? "true" : "false") . "-");
            foreach ($kernelScripts as $kernelScript)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/" . $kernelScript)->toString()) . "-");
            foreach ($applicationScripts as $applicationScript)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(CLIENT_FOLDER . "Controller/" . $applicationScript)->toString()) . "-");
            foreach ($applicationComponentScripts as $applicationComponentScript)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(CLIENT_FOLDER . "Component/" . $applicationComponentScript)->toString()) . "-");
            foreach ($applicationEventScripts as $applicationEventScript)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(CLIENT_FOLDER . "Event/" . $applicationEventScript)->toString()) . "-");

            if ($config->front->polyfill->legacyBrowser == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/LegacyBrowser.js")->toString()) . "-");
            if ($config->front->polyfill->ecmaScript5 == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript5.js")->toString()) . "-");
            if ($config->front->polyfill->ecmaScript6 == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript6.js")->toString()) . "-");
            if ($config->front->polyfill->ecmaScript7 == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript7.js")->toString()) . "-");
            if ($config->front->polyfill->html5 == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/HTML5.js")->toString()) . "-");
            if ($config->front->polyfill->typedArray == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/TypedArray.js")->toString()) . "-");
            if ($config->front->polyfill->canvas == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Canvas.js")->toString()) . "-");
            if ($config->front->polyfill->xhr == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/XHR.js")->toString()) . "-");
            if ($config->front->polyfill->url == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/URL.js")->toString()) . "-");
            if ($config->front->polyfill->webAudio == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/WebAudio.js")->toString()) . "-");
            if ($config->front->polyfill->blob == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Blob.js")->toString()) . "-");
            if ($config->front->polyfill->web == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/WEB.js")->toString()) . "-");
            if ($config->front->polyfill->keyboard == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Keyboard.js")->toString()) . "-");
            if ($config->front->polyfill->promise == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Promise.js")->toString()) . "-");

            $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Annyang.js")->toString()) . "-");

            if ($config->front->support->validate == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Modernizr.js")->toString()) . "-");
            if ($config->front->support->render == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Twig.js")->toString()) . "-");
            if ($config->front->support->webgl == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Three.js")->toString()) . "-");
            if ($config->front->support->screenshot == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/HTML2Canvas.js")->toString()) . "-");
            if ($config->front->support->gyroscope == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Gyronorm.js")->toString()) . "-");
            if ($config->front->support->prefix == true)
                $mountHash .= (\Security\Hash::toSha1(\File::getLastModifiedDateTimeEx(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/AutoPrefix.js")->toString()) . "-");

            $mountHash .= (\Security\Hash::toSha1(self::getApplicationPreBuild()) . "-");
            $mountHash .= (\Security\Hash::toSha1(self::getApplicationPostProcess()) . "-");
            $mountHash .= (($config->front->assets->js->minify == true) ? "true" : "false");

            $mountHash = \Security\Hash::toSha1($mountHash);

            $mountHashMd5 = \Security\Hash::toMd5($mountHash, false, true);
            $mountHashMd5 = (stringEx($mountHashMd5)->subString(0, 8) . "js" . stringEx($mountHashMd5)->subString(8));

            $packageHashPath = (\Garbage\Cache::getCachePath() . ".tmp/render/packagejs/". $mountHashMd5 . ".blob");

            if (!\File::exists($packageHashPath))
            {
                $mountJS = "";

                if ($config->front->polyfill->legacyBrowser == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/LegacyBrowser.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->ecmaScript5 == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript5.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->ecmaScript6 == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript6.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->ecmaScript7 == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/EcmaScript7.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->html5 == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/HTML5.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->typedArray == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/TypedArray.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->canvas == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Canvas.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->xhr == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/XHR.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->url == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/URL.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->webAudio == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/WebAudio.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->blob == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Blob.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->web == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/WEB.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->keyboard == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Keyboard.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->polyfill->promise == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Polyfill/Promise.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }

                $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Annyang.js");
                if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData);
                $mountJS .= $_fileData;

                if ($config->front->support->validate == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Modernizr.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->support->render == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Twig.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->support->webgl == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Three.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->support->screenshot == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/HTML2Canvas.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->support->gyroscope == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/Gyronorm.js");
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                if ($config->front->support->prefix == true) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/External/Support/AutoPrefix.js");
                    $mountJS .= $_fileData; // Cant minimize
                }

                // Common scripts
                foreach ($scripts as $script) {
                    if ($script->scriptFileURL != null) {
                        $_fileData = ("try {\n" . \File::getContents($script->scriptFileURL) . "\n} catch (e) { console.error(e); }");
                        if ($script->minify == true && $config->front->assets->js->minify == true)
                            $_fileData = Front\Minify\JS::toMinified($_fileData);
                        $mountJS .= $_fileData;
                    }
                    elseif ($script->scriptBody != null) {
                        $_fileData = ("try {\n" . $script->scriptBody  . "\n} catch (e) { console.error(e); }");
                        if ($script->minify == true && $config->front->assets->js->minify == true)
                            $_fileData = Front\Minify\JS::toMinified($_fileData);
                        $mountJS .= $_fileData;
                    }
                }
                
                // Kernel scripts
                foreach ($kernelScripts as $kernelScript) {
                    $_fileData = \File::getContents(__KRUPA_PATH_LIBRARY__ . "KrupaBOX/" . $kernelScript);
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }

                // Kernel scripts

                $_fileData = self::getApplicationPreBuild();
                if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData);
                $mountJS .= $_fileData;
                
                foreach ($applicationScripts as $applicationScript) {
                    $_fileData = self::getApplicationFileCompiled($applicationScript);
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                foreach ($applicationComponentScripts as $applicationComponentScript) {
                    $_fileData = self::getApplicationComponentFileCompiled($applicationComponentScript);
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }
                foreach ($applicationEventScripts as $applicationEventScript) {
                    $_fileData = self::getApplicationEventFileCompiled($applicationEventScript);
                    if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData); $mountJS .= $_fileData;
                }

                $_fileData = self::getApplicationPostProcess();
                if ($config->front->assets->js->minify == true) $_fileData = Front\Minify\JS::toMinified($_fileData);
                $mountJS .= $_fileData;

                \File::setContents($packageHashPath, $mountJS);
//                if (function_exists("gzencode")) // For GZIP output later
//                    \File::setContents($packageHashPath . ".gz", @gzencode($mountJS));
            }

            return $mountHashMd5;
        }

        protected function downloadExternalScripts($scripts)
        {
            foreach ($scripts as $script)
            {
                if ($script->scriptURL == null)
                    continue;

                $indexOfExternal = strpos($script->scriptURL, "http://");
                if ($indexOfExternal === false || $indexOfExternal !== 0)
                    $indexOfExternal = strpos($script->scriptURL, "https://");
                if ($indexOfExternal === false || $indexOfExternal !== 0)
                    $indexOfExternal = strpos($script->scriptURL, "//");
                if ($indexOfExternal === false || $indexOfExternal !== 0)
                    $indexOfExternal = strpos($script->scriptURL, "ftp://");

                if ($indexOfExternal === 0)
                {
                    if (strpos($script->scriptURL, "//") === 0)
                        $script->scriptURL = ("https:" . $script->scriptURL);

                    $script->scriptHashURL = sha1($script->scriptURL);
                    $cacheExternalFile = (\Garbage\Cache::getCachePath() . ".tmp/render/externaljs/". $script->scriptHashURL . ".js");

                    if (!\File::exists($cacheExternalFile)) {
                        $scriptData = @file_get_contents($script->scriptURL);
                        if (!empty($scriptData))
                            \File::setContents($cacheExternalFile, $scriptData);
                    }

                    $script->scriptFileURL = $cacheExternalFile;
                    $script->enabled       = true;
                }
            }

            return $scripts;
        }

        protected function getDumppedStylesheetWithRender()
        {
            return <<<STYLESHEET
            <style type="text/css">
                .kint {
                    font-size:   13px;
                    margin:      8px 0;
                    overflow-x:  auto;
                    white-space: nowrap;
                    position:    absolute;
                    width:       100%;
                    padding:     0px 10px 0px 10px;
                    z-index:     9999;
                }
            </style>
STYLESHEET;
        }
    }
}