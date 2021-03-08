<?php
namespace Config\Bans
{
    class IpAddress
    {
        const VERSION = "1.1";

        protected static $lastBansHash = null;

        protected static $bannedIpAddresses = null;
        protected static $__isInitialized = false;

        protected static function updateBans()
        {
            if (self::$bannedIpAddresses == null)
                self::$bannedIpAddresses = Arr();

            $cachePath = null;

            $applicationConfigData = null;
            $applicationConfigPath = \File::getRealPath(APPLICATION_FOLDER . "Config/Bans/IpAddress.xml");

            if ($applicationConfigPath != null)
            {
                $lastModifiedDate = \File::getLastModifiedDateTimeEx($applicationConfigPath);
                $lastModifiedDate = (($lastModifiedDate == null) ? \DateTimeEx::now() : $lastModifiedDate);

                $lastModifiedDateHash = \Security\Hash::toSha1(self::VERSION . $lastModifiedDate->toString());
                if ($lastModifiedDateHash == self::$lastBansHash)
                    return null;

                self::$bannedIpAddresses = Arr();


                $cachePath = (\Garbage\Cache::getCachePath() . ".bans/ipAddress." . $lastModifiedDateHash . ".dat");

                if (\File::exists($cachePath))
                {
                    $cacheData = \File::getContents($cachePath);
                    if ($cacheData != null) $cacheData = Arr(\Serialize\Json::decode($cacheData));

                    if ($cacheData != null)
                    {
                        self::$bannedIpAddresses = $cacheData;
                        return null;
                    }

                }

                $applicationConfigContent = (($applicationConfigPath != null) ? \File::getContents($applicationConfigPath) : null);
                $_applicationConfigData = \Serialize\Xml::decode($applicationConfigContent);
                $_applicationConfigData = (($_applicationConfigData != null) ? Arr($_applicationConfigData) : Arr());

                if ($_applicationConfigData != null && $_applicationConfigData->containsKey(Config))
                    foreach ($_applicationConfigData->Config as $key => $value)
                        if ($key == ipAddress)
                        {
                            if (\Variable::get($value)->isArr() || \Variable::get($value)->isArray())
                            {
                                foreach ($value as $_ipAddress)
                                    if (!self::$bannedIpAddresses->contains($_ipAddress))
                                        self::$bannedIpAddresses->add(stringEx($_ipAddress)->trim("\r\n"));
                            } else self::$bannedIpAddresses->add(stringEx($value)->trim("\r\n"));

                        }
            }

            if ($cachePath != null)
                \File::setContents($cachePath, \Serialize\Json::encode(self::$bannedIpAddresses));
        }

        public static function isBannedIpAddress($ipAddress)
        {
            self::updateBans();

            $ipAddress = stringEx($ipAddress)->toString();
            if (stringEx($ipAddress)->isEmpty()) return false;

            foreach (self::$bannedIpAddresses as $banIpAddress)
                if ($ipAddress == $banIpAddress)
                    return true;

            return false;
        }

        public static function banIpAddress($ipAddress)
        {
            self::updateBans();

            $ipAddress = stringEx($ipAddress)->toString();
            if (stringEx($ipAddress)->isEmpty()) return null;

            if (!self::$bannedIpAddresses->contains($ipAddress))
                self::$bannedIpAddresses->add($ipAddress);

            self::saveBans();
            return null;
        }

        public static function unbanIpAddress($ipAddress)
        {
            self::updateBans();

            $ipAddress = stringEx($ipAddress)->toString();
            if (stringEx($ipAddress)->isEmpty()) return null;

            $cleanBannedIpAddress = Arr();
            foreach (self::$bannedIpAddresses as $banIpAddress)
                if ($banIpAddress != $ipAddress)
                    $cleanBannedIpAddress->add($banIpAddress);
            self::$bannedIpAddresses = $cleanBannedIpAddress;

            self::saveBans();
            return null;
        }

        protected static function saveBans()
        {
            $xmlRaw = "<Config>\r\n";
            if (self::$bannedIpAddresses->count > 0)
                foreach (self::$bannedIpAddresses as $banIpAddress)
                    $xmlRaw .= ("\t<ipAddress>" . $banIpAddress . "</ipAddress>\r\n");
            $xmlRaw .= "</Config>";

            \File::setContents(APPLICATION_FOLDER . "Config/Bans/IpAddress.xml", $xmlRaw);
            self::$lastBansHash = null;
        }
    }
}