<?php

class Kernel
{
    public static function error($sendHeader = true)
    {
        self::__sendHeader($sendHeader);
        
        
        
        self::__close();
    }
    
    public static function errorJson($stringError, array $parameters = null, $sendHeader = true)
    {
        //\Header::setContentType("application/json");
        //self::__sendHeader($sendHeader);

        $stringError = stringEx($stringError)->toString();

        if ($parameters != null)
            $parameters["error"] = $stringError;
        else $parameters = ["error" => $stringError];

        if (@function_exists("curl_init") == true) {
            $documentationUrl = \Http\Url::getCurrent();
            $documentationUrl->removeAllParameters();
            $documentationUrl->setParameter(documentation, "true");
            $parameters["documentation"] = $documentationUrl->toUrl();
        }

        $json = \Serialize\Json::encode($parameters);

        if (\Connection::isCommandLineRequest() && \System\CommandLine::getAsyncHashInternal() != null)
            \File::setContents("cache://.async/" . \System\CommandLine::getAsyncHashInternal() . ".blob", $json);

        \Connection\Output::execute($json, "application/json");
        //echo $json;

        self::__close();
    }
    
    public static function successJson(array $parameters = null, $sendHeader = true)
    {
       // \Header::setContentType("application/json");
       // self::__sendHeader($sendHeader);
        
        $json = \Serialize\Json::encode($parameters);

        if (\Connection::isCommandLineRequest() && \System\CommandLine::getAsyncHashInternal() != null)
            \File::setContents("cache://.async/" . \System\CommandLine::getAsyncHashInternal() . ".blob", $json);

        \Connection\Output::execute($json, "application/json");
        //echo $json;
        
        self::__close();
    }
    
    public static function close($sendHeader = true)
    {
        self::__sendHeader($sendHeader);
        self::__close();
    }
    
    private static function __sendHeader($sendHeader)
    { 
        if ($sendHeader == true)
            Header::sendHeader();
    }
    
    private static function __close()
    { die(); }
    
}