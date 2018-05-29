<?php
/**
 * Routing Class
 *
 * PHP version 5.6
 *
 * @category Bootstrap
 * @package  FastApi
 * @author   Mario Miranda Fernandes Junior <mario.junior@aker.com.br>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
namespace FastApi\Routing;
/**
 * Routing Class
 *
 * @category  Bootstrap
 * @package   FastApi
 * @author    Mario Miranda Fernandes Junior <mario.junior@aker.com.br>
 * @copyright 2018 Mario Miranda
 * @license   mmfjunior1@gmail.com Proprietary
 * @link      www.aker.com.br
 */
class Routing
{
    /**
     * The routes added
     *
     * @var array
     */
    static $uri = [];
    /**
     * Add route 
     * 
     * @param String $uri    uri
     * @param String $method method
     * @param array  $params parameters
     * 
     * @return string $proxy
     */
    public static function add($uri, $method = "", $params = array())
    {
        self::$uri[] = array($uri,$method,$params);
    }
    /**
     * Submit the selected route
     * 
     * @return void
     */
    private static function _submit()
    {
        $requestData         = self::_getRequestData();
        $requestMethod       = $requestData['REQUEST_METHOD'];
        $getFields           = self::_getParametersRequest($requestMethod);
        $resource            = trim($requestData['REQUEST_URI'], '/').'/';
        $uriGetParam         = isset($resource) ? $resource : '/';
        $uriGetParamExplode  = explode("/", $uriGetParam);
        foreach (self::$uri as $key) {
            $key[0] = trim($key[0],'/');
            $isValidMethod       = true;
            $uri                 = trim($key[0], "/")."/";
            $uriExplode          = explode("/", $uri);
            $a = 0;
            $paramsToFuncion    = array();
            if (count($uriExplode)  != count($uriGetParamExplode)) {
                continue;
            }
            $key[0] = explode("/", $key[0]);
            $uriGetParam = explode("/", urldecode($uriGetParam));
            $indexKey = 0;
            foreach ($key[0] as $index => $value) {
                if (preg_match_all("/^{[\w\.\-\*\/\+\,\:\;\>\<\s]{1,}}$/", $value)) {
                    $pos = strpos($uriGetParam[$indexKey],'?');
                    $pos = $pos > 0 ? $pos : strlen($uriGetParam[$indexKey]);
                    $key[0][$indexKey]  = substr($uriGetParam[$indexKey],0,$pos );
                    $paramsToFuncion[]  = $key[0][$indexKey];
                }
                $indexKey++;
            }
            $key[0] = implode("/", $key[0]);
            $key[0] = strlen(trim($key[0],"/")) == 0 ? '/' : trim($key[0],"/");
            $uriGetParam = implode("/", $uriGetParam);
            if (preg_match("#^(".preg_quote($key[0],"\\").")+([\/a-zA-Z0-9\-\{\}\%\-\/\*\?\+\.\s\=]){0,}$#", urldecode($uriGetParam))) {
                foreach ($key[2] as $keyFilter => $filter) {
                    switch ($keyFilter) {
                    case 'method':
                        if (is_array($filter)) {
                            if (!in_array($requestMethod, $filter)) {
                                $isValidMethod    = false;
                            }
                            continue;
                        }
                        if (trim($filter) != $requestMethod) {
                            $isValidMethod = false;
                            continue;
                        }
                        break;
                    case 'middleware':
                        if (is_array($filter)) {
                            foreach ($filter as $middleware) {
                                $middleware         = "App\\Http\\Middleware\\".$middleware;
                                $middlewareInstance = new $middleware;
                                $middlewareInstance->run();        
                            }
                            break;
                        }
                        $middleware             = "App\\Http\\Middleware\\".$filter;
                        $middlewareInstance     = new $middleware;
                        $middlewareInstance->run();
                        break;
                    }
                }
                if ($isValidMethod) {
                    //
                    $explodMethod            = explode("@", $key[1]);
                    $controller              = "App\\Controller\\".$explodMethod[0];
                    $function                = $explodMethod[1];
                    $controllerInstance      = new $controller;
                    $controllerInstance->parametersRequest     = $getFields;

                    if (method_exists($controllerInstance, $function)) {
                        call_user_func_array(array($controllerInstance,$function), $paramsToFuncion);
                        return true;
                    }
                    throw new \Exception("Method ".$function." not found in Controller ".$explodMethod[0]);
                }
                continue;
            }
        }
        throw new \Exception('ROUTE NOT FOUND');
    }
    /**
     *  Get the  Request fields
     *
     * @param String $requestMethod Request Method
     * 
     * @return boolean false | array
     */
    private static function _getParametersRequest($requestMethod = 'GET')
    {
        switch ($requestMethod) {
        case 'GET':
            return filter_input_array(INPUT_GET);
            break;
        case 'POST':
            return filter_input_array(INPUT_POST);
            break;
        case 'PUT':
        case 'DELETE':
        case 'OPTIONS':
            parse_str(file_get_contents("php://input"), $post_vars);
            return $post_vars;
            break;
        }
        return false;
    }
    /**
     * Provide the request method
     *
     * @return array
     */
    private static function _getRequestData()
    {
        return filter_input_array(INPUT_SERVER);
    }
    /**
     * Is the bootstrap
     *
     * @return $this->_submit() | false
     */
    public static function run()
    {
        try {
            return self::_submit();
        } catch (\Exception $e) {
            return \FastApi\View\View::json(array("msg"=>'Exception error: '.  $e->getMessage(),"status" => false));
        }
    }
}
