<?php

namespace {

class stringEx implements \ArrayAccess, \Iterator
{
    const PAD_LEFT  = STR_PAD_LEFT;
    const PAD_RIGHT = STR_PAD_RIGHT;
    const PAD_BOTH  = STR_PAD_BOTH;

    const TRUNCATE_BEFORE = "before";
    const TRUNCATE_AFTER  = "after";

    const DIRECTION_LEFT_TO_RIGHT = ">";
    const DIRECTION_RIGHT_TO_LEFT = "<";

    const ENCODING_DEFAULT = "UTF-8";
    const ENCODING_UCS4 = "UCS-4";
    const ENCODING_UCS4BE = "UCS-4BE";
    const ENCODING_UCS4LE = "UCS-4LE";
    const ENCODING_UCS2 = "UCS-2";
    const ENCODING_UCS2BE = "UCS-2BE";
    const ENCODING_UCS2LE = "UCS-2LE";
    const ENCODING_UTF32 = "UTF-32";
    const ENCODING_UTF32BE = "UTF-32BE";
    const ENCODING_UTF32LE = "UTF-32LE";
    const ENCODING_UTF16 = "UTF-16";
    const ENCODING_UTF16BE = "UTF-16BE";
    const ENCODING_UTF16LE = "UTF-16LE";
    const ENCODING_UTF7 = "UTF-7";
    const ENCODING_UTF7_IMAP = "UTF7-IMAP";
    const ENCODING_UTF8 = "UTF-8";
    const ENCODING_ASCII = "ASCII";
    const ENCODING_EUC_JP = "EUC-JP";
    const ENCODING_SJIS = "SJIS";
    const ENCODING_EUCJP_WIN = "eucJP-win";
    const ENCODING_SJIS_WIN = "SJIS-win";
    const ENCODING_ISO_2022_JP = "ISO-2022-JP";
    const ENCODING_ISO_2022_JP_MS = "ISO-2022-JP-MS";
    const ENCODING_CP932 = "CP932";
    const ENCODING_CP51932 = "CP51932";
    const ENCODING_SJIS_MAC = "SJIS-mac";
    const ENCODING_MAPJAPANESE = "SJIS-mac";
    const ENCODING_SJIS_MOBILE_DOCOMO = "SJIS-Mobile#DOCOMO";
    const ENCODING_SJIS_DOCOMO = "SJIS-Mobile#DOCOMO";
    const ENCODING_SJIS_MOBILE_KDDI = "SJIS-Mobile#KDDI";
    const ENCODING_SJIS_KDDI = "SJIS-Mobile#KDDI";
    const ENCODING_SJIS_MOBILE_SOFTBANK = "SJIS-Mobile#SOFTBANK";
    const ENCODING_SJIS_SOFTBANK = "SJIS-Mobile#SOFTBANK";
    const ENCODING_UTF8_MOBILE_DOCOMO = "UTF-8-Mobile#DOCOMO";
    const ENCODING_UTF8_DOCOMO = "UTF-8-Mobile#DOCOMO";
    const ENCODING_UTF8_MOBILE_KDDI_A = "UTF-8-Mobile#KDDI-A";
    const ENCODING_UTF8_MOBILE_KDDI_B = "UTF-8-Mobile#KDDI-B";
    const ENCODING_UTF8_KDDI = "UTF-8-Mobile#KDDI-B";
    const ENCODING_UTF8_MOBILE_SOFTBANK = "UTF-8-Mobile#SOFTBANK";
    const ENCODING_UTF8_SOFTBANK = "UTF-8-Mobile#SOFTBANK";
    const ENCODING_ISO_2022_JP_MOBILE_KDDI = "ISO-2022-JP-MOBILE#KDDI";
    const ENCODING_ISO_2022_JP_KDDI = "ISO-2022-JP-MOBILE#KDDI";
    const ENCODING_JIS = "JIS";
    const ENCODING_JIS_MS = "JIS-ms";
    const ENCODING_CP50220 = "CP50220";
    const ENCODING_CP50220RAW = "CP50220raw";
    const ENCODING_CP50221 = "CP50221";
    const ENCODING_CP50222 = "CP50222";
    const ENCODING_ISO_8859_1 = "ISO-8859-1";
    const ENCODING_ISO_8859_2 = "ISO-8859-2";
    const ENCODING_ISO_8859_3 = "ISO-8859-3";
    const ENCODING_ISO_8859_4 = "ISO-8859-4";
    const ENCODING_ISO_8859_5 = "ISO-8859-5";
    const ENCODING_ISO_8859_6 = "ISO-8859-6";
    const ENCODING_ISO_8859_7 = "ISO-8859-7";
    const ENCODING_ISO_8859_8 = "ISO-8859-8";
    const ENCODING_ISO_8859_9 = "ISO-8859-9";
    const ENCODING_ISO_8859_10 = "ISO-8859-10";
    const ENCODING_ISO_8859_13 = "ISO-8859-13";
    const ENCODING_ISO_8859_14 = "ISO-8859-14";
    const ENCODING_ISO_8859_15 = "ISO-8859-15";
    const ENCODING_BYTE2BE = "byte2be";
    const ENCODING_BYTE2LE = "byte2le";
    const ENCODING_BYTE4BE = "byte4be";
    const ENCODING_BYTE4LE = "byte4le";
    const ENCODING_BASE64 = "BASE64";
    const ENCODING_HTML_ENTITIES = "HTML-ENTITIES";
    const ENCODING_7BIT = "7bit";
    const ENCODING_8BIT = "8bit";
    const ENCODING_EUC_CN = "EUC-CN";
    const ENCODING_CP936 = "CP936";
    const ENCODING_GB18030 = "GB18030";
    const ENCODING_HZ = "HZ";
    const ENCODING_EUC_TW = "EUC-TW";
    const ENCODING_CP950 = "CP950";
    const ENCODING_BIG5 = "BIG-5";
    const ENCODING_EUC_KR = "EUC-KR";
    const ENCODING_UHC = "UHC";
    const ENCODING_CP949 = "UHC";
    const ENCODING_ISO_2022_KR = "ISO-2022-KR";
    const ENCODING_WINDOWS_1251 = "Windows-1251";
    const ENCODING_CP1251 = "Windows-1251";
    const ENCODING_WINDOWS_1252 = "Windows-1252";
    const ENCODING_CP1252 = "Windows-1252";
    const ENCODING_CP866 = "CP866";
    const ENCODING_IBM866 = "CP866";
    const ENCODING_KOI8_R = "KOI8-R";
    const ENCODING_ARMSCII_8 = "ArmSCII-8";
    const ENCODING_ARMSCII8 = "ArmSCII-8";

    const SLUG_RULESET_DEFAULT = "default";
    const SLUG_RULESET_AZERBAIJANI = "azerbaijani";
    const SLUG_RULESET_BURMESE = "burmese";
    const SLUG_RULESET_FINDI = "hindi";
    const SLUG_RULESET_NORWEGIAN = "norwegian";
    const SLUG_RULESET_VIETNAMESE = "vietnamese";
    const SLUG_RULESET_UKRAINIAN = "ukrainian";
    const SLUG_RULESET_LATVIAN = "latvian";
    const SLUG_RULESET_FINNISH = "finnish";
    const SLUG_RULESET_GREEK = "greek";
    const SLUG_RULESET_CZECH = "czech";
    const SLUG_RULESET_ARABIC = "arabic";
    const SLUG_RULESET_TURKISH = "turkish";
    const SLUG_RULESET_POLISH = "polish";
    const SLUG_RULESET_GERMAN = "german";
    const SLUG_RULESET_RUSSIAN = "russian";
    const SLUG_RULESET_ROMANIAN = "romanian";

    protected static $internalEncoding = self::ENCODING_DEFAULT;
    protected $encoding = self::ENCODING_DEFAULT;

    const VALUE = "";
    private $value = "";

    private $lastCharArrString = null;
    private $charArr           = null;

    private $iteratorPosition  = 0;
    private static $implements = null;

    protected static $isLibraryLoaded = false;
    protected static function loadLibs()
    {
        if (self::$isLibraryLoaded == true)
            return null;

        \KrupaBOX\Internal\Library::load("Ustring");
        \KrupaBOX\Internal\Library::load("ForceUTF8");
        \KrupaBOX\Internal\Library::load("Slugify");
        \KrupaBOX\Internal\Library::load("Coduo");
        self::$isLibraryLoaded = true;
    }

    public function __construct($value = null)
    {
        /*if ($usePhpParse == true && is_bool($value))
        {
            if ($value == true)
                $this->value = "true";
            elseif ($value == false)
                $this->value == "false";
        }
        else */

        if (is_object($value))
        {
            $reflector = new \ReflectionClass($value);
            if (!($reflector->hasMethod("_toString") && $reflector->getMethod("_toString")->isPublic()))
                $this->value = json_encode($value);
        }
        elseif (is_array($value))
            $this->value = json_encode($value);
        else $this->value = strval($value);
    }

    public function __get($name)
    {
        $name = stringEx($name)->toLower(true);

        if ($name == "length" || $name == "count")
        {
            $length = ($this->__isMultibyte() == true)
                ? mb_strlen($this->value, $this->getEncoding())
                : strlen($this->value);

            return intEx($length)->toInt();
        }

        return null;
    }

    public function length()
    {
        return $this->length;
    }

    protected function updateCharArr()
    {
        if ($this->lastCharArrString != $this->value)  {
            $this->lastCharArrString = $this->value;
            $this->charArr = $this->toCharArr(true);
        }
    }

    // ITERATOR
    function rewind()
    { $this->iteratorPosition = 0; }

    function current() {
        $this->updateCharArr();
        if (isset($this->charArr[$this->iteratorPosition]))
            return $this->charArr[$this->iteratorPosition];
        return null;
    }

    function key()  { return $this->iteratorPosition; }
    function next() { ++$this->iteratorPosition; }

    function valid() {
        $this->updateCharArr();
        return isset($this->charArr[$this->iteratorPosition]);
    }
    // END ITERATOR

    // ARRAYACCESS
    public function offsetExists($offset)
    {
        $this->updateCharArr();
        return (isset($this->charArr[$offset]));
    }

    public function offsetGet($offset)
    {
        $this->updateCharArr();
        if (isset($this->charArr[$offset]))
            return $this->charArr[$offset];
        return null;
    }

    public function offsetSet($offset , $value)
    {
        $this->updateCharArr();
        $value = stringEx($value)->toString();

        $this->charArr[$offset] = $value;
        $this->value = \stringEx::fromCharArr($this->charArr)->toString();

        $this->lastCharArrString = null;
    }

    public function offsetUnset($offset)
    {
        $this->updateCharArr();

        if (isset($this->charArr[$offset]))
        {
            unset($this->charArr[$offset]);
            $this->value = \stringEx::fromCharArr($this->charArr)->toString();
            $this->lastCharArrString = null;
        }
    }
    // END ARRAYACCESS

    public function __toString()
    { return $this->toString(); }

    public function toString()
    { return $this->value; }

    public function toInt()
    { return intEx($this->value)->toInt(); }

    public function toFloat()
    { return floatEx($this->value)->toFloat(); }

    public function toBool($usePhpParse = false)
    { return boolEx($this->value)->toBool($usePhpParse); }

    public function isEmpty()
    { return empty($this->value); }

    public function unSerialize()
    { return unserialize($this->value); }

    public function toLower($returnString = true)
    {
        $this->value = ($this->__isMultibyte() == true)
            ? mb_strtolower($this->value, $this->getEncoding())
            : strtolower($this->value);

        return ($returnString == true) ? $this->value : $this;
    }

    public function toUpper($returnString = true)
    {
        $this->value = ($this->__isMultibyte() == true)
            ? mb_strtoupper($this->value, $this->getEncoding())
            : strtoupper($this->value);

        return ($returnString == true) ? $this->value : $this;
    }

    public function startsWith($search, $caseSensitive = true)
    {
        $search = stringEx($search)->toString();
        if ($search == "") return true;

        $indexOf = ($this->__isMultibyte() == true)
            ? (($caseSensitive == true) ? mb_strpos($this->value, $search, 0, $this->getEncoding()) : mb_stripos($this->value, $search, 0, $this->getEncoding()))
            : (($caseSensitive == true) ? strpos($this->value, $search) : stripos($this->value, $search));

        if ($indexOf === false)
            return false;
        return ($indexOf === 0);
    }

    public function endsWith($search, $caseSensitive = true)
    {
        $search = stringEx($search)->toString();

        if ($search == "")
            return true;

        $indexOf = ($this->__isMultibyte() == true)
            ? (($caseSensitive == true) ? mb_strrpos($this->value, $search, 0, $this->getEncoding()) : mb_strripos($this->value, $search, 0, $this->getEncoding()))
            : (($caseSensitive == true) ? strrpos($this->value, $search) : strripos($this->value, $search));

        return ($indexOf + stringEx($search)->length == $this->length);
    }

    public function contains($search, $caseSensitive = true)
    {
        $search = stringEx($search)->toString();

//        $indexOf = ($this->__isMultibyte() == true)
//            ? (($caseSensitive == true) ? mb_strrpos($this->value, $search, 0, $this->getEncoding()) : mb_strripos($this->value, $search, 0, $this->getEncoding()))
//            : (($caseSensitive == true) ? strrpos($this->value, $search) : strripos($this->value, $search));
//
//        return ($indexOf + stringEx($search)->length == $this->length);

        return ($this->__isMultibyte() == true)
            ? (($caseSensitive == true) ? mb_strpos($this->value, $search, 0, $this->getEncoding()) !== false : mb_stripos($this->value, $search, 0, $this->getEncoding()) !== false)
            : (($caseSensitive == true) ? strpos($this->value, $search) !== false : stripos($this->value, $search) !== false);
    }

    public function containsAny($array, $caseSensitive = true)
    {
        $array = Arr($array);

        foreach ($array as $search)  {
            $search = stringEx($search)->toString();
            if (!stringEx($search)->isEmpty())
                if ($this->contains($search, $caseSensitive))
                    return true;
        }

        return false;
    }

    public function equals($string, $caseSensitive = true)
    {
        $string = stringEx($string)->toString();
        if ($this->value == $string)
            return true;

        if ($caseSensitive == false)
        {
            $stringLower = stringEx($string)->toLower();
            $thisLower   = $this->toLower();

            if ($stringLower == $thisLower)
                return true;
        }

        return false;
    }

    public function equalsAny($array, $caseSensitive = true)
    {
        $array = Arr($array);

        foreach ($array as $search) {
            $search = stringEx($search)->toString();
            if ($this->equals($search, $caseSensitive) == true)
                return true;
        }

        return false;
    }



    public function replace($replace, $with, $returnString = true)
    {
        $replace = stringEx($replace)->toString();
        $with = stringEx($with)->toString();

    //($this->__isMultibyte() == true) ? mb_str_replace($replace, $with, $this->value)  //:

        $this->value = str_replace($replace, $with, $this->value);
        return ($returnString == true) ? $this->value : $this;
    }

    public function remove($remove, $returnString = true)
    {
        $remove = stringEx($remove)->toString();

        $this->replace($remove, "");
        return ($returnString == true) ? $this->value : $this;
    }

    public function encode($raw = false, $returnString = true)
    {
        $this->value = ($raw == false)
            ? urlencode($this->value)
            : rawurlencode($this->value);

        return ($returnString == true) ? $this->value : $this;
    }

    public function decode($raw = false, $returnString = true)
    {
        $this->value = ($raw == false)
            ? urldecode($this->value)
            : rawurldecode($this->value);

        return ($returnString == true) ? $this->value : $this;
    }

    public function split($search = ",", $clearEmpty = true, $keepDelimiter = false)
    {
        $search = stringEx($search)->toString();

        $return = \Arr();
        $split = (($keepDelimiter == false)
            ? explode($search, $this->value)
            : @preg_split('@(?=' . $search . ')@', $this->value)
        );

        foreach ($split as &$value)
            if ($clearEmpty != true || $value != "")
                $return[] = $value;

        return $return;
    }

    public function splitLength($length)
    {
        $length = intEx($length)->toInt();
        if ($length <= 0) $length = 1;
        if ($length == 1) return $this->toCharArr();

        $splitLength = Arr();
        $value = $this->value;

        while (stringEx($value)->count > $length) {
            $splitLength->add(stringEx($value)->subString(0, $length));
            $value = stringEx($value)->subString($length);
        }

        if (stringEx($value)->count > 0)
            $splitLength->add($value);

        return $splitLength;
    }

    public function truncate($limit = \intEx::LIMIT, $type = self::TRUNCATE_BEFORE, $returnString = true)
    {
        if ($type != self::TRUNCATE_AFTER && $type != self::TRUNCATE_BEFORE)
            return null;

        $limit = intEx($limit)->toInt(); if ($limit <= 0) $limit = 0;
        $value = null;

        if ($type == self::TRUNCATE_AFTER) {
            self::loadLibs();
            $value = @\Coduo\PHPHumanizer\StringHumanizer::truncate($this->value, $limit);
        }
        else {
            if ($limit != 0)
            {
                $words = stringEx($this->value)->splitWords();
                $currentTruncate = "";
                foreach ($words as $word)  {
                    $newTruncate = ("" . $currentTruncate);
                    if ($newTruncate != "")
                        $newTruncate .= " ";
                    $newTruncate .= $word;

                    if (stringEx($newTruncate)->count > $limit)
                        break;
                    $currentTruncate = $newTruncate;
                }
                $value = $currentTruncate;
            }
            else $value = "";
        }

        $this->value = $value;
        return ($returnString == true) ? $this->value : $this;
    }

    public function splitWords()
    {
        $wordsFix = stringEx($this->toString())->
        replace("\r", " ", false)->
        replace("\n", " ", false)->
        replace("\t", " ");

        while (stringEx($wordsFix)->contains("  "))
            $wordsFix = stringEx($wordsFix)->replace("  ", " ");
        $split = stringEx($wordsFix)->split(" ");
        return $split;
    }

    public function splitLines()
    {
        $linesFix = stringEx($this->toString())->
        replace("\r\n", "\n", false)->
        replace("\r", "\n");

        return stringEx($linesFix)->split("\n");
    }

    public function subString($start, $lenght = null, $returnString = true)
    {
        $start = intEx($start)->toInt();

        if ($lenght != null)
            $lenght = intEx($lenght)->toInt();
        if ($lenght == 0) $lenght = 999999;

        $this->value = ($this->__isMultibyte() == true)
            ? mb_substr($this->value, $start, $lenght, $this->getEncoding())
            : substr($this->value, $start, $lenght);

        return ($returnString == true) ? $this->value : $this;
    }

    public function indexOf($search, $caseSensitive = true)
    {
        $search = stringEx($search)->toString();

        $return = ($this->__isMultibyte() == true)
            ? (($caseSensitive == true) ? mb_strpos($this->value, $search, 0, $this->getEncoding()) : mb_stripos($this->value, $search, 0, $this->getEncoding()))
            : (($caseSensitive == true) ? strpos($this->value, $search) : stripos($this->value, $search));

        if ($return === false || $return < 0)
            return null;

        return intEx($return)->toInt();
    }

    public function lastIndexOf($search, $caseSensitive = true)
    {
        $search = stringEx($search)->toString();

        $return = ($this->__isMultibyte() == true)
            ? (($caseSensitive == true) ? mb_strrpos($this->value, $search, 0, $this->getEncoding()) : mb_strripos($this->value, $search, 0, $this->getEncoding()))
            : (($caseSensitive == true) ? strrpos($this->value, $search) : strripos($this->value, $search));

        return intEx($return)->toInt();
    }

    public function trim($extraCharlist = "", $returnString = true)
    {
        $extraCharlist = stringEx($extraCharlist)->toString();
        $this->value = $this->__mb_trim($this->value, " " . $extraCharlist);

        return ($returnString == true) ? $this->value : $this;
    }

    public function capitalize($returnString = true)
    {
        $split = $this->split(" ");
        $newValue = "";
        for ($i = 0; $i < $split->count; $i++) {
            $newValue .= stringEx($split[$i])->capitalizeFirst();
            if ($i != ($split->count - 1))
                $newValue .= " ";
        }  $this->value = $newValue;

        return ($returnString == true) ? $this->value : $this;
    }

    public function capitalizeFirst($returnString = true)
    {
        $this->value[0] = stringEx($this->value[0])->toUpper();
        return ($returnString == true) ? $this->value : $this;
    }

    public function toCamelCase($capitalizeFirst = false, $returnString = true)
    {
        \Cake::load();

        $value = toString($this->value);
        $value = stringEx($value)->replace("-", " ");
        $value = stringEx($value)->replace("_", " ");
        $value = \Cake\Utility\Inflector::humanize($value);
        $value = stringEx($value)->remove(" ");

        if ($capitalizeFirst == false && stringEx($value)->isEmpty() == false)
        {
            $charArr = stringEx($value)->toCharArr();
            $charArr[0] = stringEx($charArr[0])->toLower();
            $value = \stringEx::fromCharArr($charArr)->toString();
        }

        return ($returnString == true) ? $value : stringEx($value);
    }

    public function setEncoding($encoding = null, $returnString = true)
    {
        $value = null;

        try
        {
            if ($this->__isMultibyte() == true)
                $value = mb_convert_encoding($this->value, $encoding, $this->getEncoding());
            else $value = iconv($this->getEncoding(), $encoding, $this->value);
        }
        catch (Exception $e) {}

        if ($value != null)
        {
            $this->encoding = $encoding;
            $this->value = $value; // only here change internal
        }

        return ($returnString == true)
                    ? $this->toString()
                    : $this;
    }

    public function getEncoding()
    {
        $value = $this->value;

        $ret = null;
		if ( function_exists( 'mb_detect_encoding' ) ) {
			$mbDetected = mb_detect_encoding( $value );
			if ( $mbDetected === self::ENCODING_ASCII) return self::ENCODING_ASCII;
		}


		if ( !function_exists( 'iconv' ) ) {
			return !empty( $mbDetected ) ? $mbDetected : self::ENCODING_UTF8;
		}

		$md5 = md5( $value );
		foreach ( self::$_supportedCharsets as $encoding ) {
			# fuck knows why, //IGNORE and //TRANSLIT still throw notice
			if ( md5( @iconv( $encoding, $encoding, $value ) ) === $md5 ) {
				return $encoding;
			}
		}

		return self::ENCODING_ASCII;
    }

    const FORMAT_NAME = "FORMAT_NAME";

    public function format($format = self::FORMAT_NAME)
    {
        if ($format == self::FORMAT_NAME)
        {
            $value = $this->toLower();
            $value = self::__ucwords_specific_name($value, "-'.");

            $value = stringEx($value)->
                replace(" De ", " de ", false)->
                replace(" De ", " da ", false)->
                replace(" De ", " do ");

            return $value;
        }

        return null;
    }

    public function addSlashes($returnString = true)
    {
        $value = stringEx(addslashes($this->value))->toString();

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function removeSlashes($returnString = true)
    {
        $value = stringEx(stripslashes($this->value))->toString();

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function toBase64($returnString = true)
    {
        $value = \Serialize\Base64::encode($this->value);

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }


    public function toHex($returnString = true)
    {
        $value = bin2hex($this->value);

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function getWidth()
    {
        self::loadLibs();
        $width = (new \Hoa\Ustring\Ustring($this->value))->getWidth();

        $width = intEx($width)->toInt();
        if ($width <= 0) $width = 0;
        return $width;
    }

    public function toAscii($returnString = true)
    {
        self::loadLibs();
        $value = (new \Hoa\Ustring\Ustring($this->value))->toAscii();

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function getCharWidth($charIndex)
    {
        self::loadLibs();
        if (!isset($this[$charIndex])) return 0;

        $char  = stringEx($this[$charIndex])->toString();
        $width = \Hoa\Ustring\Ustring::getCharWidth($char);

        $width = intEx($width)->toInt();
        if ($width <= 0) $width = 0;
        return $width;
    }

    public function getSize()
    {
        self::loadLibs();

        $hoa   = new \Hoa\Ustring\Ustring($this->value);
        $bytes = intEx($hoa->getBytesLength())->toInt();

        if ($bytes <= 0) $bytes = 0;
        return \File\Size::fromBytes($bytes);
    }

    public function toCharCode($charIndex)
    {
        self::loadLibs();
        if (!isset($this[$charIndex])) return null;

        $char  = stringEx($this[$charIndex])->toString();
        return \Hoa\Ustring\Ustring::toCode($char);
    }

    public function toCharCodeArr()
    {
        $codeCharArr = Arr();
        $charArr = $this->toCharArr(true);

        foreach ($charArr as $char)
            $codeCharArr->add(string($char)->toCharCode(0));
        return $codeCharArr;
    }

    public function toCharBinaryCode($charIndex)
    {
        self::loadLibs();
        if (!isset($this[$charIndex])) return null;

        $char  = stringEx($this[$charIndex])->toString();
        return \Hoa\Ustring\Ustring::toBinaryCode($char);
    }

    public function toCharBinaryCodeArr()
    {
        $codeCharArr = Arr();
        $charArr = $this->toCharArr(true);

        foreach ($charArr as $char)
            $codeCharArr->add(string($char)->toCharBinaryCode(0));
        return $codeCharArr;
    }


    public function toCharArr($useUnicode = true)
    {
        if ($useUnicode == false)
        {
            $array = \Arr();

            for ($i = 0; $i < ($this->length); $i++)
                $array[] = stringEx($this->value[$i])->toString();

            return $array;
        }

        $value = $this->
            remove("{{{..krupa.internal.chararray.point..}}}", false)->
            remove("{{{...krupa.internal.chararray.and...}}}", false)->
            remove("{{{.krupa.internal.chararray.hashtag.}}}", false)->
            replace(";", "{{{..krupa.internal.chararray.point..}}}", false)->
            replace("&", "{{{...krupa.internal.chararray.and...}}}", false)->
            replace("#", "{{{.krupa.internal.chararray.hashtag.}}}");

        $htmlEntities = stringEx($value)->toDecHtmlEntities();
        $charArray = stringEx($htmlEntities)->toCharArr(false);

        $array = \Arr();

        for ($i = 0; $i < $charArray->length; $i++)
        {
            $first = $charArray[$i];
            $second = isset($charArray[($i + 1)]) ? $charArray[($i + 1)] : null;

            if ($first == "&" && $second == "#")
            {
                $indexOf = null;
                $exportStr = "";

                for ($j = (0 + $i); $j < $charArray->length; $j++)
                {
                    $exportStr .= $charArray[$j];

                    if ($charArray[$j] == ";")
                    { $indexOf = $j; $i = $j; break; }
                }

                $exportOk = $tryHtmlEntities = stringEx::fromHtmlEntities($exportStr);

                if (!stringEx($exportOk)->isEmpty())
                { $array[] = $exportOk; continue; }
            }

            $array[] = $first;
        }

        $cleanArray = \Arr();

        for ($i = 0; $i < $array->length; $i++)
        {
            $securityStr = "";

            for ($j = ($i + 0); $j < $array->length; $j++)
            {
                $securityStr .= $array[$j];
                if (stringEx($securityStr)->length >= 40) break;
            }

            $insert = $array[$i];

            if ($securityStr == "{{{..krupa.internal.chararray.point..}}}")
            { $insert = ";"; $i = $j; }
            elseif ($securityStr == "{{{...krupa.internal.chararray.and...}}}")
            { $insert = "&"; $i = $j; }
            elseif ($securityStr == "{{{.krupa.internal.chararray.hashtag.}}}")
            { $insert = "#"; $i = $j; }

            $cleanArray[] = $insert;
        }

        return $cleanArray;
    }

    public function getOnlyNumbers($whitelist = null, $returnString = true)
    {
        $whitelist = stringEx($whitelist)->toString();

        $mountRegex = "/[^0-9" . $whitelist . "]*/";
        $value =  preg_replace($mountRegex, "", $this->value);

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function getOnlyLetters($returnString = true)
    {
        $value = preg_replace("/[^a-zA-Z]+/", "", $this->value);

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function limit($limitCount = 10, $returnString = true)
    {
        $value = $this->subString(0, $limitCount);

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function toMatchCodeEx($removeAccents = true, $removeSpecialCharacters = true, $removeSpaces = true, $removeSequentials = true, $removeNumbers = true, $returnString = true)
    {
        return self::toMatchCode([
            removeAccents           => $removeAccents,
            removeSpecialCharacters => $removeSpecialCharacters,
            removeSpaces            => $removeSpaces,
            removeSequentials       => $removeSequentials,
            removeNumbers           => $removeNumbers
        ], $returnString);
    }

    public function toUTF8($fixBadEncoding = true, $returnString = true)
    {
        self::loadLibs();

        if ($fixBadEncoding == true) {
            $value = \ForceUTF8\Encoding::fixUTF8($this->value);
            return ($returnString == true)
                ? stringEx($value)->toString()
                : stringEx($value);
        }

        $value = \ForceUTF8\Encoding::toUTF8($this->value);
        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function toLatin1($fixBadEncoding = true, $returnString = true)
    {
        self::loadLibs();

        if ($fixBadEncoding == true) {
            $value = \ForceUTF8\Encoding::fixUTF8($this->value);
            $value = \ForceUTF8\Encoding::toLatin1($value);
            return ($returnString == true)
                ? stringEx($value)->toString()
                : stringEx($value);
        }

        $value = \ForceUTF8\Encoding::toLatin1($this->value);
        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function toISO8859($fixBadEncoding = true, $returnString = true)
    {
        self::loadLibs();

        if ($fixBadEncoding == true) {
            $value = \ForceUTF8\Encoding::fixUTF8($this->value);
            $value = \ForceUTF8\Encoding::toISO8859($value);
            return ($returnString == true)
                ? stringEx($value)->toString()
                : stringEx($value);
        }

        $value = \ForceUTF8\Encoding::toISO8859($this->value);
        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function toWin1252($fixBadEncoding = true, $returnString = true)
    {
        self::loadLibs();

        if ($fixBadEncoding == true) {
            $value = \ForceUTF8\Encoding::fixUTF8($this->value);
            $value = \ForceUTF8\Encoding::toWin1252($value);
            return ($returnString == true)
                ? stringEx($value)->toString()
                : stringEx($value);
        }

        $value = \ForceUTF8\Encoding::toWin1252($this->value);
        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function toMatchCode($parameters = null, $returnString = true)
    {
        $parameters = Arr($parameters);

        $parameters->removeAccents = ($parameters->containsKey(removeAccents) ? boolEx($parameters->removeAccents)->toBool() : true);
        $parameters->removeSpecialCharacters = ($parameters->containsKey(removeSpecialCharacters) ? boolEx($parameters->removeSpecialCharacters)->toBool() : true);
        $parameters->removeSpaces = ($parameters->containsKey(removeSpaces) ? boolEx($parameters->removeSpaces)->toBool() : true);
        $parameters->removeSequentials = ($parameters->containsKey(removeSequentials) ? boolEx($parameters->removeSequentials)->toBool() : true);
        $parameters->removeNumbers = ($parameters->containsKey(removeNumbers) ? boolEx($parameters->removeNumbers)->toBool() : true);

        if ($this->isEmpty())
            return ($returnString == true)
                ? stringEx($this->value)->toString()
                : stringEx($this->value);

        $value = $this->value;

        $value = stringEx($value, stringEx::ENCODING_UTF8);

        if ($parameters->removeAccents == true)             $value = stringEx($value)->removeAccents();
        if ($parameters->removeSpecialCharacters == true)
        {
            $value = stringEx($value)->removeSpecialCharacters();
            $value = stringEx($value)->remove("’");
        }
        if ($parameters->removeSpaces == true)              $value = stringEx($value)->removeSpaces();

        $value = stringEx($value)->toLower();

        if ($parameters->removeNumbers == true)     $value = stringEx($value)->removeNumbers();
        if ($parameters->removeSequentials == true) $value = stringEx($value)->removeSequentials();

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function removeSequentials($returnString = true)
    {
        $charArray = stringEx($this->value)->toCharArr(true);
        $value = "";

        foreach ($charArray as &$char)
            $value .= stringEx($char)->toHtmlEntities();

        for ($i = 0; $i < \Arr($charArray)->length; $i++)
        {
            if (stringEx($charArray[$i])->toHtmlEntities(false)->length <= 1)
                continue;

            $_search = stringEx($charArray[$i])->toHtmlEntities() . stringEx($charArray[$i])->toHtmlEntities();

            while(stringEx($value)->contains($_search))
                $value = stringEx($value)->replace($_search, stringEx($charArray[$i])->toHtmlEntities()); //$next = stringEx($charArray[($i + 1)])->toHtmlEntities();
        }

        $value = stringEx::fromHtmlEntities($value);
        $charArray = stringEx($value)->toCharArr(true);

        for ($i = 0; $i < \Arr($charArray)->length; $i++)
        {
            if (stringEx($charArray[$i])->toHtmlEntities(false)->length > 1)
                continue;

            $_search = stringEx($charArray[$i])->toHtmlEntities() . stringEx($charArray[$i])->toHtmlEntities();

            while(stringEx($value)->contains($_search))
                $value = stringEx($value)->replace($_search, stringEx($charArray[$i])->toHtmlEntities()); //$next = stringEx($charArray[($i + 1)])->toHtmlEntities();
        }

        $value = stringEx::fromHtmlEntities($value);

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function removeNumbers($returnString = true)
    {
        $charArray = stringEx($this->value)->toCharArr(true);
        $value = "";

        foreach ($charArray as &$char)
        {
            $charValue = stringEx($char)->toHtmlEntities();

            if (stringEx($charValue)->length <= 1)
                for ($i = 0; $i < 10; $i++)
                    if ($charValue == stringEx($i)->toString())
                    { $charValue = ""; break; }

            $value .= $charValue;
        }


        $value = stringEx::fromHtmlEntities($value);

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function removeSpaces($includeBreakline = true, $returnString = true)
    {
        $value = stringEx($this->value)->trim();
        $value = stringEx($value)->remove(" ", false)->remove("\t");

        if ($includeBreakline == true)
            $value = stringEx($value)->remove("\r", false)->remove("\n", false)->remove("\t");

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function removeSpecialCharacters($includeUnderline = true, $returnString = true)
    {
        $value = preg_replace(
            '/[-`~!@#$%\^&*' .
            (($includeUnderline == true) ? "_" : "") .
            '()+={}[\]\\\\|;:\'",.><?\/]/', "", $this->value);

        $value = stringEx($value)->toHtmlEntities(false)->remove("&#180;");
        $value = stringEx::fromHtmlEntities($value);
        $value = stringEx($value)->toString();

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function getComparison($with, $caseSensitive = true)
    {
        $with = toString($with);
        $compare = null;
        if ($caseSensitive == true)
            $compare = \strcmp($this->value, $with);
        else $compare = \strcasecmp($this->value, $with);
        if ($compare == -1)    return false;
        elseif ($compare == 0) return null;
        elseif ($compare == 1) return true;
        return null;
    }

    public function getDirection()
    {
        self::loadLibs();

        $hoa = new \Hoa\Ustring\Ustring($this->value);
        $direction = $hoa->getDirection();

        if ($direction === \Hoa\Ustring\Ustring::LTR)
            return self::DIRECTION_LEFT_TO_RIGHT;
        elseif ($direction == \Hoa\Ustring\Ustring::RTL)
            return self::DIRECTION_RIGHT_TO_LEFT;

        return self::DIRECTION_LEFT_TO_RIGHT; //default
    }

    public function removeHtmlTags($cleanContent = false, $returnString = true)
    {
        if ($this->isEmpty())
            return "";

        $value = null;

        if ($cleanContent == true)
        {
            $value = stringEx($this->value)->
                replace("<", " <", false)->
                replace(">", "> ", false)->
                trim("\r\n\t");

            $value = strip_tags($value);
            $value = stringEx($value)->
                replace("\r", "", false)->
                replace("\n", "", false)->
                replace("\t", "", false)->
                trim("\r\n\t");

            while (stringEx($value)->contains("  "))
                $value = stringEx($value)->replace("  ", " ");
        }
        else $value = strip_tags($this->value);

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function toSlug($delimiter = "-", $ruleset = self::SLUG_RULESET_DEFAULT, $rules = null, $returnString = true)
    {
        self::loadLibs();

        $_ruleset = null;
        if ($ruleset != self::SLUG_RULESET_DEFAULT && ($ruleset == self::SLUG_RULESET_AZERBAIJANI || $ruleset == self:: SLUG_RULESET_BURMESE || $ruleset == self:: SLUG_RULESET_FINDI || $ruleset == self:: SLUG_RULESET_NORWEGIAN || $ruleset == self:: SLUG_RULESET_VIETNAMESE || $ruleset == self:: SLUG_RULESET_UKRAINIAN || $ruleset == self:: SLUG_RULESET_LATVIAN || $ruleset == self:: SLUG_RULESET_FINNISH || $ruleset == self:: SLUG_RULESET_GREEK || $ruleset == self:: SLUG_RULESET_CZECH || $ruleset == self:: SLUG_RULESET_ARABIC || $ruleset == self:: SLUG_RULESET_TURKISH || $ruleset == self:: SLUG_RULESET_POLISH || $ruleset == self:: SLUG_RULESET_GERMAN || $ruleset == self:: SLUG_RULESET_RUSSIAN || $ruleset == self:: SLUG_RULESET_ROMANIAN))
            $_ruleset = $ruleset;
        $ruleset = $_ruleset;

        $slugify = new \Cocur\Slugify\Slugify();
        if ($ruleset != null) $slugify->activateRuleSet($ruleset);
        if ($rules != null) {
            $rules = Arr($rules);
            foreach ($rules as $rule)
                if ($rule->containsKey(from) && $rule->containsKey(to) && !stringEx($rule->from)->isEmpty())
                    $slugify->addRule(string($rule->from)->toString(), stringEx($rule->to)->toString());
        }

        $value = $slugify->slugify($this->value, stringEx($delimiter)->toString());

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function append($value, $returnString = true)
    {
        $value = ($this->value . stringEx($value)->toString());
        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function prepend($value, $returnString = true)
    {
        $value = (string($value)->toString() . $this->value);
        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    public function toPad($type = self::PAD_LEFT, $count = 1, $pad = " ")
    {
        $count = intEx($count)->toInt();
        if ($count <= 0 || $type != self::PAD_LEFT && $type != self::PAD_RIGHT && $type != self::PAD_RIGHT)
            return $this->toString();
        return str_pad($this->value, $count, $pad, $type);
    }

    public function removeAccents($returnString = true)
    {
        $string = $this->value;

        if ( !preg_match('/[\x80-\xff]/', $string) )
            return ($returnString == true)
                ? stringEx($string)->toString()
                : stringEx($string);

        if ($this->__seems_utf8($string)) {
            $chars = array(
                // Decompositions for Latin-1 Supplement
                chr(194).chr(170) => 'a', chr(194).chr(186) => 'o',
                chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
                chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
                chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
                chr(195).chr(134) => 'AE',chr(195).chr(135) => 'C',
                chr(195).chr(136) => 'E', chr(195).chr(137) => 'E',
                chr(195).chr(138) => 'E', chr(195).chr(139) => 'E',
                chr(195).chr(140) => 'I', chr(195).chr(141) => 'I',
                chr(195).chr(142) => 'I', chr(195).chr(143) => 'I',
                chr(195).chr(144) => 'D', chr(195).chr(145) => 'N',
                chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
                chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
                chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
                chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
                chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
                chr(195).chr(158) => 'TH',chr(195).chr(159) => 's',
                chr(195).chr(160) => 'a', chr(195).chr(161) => 'a',
                chr(195).chr(162) => 'a', chr(195).chr(163) => 'a',
                chr(195).chr(164) => 'a', chr(195).chr(165) => 'a',
                chr(195).chr(166) => 'ae',chr(195).chr(167) => 'c',
                chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
                chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
                chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
                chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
                chr(195).chr(176) => 'd', chr(195).chr(177) => 'n',
                chr(195).chr(178) => 'o', chr(195).chr(179) => 'o',
                chr(195).chr(180) => 'o', chr(195).chr(181) => 'o',
                chr(195).chr(182) => 'o', chr(195).chr(184) => 'o',
                chr(195).chr(185) => 'u', chr(195).chr(186) => 'u',
                chr(195).chr(187) => 'u', chr(195).chr(188) => 'u',
                chr(195).chr(189) => 'y', chr(195).chr(190) => 'th',
                chr(195).chr(191) => 'y', chr(195).chr(152) => 'O',
                // Decompositions for Latin Extended-A
                chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
                chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
                chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
                chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
                chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
                chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
                chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
                chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
                chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
                chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
                chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
                chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
                chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
                chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
                chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
                chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
                chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
                chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
                chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
                chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
                chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
                chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
                chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
                chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
                chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
                chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
                chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
                chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
                chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
                chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
                chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
                chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
                chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
                chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
                chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
                chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
                chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
                chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
                chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
                chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
                chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
                chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
                chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
                chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
                chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
                chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
                chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
                chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
                chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
                chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
                chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
                chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
                chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
                chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
                chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
                chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
                chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
                chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
                chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
                chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
                chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
                chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
                chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
                chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
                // Decompositions for Latin Extended-B
                chr(200).chr(152) => 'S', chr(200).chr(153) => 's',
                chr(200).chr(154) => 'T', chr(200).chr(155) => 't',
                // Euro Sign
                chr(226).chr(130).chr(172) => 'E',
                // GBP (Pound) Sign
                chr(194).chr(163) => '',
                // Vowels with diacritic (Vietnamese)
                // unmarked
                chr(198).chr(160) => 'O', chr(198).chr(161) => 'o',
                chr(198).chr(175) => 'U', chr(198).chr(176) => 'u',
                // grave accent
                chr(225).chr(186).chr(166) => 'A', chr(225).chr(186).chr(167) => 'a',
                chr(225).chr(186).chr(176) => 'A', chr(225).chr(186).chr(177) => 'a',
                chr(225).chr(187).chr(128) => 'E', chr(225).chr(187).chr(129) => 'e',
                chr(225).chr(187).chr(146) => 'O', chr(225).chr(187).chr(147) => 'o',
                chr(225).chr(187).chr(156) => 'O', chr(225).chr(187).chr(157) => 'o',
                chr(225).chr(187).chr(170) => 'U', chr(225).chr(187).chr(171) => 'u',
                chr(225).chr(187).chr(178) => 'Y', chr(225).chr(187).chr(179) => 'y',
                // hook
                chr(225).chr(186).chr(162) => 'A', chr(225).chr(186).chr(163) => 'a',
                chr(225).chr(186).chr(168) => 'A', chr(225).chr(186).chr(169) => 'a',
                chr(225).chr(186).chr(178) => 'A', chr(225).chr(186).chr(179) => 'a',
                chr(225).chr(186).chr(186) => 'E', chr(225).chr(186).chr(187) => 'e',
                chr(225).chr(187).chr(130) => 'E', chr(225).chr(187).chr(131) => 'e',
                chr(225).chr(187).chr(136) => 'I', chr(225).chr(187).chr(137) => 'i',
                chr(225).chr(187).chr(142) => 'O', chr(225).chr(187).chr(143) => 'o',
                chr(225).chr(187).chr(148) => 'O', chr(225).chr(187).chr(149) => 'o',
                chr(225).chr(187).chr(158) => 'O', chr(225).chr(187).chr(159) => 'o',
                chr(225).chr(187).chr(166) => 'U', chr(225).chr(187).chr(167) => 'u',
                chr(225).chr(187).chr(172) => 'U', chr(225).chr(187).chr(173) => 'u',
                chr(225).chr(187).chr(182) => 'Y', chr(225).chr(187).chr(183) => 'y',
                // tilde
                chr(225).chr(186).chr(170) => 'A', chr(225).chr(186).chr(171) => 'a',
                chr(225).chr(186).chr(180) => 'A', chr(225).chr(186).chr(181) => 'a',
                chr(225).chr(186).chr(188) => 'E', chr(225).chr(186).chr(189) => 'e',
                chr(225).chr(187).chr(132) => 'E', chr(225).chr(187).chr(133) => 'e',
                chr(225).chr(187).chr(150) => 'O', chr(225).chr(187).chr(151) => 'o',
                chr(225).chr(187).chr(160) => 'O', chr(225).chr(187).chr(161) => 'o',
                chr(225).chr(187).chr(174) => 'U', chr(225).chr(187).chr(175) => 'u',
                chr(225).chr(187).chr(184) => 'Y', chr(225).chr(187).chr(185) => 'y',
                // acute accent
                chr(225).chr(186).chr(164) => 'A', chr(225).chr(186).chr(165) => 'a',
                chr(225).chr(186).chr(174) => 'A', chr(225).chr(186).chr(175) => 'a',
                chr(225).chr(186).chr(190) => 'E', chr(225).chr(186).chr(191) => 'e',
                chr(225).chr(187).chr(144) => 'O', chr(225).chr(187).chr(145) => 'o',
                chr(225).chr(187).chr(154) => 'O', chr(225).chr(187).chr(155) => 'o',
                chr(225).chr(187).chr(168) => 'U', chr(225).chr(187).chr(169) => 'u',
                // dot below
                chr(225).chr(186).chr(160) => 'A', chr(225).chr(186).chr(161) => 'a',
                chr(225).chr(186).chr(172) => 'A', chr(225).chr(186).chr(173) => 'a',
                chr(225).chr(186).chr(182) => 'A', chr(225).chr(186).chr(183) => 'a',
                chr(225).chr(186).chr(184) => 'E', chr(225).chr(186).chr(185) => 'e',
                chr(225).chr(187).chr(134) => 'E', chr(225).chr(187).chr(135) => 'e',
                chr(225).chr(187).chr(138) => 'I', chr(225).chr(187).chr(139) => 'i',
                chr(225).chr(187).chr(140) => 'O', chr(225).chr(187).chr(141) => 'o',
                chr(225).chr(187).chr(152) => 'O', chr(225).chr(187).chr(153) => 'o',
                chr(225).chr(187).chr(162) => 'O', chr(225).chr(187).chr(163) => 'o',
                chr(225).chr(187).chr(164) => 'U', chr(225).chr(187).chr(165) => 'u',
                chr(225).chr(187).chr(176) => 'U', chr(225).chr(187).chr(177) => 'u',
                chr(225).chr(187).chr(180) => 'Y', chr(225).chr(187).chr(181) => 'y',
                // Vowels with diacritic (Chinese, Hanyu Pinyin)
                chr(201).chr(145) => 'a',
                // macron
                chr(199).chr(149) => 'U', chr(199).chr(150) => 'u',
                // acute accent
                chr(199).chr(151) => 'U', chr(199).chr(152) => 'u',
                // caron
                chr(199).chr(141) => 'A', chr(199).chr(142) => 'a',
                chr(199).chr(143) => 'I', chr(199).chr(144) => 'i',
                chr(199).chr(145) => 'O', chr(199).chr(146) => 'o',
                chr(199).chr(147) => 'U', chr(199).chr(148) => 'u',
                chr(199).chr(153) => 'U', chr(199).chr(154) => 'u',
                // grave accent
                chr(199).chr(155) => 'U', chr(199).chr(156) => 'u',
            );

            $string = strtr($string, $chars);
        } else {
            $chars = array();
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
                .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
                .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
                .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
                .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
                .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
                .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
                .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
                .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
                .chr(252).chr(253).chr(255);

            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars = array();
            $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }

        $value = $string;

        return ($returnString == true)
            ? stringEx($value)->toString()
            : stringEx($value);
    }

    private function __isMultibyte()
    { return function_exists("mb_detect_encoding"); }

    private static $_supportedCharsets = [
		self::ENCODING_UTF8,
		'Windows-1252',
		'euc-jp',
	];

    private static function __mb_str_replace($haystack, $search, $replace, $offset = 0, $encoding = 'auto')
    {
        $len_sch = mb_strlen($search, $encoding);
        $len_rep = mb_strlen($replace, $encoding);

        while (($offset = mb_strpos($haystack, $search, $offset, $encoding)) !== false)
        {
            $haystack = mb_substr($haystack, 0, $offset, $encoding)
                . $replace . mb_substr($haystack, $offset + $len_sch, 1000, $encoding);
            $offset = $offset + $len_rep;
            if ($offset > mb_strlen($haystack, $encoding))
                break;
        }
        return $haystack;
    }

    private function __ucwords_specific_name($string, $delimiters = '', $encoding = NULL)
    {
        if ($encoding === NULL)
            $encoding = mb_detect_encoding($string);

        if (is_string($delimiters))
            $delimiters =  str_split( str_replace(' ', '', $delimiters));

        $delimiters_pattern1 = array();
        $delimiters_replace1 = array();
        $delimiters_pattern2 = array();
        $delimiters_replace2 = array();

        foreach ($delimiters as $delimiter)
        {
            $uniqid = uniqid();
            $delimiters_pattern1[]   = '/'. preg_quote($delimiter) .'/';
            $delimiters_replace1[]   = $delimiter.$uniqid.' ';
            $delimiters_pattern2[]   = '/'. preg_quote($delimiter.$uniqid.' ') .'/';
            $delimiters_replace2[]   = $delimiter;
        }

        $return_string = $string;
        $return_string = preg_replace($delimiters_pattern1, $delimiters_replace1, $return_string);

        $words = explode(' ', $return_string);

        foreach ($words as $index => $word)
            $words[$index] = mb_strtoupper(mb_substr($word, 0, 1, $encoding), $encoding).mb_substr($word, 1, mb_strlen($word, $encoding), $encoding);

        $return_string = implode(' ', $words);
        $return_string = preg_replace($delimiters_pattern2, $delimiters_replace2, $return_string);

        return $return_string;
    }

    private function __mbstring_binary_safe_encoding($reset = false)
    {
        static $encodings = array();
        static $overloaded = null;

        if ( is_null( $overloaded ) )
            $overloaded = function_exists( 'mb_internal_encoding' ) && ( ini_get( 'mbstring.func_overload' ) & 2 );

        if ( false === $overloaded )
            return;

        if ( ! $reset ) {
            $encoding = mb_internal_encoding();
            array_push( $encodings, $encoding );
            mb_internal_encoding(self::ENCODING_ISO_8859_1);
        }

        if ( $reset && $encodings ) {
            $encoding = array_pop( $encodings );
            mb_internal_encoding( $encoding );
        }
    }

    private function __reset_mbstring_encoding()
    { $this->__mbstring_binary_safe_encoding(true); }

    private function __seems_utf8( $str )
    {
        $this->__mbstring_binary_safe_encoding();
        $length = strlen($str);
        $this->__reset_mbstring_encoding();
        for ($i=0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80) $n = 0; // 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0) $n=1; // 110bbbbb
            elseif (($c & 0xF0) == 0xE0) $n=2; // 1110bbbb
            elseif (($c & 0xF8) == 0xF0) $n=3; // 11110bbb
            elseif (($c & 0xFC) == 0xF8) $n=4; // 111110bb
            elseif (($c & 0xFE) == 0xFC) $n=5; // 1111110b
            else return false; // Does not match any model
            for ($j=0; $j<$n; $j++) { // n bytes matching 10bbbbbb follow ?
                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;
    }

    private function __mb_trim($string, $charlist = null)
    {
        if (\function_exists("mb_trim"))
            return \mb_trim($string, $charlist);

        if (\is_null($charlist)) {
            return \trim($string);
        } else {
            $charlist = \str_replace('/', '\/', preg_quote ($charlist));
            return \preg_replace("/(^[$charlist]+)|([$charlist]+$)/us", '', $string);
        }
    }


    private function __mb_internal_encoding($encoding = NULL)
    { return ($encoding === NULL) ? iconv_get_encoding() : iconv_set_encoding($encoding); }

    private function __mb_convert_encoding($str, $to_encoding, $from_encoding = NULL)
    { return iconv(($from_encoding === NULL) ? $this->__mb_internal_encoding() : $from_encoding, $to_encoding, $str); }

    private function __mb_chr($ord, $encoding = self::ENCODING_UTF8)
    {
        if ($encoding === self::ENCODING_UCS4BE)
            return pack("N", $ord);
        else return $this->__mb_convert_encoding($this->__mb_chr($ord, self::ENCODING_UCS4BE), $encoding, self::ENCODING_UCS4BE);
    }

    private function __mb_ord($char, $encoding = self::ENCODING_UTF8)
    {
        if ($encoding === self::ENCODING_UCS4BE) {
            list(, $ord) = (strlen($char) === 4) ? @unpack('N', $char) : @unpack('n', $char);
            return $ord;
        } else {
            return $this->__mb_ord($this->__mb_convert_encoding($char, self::ENCODING_UCS4BE, $encoding), self::ENCODING_UCS4BE);
        }
    }

    private function __mb_htmlentities($string, $hex = true, $encoding = self::ENCODING_UTF8)
    {
        return preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($match) use ($hex) {
            return sprintf($hex ? '&#x%X;' : '&#%d;', $this->__mb_ord($match[0])); }, $string);
    }

    private function __mb_html_entity_decode($string, $flags = null, $encoding = self::ENCODING_UTF8)
    { return html_entity_decode($string, ($flags === NULL) ? ENT_COMPAT | ENT_HTML401 : $flags, $encoding); }

    private function __codepoint_encode($str)
    { return substr(json_encode($str), 1, -1); }

    private function __codepoint_decode($str)
    { return json_decode(sprintf('"%s"', $str)); }

    public static function fromDecHtmlEntities($numericDec, $encoding = self::ENCODING_UTF8) // 271
    { return (stringEx(string()->__mb_chr($numericDec))->toString()); }

    public static function fromHexHtmlEntities($hex, $encoding = self::ENCODING_UTF8) // 0x010F
    { return (stringEx(string()->__mb_chr($hex))->toString()); }

    public static function fromHtmlEntities($decHtmlEntities) // tch&#xFC;&#xDF; or tch&#252;&#223;
    { return stringEx(stringEx()->__mb_html_entity_decode($decHtmlEntities, false))->toString(); }

    public function toHtmlEntities($returnString = true)
    { return $this->toDecHtmlEntities($returnString); }

    public function toDecHtmlEntities($returnString = true)
    {
        $value = stringEx($this->__mb_htmlentities($this->value, false))->toString();
        return ($returnString == true) ? stringEx($value)->toString() : stringEx($value);
    }

    public function toHexHtmlEntities($returnString = true)
    {
        $value = stringEx($this->__mb_htmlentities($this->value))->toString();
        return ($returnString == true) ? stringEx($value)->toString() : stringEx($value);
    }

    public static function fromUnicode($unicode) // 'tch\u00fc\u00df' (unicode)
    { return stringEx(stringEx()->__codepoint_decode($unicode))->toString(); }

    public function toUnicode($returnString = true)
    {
        $value = stringEx($this->__codepoint_encode($this->value))->toString();
        return ($returnString == true) ? stringEx($value)->toString() : stringEx($value);
    }

    //echo "\nGet numeric value of character as DEC string\n";
    //var_dump(mb_ord('d', 'UCS-4BE'));
    //var_dump(mb_ord('d'));

    //echo "\nGet numeric value of character as HEX string\n";
    //var_dump(dechex(mb_ord('d', 'UCS-4BE')));
    //var_dump(dechex(mb_ord('d')));

    public static function setInternalEncoding($encoding = self::ENCODING_UTF8)
    {
        self::$internalEncoding = $encoding;
        if (self::$internalEncoding == null)
            self::$internalEncoding = self::ENCODING_DEFAULT;
    }

    public static function getInternalEncoding()
    { return self::$internalEncoding; }

    public static function fromBase64($value)
    { return stringEx(\Serialize\Base64::decode($value))->toString(); }

    public static function fromHex($value)
    {

        $value = stringEx($value)->toString();
        return stringEx(hex2bin($value))->toString();
    }

    public static function from($value)
    { return stringEx($value)->toString(); }

    public static function fromCharArr($charArr) {
        $value = ""; $charArr = Arr($charArr);
        foreach ($charArr as $char)
            $value .= $char;
        return stringEx($value);
    }

    public static function fromCharCode($charCode)
    {
        $variable = \Variable::get($charCode);
        if ($variable->getPreferredTypeByType($variable->getType()) == Arr)
            $charCode = stringEx($charCode)->toString();

        self::loadLibs();
        return stringEx(\Hoa\Ustring\Ustring::fromCode($charCode))->toString();
    }

    public static function fromCharCodeArr($charCodeArr)
    {
        $charCodeArr = Arr($charCodeArr);
        $value = "";
        foreach ($charCodeArr as $charCode)
            $value .= stringEx::fromCharCode($charCode);
        return $value;
    }

    public static function getCharWidthEx($char)
    {
        self::loadLibs();

        $char  = stringEx($char)->toString();
        $width = \Hoa\Ustring\Ustring::getCharWidth($char);

        $width = intEx($width)->toInt();
        if ($width <= 0) $width = 0;
        return $width;
    }

    public static function implement($name, $delegate)
    {
        if (method_exists(self::class, $name) || \FunctionEx::isFunction($delegate) == false)
            return false;

        if (self::$implements == null)
            self::$implements = Arr();

        self::$implements[$name] = $delegate;
        return true;
    }

    public function __call($name, $arguments)
    {
        if (self::$implements == null || self::$implements->containsKey($name) == false)
            \trigger_error('Call to undefined method '. __CLASS__ . '::' . $name . '()', E_USER_ERROR);

        $callFunction = self::$implements[$name];
        \array_unshift($arguments , $this->value);
        return \call_user_func_array($callFunction, $arguments);
    }
}

function stringEx($value = null, $encoding = null)
{
    if ($encoding != null)
        return stringEx($value)->setEncoding($encoding, true);

    $newString = new stringEx($value);
    return $newString->setEncoding(stringEx::getInternalEncoding(), false);
}

const stringEx = "stringEx";

function str($value = null, $encoding = null)
{ return stringEx($value, $encoding); }
class str extends stringEx {}
const str = "str";

function toString($value) { return stringEx($value)->toString(); }

// Database tools
function enum() {
    $args = func_get_args();
    $enum = \Arr(["enum"]);
    foreach ($args as $arg)
        $enum[] = $arg;
    return $enum;
}

function bigint($length) {
    $length = toInt($length);
    return ("bigint(" . $length . ")");
}

function varchar($length) {
    $length = toInt($length);
    return ("varchar(" . $length . ")");
}



}