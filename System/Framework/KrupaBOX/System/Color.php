<?php

class Color
{

    protected static $__isInitialized = false;
    protected static function __initialize()
    {
        if (self::$__isInitialized == true)
            return true;
        \KrupaBOX\Internal\Library::load("ColorJizz");
        self::$__isInitialized = true; return true;
    }

    protected $red   = 0;
    protected $green = 0;
    protected $blue  = 0;

    protected $hex   = null;

    protected $colorJizz = null;

    public function __construct($red, $green, $blue)
    {
        self::__initialize();

        $this->red = floatEx($red)->toFloat();
        $this->green = floatEx($green)->toFloat();
        $this->blue = floatEx($blue)->toFloat();

        $this->updateColor();
        $this->calculateHex();
    }

    protected function updateColor()
    {
        if ($this->colorJizz == null)
            $this->colorJizz = new \MischiefCollective\ColorJizz\Formats\RGB($this->red, $this->green, $this->blue);

        $this->colorJizz->red  = $this->red;
        $this->colorJizz->green = $this->green;
        $this->colorJizz->blue  = $this->blue;
    }

    protected function calculateHex()
    {

    }

    public function __set($name, $value)
    {
        $name = stringEx($name)->toLower();

        if ($name == "red" || $name == "r")
            $this->red = intEx($value)->toInt();
        elseif ($name == "green" || $name == "g")
            $this->green = intEx($value)->toInt();
        elseif ($name == "blue" || $name == "b")
            $this->blue = intEx($value)->toInt();

        $this->updateColor();
    }

    public function __get($name)
    {
        $name = stringEx($name)->toLower();

        if ($name == "red" || $name == "r")
            return $this->red;
        elseif ($name == "green" || $name == "g")
            return $this->green;
        elseif ($name == "blue" || $name == "b")
            return $this->blue;
        return null;
    }

    public function toRGB()
    { return ("rgb(" . $this->red . "," . $this->green . "," . $this->blue . ")"); }

    public function toHEX()
    { return sprintf("#%02x%02x%02x", $this->red, $this->green, $this->blue); }

    public function toCMY()
    {
        $cmy = ($this->colorJizz->toCMY() . "");
        $split = stringEx($cmy)->split(",");
        if ($split->count < 3) return null;
        return ("cmy(" . stringEx($cmy)->remove(" ") . ")");
    }

    public function toCMYK()
    {
        $cmyk = ($this->colorJizz->toCMYK() . "");
        $split = stringEx($cmyk)->split(",");
        if ($split->count < 4) return null;
        return ("cmyk(" . stringEx($cmyk)->remove(" ") . ")");
    }

    public function toHSV()
    {
        $hsv = ($this->colorJizz->toHSV() . "");
        $split = stringEx($hsv)->split(",");
        if ($split->count < 3) return null;
        return ("hsv(" . stringEx($hsv)->remove(" ") . ")");
    }

    public function toXYZ()
    {
        $xyz = ($this->colorJizz->toXYZ() . "");
        $split = stringEx($xyz)->split(",");
        if ($split->count < 3) return null;
        return ("xyz(" . stringEx($xyz)->remove(" ") . ")");
    }

    public function toYXY()
    {
        $yxy = ($this->colorJizz->toYXY() . "");
        $split = stringEx($yxy)->split(",");
        if ($split->count < 3) return null;
        return ("yxy(" . stringEx($yxy)->remove(" ") . ")");
    }

    public static function fromRGB($r, $g, $b)
    { return self::fromString("rgb(" . floatEx($r)->toFloat() . "," . floatEx($g)->toFloat() . "," . floatEx($b)->toFloat() . ")"); }
    public static function fromCMY($c, $m, $y)
    { return self::fromString("cmy(" . floatEx($c)->toFloat() . "," . floatEx($m)->toFloat() . "," . floatEx($y)->toFloat() . ")"); }
    public static function fromCMYK($c, $m, $y, $k)
    { return self::fromString("cmyk(" . floatEx($c)->toFloat() . "," . floatEx($m)->toFloat() . "," . floatEx($y)->toFloat() . "," . floatEx($k)->toFloat() . ")"); }
    public static function fromHSV($h, $s, $v)
    { return self::fromString("hsv(" . floatEx($h)->toFloat() . "," . floatEx($s)->toFloat() . "," . floatEx($v)->toFloat() . ")"); }
    public static function fromXYZ($x, $y, $z)
    { return self::fromString("xyz(" . floatEx($x)->toFloat() . "," . floatEx($y)->toFloat() . "," . floatEx($z)->toFloat() . ")"); }
    public static function fromYXY($y, $x, $_y)
    { return self::fromString("yxy(" . floatEx($y)->toFloat() . "," . floatEx($x)->toFloat() . "," . floatEx($_y)->toFloat() . ")"); }
    public static function fromHex($hex)
    { return self::fromString($hex); }

    public static function fromString($string)
    {
        self::__initialize();

        $string = stringEx($string)->trim("\r\n\t");
        if (stringEx($string)->endsWith(")"))
            $string = stringEx($string)->subString(0, stringEx($string)->count - 1);

        if (stringEx($string)->startsWith("rgb("))
        {
            $string = stringEx($string)->subString(4);
            $split = stringEx($string)->split(",");
            if ($split->count < 3) return null;
            $color = new \Color(floatEx($split[0])->toFloat(), floatEx($split[1])->toFloat(), floatEx($split[2])->toFloat());
            return $color;
        }
        elseif (stringEx($string)->startsWith("cmy("))
        {
            $string = stringEx($string)->subString(4);
            $split = stringEx($string)->split(",");
            if ($split->count < 3) return null;

            $cmy = new \MischiefCollective\ColorJizz\Formats\CMY(floatEx($split[0])->toFloat(), floatEx($split[1])->toFloat(), floatEx($split[2])->toFloat());
            $rgb = $cmy->toRGB();

            $color = new \Color($rgb->getRed(), $rgb->getGreen(), $rgb->getBlue());
            return $color;
        }
        elseif (stringEx($string)->startsWith("cmyk("))
        {
            $string = stringEx($string)->subString(5);
            $split = stringEx($string)->split(",");
            if ($split->count < 4) return null;

            $cmyk = new \MischiefCollective\ColorJizz\Formats\CMYK(floatEx($split[0])->toFloat(), floatEx($split[1])->toFloat(), floatEx($split[2])->toFloat(), floatEx($split[3])->toFloat());
            $rgb = $cmyk->toRGB();

            $color = new \Color($rgb->getRed(), $rgb->getGreen(), $rgb->getBlue());
            return $color;
        }
        elseif (stringEx($string)->startsWith("hsv("))
        {
            $string = stringEx($string)->subString(4);
            $split = stringEx($string)->split(",");
            if ($split->count < 3) return null;

            $hsv = new \MischiefCollective\ColorJizz\Formats\HSV(floatEx($split[0])->toFloat(), floatEx($split[1])->toFloat(), floatEx($split[2])->toFloat());
            $rgb = $hsv->toRGB();

            $color = new \Color($rgb->getRed(), $rgb->getGreen(), $rgb->getBlue());
            return $color;
        }
        elseif (stringEx($string)->startsWith("xyz("))
        {
            $string = stringEx($string)->subString(4);
            $split = stringEx($string)->split(",");
            if ($split->count < 3) return null;

            $xyz = new \MischiefCollective\ColorJizz\Formats\XYZ(floatEx($split[0])->toFloat(), floatEx($split[1])->toFloat(), floatEx($split[2])->toFloat());
            $rgb = $xyz->toRGB();

            $color = new \Color($rgb->getRed(), $rgb->getGreen(), $rgb->getBlue());
            return $color;
        }
        elseif (stringEx($string)->startsWith("yxy("))
        {
            $string = stringEx($string)->subString(4);
            $split = stringEx($string)->split(",");
            if ($split->count < 3) return null;

            $yxy = new \MischiefCollective\ColorJizz\Formats\Yxy(floatEx($split[0])->toFloat(), floatEx($split[1])->toFloat(), floatEx($split[2])->toFloat());
            $rgb = $yxy->toRGB();

            $color = new \Color($rgb->getRed(), $rgb->getGreen(), $rgb->getBlue());
            return $color;
        }

        $split = stringEx($string)->split(",");
        if ($split->count >= 3)
            return self::fromString("rgb(" . $split[0] . "," . $split[1] . "," . $split[2] . ")");

        // case hex
        if (stringEx($string)->startsWith("#") || stringEx($string)->count == 6 || stringEx($string)->count == 3)
        {
            $hex = ("" . $string);
            if (stringEx($hex)->startsWith("#"))
                $hex = stringEx($hex)->subString(1);

            $hex = stringEx($hex)->limit(6);
            if (stringEx($hex)->count == 6)
            {
                $hex = ("#" . $hex);
                list($r, $g, $b) = sscanf($hex, "#%2x%2x%2x");
                $color = new \Color($r, $g, $b);
                return $color;
            }
        }

        return null;
    }

}