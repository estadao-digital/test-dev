<?php

namespace Monetary
{
    class CreditCard
    {
        const TYPE_UNKNOWN          = "Unknown";
        const TYPE_AMERICAN_EXPRESS = "American Express";
        const TYPE_DINERS_CLUB      = "Diners Club";
        const TYPE_DISCOVER         = "Discover";
        const TYPE_JCB              = "JCB";
        const TYPE_MASTERCARD       = "MasterCard";
        const TYPE_VISA             = "Visa";

        public static function getTypeByNumber($creditCardNumber)
        {
            $creditCardNumber = stringEx($creditCardNumber)->getOnlyNumbers();
            $number = stringEx(preg_replace('/[^\d]/','', $creditCardNumber))->toString();

            if (preg_match('/^3[47][0-9]{13}$/', $number))
                return self::TYPE_AMERICAN_EXPRESS;
            elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/', $number))
                return self::TYPE_DINERS_CLUB;
            elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/', $number))
                return self::TYPE_DISCOVER;
            elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/', $number))
                return self::TYPE_JCB;
            elseif (preg_match('/^5[1-5][0-9]{14}$/', $number))
                return self::TYPE_MASTERCARD;
            elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $number))
                return self::TYPE_VISA;
            else return self::TYPE_UNKNOWN;
        }
    }
}