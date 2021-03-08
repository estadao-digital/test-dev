<?php

class Location
{
    protected static $cacheIpAddress = null;

    public static function getCurrent()
    { return self::getByIpAddress("self"); }

    public static function getByIpAddress($ipAddress)
    {
        if (self::$cacheIpAddress == null)
            self::$cacheIpAddress = Arr();

        if (\Connection::isValidIpAddress($ipAddress) == false && stringEx($ipAddress)->toLower() != "self" && stringEx($ipAddress)->toLower() != "")
            return null;

        if ($ipAddress == "self" || $ipAddress == "127.0.0.1" || $ipAddress == "") $ipAddress = "";
        $ipAddress = stringEx($ipAddress)->toString();
        $ipHash    = \Security\Hash::toSha1($ipAddress);

        if (self::$cacheIpAddress->containsKey($ipHash))
            return self::$cacheIpAddress[$ipHash];

        $cacheHashPath = (\Garbage\Cache::getCachePath() . ".location/". $ipHash . ".dat");
        if (\File::exists($cacheHashPath))
        {
            self::$cacheIpAddress[$ipHash] = Arr(\Serialize\Json::decode(\File::getContents($cacheHashPath)));
            self::$cacheIpAddress[$ipHash]->timezone = \DateTimeEx\TimeZone::getBySid(self::$cacheIpAddress[$ipHash]->timezoneSid);
            if (self::$cacheIpAddress[$ipHash]->coordinates->latitude != null && self::$cacheIpAddress[$ipHash]->coordinates->longitude != null)
                self::$cacheIpAddress[$ipHash]->coordinates = new \Geolocation\Coordinate(self::$cacheIpAddress[$ipHash]->coordinates->latitude, self::$cacheIpAddress[$ipHash]->coordinates->longitude);
            else self::$cacheIpAddress[$ipHash]->coordinates = null;
            return self::$cacheIpAddress[$ipHash];
        }

        $request = new \Http\Request("http://www.geoplugin.net/json.gp");
        $request->method = get;
        $request->dataType = json;
        $request->data->ip = $ipAddress;
        $data = $request->send();

        $geoData = null;
        if ($data->error == null && $data->data != null && $data->data->json != null) { $data = $data->data->json;
            if ($data->containsKey(geoplugin_status) && $data->geoplugin_status == 200)
                $geoData = $data; }
        if ($geoData == null) return null;

        $formatedData = Arr([
            ipAddress   => ($geoData->containsKey(geoplugin_request) ? stringEx($geoData->geoplugin_request)->toLower() : $ipAddress),
            country     => ($geoData->containsKey(geoplugin_countryCode) ? stringEx($geoData->geoplugin_countryCode)->toUpper() : null),
            countryName => ($geoData->containsKey(geoplugin_countryName) ? stringEx::fromHtmlEntities($geoData->geoplugin_countryName) : null),

            state     => ($geoData->containsKey(geoplugin_regionCode) ? stringEx::fromHtmlEntities($geoData->geoplugin_regionCode) : null),
            stateName => ($geoData->containsKey(geoplugin_regionName) ? stringEx::fromHtmlEntities($geoData->geoplugin_regionName) : null),

            coordinates => [
                latitude  => ($geoData->containsKey(geoplugin_latitude) ? stringEx($geoData->geoplugin_latitude)->toFloat() : null),
                longitude => ($geoData->containsKey(geoplugin_longitude) ? stringEx($geoData->geoplugin_longitude)->toFloat() : null),
            ],

            timezoneSid => ($geoData->containsKey(geoplugin_timezone) ? stringEx($geoData->geoplugin_timezone)->toString() : null),
        ]);

        $formatedData->timezone = \DateTimeEx\TimeZone::getBySid($formatedData->timezoneSid);

        self::$cacheIpAddress[$ipHash] = $formatedData;
        \File::setContents($cacheHashPath, \Serialize\Json::encode($formatedData));

        if (self::$cacheIpAddress[$ipHash]->coordinates->latitude != null && self::$cacheIpAddress[$ipHash]->coordinates->longitude != null)
            self::$cacheIpAddress[$ipHash]->coordinates = new \Geolocation\Coordinate(self::$cacheIpAddress[$ipHash]->coordinates->latitude, self::$cacheIpAddress[$ipHash]->coordinates->longitude);
        else self::$cacheIpAddress[$ipHash]->coordinates = null;

        return self::$cacheIpAddress[$ipHash];
    }

}