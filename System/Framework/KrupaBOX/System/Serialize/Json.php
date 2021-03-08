<?php

namespace Serialize
{
    class Json
    {
        public static function decode($value = null, $parseArr = true)
        {
            $json = @json_decode($value);
            if ($parseArr == true)
                return Arr($json);
            return $json;
        }

        public static function isJson($value = null)
        {
            @json_decode($value);
            return (json_last_error() === JSON_ERROR_NONE);
        }

        public static function encode($value = null)
        {
            $value = [$value];
            $value = self::__encodeArrayCheck($value);
            $value = $value[0];
            return json_encode($value);
        }

        private static function __encodeArrayCheck($array)
        {
            foreach($array as &$value)
            {
                $variable = \Variable::get($value);

                if ($value == null)
                    continue;
                elseif ($variable->isDateTimeEx() || $variable->isDateTime())
                    $value = (new \DateTimeEx($value))->toString();
                elseif ($variable->isInstance())
                {
                    if ($variable->isStringEx())
                        $value = $value->toString();
                    elseif ($variable->isIntEx())
                        $value = $value->toInt();
                    elseif ($variable->isFloatEx())
                        $value = $value->toFloat();
                    elseif ($variable->isArr())
                        $value = $value->toArray();
                    elseif ($variable->isBoolEx())
                        $value = $value->toBool();
                }

                $variable = \Variable::get($value);

                if ($variable->isObject())
                    $value = (array)$value;

                if($variable->isArray())
                    $value = self::__encodeArrayCheck($value);
            }

            return $array;
        }

        public static function encodeFromXmlString($xmlString)
        {
            $xmlString = stringEx($xmlString)->trim("\r\n");
            if (stringEx($xmlString)->startsWith("<?xml"))
            {
                $indexOf = stringEx($xmlString)->indexOf("?>");
                if ($indexOf === null) $indexOf = stringEx($xmlString)->indexOf(">");
                if ($indexOf === null) return self::encode(null);

                $xmlString = stringEx($xmlString)->subString($indexOf + 2);
                $indexOfEnd = stringEx($xmlString)->indexOf("</?xml");
                if ($indexOfEnd === null) $indexOfEnd = stringEx($xmlString)->indexOf("</?");
                if ($indexOfEnd != null) $xmlString = stringEx($xmlString)->subString(0, $indexOfEnd);
            }

            $xmlString = stringEx($xmlString)->trim("\r\n");

            if (!@function_exists("simplexml_load_string"))
            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing XML extension."]); \KrupaBOX\Internal\Kernel::exit(); }

            $xml = simplexml_load_string($xmlString);
            if ($xml == false) return null;
            
            return self::encode([$xml->getName() => $xml]);
        }
    }
}