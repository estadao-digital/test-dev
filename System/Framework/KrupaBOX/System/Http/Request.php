<?php

namespace Http
{
    use Symfony\Component\Config\Definition\Exception\Exception;

    class Request
    {
        protected static $hosts = null;

        const CONTENT_TYPE_FORM_DATA = "form-data";
        
        protected $url         = "";
        protected $redirectUrl = "";
        protected $dataType    = text;
        protected $method      = get;
        protected $contentType = "www-form";

        protected $proxy   = null;
        protected $timeout = null;

        public $auth    = null;
        public $data    = null;
        public $header  = null;
        public $content = null;

        public function __construct($url = null)
        {
            $this->url    = stringEx($url)->toString();
            $this->data   = Arr();
            $this->header = Arr();

            $this->auth = Arr([
                basic => ([
                    username  => null,
                    password  => null,
                    active    => false
                ])
            ]);
        }

        public function __set($key, $value)
        {
            if ($key == method)
            { if (stringEx($value)->toLower() == get || stringEx($value)->toLower() == post) $this->method = stringEx($value)->toLower(); }
            elseif ($key == dataType)
            { if ($value == text || $value == json) $this->dataType = $value; }
            elseif ($key == contentType) {
                if ($value == "x-www-form-urlencoded" || $value == "form-data" || $value == "form-data" || $value == "json")
                    $this->contentType = $value;
            }
            elseif ($key == timeout)
            { $this->timeout = intEx($value)->toInt(); if ($this->timeout <= 0) $this->timeout = null; }
            elseif ($key == proxy)
            {
                if ($value instanceof \Http\Proxy)
                    $this->proxy = $value;
                else
                {
                    $value = Arr($value);
                    if ($value->containsKey(ipAddress))
                    {
                        $port = (($value->containsKey(port)) ? $value->port : 80);
                        $this->proxy = new \Http\Proxy($value->ipAddress, $port);
                    }
                }
            }
        }

        protected function checkRedirectResponse($data)
        {
            $redirect = null;

            if ($data->error != null)
                foreach ($data->header as $header)
                    if (stringEx($header)->startsWith("Location: ")) {
                        $redirect = $header;
                        break;
                    }

            if ($redirect == null) return $data;

            $redirectUrl = stringEx($redirect)->subString(10);
            $this->url = $redirectUrl;
            $this->redirectUrl = $redirectUrl;
            return $this->send();
        }

        public function send($delegate = null)
        {
            if (stringEx($this->url)->isEmpty())
                return $this->checkRedirectResponse(new Request\Response($this->dataType, null,
                    Arr([message => "Url can't be blank.", errorSid => EMPTY_URL, errorCode => 500]), null, $this->redirectUrl));

            $currentHost = \Http\Url::getCurrent()->host;
            if ($currentHost == "" || $currentHost == null)
                $currentHost = "127.0.0.1";

            if (stringEx($this->url)->startsWith("http:///") == true)
                $this->url = ("http://" . $currentHost . "/" . stringEx($this->url)->subString(8));
            if (stringEx($this->url)->startsWith("https:///") == true)
                $this->url = ("http://" . $currentHost . "/" . stringEx($this->url)->subString(9));
            if (stringEx($this->url)->startsWith("ftp:///") == true)
                $this->url = ("http://" . $currentHost . "/" . stringEx($this->url)->subString(7));

            if (stringEx($this->url)->startsWith("//"))
                $this->url = ("http:" . $this->url);

            // Check for hosts
            $hosts = self::getHosts();

            $httpUrl = new \Http\Url($this->url);
            if (stringEx($httpUrl->host)->isEmpty() == false) {
                $hostLower = stringEx($httpUrl->host)->toLower();
                if (self::$hosts->containsKey($hostLower)) {
                    $parseUrl = stringEx($this->url)->subString(stringEx($httpUrl->protocol)->count + 3);
                    $isBigUrl = false;
                    if (stringEx($parseUrl)->contains("/")) {
                        $split = stringEx($parseUrl)->split("/", false, true);
                        if ($split->count >= 2) { $isBigUrl = true; $parseUrl = ""; for ($i = 1; $i < $split->count; $i++) $parseUrl .= $split[$i]; }
                    } if ($isBigUrl == false) $parseUrl = "";
                    $this->url = ($httpUrl->protocol . "://" . self::$hosts[$hostLower] . $parseUrl);
                }
            }

            $this->data = Arr($this->data);
            $query = http_build_query($this->data);

            $requestData    = null;
            $responseHeader = null;

            if ($this->method == post && $this->contentType == "form-data" && function_exists("curl_init")) // CURL alternative
            {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FAILONERROR, true);
                curl_setopt($ch, CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data->toArray(true));
                //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $curl_return = curl_exec($ch);
                if (curl_errno($ch))
                    return $this->checkRedirectResponse(new Request\Response($this->dataType, null,
                        Arr([message => curl_error($ch), errorSid => (ERROR_ . curl_errno($ch)), errorCode => curl_errno($ch)])
                        , null, $this->redirectUrl));
                curl_close($ch);

                return $this->checkRedirectResponse(new Request\Response($this->dataType, stringEx($curl_return)->toUTF8(), null, $responseHeader, $this->redirectUrl));
            }

            $contentType = "application/x-www-form-urlencoded";

            $jsonData = null;
            if ($this->contentType == "json") {
                $contentType = "application/json";
                $jsonData = \Serialize\Json::encode($this->data);
                if ($jsonData == null) $jsonData = \Serialize\Json::encode(Arr());

            }

            $requestUrl = new \Http\Url($this->url);
            $requestOptions = [ 'http' => [
                'header'  => "",
                'method'  => (($this->method == get) ? "GET" : "POST"),
                'content' => (($this->contentType != "json") ? $query : $jsonData),
            ]];

            if ($this->contentType != "json" && $this->method == get)
            {
                $requestUrl->parameters = $query;
                $requestOptions["http"]["content"] = "";
            }

            if ($this->contentType != "json" && $this->content != null && !stringEx($this->content)->isEmpty())
                $requestOptions["http"]["content"] = $this->content;

            if ($this->proxy != null)
            {
                $proxy = $this->proxy->getProxy();
                $requestOptions["http"]["proxy"] = ("tcp://" . $proxy->ipAddress . ":" . $proxy->port);
                $requestOptions["http"]["request_fulluri"] = true;
            }

            if ($this->timeout != null)
                $requestOptions["http"]["timeout"] = $this->timeout;

            // Mount authorization header
            $authorization = null;

            if ($this->auth != null && $this->auth->containsKey(basic) && $this->auth->basic->containsKey(active) && $this->auth->basic->active == true)
                $authorization = ("Basic " . base64_encode(stringEx($this->auth->basic->username)->toString() . ":" .
                    stringEx($this->auth->basic->username)->toString()));

            foreach ($this->header as $key => $value)
                if (stringEx($key)->toLower() == "authorization")
                { $authorization = $value; break; }

            if ($authorization != null)
                $requestOptions["http"]["header"] .= ("Authorization: " . $authorization . "\r\n");

            // Mount content-type header
            foreach ($this->header as $key => $value)
                if (stringEx($key)->toLower() == "content-type")
                { $contentType = $value; break; }

            if ($contentType != null)
                $requestOptions["http"]["header"] .= ("Content-Type: " . $contentType . "\r\n");

            // Mount accept header
            $accept = null;
            if ($this->dataType == json)
                $accept = "application/json";

            foreach ($this->header as $key => $value)
                if (stringEx($key)->toLower() == "accept")
                { $accept = $value; break; }

            if ($accept != null)
                $requestOptions["http"]["header"] .= ("Accept: " . $accept . "\r\n");

            // Mount all others headers
            foreach ($this->header as $key => $value)
            {
                $keyLower = stringEx($key)->toLower();
                if ($keyLower == "accept" || $keyLower == "content-type" || $keyLower == "authorization") continue;

                $requestOptions["http"]["header"] .= ($key . ": " . $value . "\r\n");
            }

            $requestOptions["http"]["ignore_errors"] = true;
            
            if (stringEx($requestUrl->toUrl())->startsWith("https:")) {
                $requestOptions["ssl"]["verify_peer"] = false;
                $requestOptions["ssl"]["verify_peer_name"] = false;
            }

            $requestContext  = stream_context_create($requestOptions);
            $requestData = @file_get_contents($requestUrl->toUrl(), false, $requestContext);

            $responseHeader = Arr();

            if (isset($http_response_header))
                $responseHeader = Arr($http_response_header);

//
//
//            dump($requestOptions);
//            exit;
//
//            if ($this->method == get)
//            {
//                //dump($this->url . "?" . $query);
//
//                $requestOptions = [ 'http' => [
//                    'header'  => ("Content-type: " . $this->contentType . "\r\n"),
//                    'method'  => 'GET',
//                    'content' => $query,
//                ]];
//
//                dump($requestOptions);
//
//                //$requestData = @file_get_contents($this->url . "?" . $query);
//                $requestContext  = stream_context_create($requestOptions);
//                $requestData = @file_get_contents($this->url, false, $requestContext);
//
//                $responseHeader = Arr();
//                if (isset($http_response_header))
//                    $responseHeader = Arr($http_response_header);
//            }
//            elseif ($this->method == post)
//            {
//                $contentType = "application/x-www-form-urlencoded";
//
//
//
//                $requestOptions = [ 'http' => [
//                    'header'  => ("Content-type: " . $contentType . "\r\n"),
//                    'method'  => 'POST',
//                    'content' => $query,
//                ]];
//
//                //dump($query);
//
//                if ($this->auth != null && $this->auth->containsKey(basic) && $this->auth->basic->containsKey(active) && $this->auth->basic->active == true)
//                {
//                    $requestOptions["http"]["header"] .= "Authorization: Basic " .
//                        base64_encode(stringEx($this->auth->basic->username)->toString() . ":" .
//                            stringEx($this->auth->basic->username)->toString()) . "\r\n";
//                }
//
//                $requestContext  = stream_context_create($requestOptions);
//                $requestData = @file_get_contents($this->url, false, $requestContext);
//
//                $responseHeader = Arr();
//                if (isset($http_response_header))
//                    $responseHeader = Arr($http_response_header);
//            }


            $error = null;
            $errorCodeString = (($responseHeader->length > 0) ? stringEx($responseHeader[0])->trim() : null);
            $errorCode = null;
            if ($errorCodeString != null) {
                $splitErrorCode = stringEx($errorCodeString)->split(" ");

                foreach ($splitErrorCode as $_errorCode) {
                    $errorCodeParse = intEx($_errorCode)->toInt();
                    if ($errorCodeParse >= 10)
                    { $errorCode = $errorCodeParse; break; }
                }
            }

            if ($errorCode == null) $errorCode = 500;
            if ($errorCode < 200 || $errorCode > 226)
                $error = Arr([message => "", errorSid => (ERROR_ . $errorCode), errorCode => $errorCode, json => Arr([ errorSid => null ])]);

            return $this->checkRedirectResponse(new Request\Response($this->dataType, stringEx($requestData)->toUTF8(), $error, $responseHeader, $this->redirectUrl));
        }

        public static function start($value)
        {
            $data = null;

            if (!isset($value[url]) || stringEx($value[url])->isEmpty())
                return (object)["error" => "EMPTY_URL"];

            $url      = stringEx($value[url])->toString();
            $method   = get;
            $dataType = text;

            $cookies  = null;
            $postPlainHeader = "";

            if (isset($value[method]))
            {
                $method = stringEx($value[method])->toString();

                if ($method != get && $method != post)
                    $method = get;
            }

            if (isset($value[dataType]))
            {
                $dataType = stringEx($value[dataType])->toString();

                if ($dataType != text && $dataType != json)
                    $dataType = text;
            }

            if (isset($value[cookies]) && $value[cookies] != null)
                $cookies = $value[cookies];

            if (isset($value[data]) && $value[data] != null && \Variable::get($value[data])->isArray() && count($value[data]) > 0)
                foreach ($value[data] as $key => &$_value)
                    $_value = stringEx($_value)->encode(true);
            else $value[data] = [];

            $params = "";

            if (count($value[data]) > 0)
            {
                foreach ($value[data] as $key => &$_value)
                    $params .= stringEx($key)->encode(true) . "=" . $_value . "&";

                if (stringEx($params)->length > 0)
                    $params = stringEx($params)->subString(0, stringEx($params)->length - 1, true);
            }

            if (isset($value[postPlainHeader]))
                $postPlainHeader = stringEx($value[postPlainHeader])->toString();

            if ($method == get)
            {
                $url .= "?" . $params;
                $data = @file_get_contents($url);
                self::$lastResponseHeader = $http_response_header;
            }
            elseif ($method == post)
            {
                $cookieStr = "";

                if ($cookies != null && \arrayk($cookies)->length > 0)
                {
                    $cookieStr = "Cookie: ";

                    foreach ($cookies as $key => $value)
                        $cookieStr .= $key . "=" . stringEx($value)->toString() . "; ";

                    $cookieStr .= "\r\n";
                }

                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n" . $cookieStr . $postPlainHeader,
                        'method'  => 'POST',
                        'content' => $params,
                    )
                );

                $context  = stream_context_create($options);
                $data = @file_get_contents($url, false, $context);
                self::$lastResponseHeader = $http_response_header;
            }

            if ($dataType == text)
                return $data;
            elseif ($dataType == json)
                return json_decode($data);
        }

        protected static function getHosts()
        {
            if (self::$hosts != null) return self::$hosts;

            $filePath = ("config://Hosts.xml");
            if (\File::exists($filePath) == null)
            { self::$hosts = Arr(); return self::$hosts; }

            $hash = \Security\Hash::toSha1(\File::getLastModifiedDateTimeEx($filePath)->toString());
            $cachePath = ("cache://.hosts/" . $hash . ".dat");
            if (\File::exists($cachePath)) {
                self::$hosts = \Serialize\Json::decode(\File::getContents($cachePath));
                self::$hosts = Arr(self::$hosts);
                return self::$hosts;
            }

            $file   = \File::getContents($filePath);
            $decode = \Serialize\Xml::decode($file);
            $data   = Arr();

            if ($decode != null && $decode->containsKey("Hosts"))
                $data = $decode->Hosts;

            $parseData = Arr();
            foreach ($data as $key => $value)
            {
                $key   = stringEx($key)->toLower(false)->trim("\r\n\t");
                $value = stringEx($value)->toLower(false)->trim("\r\n\t");

                $fromHost = ((new \Http\Url($key))->host);
                $toHost   = ((new \Http\Url($value))->host);

                if (stringEx($fromHost)->isEmpty()) $fromHost = $key;
                if (stringEx($toHost)->isEmpty())   $toHost = $value;

                if (stringEx($fromHost)->isEmpty() == false && stringEx($toHost)->isEmpty() == false)
                    $parseData[$fromHost] = $toHost;
            }

            self::$hosts = $parseData;
            return self::$hosts;
        }
    }
}
