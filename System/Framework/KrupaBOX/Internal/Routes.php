<?php

namespace KrupaBOX\Internal {

class Routes
{
    protected static $controllersPath = "";
    protected static $viewsPath = "";

    private static $route         = null;
    private static $routeFile     = null;
    private static $routeOriginal = null;
    private static $extension     = null;

    protected static function preRun()
    {
        $config = \Config::get();

        $dontExecute = KRUPABOX_DONT_EXECUTE;
        if ($dontExecute === true) return false;

        if ($config->connection->onlySecure == true) {
            $currentUrl = \Http\Url::getCurrent();
            if ($currentUrl->protocol != "https") {
                $currentUrl->protocol = "https";
                \Header::redirect($currentUrl->toUrl());
            }
        }

        self::checkDirectories();

        if ($config->connection->onlyWWW == true) {
            $currentUrl = \Http\Url::getCurrent();
            if (stringEx($currentUrl->host . "")->startsWith("www.") == false) {
                $url = $currentUrl->toUrl();
                $url = stringEx($currentUrl->toUrl())->replace($currentUrl->host . "", "www." . $currentUrl->host);
//                $currentUrl->protocol = "https";
                \Header::redirect($url);
            }
        }

        if ($config->connection->keepAlive == true)
            \Connection::keepAlive();

        // CHECK IS NEED RUN SERVICES
        $return = \KrupaBOX\Internal\CLI\Services::run();
        if ($return == STOP) return false;

        $ipAddress = \Connection::getIpAddress();
        self::onInitializeEvent();
        self::onOpenConnectionEvent($ipAddress);

//        if (\Config::get()->server->maintence == true)
//            self::onMaintenceEvent($ipAddress);
        
        //self::checkBanIpAddress($ipAddress);

        return true;
    }

    protected static function checkDirectories()
    {
        $paths = Arr([
            'app://',
            'server://',
            'config://',
            'client://',
            'public://',
            'view://',
            'cache://',
            'build://',
            'composer://',
            'config://Application',
            'server://Component',
            'server://Composer',
            'server://Controller',
            'server://Model',
            'server://Event',
            'server://Native',
            'client://Component',
            'client://Composer',
            'client://Controller',
            'client://Event',
            'composer://server',
            'composer://client',
        ]);

        foreach ($paths as $_path)
            if (\DirectoryEx::exists($_path) === false)
                \DirectoryEx::create($_path);

            $composerDefault = '{
    "name": "root/composer",
    "authors": [
        {
            "name": "Krupabox",
            "email": "contact@krupabox.io"
        },
        "config": {
            "vendor-dir": "../../.composer/server"
        }
    ],
    "require": {}
}';

        if (\File::exists('server://Composer/composer.json') === false)
            \File::setContents('server://Composer/composer.json', $composerDefault);
        if (\File::exists('client://Composer/composer.json') === false)
            \File::setContents('client://Composer/composer.json', $composerDefault);

        if (\File::exists('composer://server/autoload.php') === true)
        \Import::PHP(\File\Wrapper::parsePath('composer://server/autoload.php'));
    }

//    protected static function onMaintenceEvent($ipAddress)
//    {
//        $allowed = ($ipAddress == "127.0.0.1" || \Config::get()->server->maintenceIps->contains($ipAddress));
//
//        if (\File::exists(SERVER_FOLDER . "Event/OnMaintence.php")) {
//            \Import::PHP(SERVER_FOLDER . "Event/OnMaintence.php");
//            if (\ClassEx::exists("Application\\Server\\Event\\OnMaintence")) {
//                $instanceName = ("Application\\Server\\Event\\OnMaintence");
//                $reflector = new \ReflectionClass($instanceName);
//                if ($reflector->hasMethod("onMaintence")) {
//                    $method = $reflector->getMethod("onMaintence");
//                    if ($method->isStatic() && $method->isPublic())
//                    {
//                        if ($instanceName::onMaintence($ipAddress, $allowed) === false)
//                        {
//                            \Header::setContentType("application/json");
//                            \Header::sendHeader();
//                            echo \Serialize\Json::encode([error => "UNDER_MAINTENCE", message => "This website is under maintence."]); \KrupaBOX\Internal\Kernel::exit();
//                        } else return;
//                    }
//
//                }
//            }
//        }
//
//        // Case not "OnMaintence" file, use built-in filter
//        if ($allowed == true) return;
//        echo \Serialize\Json::encode([error => "UNDER_MAINTENCE", message => "This website is under maintence."]); \KrupaBOX\Internal\Kernel::exit();
//    }

    protected static function onOpenConnectionEvent($ipAddress) {
        if (\File::exists(SERVER_FOLDER . "Event/OnConnection.php")) {
            \Import::PHP(SERVER_FOLDER . "Event/OnConnection.php");
            if (\ClassEx::exists("Application\\Server\\Event\\OnConnection")) {
                $instanceName = ("Application\\Server\\Event\\OnConnection");
                $reflector = new \ReflectionClass($instanceName);
                if ($reflector->hasMethod("onConnection")) {
                    $method = $reflector->getMethod("onConnection");
                    if ($method->isStatic() && $method->isPublic())
                        if ($instanceName::onConnection($ipAddress) === false)
                        {
                            \Header::setContentType("application/json");
                            \Header::sendHeader();
                            echo \Serialize\Json::encode([error => "INTERNAL_SERVER_ERROR", message => "Please, contact an administrator."]); \KrupaBOX\Internal\Kernel::exit();
                        }
                }
            }
        }
    }

    protected static function onInitializeEvent()
    {
        if (\File::exists(SERVER_FOLDER . "Event/OnInitialize.php")) {
            \Import::PHP(SERVER_FOLDER . "Event/OnInitialize.php");
            if (\ClassEx::exists("Application\\Server\\Event\\OnInitialize")) {
                $instanceName = ("Application\\Server\\Event\\OnInitialize");
                $reflector = new \ReflectionClass($instanceName);
                if ($reflector->hasMethod("onInitialize")) {
                    $method = $reflector->getMethod("onInitialize");
                    if ($method->isStatic() && $method->isPublic())
                        $instanceName::onInitialize();
                }
            }
        }
    }

    protected static function checkBanIpAddress($ipAddress)
    {
        if (!stringEx($ipAddress)->isEmpty() && \Config\Bans\IpAddress::isBannedIpAddress($ipAddress)) {
            \Header::setContentType("application/json");
            \Header::sendHeader();
            echo \Serialize\Json::encode([error => "INTERNAL_SERVER_ERROR", message => "Please, contact an administrator."]); \KrupaBOX\Internal\Kernel::exit();
        }
    }

    public static function run()
    {
        if (self::preRun() == false) return null;

        self::$controllersPath = (SERVER_FOLDER . "Controller/");
        self::$viewsPath       = (CLIENT_FOLDER . "View/");

        $route = null;

        if (\Connection::isCommandLineRequest() == true)
        {
            $parameters = \System\CommandLine::getParameters(true);

            if ($parameters->containsKey(controller))
            {
                $route = stringEx($parameters->controller)->toString();
                if (!stringEx($route)->startsWith("/"))
                    $route = ("/" . $route);
                $route = stringEx($route)->replace(".", "/", false)->replace("//", "/");

                // Check if is full path controller
                if (stringEx($route)->toLower(false)->startsWith("/application/server/controller/") == false)
                    $route = ("/Application/Server/Controller" . $route);

                if (stringEx($route)->toLower(false)->startsWith("/application/server/controller/") == true)
                    $route = stringEx($route)->subString(stringEx("/application/server/controller")->count, stringEx($route)->count);

                $parameters->removeKey(0);
                $parameters->removeKey(controller);
                $parameters->removeKey(__async_hash__);

                $asyncInput = Arr([get => $parameters, post => $parameters]);

                if ($parameters->containsKey(__async_input__))
                    $asyncInput = Arr(\Serialize\Json::decode(\Security\JsonWebToken::decode($parameters->__async_input__)[0]));

                \Input::__cmd__($asyncInput);
            }
        }

        if ($route == null)
            $route = stringEx($_SERVER["REQUEST_URI"])->toString();
        $route = stringEx($route)->decode();

        self::$routeOriginal = $route;
        $route = stringEx($route)->replace("\\", "/");

        while (stringEx($route)->contains("//"))
            $route = stringEx($route)->replace("//", "/");

        if (stringEx($route)->startsWith("/"))
            $route = stringEx($route)->subString(1, stringEx($route)->length);

        // DIRECT ROUTE ACCESS
//        $routeLower = stringEx($route)->toLower();
//
//        // OPEN ADMIN PAGES
//        if ($routeLower == ".admin")
//            return self::adminPage();

        $endsWith = stringEx($route)->subString(stringEx($route)->length - 1, 1);
        if ($endsWith == "/")
            $route = stringEx($route)->subString(0, stringEx($route)->length - 1);

        // Fix subfolder path root
        $subfolderPathDiff = self::getSubfolderPathDiff();

        if ($subfolderPathDiff != null)
        {
            if (stringEx($subfolderPathDiff)->endsWith("/"))
                $subfolderPathDiff = stringEx($subfolderPathDiff)->subString(0, (stringEx($subfolderPathDiff)->count - 1));

            if (stringEx($route)->startsWith($subfolderPathDiff))
            {
                $route = stringEx($route)->subString(stringEx($subfolderPathDiff)->count, stringEx($route)->count);
                if (stringEx($route)->startsWith("/")) $route = stringEx($route)->subString(1, stringEx($route)->count);
            }
        }

        if (stringEx($route)->isEmpty() || stringEx($route)->startsWith("#") || stringEx($route)->startsWith("?"))
            $route = "index";

        $split = stringEx($route)->split("?");
        $split = \Arr($split); // TODO: remove after update
        $route = stringEx($split[0])->toString();

        $endsWith = stringEx($route)->subString(stringEx($route)->length - 1, 1);
        if ($endsWith == "/") $route = stringEx($route)->subString(0, stringEx($route)->length - 1);

        self::$routeFile = $route; // for direct link files: ex (localhost/assets/css/test.css)
        self::$extension = \File::getFileExtension($route, false);

        $split = stringEx($route)->split(".");
        $split = \Arr($split); // TODO: remove after update
        $route = stringEx($split[0])->toString();

        $customRoute = self::tryCustomRoute($route);
        if ($customRoute != false)
            $route = $customRoute;
        else
        {
            $route = stringEx($route)->replace("-", "");
            $route = stringEx($route)->replace(" ", "");
        }

        self::$route = $route;

        if (stringEx(self::$routeFile)->startsWith(".async"))
        {
            \Import::PHP(__KRUPA_PATH_INTERNAL__ . "Internal/Async/Connection.php");
            \KrupaBOX\Internal\Async\Connection::onRequest();
            \KrupaBOX\Internal\Kernel::exit();
        }

//        if (self::$route == krupabox || self::$route == robots || stringEx(self::$route)->toLower() == "admin/information/php")
//        {
//            $_route = stringEx(self::$routeOriginal)->toLower();
//            while (stringEx($_route)->startsWith("/"))
//                $_route = stringEx($_route)->subString(1);
//
//            if (stringEx($_route)->startsWith("krupabox.dtd"))
//                return self::outputDTD();
//            elseif (stringEx($_route)->startsWith("robots.txt"))
//                return self::outputRobots();
//            elseif (stringEx(self::$routeOriginal)->toLower() == "/.admin/information/php")
//                return self::outputPhpInfo();
//        }

        // Events: onRoute
        if (\File::exists(SERVER_FOLDER . "Event/OnRoute.php")) {
            \Import::PHP(SERVER_FOLDER . "Event/OnRoute.php");
            if (\ClassEx::exists("Application\\Server\\Event\\OnRoute")) {
                $instanceName = ("Application\\Server\\Event\\OnRoute");
                $reflector = new \ReflectionClass($instanceName);
                if ($reflector->hasMethod("onRoute")) {
                    $method = $reflector->getMethod("onRoute");
                    if ($method->isStatic() && $method->isPublic())
                    {
                        $return = $instanceName::onRoute($route);
                        if ($return !== true && $return !== false && $return !== null)
                        {
                            if ($return instanceOf \Router)
                            {
                                $router = $return;
                                $routeData = $router->execute();

                                if ($routeData != null)
                                {
                                    $possibleRoute = $routeData->controller;
                                    if (stringEx($possibleRoute)->startsWith("Application/Server/Controller/"))
                                        $possibleRoute = stringEx($possibleRoute)->subString(stringEx("Application/Server/Controller/")->count);

                                    \Input::injectData($routeData->parameters);
                                    self::$route = $possibleRoute;
                                    self::tryController();
                                    return null;
                                }
                            }
                            elseif (!stringEx($return)->isEmpty())
                                self::$route = $return;
                        }

                    }
                }
            }
        }

        //self::tryPhpMyAdmin(self::$route);
        self::tryController();
    }

    protected static function tryPhpMyAdmin($route)
    {
        $config = \Config::get();
        $current = \Http\Url::getCurrent();
        $currentSubdomain = stringEx($current->subdomain)->toLower();

        if (($currentSubdomain == $config->admin->mysqlSubdomain || stringEx($currentSubdomain)->startsWith($config->admin->mysqlSubdomain . ".")) == false)
            return null;

        $basePath = (__KRUPA_PATH_LIBRARY__ . "PhpMyAdmin/");
        define("PHPMYADMIN_BASEPATH", $basePath);

        $filePhpPath = (PHPMYADMIN_BASEPATH . $route . ".php");

        if (\File::exists($filePhpPath))
        { \Import::PHP($filePhpPath); \KrupaBOX\Internal\Kernel::exit(); }

        \KrupaBOX\Internal\Kernel::exit();
    }

    protected static function outputPhpInfo()
    {
        \Header::setContentType("text/html");
        \Header::sendHeader();

        \phpInfo();
        \KrupaBOX\Internal\Kernel::exit();
    }
    protected static function outputDTD()
    {
        $doctypePath = (__KRUPA_PATH_INTERNAL__ . "Internal/Compilation/doctype.dtd");

        \Header::setContentType("application/xml-dtd");
        \Header::sendHeader();

        if (\File::exists($doctypePath)) {
            $doctypeContent = \File::getContents($doctypePath);
            echo $doctypeContent;
        }
        \KrupaBOX\Internal\Kernel::exit();
    }

    protected static function outputRobots()
    {
        \KrupaBOX\Internal\Kernel::exit();
    }

    public static function getRoute()
    { return stringEx(self::$route)->toString(); }

    public static function getRouteOriginal()
    { return stringEx(self::$routeOriginal)->toString(); }

    protected static function tryCustomRoute($route)
    {
        return false;
    }

    protected static function tryController()
    {
        $possiblePath = (self::$controllersPath . self::$route . ".php");

        if (!\File::exists($possiblePath))
        { self::tryControllerCaseInsensitive(); return; }

        self::loadController($possiblePath);
        \KrupaBOX\Internal\Kernel::exit();
    }

    protected static function tryControllerCaseInsensitive()
    {
        self::onError(PAGE_DOES_NOT_EXIST);
    } // TODO: get fileSystem real name/check with locase

    protected static function tryDirectHtmlRender()
    {
        $possiblePath = self::$viewsPath . self::$route; //multiple extensions
        $extension    = null;
/*
        echo $possiblePath;
        //$possiblePath = "/var/www/html/Application/Client/View/Index";

        echo "<br>----------------------------------";
        echo "<br>";
        echo $possiblePath . ".html";
        echo "<br>";
        echo \File::getRealPath($possiblePath . ".html");
        echo "<br>";
        echo \File::getRealPath("/var/www/html/Application/Client/View/Index.html");
        echo "<br>";
        echo "------------------------------------------<br>";*/

        if (\File::exists($possiblePath . ".html", true))
            $extension = html;
        elseif (\File::exists($possiblePath . ".htm", true))
            $extension = htm;
        elseif (\File::exists($possiblePath . ".xhtml", true))
            $extension = xhtml;

        if ($extension == null)
        return false;

        $htmlNamespace = stringEx(self::$route)->replace("/", ".");
        $front = new \Render\Front();
        $front->addView(\Render\Front\View::fromNamespace($htmlNamespace));

        $htmlRender = $front->toHTML(\Config::get()->server->environment == release);
        \Connection\Output::execute("<!DOCTYPE html>\n" . $htmlRender, "text/html");

        return true;
    }

    protected static function tryDirectFileRender()
    {
        // Case SSL certificate registration
        if (stringEx(self::$routeFile)->startsWith(".well-known/acme-challenge")) {
            $fixRouteInjection = stringEx(self::$routeFile)->replace("..", "");
            $fixRouteInjection = stringEx($fixRouteInjection)->replace(",", "");
            $certFile = stringEx($fixRouteInjection)->subString(27);
            $certChallengePath = \File::getContents("cache://.certificate/challenge/" . $certFile);
            \Header::setContentType("text/plain");
            echo $certChallengePath; \KrupaBOX\Internal\Kernel::exit();
        }

        // Blob
        if (stringEx(self::$routeFile)->count == 36 && stringEx(self::$routeFile)->remove("-", false)->count == 32) {
            $blob = \Blob::fromPublicUrl("blob://" . self::$routeFile);
            if ($blob != null) $blob->output();
        }

        if (stringEx(self::$routeFile)->count == 38 && stringEx(self::$routeFile)->remove("-", false)->count == 34) {
            $getInternalCode = stringEx(self::$routeFile)->subString(8, 2);
            $isScripts = ($getInternalCode == "js");
            $isBundle  = ($getInternalCode == "bc");

            $bufferData = "";

            if ($isBundle == true)
            {
                $packageHashPath = (\Garbage\Cache::getCachePath() . ".tmp/render/bundlecss/". self::$routeFile . ".blob");

                \Header::setContentType("text/css");
                \Header::setCache(60 * 60 * 24 * 30);

                if (\File::exists($packageHashPath)) {
                    if (\Dumpper::isPageDumped() == false)
                        \Header::sendHeader();
                    \File::output($packageHashPath); \KrupaBOX\Internal\Kernel::exit(); // Fast output mode
                }
            }
            else if (stringEx(self::$routeFile)->isEmpty() == false)
            {
                $packageHashPath = (\Garbage\Cache::getCachePath() . ".tmp/render/" .
                    (($isScripts == true) ? "packagejs" : "packagecss") . "/". self::$routeFile .
                    ".blob"
                );

//                $canGzip = (\Config::get()->output->gzip == true && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && stripos($_SERVER['HTTP_ACCEPT_ENCODING'], "gzip") !== false);
//                if ($canGzip == true && (\Dumpper::isPageDumped() == true || \File::exists($packageHashPath . ".gz") == false)) $canGzip = false;

                \Header::setContentType(($isScripts == true) ? "text/javascript" : "text/css");
                \Header::setCache(60 * 60 * 24 * 30);

//                if ($canGzip) {
//                    \Header::setContentEncoding("gzip");
//                    \Header::sendHeader();
//                    \File::output($packageHashPath . ".gz"); exit; // Fast output mode
//                }

                if (\File::exists($packageHashPath)) {
                    if (\Dumpper::isPageDumped() == false)
                        \Header::sendHeader();
                    \File::output($packageHashPath); \KrupaBOX\Internal\Kernel::exit(); // Fast output mode
                }
            }

            \Connection\Output::execute($bufferData,  (($isScripts == true) ? "text/javascript" : "text/css"), null, true, 60 * 60 * 24 * 30);
            return true;
        }

        if (stringEx(self::$routeFile)->startsWith(".compiled/") && (stringEx(self::$routeFile)->endsWith(".js") || stringEx(self::$routeFile)->endsWith(".css")))
        {
            $isScripts = stringEx(self::$routeFile)->endsWith(".js");

            $hash = stringEx(self::$routeFile)->subString(10);
            $hash = stringEx($hash)->subString(0, stringEx($hash)->count - (($isScripts == true) ?  3 : 4));

            $bufferData = "";
            if (stringEx($hash)->isEmpty() == false) {
                $packageHashPath = (\Garbage\Cache::getCachePath() . ".tmp/render/" .
                    (($isScripts == true) ? "packagejs" : "packagecss") . "/". $hash .
                    (($isScripts == true) ? ".js" : ".css")
                );

//                $canGzip = (\Config::get()->output->gzip == true && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && stripos($_SERVER['HTTP_ACCEPT_ENCODING'], "gzip") !== false);
//                if ($canGzip == true && (\Dumpper::isPageDumped() == true || \File::exists($packageHashPath . ".gz") == false)) $canGzip = false;

                \Header::setContentType(($isScripts == true) ? "text/javascript" : "text/css");
                \Header::setCache(60 * 60 * 24 * 30);

//                if ($canGzip) {
//                    \Header::setContentEncoding("gzip");
//                    \Header::sendHeader();
//                    \File::output($packageHashPath . ".gz"); exit; // Fast output mode
//                }

                if (\File::exists($packageHashPath)) {
                    if (\Dumpper::isPageDumped() == false)
                        \Header::sendHeader();
                    \File::output($packageHashPath); \KrupaBOX\Internal\Kernel::exit(); // Fast output mode
                }
            }

            \Connection\Output::execute($bufferData,  (($isScripts == true) ? "text/javascript" : "text/css"), null, true, 60 * 60 * 24 * 30);
            return true;
        }

        // Compile scripts
        $compiledPhpJsRouteFile = null;

        // If is direct file
        $realFilePath = \File::getRealPath(CLIENT_FOLDER . self::$routeFile, true);

        // If is public direct file
        if ($realFilePath == null)
        {
            $realFilePath = \File::getRealPath(CLIENT_FOLDER . "Public/" . self::$routeFile, true);

            // If is a single PHP, instantiate it
            if ($realFilePath != null && stringEx($realFilePath)->endsWith(".php"))
            { \Import::PHP($realFilePath); return true; }

            // if is a single LESS, compile it
            $possibleRenderCSS = false;
            $requestHeaders = \Connection::getRequestHeaders();
            if ($requestHeaders->containsKey("Accept") && stringEx($requestHeaders["Accept"])->contains("text/css"))
                $possibleRenderCSS = true;
            elseif ($requestHeaders->containsKey("accept") && stringEx($requestHeaders["accept"])->contains("text/css"))
                $possibleRenderCSS = true;
            elseif (\Input::get([compile => bool])->compile == true)
                $possibleRenderCSS = true;

            if ($realFilePath != null && $possibleRenderCSS == true) //    (stringEx($realFilePath)->endsWith(".less") || stringEx($realFilePath)->endsWith(".sass") || stringEx($realFilePath)->endsWith(".scss")))//  && \Input::get([compile => bool])->compile !== false)
            {
                if (stringEx($realFilePath)->endsWith(".less")) {
                    $less = \Less::fromFilePath($realFilePath);
                    $less->render();
                } elseif (stringEx($realFilePath)->endsWith(".scss")) {
                    $scss = \Scss::fromFilePath($realFilePath);
                    $scss->render();
                }
            }
        }

        // If is public direct folder (with index.html/php/etc inside)
        if ($realFilePath == null || \File::exists($realFilePath) == false || \DirectoryEx::isDirectory($realFilePath))
        {
            $_realFilePath = ($realFilePath . "/index.");

            $validIndexExtensions = Arr([php, html, txt, json, js, css, xml, jpg, png, bmp, mp4, htm, xhtml]);

            foreach ($validIndexExtensions as $validIndexExtension)
                if (\File::exists($_realFilePath . $validIndexExtension))
                { $realFilePath = ($_realFilePath . $validIndexExtension); break; }

            // Redirect to correct uri
            if (stringEx($realFilePath)->endsWith(".html") || stringEx($realFilePath)->endsWith(".php") || stringEx($realFilePath)->endsWith(".htm") || stringEx($realFilePath)->endsWith(".xhtml"))
            {
                $requestUriCheck = stringEx($_SERVER["REQUEST_URI"])->split("?")[0];
                if (!stringEx($requestUriCheck)->endsWith("/"))
                    \Header::redirect($requestUriCheck . "/");
            }

            // If is a single PHP, instantiate it
            if ($realFilePath != null && stringEx($realFilePath)->endsWith(".php"))
            { \Import::PHP($realFilePath); return true; }
        }

        // If is JS to PHP Transpiler
        if ($realFilePath == null && (stringEx(CLIENT_FOLDER . self::$routeFile)->startsWith(CLIENT_FOLDER . "Controller") ||
            stringEx(CLIENT_FOLDER . self::$routeFile)->startsWith(CLIENT_FOLDER . "Component") ||
            stringEx(CLIENT_FOLDER . self::$routeFile)->startsWith(CLIENT_FOLDER . "Event")
            ) && stringEx(self::$routeFile)->endsWith(".js"))
        {
            $compiledPhpJsRouteFile = (stringEx(self::$routeFile)->subString(0, stringEx(self::$routeFile)->length - 3) . ".php");
            $realFilePath = \File::getRealPath(CLIENT_FOLDER . $compiledPhpJsRouteFile, true);
        }


        if ($realFilePath != null && stringEx($realFilePath)->startsWith(CLIENT_FOLDER) && \File::exists($realFilePath))
        {
            if ((stringEx($realFilePath)->startsWith(CLIENT_FOLDER . "Controller") ||
                stringEx($realFilePath)->startsWith(CLIENT_FOLDER . "Component")) && stringEx($realFilePath)->endsWith(".php") ||
                stringEx($realFilePath)->startsWith(CLIENT_FOLDER . "Event") && stringEx($realFilePath)->endsWith(".php"))
            {
                $compiledData = null;

                if (stringEx($realFilePath)->startsWith(CLIENT_FOLDER . "Controller"))
                {
                    $compiledPhpJsRouteFile = stringEx($compiledPhpJsRouteFile)->subString(11, stringEx($compiledPhpJsRouteFile)->length);
                    $compiledData = ("try {\n" . \Render\Front::getApplicationFileCompiled($compiledPhpJsRouteFile) . "\n} catch (e) { console.error(e); }");
                }
                elseif (stringEx($realFilePath)->startsWith(CLIENT_FOLDER . "Component"))
                {
                    $compiledPhpJsRouteFile = stringEx($compiledPhpJsRouteFile)->subString(10, stringEx($compiledPhpJsRouteFile)->length);
                    $compiledData = ("try {\n" . \Render\Front::getApplicationComponentFileCompiled($compiledPhpJsRouteFile) . "\n} catch (e) { console.error(e); }");
                }
                elseif (stringEx($realFilePath)->startsWith(CLIENT_FOLDER . "Event"))
                {
                    $compiledPhpJsRouteFile = stringEx($compiledPhpJsRouteFile)->subString(6, stringEx($compiledPhpJsRouteFile)->length);
                    $compiledData = ("try {\n" . \Render\Front::getApplicationEventFileCompiled($compiledPhpJsRouteFile) . "\n} catch (e) { console.error(e); }");
                }

                \Connection\Output::execute($compiledData, "text/javascript", null, true, 60 * 60 * 24 * 30);
            }

            $lastExtension = \File::getFileExtension($realFilePath, true);
            \Header::setCache(60 * 60 * 24 * 30);
            \Header::setContentTypeByExtension($lastExtension);
            \Header::sendHeader();

            // File output by chunks
            \File::output($realFilePath); \KrupaBOX\Internal\Kernel::exit();
        }

        return false;
    }

    protected static function loadController($controllerPath)
    {
        //exit;

        $route = stringEx($controllerPath)->subString(stringEx(self::$controllersPath)->length, stringEx($controllerPath)->length); //get only modified route
        if (stringEx($route)->endsWith(".php")) $route = stringEx($route)->subString(0, stringEx($route)->length - 4);

        $namespace = "";
        $class = "";

        if (stringEx($route)->contains("/"))
        {
            $split = stringEx($route)->split("/");

            //$class = stringEx($route)->subString(stringEx($namespace)->length + 1, stringEx($route)->length);

            foreach ($split as $_split)
                if ($_split != $split[($split->count - 1)])
                    $namespace .= "/" . $_split; // . (($split->count >- 2 && $_split != $split[($split->count - 2)]) ? "/" : "");

            $class = $split[($split->count - 1)];

        } else $class = $route;

        $namespace = ("Application/Server/Controller" . $namespace);
        $namespace = stringEx($namespace)->replace("/", "\\");

        $fileData = \File::getContents($controllerPath);
        $splitNamespace = stringEx($fileData)->split("namespace");



        foreach ($splitNamespace as $namespaceData)
        {
            if ($namespaceData == $splitNamespace[0])
                continue;


            $indexOfPoint = stringEx($namespaceData)->indexOf(";");
            $indexOfKey = stringEx($namespaceData)->indexOf("{");

            $splitInsideNamespace = stringEx($namespaceData)->split(($indexOfPoint != null && $indexOfPoint < $indexOfKey) ? ";" : "{");
            $extractNamespace = stringEx($splitInsideNamespace[0])->removeSpaces();

            if (stringEx($extractNamespace)->toLower() == stringEx($namespace)->toLower())
            {
                $splitClass = stringEx($fileData)->split("class");

                foreach ($splitClass as $classData)
                {
                    if ($classData == $splitClass[0])
                        continue;

                    $splitInsideClass = stringEx($classData)->split("{");
                    $splitInsideClassFix = stringEx($splitInsideClass[0])->split(" ");
                    $extractClass = stringEx($splitInsideClassFix[0])->removeSpaces();

                    if (stringEx($extractClass)->toLower() == stringEx($class)->toLower())
                    {
                        $config = \Config::get();

//                        if ($config->compiler->controller == true)
                            \PHP\Compiler\PHP7::compileToPHP5($controllerPath, true);
//                        else \KrupaBOX\Internal\Engine::includeInsensitive($controllerPath);

                        //\KrupaBOX\Internal\Engine::includeInsensitive($controllerPath);
                        self::instantiateController($extractNamespace, $extractClass);
                        return true;
                    }
                }
            }
        }

        return self::onError(INVALID_CONTROLLER_NAMESPACE_OR_CLASS);
    }

    protected static function onError($error)
    {
        $renderType = \Input::get([__render__ => string])->__render__;
        if (stringEx($renderType)->toLower() != "krupabox.front.engine")
            $renderType = \Input::post([__render__ => string])->__render__;

        if (stringEx($renderType)->toLower() == "krupabox.front.engine")
        {
            \Header::setContentType("application/json");
            echo \Serialize\Json::encode([error => $error]);
            \KrupaBOX\Internal\Kernel::exit();
        }

        if ($error == PAGE_DOES_NOT_EXIST)
        {
            if (self::tryDirectHtmlRender() == true) return;
            if (self::tryDirectFileRender() == true) return;
        }


        if (intEx(self::$route)->toInt() == \Header::HTTP_CODE_NOT_FOUND ||
            ($error == PAGE_DOES_NOT_EXIST && \intEx(self::$route)->toInt() != \Header::HTTP_CODE_INTERNAL_SERVER_ERROR))
            self::renderError404();

        self::renderError500($error);
    }

    protected static function renderError404()
    {
        $config = \Config::get();

        $path404 = "server://Controller/404.php";
        if (\File::exists($path404))
        {
            $extractNamespace = null;
            $fileData = \File::getContents($path404);
            $splitNamespace = stringEx($fileData)->split("namespace");
            foreach ($splitNamespace as $namespaceData) {
                if ($namespaceData == $splitNamespace[0])
                    continue;

                $indexOfPoint = stringEx($namespaceData)->indexOf(";");
                $indexOfKey = stringEx($namespaceData)->indexOf("{");
                $splitInsideNamespace = stringEx($namespaceData)->split(($indexOfPoint != null && $indexOfPoint < $indexOfKey) ? ";" : "{");
                $extractNamespace = stringEx($splitInsideNamespace[0])->removeSpaces();

                $splitClass = stringEx($fileData)->split("class");
                foreach ($splitClass as $classData) {
                    if ($classData == $splitClass[0])
                        continue;

                    $splitInsideClass = stringEx($classData)->split("{");
                    $splitInsideClassFix = stringEx($splitInsideClass[0])->split(" ");
                    $extractClass = stringEx($splitInsideClassFix[0])->removeSpaces();

                    $config = \Config::get();
//                    if ($config->compiler->controller == true)
                        \PHP\Compiler\PHP7::compileToPHP5($path404, true);
//                    else \KrupaBOX\Internal\Engine::includeInsensitive($path404);

                    //\KrupaBOX\Internal\Engine::includeInsensitive($controllerPath);
                    self::instantiateController($extractNamespace, $extractClass);
                    return true;
                }
            }
        }

        $view404 = \Render\Front\View::fromPath("view://404.html");
        if ($view404 != null)
        {
            $render = new \Render\Front();
            $render->addView($view404);
            $html = $render->toHTML(($config->server->environment == release), [path => self::$route]);

            \Header::setContentType("text/html");
            \Header::setHttpCode(\Header::HTTP_CODE_NOT_FOUND);
            \Header::sendHeader();
            echo $html; \KrupaBOX\Internal\Kernel::exit();
        }

        if (\intEx(self::$route)->toInt() != \Header::HTTP_CODE_NOT_FOUND)
            \Header::redirect("/" . $config->front->base . \Header::HTTP_CODE_NOT_FOUND . "/?page=" . self::$route);

        $errorCode = \Header::HTTP_CODE_NOT_FOUND;

        \Header::setContentType("text/html");
        \Header::setHttpCode($errorCode);
        \Header::sendHeader();

        $inputPage = \Input::get([page => string])->page;
        $inputPage = (stringEx($inputPage)->isEmpty() ? " " : (" '" . $inputPage . "' "));

        echo <<<HTML
            <html>
                <head>
                    <title>{$errorCode}</title>
                </head>
                <body style="background-color: #19191B">
                    <br/><br/>
                    <p style="text-align: center; font-size:100px; color: #CBCBCC">
                        {$errorCode}
                    </p>
                    <p style="text-align: center; font-size:20px; color: #CBCBCC">
                        The page{$inputPage}does not exist.
                    </p>
                </body>
            </html>
HTML;
        \KrupaBOX\Internal\Kernel::exit();
    }

    protected static function renderError500($error)
    {
        if (\intEx(self::$route)->toInt() != \Header::HTTP_CODE_INTERNAL_SERVER_ERROR)
        {
            $friendlyError = unknown;

            if ($error == INVALID_CONTROLLER_NAMESPACE_OR_CLASS)
                $friendlyError = namespaceClass;
            elseif ($error == INVALID_CONTROLLER_EXTENDS)
                $friendlyError = controllerExtends;

            \Header::redirect("/" . self::getSubfolderPathDiff(true) . \Header::HTTP_CODE_INTERNAL_SERVER_ERROR . "/?page=" . self::$route . "&error=" . $friendlyError);
        }

        $errorCode = \Header::HTTP_CODE_INTERNAL_SERVER_ERROR;

        \Header::setContentType("text/html");
        \Header::setHttpCode($errorCode);
        \Header::sendHeader();

        $inputPage = \Input::get([page => string])->page;
        $inputPageFormated = (stringEx($inputPage)->isEmpty() ? " " : (" '" . $inputPage . "' "));

        $extraErrorInformationHTML = "";

        if (!stringEx($inputPage)->isEmpty())
        {
            $inputPageSplit = stringEx($inputPage)->replace("\\", "/", false)->split("/");

            $correctNamespace = "Application/Server/Controller/";
            $correctClass     = "";

            foreach ($inputPageSplit as $_inputPageSplit)
                if ($_inputPageSplit != $inputPageSplit[($inputPageSplit->length - 1)])
                    $correctNamespace .= ($_inputPageSplit . "/");

            if (stringEx($correctNamespace)->endsWith("/"))
                $correctNamespace = stringEx($correctNamespace)->subString(0, -1);

            $correctClass = $inputPageSplit[($inputPageSplit->length - 1)];

            $extraErrorInformationHTML = "" .
                "<br/>" .
                "<p style=\"text-align: center; font-size:16px; color: #CBCBCC\">Correct namespace</p>".
                "<p style=\"text-align: center; font-size:20px; color: #329246\">'" . $correctNamespace . "''</p>".
                "<p style=\"text-align: center; font-size:16px; color: #CBCBCC\">Correct class</p>" .
                "<p style=\"text-align: center; font-size:20px; color: #329246\">'" . $correctClass ."''</p>";
        }

        $HTML = <<<HTML
            <html>
                <head>
                    <title>{$errorCode}</title>
                </head>
                <body style="background-color: #19191B">
                    <br/><br/>
                    <p style="text-align: center; font-size:100px; color: #BB2C2C">
                        {$errorCode}
                    </p>
                    <p style="text-align: center; font-size:20px; color: #BB2C2C">
                        The page{$inputPageFormated}is invalid.
                    </p>
                    {{extraErrorInformation}}
                </body>
            </html>
HTML;

        $HTML = stringEx($HTML)->replace("{{extraErrorInformation}}", $extraErrorInformationHTML);
        echo $HTML; \KrupaBOX\Internal\Kernel::exit();
    }

    protected static function instantiateController($namespace, $class)
    {
        $instanceName = "\\" . $namespace . "\\" . $class;
        $reflector = new \ReflectionClass($instanceName);

        if ($reflector->hasMethod("__onConstructStatic"))
        {
            $method = $reflector->getMethod("__onConstructStatic");

            if ($method->isStatic() && $method->isPublic())
                $instanceName::__onConstructStatic();
        }

        /*if ($reflector->hasMethod("onRequest"))
        {
            $method = $reflector->getMethod("onRequest");

            if ($method->isStatic() && $method->isPublic())
                $instanceName::onRequest();
        }*/

        $instance = new $instanceName();

        if ($reflector->hasMethod("__onInitialize"))
        {
            $method = $reflector->getMethod("__onInitialize");

            if (!$method->isStatic() && $method->isPublic())
            { $instance->__onInitialize(); return; }
        }

        self::onError(INVALID_CONTROLLER_EXTENDS);
    }

    public static function getSubfolderPathDiff($notNull = false)
    {
        if (ROOT_SERVER_FOLDER != ROOT_FOLDER && stringEx(ROOT_SERVER_FOLDER)->count < stringEx(ROOT_FOLDER)->count)
        {
            $fixRouteNonRoot = null;

            if (stringEx(ROOT_FOLDER)->startsWith(ROOT_SERVER_FOLDER))
            {
                $fixRouteNonRoot = stringEx(ROOT_FOLDER)->subString(
                    (stringEx(ROOT_SERVER_FOLDER)->count - 1), stringEx(ROOT_FOLDER)->count);

                if (stringEx($fixRouteNonRoot)->isEmpty())
                    $fixRouteNonRoot = null;

                if ($fixRouteNonRoot != null)
                {
                    if (stringEx($fixRouteNonRoot)->startsWith("/"))
                        $fixRouteNonRoot = stringEx($fixRouteNonRoot)->subString(1, stringEx($fixRouteNonRoot)->count);
                    if (stringEx($fixRouteNonRoot)->endsWith("/"))
                        $fixRouteNonRoot = stringEx($fixRouteNonRoot)->subString(0, (stringEx($fixRouteNonRoot)->count - 1));
                }

                if (stringEx($fixRouteNonRoot)->isEmpty())
                    $fixRouteNonRoot = null;
            }

            if ($fixRouteNonRoot == null)
                return (($notNull == true) ? "" : null);

            if (!stringEx($fixRouteNonRoot)->endsWith("/"))
                $fixRouteNonRoot .= "/";
            return $fixRouteNonRoot;
        }

        return (($notNull == true) ? "" : null);
    }

    protected static function startWebSocket()
    {
        echo "I WANT START";
    }

    protected static function adminPage()
    {
        if (\Config\Admin::isValidAdmin() == false)
            \Config\Admin::promptLogin();

        \Config\Admin::renderAdminPage();
    }
}

}
