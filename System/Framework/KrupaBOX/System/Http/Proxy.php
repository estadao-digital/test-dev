<?php

namespace Http
{
    class Proxy
    {
        protected $ipAddress = null;
        protected $port      = 80;

        public function __construct($ipAddress, $port)
        {
            $ipAddress = stringEx($ipAddress)->toString();
            if (!stringEx($ipAddress)->isEmpty())
                $this->ipAddress = $ipAddress;

            $port = intEx($port)->toInt();
            if ($port > 0) $this->port = $port;
        }

        public function isValid()
        { return self::isValidProxy($this->ipAddress, $this->port); }

        public function getProxy()
        {
            if ($this->ipAddress == null) return null;
            return Arr([ipAddress => $this->ipAddress, port => $this->port]);
        }

        public static function isValidProxy($ipAddress, $port)
        {
            $ipAddress = stringEx($ipAddress)->toString();
            $port      = intEx($port)->toInt();

            if (stringEx($ipAddress)->isEmpty() || $port <= 0) return false;

            $request = new \Http\Request("http://www.meuip.com.br");
            $request->proxy   = new \Http\Proxy($ipAddress, $port);
            $request->timeout = 1;

            $data     = $request->send();
            $response = (($data->error == null && $data->data != null && $data->data->containsKey(text)) ? $data->data->text : null);

//            $ch = curl_init();
//
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//            curl_setopt($ch, CURLOPT_URL, "http://www.meuip.com.br");
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_PROXY, ($ipAddress . ":" . $port));
//            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000);
//            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 1000);
//            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
//            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
//
//            $response = curl_exec($ch);
//            curl_close($ch);

            if ($response == null)
                return false;

            $response = stringEx($response)->toLower();
            $indexRemote = stringEx($response)->indexOf("remote addr:");
            if ($indexRemote == null)
                return false;

            $response = stringEx($response)->subString($indexRemote + 12);
            $indexRemote = stringEx($response)->indexOf("-");
            if ($indexRemote == null)
                return false;

            $response = stringEx($response)->subString(0, $indexRemote);
            $response = stringEx($response)->trim("\r\n\t");

            return ($response == $ipAddress);
        }
    }
}