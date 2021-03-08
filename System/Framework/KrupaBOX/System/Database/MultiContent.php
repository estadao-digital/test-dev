<?php

namespace Database
{
    class MultiContent
    {
        public static function unpack($value)
        {
            $value = stringEx($value)->toString();
            $split = stringEx($value)->split("|");
            if ($split->count <= 1) return Arr();
            $type = $split[0];
            if ($type != int && $type != bool && $type != float)
                return Arr();
            $value = $split[1];
            if (stringEx($value)->startsWith("+"))
                $value = stringEx($value)->subString(stringEx("+")->length);
            if (stringEx($value)->endsWith("+"))
                $value = stringEx($value)->subString(0, stringEx($value)->length - stringEx("+")->length);
            $unpack = stringEx($value)->split("+");
            $typedUnpack = Arr();
            if ($type == int)       foreach ($unpack as $_unpack) $typedUnpack->add(intEx($_unpack)->toInt());
            elseif ($type == float) foreach ($unpack as $_unpack) $typedUnpack->add(floatEx($_unpack)->toFloat());
            elseif ($type == bool)  foreach ($unpack as $_unpack) $typedUnpack->add(boolEx($_unpack)->toBool());
            return $typedUnpack;
        }

        public static function pack($value, $type = int)
        {
            if ($type != int && $type != bool && $type != float)
                return null;
            $value = Arr($value); $packed = "";
            foreach ($value as $_value)
                $packed .= ("+" . $_value . "+");
            $packed = ($type . "|" . stringEx($packed)->replace("++", "+"));
            return $packed;
        }
    }
}