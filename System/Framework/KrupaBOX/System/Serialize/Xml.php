<?php

namespace Serialize
{
    class Xml
    {
        protected static function parseIgnoreBlocks($value)
        {
            return stringEx($value)->
                replace("{% ignore %}", "{%ignore%}", false)->
                replace("{% ignore%}", "{%ignore%}", false)->
                replace("{%ignore %}", "{%ignore%}", false)->
                replace("{% endignore %}", "{%endignore%}", false)->
                replace("{% endignore%}", "{%endignore%}", false)->
                replace("{%endignore %}", "{%endignore%}", false)->
                replace("{%ignore%}", "<![CDATA[", false)->
                replace("{%endignore%}", "]]>");
        }

        public static function decode($value = null, $parseArr = true)
        {
            $value = self::parseIgnoreBlocks($value);
            $jsonDec = @\Serialize\Json::encodeFromXmlString($value);
            $decode = @\Serialize\Json::decode($jsonDec);
            return (($parseArr == true) ? Arr($decode) : Arr());
        }

        public static function encode($value = null)
        {
            $jsonEnc = @\Serialize\Json::encode($value);
            $jsonDec = @\Serialize\Json::decode($jsonEnc);

            return @self::encodeFromJsonDecode($jsonDec);
        }

        public static function encodeFromJsonString($jsonString)
        {
            $jsonDec = @\Serialize\Json::decode($jsonString);
            return @self::encodeFromJsonDecode($jsonDec);
        }

        protected static function encodeFromJsonDecode($jsonDecode)
        {
            $var = \Variable::get($jsonDecode);

            if (!$var->isArr() && !$var->isArray() && !$var->isObject())
            { $jsonDecode = Arr($jsonDecode); }

            $jsonDecode = (array)$jsonDecode;
            $jsonDecodeEx = Arr($jsonDecode);

            if (!@function_exists("simplexml_load_string"))
            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing XML extension."]); \KrupaBOX\Internal\Kernel::exit(); }

            $xmlData = null;
            if ($jsonDecodeEx != null && $jsonDecodeEx->count == 0)
                $xmlData = @simplexml_load_string("<data></data>");
            else
            {
                $fixedData = null;
                if ($jsonDecodeEx->count != 1)
                {
                    $xmlData = @simplexml_load_string("<data></data>");
                    $fixedData = $jsonDecode;
                }
                else {
                    $fixedData = null;

                    foreach ($jsonDecodeEx as $key => $value)
                    {
                        $xmlData = @simplexml_load_string("<" . $key . "></" . $key . ">");
                        $fixedData = $jsonDecode[$key]; break;
                    }
                }

                @self::parseDeepArrayToXml($fixedData, $xmlData);
            }

            $xmlFileString = $xmlData->asXML();
            $xmlString = stringEx($xmlFileString)->trim("\r\n");
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

            return $xmlString;
        }

        protected static function parseDeepArrayToXml($data, &$xmlData)
        {
            foreach ($data as $key => $value)
                if (is_array($value)) {
                    if (is_numeric($key)) //dealing with <0/>..<n/> issues
                        $key = 'item' . $key;

                    $subnode = $xmlData->addChild($key);
                    @self::parseDeepArrayToXml($value, $subnode);
                } else $xmlData->addChild("$key", htmlspecialchars("$value"));
        }
    }
}