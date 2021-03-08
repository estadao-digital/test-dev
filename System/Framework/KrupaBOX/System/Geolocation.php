<?php

class Geolocation
{
    public static function getCurrent()
    {
        $data = \Location::getCurrent();
        if ($data != null && $data->containsKey(coordinates) && $data->coordinates != null)
            return $data->coordinates;
        return null;
    }
}
