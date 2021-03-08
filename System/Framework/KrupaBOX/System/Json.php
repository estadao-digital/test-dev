<?php
//
//class Json
//{
//    protected static $CI = null;
//    protected static $defaultStringId = null;
//    protected static $cache = null;
//
//    protected static function initialize()
//    { }
//
//    protected static function getCI()
//    {
//        self::initialize();
//
//        if (self::$CI == null)
//            self::$CI = &get_instance();
//
//        return self::$CI;
//    }
//
//    public static function decode($value = null)
//    {
//        self::initialize();
//        return json_decode($value);
//    }
//
//    public static function encode($value = null)
//    {
//        self::initialize();
//
//        $value = [$value];
//        $value = self::__encodeArrayCheck($value);
//        $value = $value[0];
//        return json_encode($value);
//    }
//
//    private static function __encodeArrayCheck($array)
//    {
//        foreach($array as &$value)
//        {
//            $variable = Variable::get($value);
//
//            if ($value == null)
//                continue;
//            elseif ($variable->isDateTimeEx())
//                $value = $value->toString();
//            elseif ($variable->isInstance())
//            {
//                if ($variable->isStringEx())
//                    $value = $value->toString();
//                elseif ($variable->isIntEx())
//                    $value = $value->toInt();
//                elseif ($variable->isFloatEx())
//                    $value = $value->toFloat();
//                elseif ($variable->isArr())
//                    $value = $value->toArray();
//                elseif ($variable->isBoolEx())
//                    $value = $value->toBool();
//            }
//
//            $variable = Variable::get($value);
//
//            if ($variable->isObject())
//                $value = (array)$value;
//
//            if($variable->isArray())
//                $value = self::__encodeArrayCheck($value);
//         }
//
//         return $array;
//    }
//
//    public static function encodeFromXmlString($xmlString)
//    {
//        if (!@function_exists("simplexml_load_string"))
//        { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing XML extension."]); exit; }
//
//        $xmlString = stringEx($xmlString)->toString();
//        $xml = @simplexml_load_string($xmlString);
//        return self::encode($xml);
//    }
//}