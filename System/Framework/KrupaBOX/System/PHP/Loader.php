<?php

namespace PHP
{
    class Loader
    {
        protected static $preNamespaces = [];

        protected static $onInitialize = false;
        protected static function onInitialize()
        {
            if (self::$onInitialize == true)
                return null;

            self::$preNamespaces = Arr(self::$preNamespaces);
            self::$onInitialize = true;

            spl_autoload_register(function($class) {
                return Loader::onReceiveAutoloadRequest($class);
            });
        }

        public static function autoLoader($preNamespace, $parameters, $callback = null)
        {
            self::onInitialize();
            if (\FunctionEx::isFunction($callback) == false)
                return null;
            self::$preNamespaces->addKey($preNamespace, Arr([callback => $callback, parameters => Arr($parameters)]));
        }

        protected static function onReceiveAutoloadRequest($class)
        {
            foreach (self::$preNamespaces as $preNamespace => $data)
                if (stringEx($class)->startsWith($preNamespace))
                {
                    $callback = $data->callback;
                    return $callback($class, $data->parameters);
                }

            return false;
        }

    }
}