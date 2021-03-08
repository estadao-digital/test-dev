<?php

class Domain
{
    public static function getInformation($domain)
    {
        $domain = new \Http\Url($domain);
        $domain = $domain->domain;

        \KrupaBOX\Internal\Library::load('WhoIsPHP');
        $whois = new \Whois();
        $data = $whois->Lookup($domain);
        if (\is_array($data) == false)
            return null;

        $data = Arr($data);

        if (isset($data->regrinfo)) {
            $regrinfo = $data->regrinfo;
            $data = $data->merge($regrinfo);
            $data->removeKey('regrinfo');
        }

        if (isset($data->regyinfo)) {
            $regyinfo = $data->regyinfo;
            $data = $data->merge($regyinfo);
            $data->removeKey('regyinfo');
        }

        if (isset($data->registered)) {
            $data->registered = toBool($data->registered);
        }

        if (isset($data->rawdata)) {
            $joinData = '';
            $rawData = $data->rawdata;
            if (\Arr::isArr($rawData))
                foreach ($rawData as $_rawData)
                    $joinData .= \toString($_rawData) . "\r\n";
            $data->data = $joinData;
            $data->removeKey('rawdata');
        }

        return $data;
    }

}