<?php

namespace {
    
class FunctionEx
{
    public static function isFunction($func)
    { return @is_callable($func); }
}

}