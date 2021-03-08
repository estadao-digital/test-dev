<?php

class Input
{
    const TYPE_GET = "get";
    const TYPE_POST = "post";
    
    protected static $CI = null;
    protected static $cmdInput = null;

    protected static function getCI()
    {
        if (self::$CI == null)
            self::$CI = \CodeIgniter::getInstance();
        return self::$CI;      
    }

    protected static $injectedData = null;

    public static function injectData($dataArray = null)
    { self::$injectedData = Arr($dataArray); }
    
    public static function get($typeArray = null) //$index = null, $xss_clean = null, $usePhpParse = false)
    {
        $CI = self::getCI();
        if (self::$injectedData == null)
            self::$injectedData = Arr();

        if ($typeArray != null) $typeArray = \Arr($typeArray);
        if ($typeArray == null) $typeArray = Arr();;

        $inputValue = \Arr((self::$cmdInput == null) ? $CI->input->get(null, true) : self::$cmdInput->get);
        $inputValue = $inputValue->merge(self::$injectedData);

        $inputValue->setTypeByArray($typeArray, true);
        return self::parseExtendedTypes($inputValue, $typeArray);
    }
    
    public static function post($typeArray = null)
    {
        $CI = self::getCI();

        if (self::$injectedData == null)
            self::$injectedData = Arr();

        if ($typeArray != null) $typeArray = \Arr($typeArray);
        if ($typeArray == null) $typeArray = Arr();

        $inputValue = null;

        if (self::$cmdInput == null)
        {
            $requestHeaders = \Connection::getRequestHeaders();
            $contentType    = ($requestHeaders->containsKey("Content-Type") ? stringEx($requestHeaders["Content-Type"])->toLower() : null);
            $phpInput       = file_get_contents("php://input");

            // XML INPUT SUPPORT
            if (stringEx($contentType)->contains("application/xml") || stringEx($contentType)->contains("text/xml"))
            {
                $inputValue = @\Serialize\Xml::decode($phpInput);
                $inputValue = (($inputValue == null) ? Arr() : Arr($inputValue));

                if ($inputValue->count == 1 && $inputValue->containsKey(data))
                    $inputValue = $inputValue->data;
            }

            // JSON INPUT SUPPORT
            elseif (stringEx($contentType)->contains("application/json"))
            {
                $inputValue = \Serialize\Json::decode($phpInput);
                $inputValue = ($inputValue != null) ? Arr($inputValue) : Arr();
            }

            // FORM-DATA SUPPORT
            elseif (stringEx($phpInput)->contains("Content-Disposition: form-data") || stringEx($contentType)->contains("multipart/form-data"))
            {
                preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
                $boundary = null; if (count($matches) > 0) $boundary = $matches[0];

                if ($boundary == null) {
                    $boundary = stringEx($phpInput)->split("Content-Disposition: form-data");
                    $boundary = stringEx($boundary[0])->trim("\r\n");
                    while(stringEx($boundary)->startsWith("-"))
                        $boundary = stringEx($boundary)->subString(1, stringEx($boundary)->count);
                }
                $a_data = array(); $a_files = array(); $a_blocks = preg_split("/-+$boundary/", $phpInput); array_pop($a_blocks);

                foreach ($a_blocks as $id => $block) {
                    if (empty($block)) continue;
                    $isFile = stringEx($block)->contains("filename=\"");
                    if (strpos($block, 'application/octet-stream') !== FALSE)
                        preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
                    else preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
                    if ($isFile == true)  {
                        $a_files[$matches[1]] = $matches[2];
                    } else $a_data[$matches[1]] = $matches[2];
                }

                $a_dataParsed = Arr();
                foreach ($a_data as $name => $value) {
                    $nameSplit = stringEx($name)->split(".");
                    if ($nameSplit->count > 1) {
                        $name = "";
                        foreach ($nameSplit as $_nameSplit)
                            if ($_nameSplit != $nameSplit[0])  {
                                if (stringEx($_nameSplit)->contains("[")) {
                                    $conSplit = stringEx($_nameSplit)->split("[");
                                    if ($conSplit->count == 1)
                                        $name .= ("[" . $_nameSplit . "]");
                                    else {
                                        foreach ($conSplit as $_conSplit)
                                            if ($_conSplit != $conSplit[0])
                                                $name .= ("[" . $_conSplit);
                                            else $name .= ("[" . $_conSplit . "]");
                                    }
                                }  else $name .= ("[" . $_nameSplit . "]");
                            } else $name .= $_nameSplit;
                    }
                    $a_dataParsed->addKey($name, $value);
                }

                $dataQueryString = "";
                foreach ($a_dataParsed as $field => $_data)
                    $dataQueryString .= ($field . "=" . stringEx($_data)->encode(true) . "&");
                if (stringEx($dataQueryString)->endsWith("&"))
                    $dataQueryString = stringEx($dataQueryString)->subString(0, stringEx($dataQueryString)->count - 1);
                $dataParsed = [];
                parse_str($dataQueryString, $dataParsed);
                $inputValue = \Arr($dataParsed);

                if (count($a_files) > 0) $inputValue->files = Arr($a_files);
                if ($inputValue->containsKey(files))
                    foreach ($inputValue->files as $key => &$value) {
                        $contentType  = null; $contentValue = $value;
                        if (stringEx($contentValue)->startsWith("Content-Type: ")) {
                            $split = stringEx($contentValue)->split("\n");
                            $contentSplit = $split["0"];
                            $contentValue = stringEx($contentValue)->subString(stringEx($contentSplit)->count, stringEx($contentValue)->count);
                            $contentSplit = stringEx($contentSplit)->replace("Content-Type: ", "");
                            $contentSplit = stringEx($contentSplit)->trim("\r\n\t");
                            if (!stringEx($contentSplit)->isEmpty()) $contentType = $contentSplit;
                            $contentValue = stringEx($contentValue)->trim("\r\n\t");
                        }
                        $value = Arr(["Content-Type" => $contentType, "binary" => $contentValue]);
                    }
            }

            // BINARY INPUT SUPPORT
            elseif (stringEx($contentType)->contains("application/x-www-form-urlencoded") == false)
            {
                $phpInput = file_get_contents("php://input");
                if (!stringEx($phpInput)->isEmpty())
                    $inputValue = Arr([binary => $phpInput]);
            }
        }

        if ($inputValue == null) $inputValue = Arr();

        $inputValueCI = \Arr((self::$cmdInput == null) ? $CI->input->post(null, true) : self::$cmdInput->post);
        $inputValue = $inputValue->merge($inputValueCI);
        $inputValue = $inputValue->merge(self::$injectedData);

        $inputValue->setTypeByArray($typeArray, true);
        return self::parseExtendedTypes($inputValue, $typeArray);
    }

    protected static function parseExtendedTypes($inputValue, $typeArray)
    {
        foreach ($typeArray as $key => $value)
        {
            $variable = \Variable::get($value);
            if ($variable->isArr())
            { $inputValue[$key] = self::parseExtendedTypes($inputValue[$key], $typeArray[$key]); }
            else
            {
                if ($value == "File\\Image")
                    $inputValue[$key] = \File\Image::fromBase64String($value);
            }
        }

        return $inputValue;
    }

    public static function cookies($typeArray = Arr)
    { return \Input\Cookie::getAll($typeArray); }

    public static function __cmd__($input = null)
    {
        if (\Connection::isCommandLineRequest() == false)
            return null;
        self::$cmdInput = $input;
    }
}