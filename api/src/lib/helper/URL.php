<?php

namespace app\lib\helper;

class URL
{

    /**
     * get the application base URL
     * @return string return the base url
     */
    public static function getBaseUrl (): string
    {
        return 'http://' . $_SERVER['HTTP_HOST'];
    }
}