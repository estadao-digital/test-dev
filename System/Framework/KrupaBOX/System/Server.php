<?php

class Server
{
    protected static $CI = null;
    protected static $CIAgent = null;

    protected static $serverUniqueId  = null;
    protected static $serverIpAddress = null;
    protected static $localIpAddress  = null;

    public static function getUniqueId()
    {
        if (self::$serverUniqueId != null)
            return self::$serverUniqueId;

        $uniqueStr = null;

        if (\System::isLinux() || \System::isMacOSX()) {
            exec("/sbin/ifconfig eth0 | grep HWaddr", $output);
            $output = Arr($output);
            if ($output->count > 0) $uniqueStr = $output[0];
        } elseif (\System::isWindows()) {
            ob_start();
            system('ipconfig /all');
            $mycom = ob_get_contents();
            ob_clean();
            $findme = 'Physical';
            $pmac = strpos($mycom, $findme);
            $mac = substr($mycom, ($pmac + 36), 17);
            $uniqueStr = $mac;
        }

        if (stringEx($uniqueStr)->isEmpty()) $uniqueStr = self::getIpAddress();
        if (stringEx($uniqueStr)->isEmpty()) return null;

        $uniqueStr = ($uniqueStr . "@" . self::getLocalIpAddress() . "@" .
            (isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME']))
                ? md5($_SERVER['SERVER_NAME'])
                : md5(pathinfo(__FILE__, PATHINFO_FILENAME)));

        self::$serverUniqueId = \Security\Hash::toSha1($uniqueStr);
        return self::$serverUniqueId;
    }

    public static function getIpAddress()
    {
        if (self::$serverIpAddress != null)
            return self::$serverIpAddress;

        $process = \Process::getCurrent(false);
        $cachePath = (($process != null) ? ("cache://.process/.ipaddress/" . \Security\Hash::toSha1($process->pid) . ".blob") : null);

        if ($cachePath != null && \File::exists($cachePath))
        {
            $ipCachedProcess = \File::getContents($cachePath);
            if (self::isValidIpAddress($ipCachedProcess)) {
                self::$serverIpAddress = $ipCachedProcess;
                return self::$serverIpAddress;
            }
        }

        $request = new \Http\Request("http://ipecho.net/plain");
        $data = $request->send();

        if ($data->error == null && self::isValidIpAddress($data->data->text)) {
            self::$serverIpAddress = $data->data->text;
            if ($cachePath != null)
                \File::setContents($cachePath, self::$serverIpAddress);
            return self::$serverIpAddress;
        }

        $ipAddress = stringEx(isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : "")->toString();

        if (self::isValidIpAddress($ipAddress) && $ipAddress != "127.0.0.1") {
            self::$serverIpAddress = $ipAddress;
            return self::$serverIpAddress;
        }

        $ipAddress = stringEx(isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : "")->toString();

        if (self::isValidIpAddress($ipAddress) && $ipAddress != "127.0.0.1") {
            self::$serverIpAddress = $ipAddress;
            return self::$serverIpAddress;
        }

        return null;
    }

    public static function getLocalIpAddress()
    {
        if (self::$localIpAddress != null)
            return self::$localIpAddress;

        $ipAddress = stringEx(isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : "")->toString();

        if (self::isValidIpAddress($ipAddress) && $ipAddress != "127.0.0.1") {
            self::$localIpAddress = $ipAddress;
            return self::$localIpAddress;
        }

        $ipAddress = stringEx(isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : "")->toString();

        if (self::isValidIpAddress($ipAddress) && $ipAddress != "127.0.0.1") {
            self::$localIpAddress = $ipAddress;
            return self::$localIpAddress;
        }

        if (function_exists("gethostname") && function_exists("gethostbyname"))
            $ipAddress = gethostbyname(gethostname());

        if (self::isValidIpAddress($ipAddress)) {
            self::$localIpAddress = $ipAddress;
            return self::$localIpAddress;
        }

        return "127.0.0.1";
    }

    public static function getLocation()
    { return \Location::getByIpAddress(self::getIpAddress()); }

    protected static function isValidIpAddress($ipAddress)
    { return \Connection::isValidIpAddress($ipAddress); }
}