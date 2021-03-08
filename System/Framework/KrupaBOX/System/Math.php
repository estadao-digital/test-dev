<?php

class Math
{
    public static function abs($value) {
        $value = \floatEx($value)->toFloat();
        return \floatEx(abs($value))->toFloat();
    }

    public static function ceil($value) {
        $value = \floatEx($value)->toFloat();
        return \floatEx(ceil($value))->toFloat();
    }

    public static function pow($valueX, $valueY) {
        $valueX = \floatEx($valueX)->toFloat();
        $valueY = \floatEx($valueY)->toFloat();
        return \floatEx(pow($valueX, $valueY))->toFloat();
    }

    public static function sqrt($value) {
        $value = \floatEx($value)->toFloat();
        return \floatEx(sqrt($value))->toFloat();
    }

    public static function random($min, $max, $decimalsCount = 0)
    {
        $min = floatEx($min)->toFloat();
        $max = floatEx($max)->toFloat();

        $decimalsCount = intEx($decimalsCount)->toInt();
        $decimalsMultiplier = null;

        if ($decimalsCount > 0) {
            $decimalsMultiplier = "1";
            for ($i = 0; $i < $decimalsCount; $i++)
                $decimalsMultiplier .= "0";
            $decimalsMultiplier = intEx($decimalsMultiplier)->toInt();
        }

        if ($decimalsMultiplier != null)
        { $min = intEx($min * $decimalsMultiplier)->toInt(); $max = intEx($max * $decimalsMultiplier)->toInt(); }
        else { $min = intEx($min)->toInt(); $max = intEx($max)->toInt(); }

        if ($min == $max) {
            if ($decimalsMultiplier != null)
                return floatEx($min / $decimalsMultiplier)->toFloat();
            return floatEx($min)->toFloat();
        }

        if ($min > $max) { $_min = $max; $max = $min; $min = $_min; }
        $random = intEx(mt_rand($min, $max))->toInt();


        if ($decimalsMultiplier != null)
            return floatEx($random / $decimalsMultiplier)->toFloat();
        return floatEx($random)->toFloat();
    }
}