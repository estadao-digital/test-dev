<?php

namespace KrupaBOX\Internal\Async
{
    class Connection
    {
        // Connection::getLocation()
        public static function connection_getlocation($input)
        {
            $location = \Connection::getLocation();
            if ($location == null)
                return self::error(NULL);
            $location = Arr($location->copy());
            $location->removeKey(timezone);

            return self::success($location);
        }

        // Connection::getLocation()
        public static function connection_getipaddress($input)
        {
            $ipAddress = \Connection::getIpAddress();
            if ($ipAddress == null) return self::error(NULL);
            return self::success([ipAddress => $ipAddress]);
        }









































        // ******** INTERNAL ******** //
        public static function onRequest()
        {
            $inputGet = (stringEx(\Input::get([method => string])->method)->toLower() == "get");

            $input = Arr([hash => string, action => string, param => string]);
            $input = (($inputGet == true) ? \Input::get($input) : \Input::post($input));

            if ($input->hash != \Browser::getHash())
                return self::error(INVALID_HASH);


            $instanceName = ("KrupaBOX\\Internal\\Async\\Connection");
            $reflector = new \ReflectionClass($instanceName);

            $actionParse = stringEx($input->action)->toLower(false)->replace(".", "_");
            if ($actionParse != "onrequest" && $reflector->hasMethod($actionParse))
            {
                $method = $reflector->getMethod($actionParse);
                if ($method->isStatic() && $method->isPublic())
                {
                    $param = \Serialize\Json::decode($input->param);
                    if ($param == null) $param = Arr();
                    $instanceName::$actionParse($param);
                    return self::error(INTERNAL_SERVER_ERROR);
                }
            }

            return self::error(INVALID_ACTION);
        }

        protected static function error($error)
        {
            \Header::setHttpCode(\Header::HTTP_CODE_BAD_REQUEST);
            \Header::sendHeader();

            $error = stringEx($error)->toString();
            \Connection\Output::execute(
                \Serialize\Json::encode(Arr([error => $error])),
                "application/json"
            );

            return null;
        }

        protected static function success($data)
        {
            \Connection\Output::execute(
                \Serialize\Json::encode($data),
                "application/json"
            );

            return null;
        }
    }
}

