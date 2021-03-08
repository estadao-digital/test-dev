<?php

namespace {
    
class string extends stringEx {}
class bool   extends boolEx {}
class float  extends floatEx {}
class int    extends intEx {}

const string = "string";
const bool   = "bool";
const float  = "float";
const int   = "int";


function string($value = null, $encoding = null)
{
    if ($encoding != null)
        return stringEx($value)->setEncoding($encoding, true);

    $newString = new stringEx($value);
    return $newString->setEncoding(stringEx::getInternalEncoding(), false);
}

function float($value = 0)
{ return new floatEx($value); }

function bool($value = null)
{ return new boolEx($value); }

function int($value = 0)    { return new intEx($value); }

}