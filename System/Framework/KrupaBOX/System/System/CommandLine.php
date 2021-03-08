<?php

namespace System
{
    class CommandLine
    {
        public static function isCommandLine()
        { return \Connection::isCommandLineRequest(); }

        public static function getAsyncHashInternal()
        {
            $parameters = \System\CommandLine::getParameters(true);
            if ($parameters->containsKey(__async_hash__))
                return $parameters->__async_hash__;
            return null;
        }

        public static function getParameters($asKeyValue = false)
        {
            $server = @$_SERVER;
            if (!\Variable::get($server)->isArray())
                $server = Arr();
            else $server = Arr($_SERVER);

            $parameters = Arr();
            if ($server->containsKey("argv")) {
                $args = $server->argv;
                if (!\Variable::get($args)->isArr())
                    $parameters = Arr();
                else $parameters = Arr($args);
            }

            if ($asKeyValue == false)
                return $parameters;

            $keyValueParameters = Arr();
            foreach ($parameters as $parameter)
            {
                if (stringEx($parameter)->contains("="))
                {
                    $split = stringEx($parameter)->split("=");
                    if ($split->count <= 1)
                        $keyValueParameters->add($parameter);
                    else
                    {
                        $key   = $split[0];
                        $value = $split[1];

                        if (\Serialize\Json::isJson($value))
                            $value = \Serialize\Json::decode($value);

                        $keyValueParameters->addKey($key, $value);
                    }
                } else $keyValueParameters->add($parameter);
            }

            // Parse to real recursive array
            $dataQueryString = "";
            foreach ($keyValueParameters as $field => $_data)
                $dataQueryString .= ($field . "=" . stringEx($_data)->encode(true) . "&");
            if (stringEx($dataQueryString)->endsWith("&"))
                $dataQueryString = stringEx($dataQueryString)->subString(0, stringEx($dataQueryString)->count - 1);
            $dataParsed = [];
            parse_str($dataQueryString, $dataParsed);

            return Arr($dataParsed);
        }
    }

}