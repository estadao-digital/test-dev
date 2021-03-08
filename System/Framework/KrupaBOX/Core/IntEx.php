<?php

namespace {

class intEx
{

    protected static $implements = null;
//    const none          = "int::none";
//    const isNullable    = "int::isNullable";
//    const onlyPositive  = "int::onlyPositive";
//    const zeroIsNull    = "int::zeroIsNull";
    
    const PAD_LEFT  = STR_PAD_LEFT;
    const PAD_RIGHT = STR_PAD_RIGHT;
    const PAD_BOTH  = STR_PAD_BOTH;

//    const VALIDATION_NONE           = self::none;
//    const VALIDATION_IS_NULLABLE    = self::isNullable;
//    const VALIDATION_ONLY_POSITIVE  = self::onlyPositive;
//    const VALIDATION_ZERO_IS_NULL   = self::zeroIsNull;

    const MAX   = PHP_INT_MAX;
    const LIMIT = PHP_INT_MAX;
    private $value = 0;

    public function __construct($value = null)//, $validationParameter = null)
    {
        if ($value === true || $value === false)
            $this->value = (($value === true) ? 1 : 0);
        else
        {
            $value = stringEx($value)->toLower();

            if ($value == "true")
                $this->value = 1;
            elseif ($value == "false")
                $this->value = 0;
            else $this->value = intval($value);
        }
    }

    public function __toString()
    { return $this->toString(); }

    public function toString()
    { return stringEx($this->value)->toString(); }

    public function toInt()
    { return $this->value; }

    public function toFloat()
    { return floatEx($this->value)->toFloat(); }

    public function toBool()
    { return boolEx($this->value)->toBool(); }

    public function toPad($type = self::PAD_LEFT, $count = 1, $pad = "0")
    {
        $count = intEx($count)->toInt();
        if ($count <= 0 || $type != self::PAD_LEFT && $type != self::PAD_RIGHT && $type != self::PAD_RIGHT)
            return $this->toString();
        return str_pad($this->value, $count, $pad, $type);
    }

    public function format($pattern)
    {
        $pattern = toString($pattern);
        if (stringEx($pattern)->isEmpty())
            return toInt($this->value);

        \Cake::load();
        return \Cake\I18n\Number::format($this->value, ["pattern" => $pattern]);
    }

    public function toRoman()
    {
        self::loadLibs();
        $roman = @\Coduo\PHPHumanizer\NumberHumanizer::toRoman($this->value);
        return $roman;
    }

    public function getOrdinal()
    {
        self::loadLibs();
        $ordinal = \Coduo\PHPHumanizer\NumberHumanizer::ordinal($this->value, \Language::getDefaultISO());
        if (($ordinal == null || $ordinal == "") && \Language::getDefaultFallbackISO() != null)
            $ordinal = \Coduo\PHPHumanizer\NumberHumanizer::ordinal($this->value, \Language::getDefaultFallbackISO());
        if ($ordinal == null || $ordinal == "")
            $ordinal = \Coduo\PHPHumanizer\NumberHumanizer::ordinal($this->value, "en");
        return $ordinal;
    }

    public function isPrimeNumber()
    {
        $divCount = 0;
        for ($current = 1; $current <= $this->value; $current++)
            if (($this->value % $current) == 0) {
                $divCount++;
                if ($divCount > 2)
                    return false;
            }

        return ($divCount == 2);
    }

    public function toOrdinalized()
    {
        $ordinal = $this->getOrdinal();
        return stringEx($this->value . $ordinal)->toString();
    }

    public static function fromRoman($roman)
    {
        self::loadLibs();
        $roman = stringEx($roman)->toString();
        $intValue = @\Coduo\PHPHumanizer\NumberHumanizer::fromRoman($roman);
        if ($intValue == null) return null;
        return intEx($intValue)->toInt();
    }

    protected static $isLibraryLoaded = false;
    protected static function loadLibs()
    {
        if (self::$isLibraryLoaded == true)
            return null;

        \KrupaBOX\Internal\Library::load("Coduo");
        self::$isLibraryLoaded = true;
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

//    public static function validate($value, $validationParameter)
//    {
//        $isInt = is_int($value); //\Variable($value)->isInt();
//        $finalValue = null; $parse = true;
//
//        if ($validationParameter != null && self::isValidationParameter($validationParameter) && $validationParameter != self::VALIDATION_NONE)
//        {
//            if ($validationParameter == self::VALIDATION_IS_NULLABLE)
//            {
//                $_value = ($isInt == true) ? $value : stringEx($value)->toLower();
//                if ($_value == "true") $_value = 1;
//                $finalValue = intval($_value);
//                $parse = false;
//
//                if (!($finalValue > 0 || ($finalValue == 0 && ($isInt == true || $_value == "0"))))
//                    $finalValue = null;
//            }
//
//            elseif ($validationParameter == self::VALIDATION_ONLY_POSITIVE || $validationParameter == self::VALIDATION_ZERO_IS_NULL)
//            {
//                $_value = ($isInt == true) ? $value : stringEx($value)->toLower();
//                if ($_value == "true") $_value = 1;
//                $finalValue = intval($_value);
//
//                if ($finalValue < 0)
//                    $finalValue = null;
//                elseif (!($finalValue > 0 || ($finalValue == 0 && ($isInt == true || $_value == "0") && $validationParameter != self::VALIDATION_ZERO_IS_NULL)))
//                    $finalValue = null;
//
//                $parse = false;
//            }
//        }
//
//        if ($parse == true)
//        {
//             if ($isInt == false)
//            {
//                $_value = stringEx($value)->toLower();
//                if ($_value == "true") $_value = 1;
//                $finalValue = intval($_value);
//            }
//            else $finalValue = $value;
//        }
//
//        return $finalValue;
//    }
//
//    public static function isValidationParameter($parameter = intEx::normal)
//    {
//        return
//            $parameter == self::VALIDATION_NONE             ||
//            $parameter == self::VALIDATION_IS_NULLABLE      ||
//            $parameter == self::VALIDATION_ONLY_POSITIVE    ||
//            $parameter == self::VALIDATION_ZERO_IS_NULL;
//    }
}

function intEx($value = 0)  { return new intEx($value); }
const intEx = "intEx";

function toInt($value) { return intEx($value)->toInt(); }
}