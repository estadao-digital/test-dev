<?php

class Router
{
    protected static $__isInitialized = false;
    protected static function __initialize()
    {
        if (self::$__isInitialized == true) return;
        \KrupaBOX\Internal\Library::load("AltoRouter");
        self::$__isInitialized = true;
    }

    protected $routes   = null;
    protected $preRoute = "";

    public function __construct()
    {
        self::__initialize();
        $this->routes = Arr();

//        $subfolderDiff = \KrupaBOX\Internal\Routes::getSubfolderPathDiff();
//        if ($subfolderDiff == null) return;
//        if (stringEx($subfolderDiff)->endsWith("/"))
//            $subfolderDiff = stringEx($subfolderDiff)->subString(0, stringEx($subfolderDiff)->length - 1);
//        if (!stringEx($subfolderDiff)->isEmpty())
//            $subfolderDiff = ("/" . $subfolderDiff);
//          $this->preRoute = $subfolderDiff;

        $config = \Config::get();
        $this->preRoute = $config->front->base;
    }

    public function add($route, $controller = null)
    {
        $route = ($this->preRoute . $route);
        $routeData = Arr();

        while(stringEx($route)->contains(" "))
            $route = stringEx($route)->remove(" ");

        $routeData->controller = stringEx($controller)->toString();
        if (stringEx($routeData->controller)->isEmpty())
            return null;

        $routeData->routeFormatted = $route;
        $routeData->parameters = Arr();

        $routeParsed = ("" . $route);

        while (stringEx($routeParsed)->indexOf("{{") !== false)
        {
            $initIndexOf  = stringEx($routeParsed)->indexOf("{{");
            $extract      = stringEx($routeParsed)->subString($initIndexOf + 2);
            $closeIndexOf = stringEx($extract)->indexOf("}}");

            if ($closeIndexOf === null) break;
            $extract = stringEx($extract)->subString(0, $closeIndexOf);
            if (stringEx($extract)->contains("{{") || stringEx($extract)->contains("}}"))
                break;

            $routeParsed = stringEx($routeParsed)->subString(0, $initIndexOf) .
                stringEx($routeParsed)->subString($initIndexOf + $closeIndexOf + 4);

            $routeData->parameters->add($extract);
        }

        // Case insensitive
        if ($routeData->parameters->count > 0) {
            $routeCaseInsensitive = ("" . $routeData->routeFormatted);
            for ($i = 0; $i < $routeData->parameters->count; $i++)
                $routeCaseInsensitive = stringEx($routeCaseInsensitive)->replace("{{" . $routeData->parameters[$i] . "}}", "{{%parameter" . $i . "%}}");
            $routeCaseInsensitive = stringEx($routeCaseInsensitive)->toLower();
            for ($i = 0; $i < $routeData->parameters->count; $i++)
                $routeCaseInsensitive = stringEx($routeCaseInsensitive)->replace("{{%parameter" . $i . "%}}", "{{" . $routeData->parameters[$i] . "}}");
        }
        else $routeData->routeFormatted = stringEx($routeData->routeFormatted)->toLower();

        $this->routes->add($routeData);
    }

    public function execute($callController = true)
    {
        // Mount router
        $router = new \AltoRouter();

        $paramItems = Arr();
        for ($i = 0; $i < $this->routes->count; $i++)
        {
            $route = ($this->routes[$i]);
            $routeParsed = $route->routeFormatted;

            foreach ($route->parameters as $param) {
                $paramItems->add($param);
                $routeParsed = stringEx($routeParsed)->replace(
                    "{{" . $param . "}}",
                    "[*:item" . $paramItems->count . "item]");
            }

            $router->map('GET|POST|PATCH|PUT|DELETE', $routeParsed, null, $i);
        }

        // Try get
        $match = $router->match();
        if ($match === false || $match === null)
            return null;

        $route = ($this->routes[($match[name])]);
        $parameters      = Arr();
        $matchParameters = Arr($match[params]);

        foreach ($route->parameters as $param)
        {
            $encodedItem = null;
            for ($i = 0; $i < $paramItems->count; $i++)
                if ($paramItems[$i] == $param)
                {
                    $break = false;
                    $encodedItem = ("item" . ($i + 1) . "item");

                    foreach ($matchParameters as $_paramEnc => $value)
                        if ($encodedItem == $_paramEnc) {
                            $parameters[$param] = $value;
                            $break = true;
                            break;
                        }

                    if ($break == true)
                        break;
                }
        }

        // Parse parameters values to case sensitive
        $currentUrl = \Http\Url::getCurrentUrl();
        $currentUrlLower = stringEx($currentUrl)->toLower();
        $casSensitiveParameters = Arr();

        foreach ($parameters as $key => $parameter)  {
            $valid = false;
            $indexOfInit = stringEx($currentUrlLower)->indexOf($parameter);
            if ($indexOfInit !== null) {
                $extractInit   = stringEx($currentUrl)->subString($indexOfInit);
                $extractFinish = stringEx($extractInit)->subString(0, stringEx($parameter)->count);
                if (stringEx($extractFinish)->toLower() == $parameter)
                { $casSensitiveParameters[$key] = $extractFinish; $valid = true;  }
            }
            if ($valid == false) $casSensitiveParameters[$key] = $parameter;
        }

        return Arr([
            controller => $route->controller,
            parameters => $casSensitiveParameters
        ]);
    }
}