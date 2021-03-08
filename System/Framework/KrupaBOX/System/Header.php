<?php

class Header
{
    const DISPOSITION_TYPE_FILENAME = "filename";

    const ENCODING_TYPE_GZIP = "gzip";

    const HTTP_CODE_CONTINUE = 100;
    const HTTP_CODE_SWITCHING_PROTOCOLS = 101;
    const HTTP_CODE_OK = 200;
    const HTTP_CODE_CREATED = 201;
    const HTTP_CODE_ACCEPTED = 202;
    const HTTP_CODE_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_CODE_NO_CONTENT = 204;
    const HTTP_CODE_RESET_CONTENT = 205;
    const HTTP_CODE_PARTIAL_CONTENT = 206;

    const HTTP_CODE_MULTIPLE_CHOICES = 300;
    const HTTP_CODE_MOVED_PERMANENTLY = 301;
    const HTTP_CODE_MOVED_TEMPORARILY = 302;
    const HTTP_CODE_SEE_OTHER = 303;
    const HTTP_CODE_NOT_MODIFIED = 304;
    const HTTP_CODE_USE_PROXY = 305;
    const HTTP_CODE_BAD_REQUEST = 400;
    const HTTP_CODE_UNAUTHORIZED = 401;
    const HTTP_CODE_PAYMENT_REQUIRED = 402;
    const HTTP_CODE_FORBIDDEN = 403;
    const HTTP_CODE_NOT_FOUND = 404;
    const HTTP_CODE_METHOD_NOT_ALLOWED = 405;
    const HTTP_CODE_NOT_ACCEPTABLE = 406;
    const HTTP_CODE_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_CODE_REQUEST_TIMEOUT = 408;
    const HTTP_CODE_CONFLICT = 409;
    const HTTP_CODE_GONE = 410;
    const HTTP_CODE_LENGTH_REQUIRED = 411;
    const HTTP_CODE_PRECONDITION_FAILED = 412;
    const HTTP_CODE_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_CODE_REQUEST_URI_TOO_LARGE = 414;
    const HTTP_CODE_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_CODE_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_CODE_INTERNAL_SERVER_ERROR = 500;
    const HTTP_CODE_NOT_IMPLEMENTED = 501;
    const HTTP_CODE_BAD_GATEWAY = 502;
    const HTTP_CODE_SERVICE_UNAVAILABLE = 503;
    const HTTP_CODE_GATEWAY_TIMEOUT = 504;
    const HTTP_CODE_HTTP_VERSION_NOT_SUPPORTED = 505;

    private static $values = [
        httpCode    => null,
        contentType => null,

        contentEncoding    => null,
        contentLength      => null,
        contentDisposition => [],

        accessControlAllow => null,
        accessControllAllowAll => false,

        cache => null,

        acceptRanges => null,
        contentRange => null
    ];

    public static function setContentType($mimeType)
    { self::$values[contentType] = $mimeType; }

    public static function setContentLength($contentLength)
    { self::$values[contentLength] = intEx($contentLength)->toInt(); }

    public static function setContentEncoding($encoding)
    { self::$values[contentEncoding] = $encoding; }

    public static function setHttpCode($httpCode)
    {
        self::getHttpCode();
        self::$values[httpCode] = intEx($httpCode)->toInt();
    }

    public static function setCache($cacheAgeInSeconds)
    {
        $cacheAgeInSeconds = intEx($cacheAgeInSeconds)->toInt();
        if ($cacheAgeInSeconds <= 0)
            self::$values[cache] = null;
        else self::$values[cache] = $cacheAgeInSeconds;
    }

    public static function setAcceptRanges($min, $max)
    {
        $min = intEx($min)->toInt();
        $max = intEx($max)->toInt();

        if ($min == $max) return null;
        self::$values[acceptRanges] = Arr([min => $min, max => $max]);
    }

    public static function setContentRange($min, $max, $total)
    {
        $min   = intEx($min)->toInt();
        $max   = intEx($max)->toInt();
        $total = intEx($total)->toInt();

        if ($min == $max || $min == $total) return null;
        self::$values[contentRange] = Arr([min => $min, max => $max, total => $total]);
    }

    public static function getHttpCodeDescription($httpCode)
    {
        $httpCode        = intEx($httpCode)->toInt();
        $httpDescription = null;

        if ($httpCode > 0)
            switch ($httpCode) {
                case 100: $httpDescription = 'Continue'; break;
                case 101: $httpDescription = 'Switching Protocols'; break;
                case 200: $httpDescription = 'OK'; break;
                case 201: $httpDescription = 'Created'; break;
                case 202: $httpDescription = 'Accepted'; break;
                case 203: $httpDescription = 'Non-Authoritative Information'; break;
                case 204: $httpDescription = 'No Content'; break;
                case 205: $httpDescription = 'Reset Content'; break;
                case 206: $httpDescription = 'Partial Content'; break;
                case 300: $httpDescription = 'Multiple Choices'; break;
                case 301: $httpDescription = 'Moved Permanently'; break;
                case 302: $httpDescription = 'Moved Temporarily'; break;
                case 303: $httpDescription = 'See Other'; break;
                case 304: $httpDescription = 'Not Modified'; break;
                case 305: $httpDescription = 'Use Proxy'; break;
                case 400: $httpDescription = 'Bad Request'; break;
                case 401: $httpDescription = 'Unauthorized'; break;
                case 402: $httpDescription = 'Payment Required'; break;
                case 403: $httpDescription = 'Forbidden'; break;
                case 404: $httpDescription = 'Not Found'; break;
                case 405: $httpDescription = 'Method Not Allowed'; break;
                case 406: $httpDescription = 'Not Acceptable'; break;
                case 407: $httpDescription = 'Proxy Authentication Required'; break;
                case 408: $httpDescription = 'Request Time-out'; break;
                case 409: $httpDescription = 'Conflict'; break;
                case 410: $httpDescription = 'Gone'; break;
                case 411: $httpDescription = 'Length Required'; break;
                case 412: $httpDescription = 'Precondition Failed'; break;
                case 413: $httpDescription = 'Request Entity Too Large'; break;
                case 414: $httpDescription = 'Request-URI Too Large'; break;
                case 415: $httpDescription = 'Unsupported Media Type'; break;
                case 500: $httpDescription = 'Internal Server Error'; break;
                case 501: $httpDescription = 'Not Implemented'; break;
                case 502: $httpDescription = 'Bad Gateway'; break;
                case 503: $httpDescription = 'Service Unavailable'; break;
                case 504: $httpDescription = 'Gateway Time-out'; break;
                case 505: $httpDescription = 'HTTP Version not supported'; break;
                default: break;
            }

        return $httpDescription;
    }


    public static function getHttpCode()
    {
        if (self::$values[httpCode] == null) {
            if (function_exists("http_response_code"))
                self::$values[httpCode] = intEx(http_response_code())->toInt();
            if (self::$values[httpCode] <= 0 && isset($GLOBALS['http_response_code']))
                self::$values[httpCode] = intEx($GLOBALS['http_response_code'])->toInt();
        }

        if (self::$values[httpCode] == null || self::$values[httpCode] <= 0)
            return 200;

        return self::$values[httpCode];
    }

    public static function setContentTypeByExtension($extension)
    {
        $mimeType = File\MIME::getMIMEsByExtension($extension);

        if ($mimeType == null || $mimeType->count <= 0)
            return;

        self::$values[contentType] = $mimeType[0];
    }

    public static function setContentDisposition($key, $value)
    {
        $key    = stringEx($key)->toString();
        $value  = stringEx($value)->toString();

        if (stringEx($value)->isEmpty())
            $value = null;

        self::$values[contentDisposition][$key] = $value;
    }

    public static function getContentType()
    { return self::$values[contentType]; }

    public static function getContentLength()
    { return self::$values[contentLength]; }

    public static function getContentEncoding()
    { return self::$values[contentEncoding]; }

    public static function getHeader()
    { return self::$values; }

    public static function redirect($url)
    {
        $url = stringEx($url)->toString();

        if (\Dumpper::isPageDumped() == true)
        { echo "<script type=\"text/javascript\"> window.location.href = \"" . $url . "\"; </script>"; \KrupaBOX\Internal\Kernel::exit(); }

        if (\Connection::isCommandLine())
        { echo "Redirect to: '" . $url . "'\n"; \KrupaBOX\Internal\Kernel::exit(); }

        header("Location: " . $url); \KrupaBOX\Internal\Kernel::exit();
        return null;
    }

    public static function sendHeader()
    {
        if (\Dumpper::__isAlreadyDumped() == true)
            return false;

        header_remove("X-Powered-By");
        header("X-Powered-By: KrupaBOX");

        $httpProtocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        $httpCode     = self::getHttpCode();

        // SET PROTOCOLS
        header($httpProtocol . " " . $httpCode . " " . self::getHttpCodeDescription($httpCode));
        if (isset($GLOBALS)) $GLOBALS['http_response_code'] = $httpCode;
        if (function_exists("http_response_code")) http_response_code($httpCode);

        // SET CONTENT TYPES
        if (self::$values[contentType] != null && !stringEx(self::$values[contentType])->isEmpty())
        {
            header_remove("Content-Type");
            header("Content-Type: " . self::$values[contentType]);
        }

        if (self::$values[acceptRanges] != null)
        {
            header_remove("Accept-Ranges");
            header("Accept-Ranges: bytes=" . self::$values[acceptRanges]->min . "-" . self::$values[acceptRanges]->max);
        }

        if (self::$values[contentRange] != null)
        {
            header_remove("Content-Range");
            header("Content-Range: bytes " . self::$values[contentRange]->min . "-" . self::$values[contentRange]->max . "/" . self::$values[contentRange]->total);
        }

        // SET CONTENT ENCODING
        if (self::$values[contentLength] != null && !stringEx(self::$values[contentLength])->isEmpty())
        {
            header_remove("Content-Length");
            header("Content-Length: " . self::$values[contentLength]);
        }

        // SET CONTENT ENCODING
        if (self::$values[contentEncoding] != null && !stringEx(self::$values[contentEncoding])->isEmpty())
        {
            header_remove("Content-Encoding");
            header("Content-Encoding: " . self::$values[contentEncoding]);
        }

        // SET CONTENT DISPOSITION
        if (self::$values[contentDisposition] != null && \Arr(self::$values[contentDisposition])->count > 0)
        {
            $dispositionStr = "Content-Disposition: ";

            foreach(self::$values[contentDisposition] as $key => $value) {
                $dispositionStr .= $key;
                if ($value != null) $dispositionStr .= "=" . $value;
                $dispositionStr .= ";";
            }

            if (stringEx($dispositionStr)->endsWith(";"))
                $dispositionStr = stringEx($dispositionStr)->subString(0, stringEx($dispositionStr)->length - 1);

            header_remove("Content-Disposition");
            header($dispositionStr);
        }


        // SET ACCESS CONTROL

        if (self::$values[accessControlAllow] != null && self::$values[accessControlAllow]->count > 0)
        {
            $connectionOrigin = \Connection::getOrigin();
            $connectionHost   = null;

            if ($connectionOrigin != null)
                $connectionHost = $connectionOrigin->host;

            $connection = null;

            foreach (self::$values[accessControlAllow] as $_connection)
                if ($_connection->origin == $connectionHost)
                { $connection = $_connection; break; }

            if ($connection != null)
            {
                if ($connectionOrigin->protocol == null)
                    $connectionOrigin->protocol = "http";

                $connectionOriginValue = ($connectionOrigin->protocol . "://" . $connectionOrigin->host);

                header_remove("Access-Control-Allow-Origin");
                header("Access-Control-Allow-Origin: " . $connectionOriginValue);

                if ($connection->credentials == true)
                {
                    header_remove("Access-Control-Allow-Credentials");
                    header("Access-Control-Allow-Credentials: true");
                }
            }

        }
        elseif (array_key_exists("accessControlAllowAll", self::$values) && isset(self::$values[accessControlAllowAll]) && self::$values[accessControlAllowAll] == true)
        {
            header_remove("Access-Control-Allow-Origin");
            header("Access-Control-Allow-Origin: *");
        }


//            $connectionDomain = \Http\Url::getDomain($connectionOrigin);
//            $connectionProtocol = \Url::getProtocol($connectionOrigin);

//            $fixedDomains = self::$values[accessControlAllowOrigin];
//
//            foreach ($fixedDomains as &$fixedDomain)
//                $fixedDomain = \Url::getDomain($fixedDomain);
//
//            $connectionOriginValue = "";
//
//            if (!\Arr($fixedDomains)->contains($connectionDomain))
//                $connectionOriginValue = "domain: " . $connectionDomain . " are not allowed";
//            else
//            {
//                $connectionOriginValue = "";
//
//                if ($connectionProtocol != null)
//                    $connectionOriginValue .= $connectionProtocol . ":";
//
//                $connectionOriginValue .= "//" . $connectionDomain;
//            }

//            header_remove("Access-Control-Allow-Origin");
//            header("Access-Control-Allow-Origin: " . $connectionOriginValue);

//        // SET CREDENTIALS
//        if (self::$values[accessControlAllowCredentials] != false)
//        {
//            header_remove("Access-Control-Allow-Credentials");
//            header("Access-Control-Allow-Credentials: true");
//        }

        if (self::$values[cache] != null)
        {
            header_remove("Cache-Control");
            header("Cache-Control: max-age=" . self::$values[cache]);
        }

    }

    public static function addAccessControlAllowAll($allowCredentials = false)
    {
        self::$values[accessControlAllow] = Arr();
        self::$values[accessControlAllowAll] = true;
        self::setAccessControlAllowCredentials($allowCredentials);
    }

    public static function addAccessControlAllow($domainUrl, $allowCredentials = false)
    {
        if (self::$values[accessControlAllow] == null)
            self::$values[accessControlAllow] = Arr();

        self::$values[accessControlAllowAll] = false;

        $url = new \Http\Url($domainUrl);
        $urlHost = $url->host;

        if (!stringEx($urlHost)->isEmpty())
        {
            $find = false;

            $allowCredentials = boolEx($allowCredentials)->toBool();

            foreach (self::$values[accessControlAllow] as $domain)
                if ($domain->origin == $urlHost)
                { $domain->credentials = $allowCredentials; $find = true; break; }

            if ($find == false)
                self::$values[accessControlAllow]->add(Arr([origin => $urlHost, credentials => $allowCredentials]));
        }
    }

    public static function setAccessControlAllowOrigin($domainUrls, $allowCredentials = false)
    {
        self::$values[accessControlAllowOrigin] = $domainUrls;
        self::$values[accessControlAllowCredentials] = ($allowCredentials == true) ? true : false;
    }

    public static function getAccessControlAllowOrigin()
    {
        if (self::$values[accessControlAllowOrigin] == null || \Arr(self::$values[accessControlAllowOrigin])->count <= 0)
            return null;

        return self::$values[accessControlAllowOrigin];
    }

    public static function setAccessControlAllowCredentials($allowCredentials)
    { self::$values[accessControlAllowCredentials] = ($allowCredentials == true) ? true : false; }

    public static function getAccessControlAllowCredentials()
    { return self::$values[accessControlAllowCredentials]; }
}