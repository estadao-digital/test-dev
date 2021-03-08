<?php

namespace {
    
class Controller extends \BaseClass
{
    protected static $canRunAsync = null;
    protected static $asyncHashs  = null;

    public function __onInitialize()
    {
        $methodResponse = static::onInitialize();
        $responseByInitialize = ($methodResponse != null && $methodResponse != false && $methodResponse->containsKey(error));

        $inputValues = null;

        if ($responseByInitialize == false)
        {
            $method = \Connection::getRequestMethod();

            $inputValues = \Arr([
                \Connection::METHOD_GET  => \Input::get(static::onInput(\Connection::METHOD_GET)),
                \Connection::METHOD_POST => \Input::post(static::onInput(\Connection::METHOD_POST))
            ]);

            if ($method == \Connection::METHOD_GET)
                $methodResponse = static::onGet($inputValues);
            elseif ($method == \Connection::METHOD_POST)
                $methodResponse = static::onPost($inputValues);

            if ($methodResponse == null || $methodResponse == false)
                $methodResponse = static::onRequest($inputValues);
        }

        $isJson = (stringEx(\Input::get([method => string])->method)->toLower() == json);
        if ($isJson == false) $isJson = (stringEx(\Input::post([method => string])->method)->toLower() == json);

        // Check if is documentation page
        if (\Input::get([documentation => bool])->documentation == true || \Input::post([documentation => bool])->documentation == true)
        {
            $documentationData = Arr();
            $inputTemplate     = Arr(static::onInput("get"));
            $inputTemplatePost = Arr(static::onInput("post"));
            $documentationData->input = $inputTemplate->merge($inputTemplatePost);

            $onDocumentation = Arr(static::onDocumentation());
            if ($onDocumentation->containsKey(input) && !$onDocumentation->input->isEmpty())
                $documentationData->input = $onDocumentation->input;
            if ($onDocumentation->containsKey(error))
                $documentationData->error = $onDocumentation->error;

            self::_sendSuccess($documentationData);
            return null;
        }


        // Render and data
        $onRender = static::onRender($methodResponse);

        if ($onRender != null)
        {
            $arrayResponse =  null;

            if ($methodResponse == null || $methodResponse == false)
                $arrayResponse = Arr([error => EMPTY_RESPONSE]);
            elseif ($methodResponse->containsKey(error))
            {
                $arrayResponse = Arr($methodResponse->error);
                $arrayResponse->error = $arrayResponse->message;
                $arrayResponse->removeKey(message);
            }
            elseif ($methodResponse->containsKey(success))
                $arrayResponse = Arr($methodResponse->success);
        }

        if ($isJson == true)
        {
            if ($methodResponse == null || $methodResponse == false)
            {  self::_sendError(EMPTY_RESPONSE); return null; }
            elseif ($methodResponse->containsKey(error))
            {
                $error = $methodResponse->error->message;
                self::_sendError($error, $methodResponse->error->parameters);
                return null;
            }
            elseif ($methodResponse->containsKey(success))
            {
                self::_sendSuccess($methodResponse->success);
                return null;
            }
        }

        if ($onRender == true)
        {
            $onRenderType = \Variable::get($onRender)->getType();
            if ($onRenderType == object)
            {
                $name = \Instance::getName($onRender);
                if ($name == "Render\\Front")
                    return self::onRenderFront($onRender, $methodResponse);
            }

            $postRender = static::onPostProcess($onRenderType, "text/html");
            if ($postRender === null || $postRender === false)
                $postRender = $onRenderType;

            \Connection\Output::execute($postRender, "text/html");
            return null;
        }

        if ($methodResponse == null || $methodResponse == false)
        {  return null; }
        elseif ($methodResponse->containsKey(error))
        {
            $error = $methodResponse->error->message;
            self::_sendError($error, $methodResponse->error->parameters);
            return null;
        }
        elseif ($methodResponse->containsKey(success))
        {
            self::_sendSuccess($methodResponse->success);
            return null;
        }
    }

    public static function execute($input = null, $method = null)
    { return self::getResponseData($input, $method); }

    public static function getResponseData($input = null)//, $method = null)
    {
        $method = null;
        $methodResponse = null;
        $_input = null;

        if ($input == null)
            $_input = \Arr([
                \Connection::METHOD_GET  => \Input::get(static::onInput(\Connection::METHOD_GET)),
                \Connection::METHOD_POST => \Input::post(static::onInput(\Connection::METHOD_POST))
            ]);
        else $_input = \Arr([\Connection::METHOD_GET => $input, \Connection::METHOD_POST => $input]);

        if ($method == \Connection::METHOD_GET)
            $methodResponse = static::onGet($_input);
        elseif ($method == \Connection::METHOD_POST)
            $methodResponse = static::onPost($_input);

        if ($methodResponse == null || $methodResponse == false)
            $methodResponse = static::onRequest($_input);

        $methodResponse = Arr($methodResponse);

        if ($methodResponse->containsKey(error))
        {
            $_methodResponse = Arr($methodResponse->error->parameters);
            $_methodResponse->error = $methodResponse->error->message;
            $methodResponse  = $_methodResponse;
        }
        elseif ($methodResponse->containsKey(success))
        {  $methodResponse = $methodResponse->success; }

        return $methodResponse;
    }

    public static function isAsyncFinish()
    {
        if (self::$asyncHashs == null || self::$asyncHashs->count <= 0)
            return true;

        // TODO: make timeout
        foreach (self::$asyncHashs as $asyncHash => $delegate)
            if (\File::exists("cache://.async/" . $asyncHash . ".blob"))
                if (\FunctionEx::isFunction($delegate)) {
                    $delegate = (($delegate == null) ? function() {} : $delegate);
                    $data = \File::getContents("cache://.async/" . $asyncHash . ".blob");
                    @$delegate(\Serialize\Json::decode($data));
                    self::$asyncHashs->removeKey($asyncHash);
                    return null;
                }

        return false;
    }

    public static function async($input = null, $delegate = null)
    {
        if (self::$canRunAsync == null) {
            if (\System::isLinux() == true) {
                $process = @popen("php -v", "r");
                $read = @fread($process, 2096);
                @pclose($process);
                self::$canRunAsync = stringEx($read)->startsWith("PHP");
            } else self::$canRunAsync = false;
        }

        if (self::$canRunAsync == false) {
            $response = self::execute($input);
            if (\FunctionEx::isFunction($delegate)) {
                $delegate = (($delegate == null) ? function() {} : $delegate);
                @$delegate($response);
                return null;
            }
        }

        $callerClass = stringEx(@get_class(new static))->toString();
        if (stringEx($callerClass)->isEmpty()) return null;
        $callerClass = stringEx($callerClass)->replace("\\", ".");

        $_input = null;
        if ($input == null)
            $_input = \Arr([
                \Connection::METHOD_GET  => \Input::get(static::onInput(\Connection::METHOD_GET)),
                \Connection::METHOD_POST => \Input::post(static::onInput(\Connection::METHOD_POST))
            ]);
        else $_input = \Arr([\Connection::METHOD_GET => $input, \Connection::METHOD_POST => $input]);

        $processHash = \Security\Hash::toSha1($callerClass . \Time::getCurrent(true) . $_input);
        $query = \Security\JsonWebToken::encode(\Serialize\Json::encode($_input->toArray()));
        $mountProcess = ("php " . __KRUPA_PATH_ROOT__ . "index.php controller=" . $callerClass . " __async_hash__=" . $processHash . " __async_input__=" . $query . " > /dev/null 2>&1 &");
        @pclose(@popen($mountProcess, "r"));

        if (self::$asyncHashs == null)
            self::$asyncHashs = Arr();

        self::$asyncHashs[$processHash] = $delegate;
    }
//
//    protected static function addView($viewRender, $visible = false, $data = null)
//    { \Render\FrontEngine::addHTMLFromView($viewRender, $visible, $data); }

    protected static function onInitialize() {}
    
    protected static function onInput($type)       { return []; }
    protected static function onRequest($input)    { return false; }
    protected static function onGet($input)        { return false; }
    protected static function onPost($input)       { return false; }

    protected static function onPostProcess($output, $mimeType) { return null; }
    protected static function onRender($response)  { return false; }
    protected static function onRenderData($input) { return false; }

    protected static function onError($error) { return $error; }
    protected static function onSuccess($success) { return $success; }

    protected static function onDocumentation()   { return []; }

    public static function error($message, $parameters = null, $errorCode = \Header::HTTP_CODE_BAD_REQUEST)
    { return Arr([error => Arr([message => $message, parameters => (($parameters != null) ? Arr($parameters) : null)]), errorCode => intEx($errorCode)->toInt()]); }

    public static function success($values = null)
    {
        if ($values != null) $values = \Arr($values);
        return Arr([success => Arr(static::onSuccess($values))]);
    }

    protected static function _sendError($message, $parameters = null, $errorCode = \Header::HTTP_CODE_BAD_REQUEST)
    {
        if ($parameters != null) $parameters = \Arr($parameters);
        if ($parameters != null) $parameters = $parameters->toArray();

        $errorCode = intEx($errorCode)->toInt();
        if ($errorCode < 0) $errorCode = \Header::HTTP_CODE_BAD_REQUEST;

        if ($message == INTERNAL_SERVER_ERROR)
            $errorCode = \Header::HTTP_CODE_INTERNAL_SERVER_ERROR;

        \Header::setHttpCode($errorCode);
        \Kernel::errorJson($message, $parameters);
    }

    protected static function _sendSuccess($values = null)
    {
        if ($values != null) $values = \Arr($values);
        $values = $values->toArray();

        $values = self::_parseSuccess($values);
        \Kernel::successJson($values);
    }

    protected static function _parseSuccess($values)
    {
        foreach ($values as $key => &$value)
        {
            $var = \Variable::get($value);

            if ($var->isDateTimeEx($value))
                $value = $value->toString();
            elseif ($var->isDateTime())
                $value = $value->format("Y-m-d  H:i:s");
            elseif ($var->isArray())
                $value = self::_parseSuccess(Arr($value));
            elseif ($var->isArr())
                $value = self::_parseSuccess($value);
            elseif ($var->isObject())
            {
                $value = $value->toArr();
                $value = Arr(self::_parseSuccess($value));
            }
        }

        return $values;
    }

    protected static function onRenderFront($render, $data)
    {
        $dynamicData = Arr();

        if ($data != null && $data->containsKey(error))
        {
            if ($data->error->containsKey(parameters) && $data->error->parameters != null)
                foreach ($data->error->parameters as $key => $value)
                    $dynamicData[$key] = $value;

            $dynamicData->error = null;
            if ($data->error->containsKey(error))
                $dynamicData->error = $data->error->error;
        }
        if ($data != null && $data->containsKey(success) && $data->success != null)
            foreach ($data->success as $key => $value)
                $dynamicData[$key] = $value;
//
//        $renderType = \Input::get([__render__ => string])->__render__;
//        if (stringEx($renderType)->toLower() != "krupabox.front.engine")
//            $renderType = \Input::post([__render__ => string])->__render__;

//        if (stringEx($renderType)->toLower() == "krupabox.front.engine")
//        {
//            $renderLoaded = \Input::get([__renderLoaded__ => string])->__renderLoaded__;
//            if (stringEx($renderLoaded)->isEmpty())
//                $renderLoaded = \Input::post([__renderLoaded__ => string])->__renderLoaded__;
//
//            $renderLoadedArr = stringEx($renderLoaded)->split(",");
//
//            $renderData = $render->getRenderData();
//            $renderDataContent = Arr();
//
//            foreach ($renderData as $namespace => $_renderData)
//                $renderDataContent->addKey($namespace, Arr([ fixed => $_renderData->details->datas->fixed, dynamic => $dynamicData ]));
//
//            $contentData = Arr([
//                __data__  => $renderDataContent,
//                __render__ => $render->getRenderData(true, $renderLoadedArr) // include injected assets & ignore already loaded namespaces
//            ]);
//
//            $contentData = \Serialize\Json::encode($contentData);
//            $contentLength = (stringEx($contentData)->count);
//
//            \Connection\Output::execute($contentData, "application/json", $contentLength);
//            return null;
//        }

        $renderedHTML = ("<!DOCTYPE html>\n" . $render->toHTML(\Config::get()->server->environment == release, $dynamicData, true, function($postData) { return static::onRenderData($postData); }));

        $postRender = static::onPostProcess($renderedHTML, "text/html");
        if ($postRender === null || $postRender === false)
            $postRender = $renderedHTML;

        \Connection\Output::execute($postRender, "text/html");
        return null;
    }
}

}
