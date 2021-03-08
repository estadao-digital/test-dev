<?php

namespace Config
{
    class Admin
    {
        protected static $admins = null;

        protected static function getAdminFile()
        {
            self::$admins = Arr();

            $adminConfigData = null;
            $adminConfigPath = \File::getRealPath(APPLICATION_FOLDER . "Config/Admin.xml");

            $adminData = null;

            if ($adminConfigPath != null)
            {
                $adminConfigContent = (($adminConfigPath != null) ? \File::getContents($adminConfigPath) : null);
                $_adminConfigData = \Serialize\Xml::decode($adminConfigContent);
                $_adminConfigData = (($_adminConfigData != null) ? Arr($_adminConfigData) : Arr());

                if ($_adminConfigData != null && $_adminConfigData->containsKey(Config))
                    if ($_adminConfigData->Config->containsKey(admin))
                        $adminData = $_adminConfigData->Config->admin;
            }

            if ($adminData != null)
            {
                if ($adminData->containsKey(username) || $adminData->containsKey(password) || $adminData->containsKey(ipAddress) || $adminData->containsKey(allowLocalhost))
                    self::$admins->add($adminData);
                else
                    foreach ($adminData as $_adminData)
                        if ($_adminData->containsKey(username) || $_adminData->containsKey(password) || $_adminData->containsKey(ipAddress) || $_adminData->containsKey(allowLocalhost))
                            self::$admins->add($_adminData);
            }

            foreach (self::$admins as &$admin)
            {
                if ($admin->containsKey(username))
                {
                    $username = stringEx($admin->username)->trim("\r\n\t");
                    if (stringEx($username)->isEmpty())
                        $admin->removeKey(username);
                    else $admin->username = $username;
                }

                if ($admin->containsKey(password))
                {
                    $password = stringEx($admin->password)->trim("\r\n\t");
                    if (stringEx($password)->isEmpty())
                        $admin->removeKey(password);
                    else $admin->password = $password;
                }

                if ($admin->containsKey(ipAddress))
                {
                    $ipAddress = stringEx($admin->ipAddress)->trim("\r\n\t");
                    if (stringEx($ipAddress)->isEmpty())
                        $admin->removeKey(ipAddress);
                    else $admin->ipAddress = $ipAddress;
                }

                if ($admin->containsKey(allowLocalhost))
                    $admin->allowLocalhost = boolEx(stringEx($admin->allowLocalhost)->trim("\r\n\t"))->toBool();
                else $admin->allowLocalhost = false;

                if ($admin->containsKey(canAccessDatabase))
                    $admin->canAccessDatabase = boolEx(stringEx($admin->canAccessDatabase)->trim("\r\n\t"))->toBool();
                else $admin->canAccessDatabase = false;

            }

            return self::$admins;
        }

        public static function getCurrentAdmin()
        {
            $ipAddress = \Connection::getIpAddress();

            $username  = (isset($_SERVER['PHP_AUTH_USER']) ? stringEx($_SERVER['PHP_AUTH_USER'])->toString() : null);
            $password  = (isset($_SERVER['PHP_AUTH_PW']) ? stringEx($_SERVER['PHP_AUTH_PW'])->toString() : null);

            if (stringEx($username)->isEmpty()) $username = null;
            if (stringEx($password)->isEmpty()) $password = null;

            $admins = self::getAdminFile();

            if (\Connection::isLocal() && $username == null && $password == null)
                foreach ($admins as $admin)
                    if (!$admin->containsKey(username) && !$admin->containsKey(password) &&
                        $admin->containsKey(allowLocalhost) && $admin->allowLocalhost == true)
                        return $admin;
            if (\Connection::isLocal() && $username != null && $password == null)
                foreach ($admins as $admin)
                    if ($admin->containsKey(username) && stringEx($admin->username)->toLower() == stringEx($username)->toLower() &&
                        !$admin->containsKey(password) && $admin->containsKey(allowLocalhost) && $admin->allowLocalhost == true)
                        return $admin;
            if ($username != null && $password != null)
                foreach ($admins as $admin)
                    if ($admin->containsKey(username) && $admin->containsKey(password) && $admin->containsKey(ipAddress) &&
                        stringEx($admin->username)->toLower() == stringEx($username)->toLower() && stringEx($admin->password)->toLower() == stringEx($password)->toLower() &&
                        $admin->ipAddress == $ipAddress)
                        return $admin;

            return null;
        }

        public static function isValidAdmin()
        { return (self::getCurrentAdmin() != null); }

        public static function promptLogin()
        {
            header('WWW-Authenticate: Basic realm="Test Authentication System"');
            header('HTTP/1.0 401 Unauthorized');

            echo \Serialize\Json::encode([error => "ACCESS_DENIED", message => "You must enter a valid credentials."]);
            \KrupaBOX\Internal\Kernel::exit();
        }

        public static function renderAdminPage()
        {
            $html = <<<HTML
            
<html>
    <head>
    </head>
    <body style="background-color: black">
    
        <div id="panel-links">
            <h1 style="color: white">KRUPABOX: Admin Panel</h1>
             <a id="database-link" href="#">
                <img src="/System/Admin/Controller/Database/img/database-banner.jpg">
             </a>
        </div>
       
        <iframe id="database-panel" src="/System/Admin/Controller/Database/" style="position: absolute; top: 0px; left: 0px; border: none; width: 100%; height: 100%; display: none;"></iframe>
        
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script>
            $(document).ready(function()
            {
                $("#database-link").on("click", function() {
                    $("#panel-links").hide();
                    $("#database-panel").show();
                });
                
            });
        </script>
    </body>
</html>
HTML;

            \Connection\Output::execute($html, "text/html");
        }
    }
}