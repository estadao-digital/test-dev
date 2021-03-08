<?php
namespace Html;

class Renderer
{
    private static $defaultStructure = <<<HTML
        <html lang="en">
            <head>
                <meta charset="UTF-8"/>
        
                <!-- INTERNAL META-TAGS -->
                <internal meta-tags/>
                
                <!-- INTERNAL STYLESHEETS -->
                <internal stylesheets/>
            </head>
            
            <body>
                <!-- INTERNAL BODY -->
                <internal body/>
                
                <!-- INTERNAL JAVASCRIPTS -->
                <internal javascripts/>
            </body>
        </html>
HTML;

    private static $defaultStylesheet = <<<CSS
        <style>
            .show
            { display: block; }
            .hide
            { display: none; }
        </style>
CSS;
    
    private static $files = [];
        
    private static $allJavaScriptsInterface = [];
    private static $allJavaScripts = [];
    private static $allStyleSheets = [];
    private static $allMetaTags = [];
    
    private $structure = "";
    private $assetUrlPrefix = "/assets/{asset}";
    
    private $body = "";
    private $bodyDiv = []; //KeyValue
    
    private $javaScriptsInterface = [];
    private $javaScripts = [];
    private $styleSheets = [];
    private $metaTags = []; // KeyValue
    
    public function __construct($autoLoad = false)
    {
        $structure = \File::getContents(APPPATH . "renderer/Structure.html");
        $structure = stringEx($structure)->toString();
        
        if ($structure != null && !stringEx($structure)->isEmpty())
            $this->structure = $structure;
        else $this->setStructureDefault();

        if ($autoLoad == true)
            $this->loadAll();
    }
    
    public function setAssetUrlPrefix($urlPrefix)
    {
        $urlPrefix = \stringEx($urlPrefix)->toString();
        
        if (!stringEx($urlPrefix)->isEmpty())
            $this->assetUrlPrefix = $urlPrefix;
    }
    
    public function setStructure($path)
    {
        $path = \stringEx($path)->toString();

        if (isset(self::$files[$path]))
        { $this->structure = self::$files[$path]; return; }
        
        $structureData = \File::getContents($path);
        $structureData = \stringEx($structureData)->toString();
        
        if (\stringEx($structureData)->isEmpty())
            return;
        
        self::$files[$path] = $structureData;
        $this->structure = self::$files[$path];
    }
    
    public function setStructureDefault()
    { $this->structure = self::$defaultStructure; }
    
    public function removeBody($removeDivs = true)
    { return $this->setBody("", $removeDivs); }
    
    public function setBody($htmlString, $removeDivs = false)
    {
        if ($removeDivs == true)
            $this->bodyDiv = [];
            
        $htmlString = stringEx($htmlString, \stringEx::ENCODING_UTF8);
        $this->body = $htmlString;
    }
    
    public function setBodyDiv($id, $view, $show = true)
    {
        $view = \stringEx($view)->toString();

        if (\stringEx($view)->endsWith(".html"))
            $view = stringEx($view)->subString(0, stringEx($view)->count - 5);
        
        $html = "";
        
        if (\File::exists(APPPATH . "views/" . $view . ".html"))
            $html = \File::getContents(APPPATH . "views/" . $view . ".html");

        $this->setBodyDivByText($id, $html, $show);    
    }
    
    public function setBodyDivByText($id, $htmlString, $show = true)
    {
        $id = stringEx($id)->toString();
        $htmlString = stringEx($htmlString, \stringEx::ENCODING_UTF8);
        $show = ($show == true) ? true : false;
        
        if (!stringEx($id)->isEmpty())
            $this->bodyDiv[$id] = [html => $htmlString, show => $show];
    }
    
    public function clearBodyDiv($id)
    { return $this->setBodyDiv($id, ""); }
    
    public function removeBodyDiv($id)
    {
        $id = stringEx($id)->toString();
        
        if (!stringEx($id)->isEmpty())
            $this->bodyDiv = \arrayk($this->bodyDiv)->removeKey($id);
    }
    
    public function addJavaScript($idOrPath)
    {
        $idOrPath = \stringEx($idOrPath)->toString();
        
        foreach ($this->javaScripts as $javaScript)
            if ($javaScript[id] == $idOrPath || $javaScript[path] == $idOrPath)
                return;
        
        $path = APPPATH . "renderer/JavaScripts.xml";
        $javaScriptsData = (isset(self::$files[$path]))
            ? self::$files[$path]
            : \File\Reader::XML($path);
            
        if (!isset(self::$files[$path]))
            self::$files[$path] = $javaScriptsData;

        if (!isset($javaScriptsData->javascripts) || !isset($javaScriptsData->javascripts->javascript))
            return;

        $javaScripts = $javaScriptsData->javascripts->javascript;
        
        foreach ($javaScripts as $javaScript)
        {
            if (!isset($javaScript->{"@attributes"}))
                continue;
                
            $javaScriptAttr = $javaScript->{"@attributes"};
            $cleanJavaScript = [id => null, path => null, autoLoad => true];

            if (isset($javaScriptAttr->id) && $javaScriptAttr->id != "")
                $cleanJavaScript[id] = $javaScriptAttr->id;
                
            if (isset($javaScriptAttr->path) && $javaScriptAttr->path != "")
                $cleanJavaScript[path] = $javaScriptAttr->path;
                
            if (isset($javaScriptAttr->autoLoad) && $javaScriptAttr->autoLoad != "")
                $cleanJavaScript[autoLoad] = \bool($javaScriptAttr->autoLoad)->toBool();
            
            if ($cleanJavaScript[path] == null || !\File::exists(APPPATH . "assets/" . $cleanJavaScript[path]) || 
                \File::getFileExtension(APPPATH . "assets/" . $cleanJavaScript[path]) != JS)
                continue;
                
            self::$allJavaScripts[] = $cleanJavaScript;
                
            if ($idOrPath == $cleanJavaScript[id] || $idOrPath == $cleanJavaScript[path])
            { $this->javaScripts[] = \arrayk($cleanJavaScript)->removeKey(autoLoad); return; }
        }
        
        if (\File::exists(__KRUPA_PATH_INTERNAL__ . "assets/" . $idOrPath) && \File::getFileExtension(__KRUPA_PATH_INTERNAL__ . "assets/" . $idOrPath) == JS)
            $this->javaScripts[] = [id => null, path => $idOrPath];
    }
    
    public function removeJavaScript($idOrPath)
    {
        $remove = null;
        $idOrPath = \stringEx($idOrPath)->toString();

        foreach ($this->javaScripts as &$javaScript)
        {
            if ($javaScript[id] == $idOrPath || $javaScript[path] == $idOrPath)
            { $remove = $javaScript; break; }
        }

        if ($remove != null)
            $this->javaScripts = \arrayk($this->javaScripts)->remove($remove);
    }
    
     public function addStyleSheet($idOrPath)
    {
        $idOrPath = \stringEx($idOrPath)->toString();
        
        foreach ($this->styleSheets as $styleSheet)
            if ($styleSheet[id] == $idOrPath || $styleSheet[path] == $idOrPath)
                return;
        
        $path = __KRUPA_PATH_INTERNAL__ . "renderer/StyleSheets.xml";
        $styleSheetsData = (isset(self::$files[$path]))
            ? self::$files[$path]
            : \File\Reader::XML($path);
            
        if (!isset(self::$files[$path]))
            self::$files[$path] = $styleSheetsData;

        if (!isset($styleSheetsData->stylesheets) || !isset($styleSheetsData->stylesheets->stylesheet))
            return;

        $styleSheets = $styleSheetsData->stylesheets->stylesheet;

        foreach ($styleSheets as $styleSheet)
        {
            if (!isset($styleSheet->{"@attributes"}))
                continue;

            $styleSheetAttr = $styleSheet->{"@attributes"};
            $cleanStyleSheet = [id => null, path => null, autoLoad => true];

            if (isset($styleSheetAttr->id) && $styleSheetAttr->id != "")
                $cleanStyleSheet[id] = $styleSheetAttr->id;
                
            if (isset($styleSheetAttr->path) && $styleSheetAttr->path != "")
                $cleanStyleSheet[path] = $styleSheetAttr->path;
                
            if (isset($styleSheetAttr->autoLoad) && $styleSheetAttr->autoLoad != "")
                $cleanStyleSheet[autoLoad] = \bool($styleSheetAttr->autoLoad)->toBool();

            if ($cleanStyleSheet[path] == null || !\File::exists(__KRUPA_PATH_INTERNAL__ . "assets/" . $cleanStyleSheet[path]) || 
                \File::getFileExtension(__KRUPA_PATH_INTERNAL__ . "assets/" . $cleanStyleSheet[path]) != CSS)
                continue;
                    
            self::$allJavaScripts[] = $cleanStyleSheet;
                
            if ($idOrPath == $cleanStyleSheet[id] || $idOrPath == $cleanStyleSheet[path])
            { $this->styleSheets[] = \arrayk($cleanStyleSheet)->removeKey(autoLoad); return; }
        }

        if (\File::exists(__KRUPA_PATH_INTERNAL__ . "assets/" . $idOrPath) && \File::getFileExtension(__KRUPA_PATH_INTERNAL__ . "assets/" . $idOrPath) == CSS)
            $this->styleSheets[] = [id => null, path => $idOrPath];
    }
    
    public function removeStyleSheet($idOrPath)
    {
        $remove = null;
        $idOrPath = \stringEx($idOrPath)->toString();

        foreach ($this->styleSheets as &$styleSheet)
        {
            if ($styleSheet[id] == $idOrPath || $styleSheet[path] == $idOrPath)
            { $remove = $styleSheet; break; }
        }

        if ($remove != null)
            $this->styleSheets = \arrayk($this->styleSheets)->remove($remove);
    }
    
    public function setMetaTag($name, $content = null)
    {
        $name    = \stringEx($name)->toString();
        $content = \stringEx($content)->toString();
        
        if (\stringEx($name)->isEmpty())
            return;
            
        if (\stringEx($content)->isEmpty())
            $content = null;
    
        $this->metaTags[$name] = $content;
    }
    
    public function removeMetaTag($name)
    { return $this->setMetaTag($name, null); }
    
    public function loadMetaTags()
    {
        $path = __KRUPA_PATH_INTERNAL__ . "renderer/MetaTags.xml";
        
        $metaTagsData = (isset(self::$files[$path]))
            ? self::$files[$path]
            : \File\Reader::XML($path);
            
        if (!isset(self::$files[$path]))
            self::$files[$path] = $metaTagsData;

        if (!isset($metaTagsData->metatags) || !isset($metaTagsData->metatags->metatag))
            return;

        $metaTags = $metaTagsData->metatags->metatag;

        foreach ($metaTags as $metaTag)
        {
            if (!isset($metaTag->{"@attributes"}))
                continue;
                
            $metaTagAttr = $metaTag->{"@attributes"};
            $cleanMetaTag = [name => null, content => null];

            if (isset($metaTagAttr->name) && $metaTagAttr->name != "")
                $cleanMetaTag[name] = $metaTagAttr->name;
                
            if (isset($metaTagAttr->content) && $metaTagAttr->content != "")
                $cleanMetaTag[content] = $metaTagAttr->content;

            self::$allMetaTags[] = $cleanMetaTag;

            if ($cleanMetaTag[name] != null)
                $this->metaTags[($cleanMetaTag[name])] = $cleanMetaTag[content];
        }
    }

    public function loadStyleSheets()
    {
        $path = __KRUPA_PATH_INTERNAL__ . "renderer/StyleSheets.xml";
        
        $styleSheetsData = (isset(self::$files[$path]))
            ? self::$files[$path]
            : \File\Reader::XML($path);
            
        if (!isset(self::$files[$path]))
            self::$files[$path] = $styleSheetsData;

        if (!isset($styleSheetsData->stylesheets) || !isset($styleSheetsData->stylesheets->stylesheet))
            return;
            
        $styleSheets = $styleSheetsData->stylesheets->stylesheet;
        
        foreach ($styleSheets as $styleSheet)
        {
            if (!isset($styleSheet->{"@attributes"}))
                continue;

            $styleSheetAttr = $styleSheet->{"@attributes"};
            $cleanStyleSheet = [id => null, path => null, autoLoad => true];

            if (isset($styleSheetAttr->id) && $styleSheetAttr->id != "")
                $cleanStyleSheet[id] = $styleSheetAttr->id;
                
            if (isset($styleSheetAttr->path) && $styleSheetAttr->path != "")
                $cleanStyleSheet[path] = $styleSheetAttr->path;
                
            if (isset($styleSheetAttr->autoLoad) && $styleSheetAttr->autoLoad != "")
                $cleanStyleSheet[autoLoad] = \bool($styleSheetAttr->autoLoad)->toBool();
            
            if ($cleanStyleSheet[path] == null || !\File::exists(__KRUPA_PATH_INTERNAL__ . "assets/" . $cleanStyleSheet[path]))
                continue;
                
            if ($cleanStyleSheet[path] == null || !\File::exists(__KRUPA_PATH_INTERNAL__ . "assets/" . $cleanStyleSheet[path]) || 
                \File::getFileExtension(__KRUPA_PATH_INTERNAL__ . "assets/" . $cleanStyleSheet[path]) != CSS)
                continue;
                
            self::$allStyleSheets[] = $cleanStyleSheet;
            
            $alreadyInserted = false;
            
            foreach ($this->styleSheets as $_styleSheet)
                if ($_styleSheet[path] == $cleanStyleSheet[path])
                { $alreadyInserted = true; break; }
                    
            if ($alreadyInserted == false && $cleanStyleSheet[autoLoad] == true)
                $this->styleSheets[] = \arrayk($cleanStyleSheet)->removeKey(autoLoad);
        }
    }
    
    public function loadJavaScripts()
    {
        $path = __KRUPA_PATH_INTERNAL__ . "renderer/JavaScripts.xml";
        
        $javaScriptsData = (isset(self::$files[$path]))
            ? self::$files[$path]
            : \File\Reader::XML($path);
            
        if (!isset(self::$files[$path]))
            self::$files[$path] = $javaScriptsData;

        if (!isset($javaScriptsData->javascripts) || !isset($javaScriptsData->javascripts->javascript))
            return;
            
        $javaScripts = $javaScriptsData->javascripts->javascript;
        
        foreach ($javaScripts as $javaScript)
        {
            if (!isset($javaScript->{"@attributes"}))
                continue;
                
            $javaScriptAttr = $javaScript->{"@attributes"};
            $cleanJavaScript = [id => null, path => null, autoLoad => true];

            if (isset($javaScriptAttr->id) && $javaScriptAttr->id != "")
                $cleanJavaScript[id] = $javaScriptAttr->id;
                
            if (isset($javaScriptAttr->path) && $javaScriptAttr->path != "")
                $cleanJavaScript[path] = $javaScriptAttr->path;
                
            if (isset($javaScriptAttr->autoLoad) && $javaScriptAttr->autoLoad != "")
                $cleanJavaScript[autoLoad] = \bool($javaScriptAttr->autoLoad)->toBool();
            
            if ($cleanJavaScript[path] == null || !\File::exists(__KRUPA_PATH_INTERNAL__ . "assets/" . $cleanJavaScript[path]))
                continue;
                
            if ($cleanJavaScript[path] == null || !\File::exists(__KRUPA_PATH_INTERNAL__ . "assets/" . $cleanJavaScript[path]) || 
                \File::getFileExtension(__KRUPA_PATH_INTERNAL__ . "assets/" . $cleanJavaScript[path]) != JS)
                continue;
                
            self::$allJavaScripts[] = $cleanJavaScript;
            
            $alreadyInserted = false;
            
            foreach ($this->javaScripts as $_javaScript)
                if ($_javaScript[path] == $cleanJavaScript[path])
                { $alreadyInserted = true; break; }
                    
            if ($alreadyInserted == false && $cleanJavaScript[autoLoad] == true)
                $this->javaScripts[] = \arrayk($cleanJavaScript)->removeKey(autoLoad);
        }
    }
    
    public function loadJavaScriptInterface()
    {
        $path = __KRUPA_PATH_INTERNAL__ . "javascripts/JavaScripts.xml";

        $javaScriptsData = (isset(self::$files[$path]))
            ? self::$files[$path]
            : \File\Reader::XML($path);
            
        if (!isset(self::$files[$path]))
            self::$files[$path] = $javaScriptsData;

        if (!isset($javaScriptsData->javascripts) || !isset($javaScriptsData->javascripts->javascript))
            return;
            
        $javaScripts = $javaScriptsData->javascripts->javascript;
        
        foreach ($javaScripts as $javaScript)
        {
            if (!isset($javaScript->{"@attributes"}))
                continue;
                
            $javaScriptAttr = $javaScript->{"@attributes"};

            $cleanJavaScript = [path => null];

            if (isset($javaScriptAttr->path) && $javaScriptAttr->path != "")
                $cleanJavaScript[path] = $javaScriptAttr->path;
                
            if ($cleanJavaScript[path] != null && stringEx($cleanJavaScript[path])->endsWith(".js"))
                $cleanJavaScript[path] = stringEx($cleanJavaScript[path])->subString(0, stringEx($cleanJavaScript[path])->length - 3);
                
            if ($cleanJavaScript[path] == null || !\File::exists(__KRUPA_PATH_INTERNAL__ . "javascripts/" . $cleanJavaScript[path] . ".js"))
                continue;
                
            if ($cleanJavaScript[path] == null || !\File::exists(__KRUPA_PATH_INTERNAL__ . "javascripts/" . $cleanJavaScript[path] . ".js") || 
                \File::getFileExtension(__KRUPA_PATH_INTERNAL__ . "javascripts/" . $cleanJavaScript[path] . ".js") != JS)
                continue;

            self::$allJavaScriptsInterface[] = $cleanJavaScript;
            
            $alreadyInserted = false;
            
            foreach ($this->javaScriptsInterface as $_javaScript)
                if ($_javaScript[path] == $cleanJavaScript[path])
                { $alreadyInserted = true; break; }
                    
            if ($alreadyInserted == false)
                $this->javaScriptsInterface[] = $cleanJavaScript;
        }
    }
    
    public function loadAll()
    {
        $this->loadMetaTags();
        $this->loadStyleSheets();
        $this->loadJavaScripts();
        //$this->loadJavaScriptInterface();
    }

    public function render($encoding)
    {
        if ($encoding == null)
            $encoding = \stringEx::ENCODING_UTF8;
            
        $body        = "";
        $metaTags    = "";
        $styleSheets = "";
        $javaScripts = "";
 
        foreach ($this->metaTags as $name => $content)
            if ($name != null && $content != null)
                $metaTags .= ((!stringEx($metaTags)->isEmpty())
                                ? "\n"
                                : ""
                             ) . 
                "<meta name=\"" . $name . "\" content=\"" . $content . "\"/>";
            
        $styleSheets = self::$defaultStylesheet . "\n";
         
        foreach ($this->styleSheets as $styleSheet)
            $styleSheets .= ((!stringEx($styleSheets)->isEmpty())
                                ? "\n"
                                : ""
                             ) .
            "<link href=\"" . (($this->assetUrlPrefix == null)
                                    ? "" // need implement base64
                                    : ((stringEx($this->assetUrlPrefix)->contains("{asset}"))
                                            ? stringEx($this->assetUrlPrefix)->replace("{asset}", $styleSheet[path])
                                            : $this->assetUrlPrefix . $styleSheet[path]
                                        )
                               ) .
            "\" rel=\"stylesheet\"/>";
            
        foreach ($this->javaScripts as $javaScript)
            $javaScripts .= ((!stringEx($javaScript)->isEmpty())
                                ? "\n"
                                : ""
                             ) .
            "<script src=\"" . (($this->assetUrlPrefix == null)
                                    ? "" // need implement base64
                                    : ((stringEx($this->assetUrlPrefix)->contains("{asset}"))
                                            ? stringEx($this->assetUrlPrefix)->replace("{asset}", $javaScript[path])
                                            : $this->assetUrlPrefix . $javaScript[path]
                                        )
                               ) .
            "\"></script>";

        $javaScripts .= ((!stringEx($javaScript)->isEmpty())
                                ? "\n"
                                : ""
                             ) .
            "<script src=\"" . (($this->assetUrlPrefix == null)
                                    ? "" // need implement base64
                                    : ((stringEx($this->assetUrlPrefix)->contains("{asset}"))
                                            ? stringEx($this->assetUrlPrefix)->replace("{asset}", "JavaScript.Aplication.js")
                                            : $this->assetUrlPrefix . "JavaScript.Aplication.js"
                                        )
                               ) .
            "\"></script>";
        
        /*
        foreach ($this->javaScriptsInterface as $javaScript)
            $javaScripts .= ((!stringEx($javaScript)->isEmpty())
                                ? "\n"
                                : ""
                             ) .
            "<script src=\"" . (($this->assetUrlPrefix == null)
                                    ? "" // need implement base64
                                    : ((stringEx($this->assetUrlPrefix)->contains("{asset}"))
                                            ? stringEx($this->assetUrlPrefix)->replace("{asset}", $javaScript[path] . ".interface.js")
                                            : $this->assetUrlPrefix . $javaScript[path] . ".interface.js"
                                        )
                               ) .
            "\"></script>";*/
            

        $body = $this->body . ((!stringEx($this->body)->isEmpty())
                                  ? "\n\n"
                                  : "");

        $bodyDivCount = 0;
        foreach ($this->bodyDiv as $id => $content)
        {
            $body .= "<div id=\"" . $id . "\" class=\"" . (($content[show] == true)
                                                                ? "show"
                                                                : "hide"
                                                        ) . "\">\n" . $content[html] . "\n</div>";
            
            if ($bodyDivCount >= \arrayk($this->bodyDiv)->count - 1)
                continue;
                
            $body .= "\n\n";
            $bodyDivCount++;
        }

        $html = "" . $this->structure;
        $html = stringEx($html)->
            replace("<internal meta-tags/>",    $metaTags, false)->
            replace("<internal stylesheets/>",  $styleSheets, false)->
            replace("<internal javascripts/>",  $javaScripts, false)->
            replace("<internal body/>",         $body);

        echo stringEx($html, $encoding); \KrupaBOX\Internal\Kernel::exit();
    }
}
    
    