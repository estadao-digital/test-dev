<?php

namespace Security\SSL
{
    class Certificate
    {
        public $domain                 = null;
        public $countryName            = null;
        public $stateOrProvinceName    = null;
        public $localityName           = null;
        public $organizationName       = null;
        public $organizationalUnitName = null;
        public $street                 = null;
        public $email                  = null;
        public $phone                  = null;

        protected static $__isInitialized = false;
        protected static function __onInitialize()
        {
            if (self::$__isInitialized == true)
                return null;
            \Import::PHP(__KRUPA_PATH_LIBRARY__ . ".plain/itr-acme-client.php");
            self::$__isInitialized = true;
        }
//
//        public static function canGenerate()
//        {
//            $version = \PHP::getVersion();
//            return ($version >= 7.1);
//        }

        public function __construct()
        {
            self::__onInitialize();
        }

        public function generate()
        {
//            if (self::canGenerate() == false)
//                return null;

            if (stringEx($this->domain)->isEmpty()) {
                $this->domain = \Config::get()->server->domain;
                if (stringEx($this->domain)->isEmpty()) {
                    $currentUrl = \Http\Url::getCurrent();
                    if ($currentUrl != null)
                        $this->domain = $currentUrl->domain;
                }
                if (stringEx($this->domain)->isEmpty())
                    return Arr([error => INTERNAL_SERVER_ERROR, message => "Invalid domain."]);
            }

            if (stringEx($this->countryName)->isEmpty())
                $this->countryName = "XX";
            if (stringEx($this->stateOrProvinceName)->isEmpty())
                $this->stateOrProvinceName = "Unknown";
            if (stringEx($this->localityName)->isEmpty())
                $this->localityName = "Unknown";
            if (stringEx($this->organizationName)->isEmpty())
                $this->organizationName = "Unknown Company";
            if (stringEx($this->organizationalUnitName)->isEmpty())
                $this->organizationalUnitName = "Webserver";
            if (stringEx($this->street)->isEmpty())
                $this->street = "Unknown street";
            if (stringEx($this->email)->isEmpty())
                $this->email = "other@unknown.com";
            if (stringEx($this->phone)->isEmpty())
                $this->phone = "+551234567890";

            return $this->execute();
        }

        protected function execute()
        {
            $iac = new \itrAcmeClient();
            $iac->testing = false;

            \File::setContents("cache://.certificate/folder.dat", "OK");
            $iac->certDir = \File\Wrapper::parsePath("cache://.certificate");
            $iac->certAccountDir = 'accounts';
            $iac->certAccountToken = 'itronic';

            $iac->certAccountContact = [
                'mailto:' . $this->email,
                'tel:' . $this->phone
            ];

            $iac->certDistinguishedName = [
                'countryName'            => 'AT',
                'stateOrProvinceName'    => 'Vienna',
                'localityName'           => 'Vienna',
                'organizationName'       => 'Example Company',
                'organizationalUnitName' => 'Webserver',
                'street'                 => 'Example street'
            ];

            $iac->webRootDir          = \File\Wrapper::parsePath("root://");
            if (stringEx($iac->webRootDir)->endsWith("/"))
                $iac->webRootDir = stringEx($iac->webRootDir)->subString(0, stringEx($iac->webRootDir)->count - 1);
            $iac->appendDomain        = false;
            $iac->appendWellKnownPath = true;

            // Initialise the object
            $init = $iac->init();
            if ($init !== true) return $init;

            // Create an account if it doesn't exists
            $createAccount = $iac->createAccount();
            if ($createAccount !== true) return $createAccount;

            // The Domains we want to sign
            $domains = [
                $this->domain
            ];

            $sign = $iac->signDomains($domains);
            if ($sign !== null)
            {
                $data = Arr();
                $data->cert  = Arr();
                $data->pem   = Arr();
                $data->chain = Arr();
                $data->key   = Arr();

                $data->cert->data  = $sign["RSA"]["cert"];
                $data->pem->data   = $sign["RSA"]["pem"];
                $data->chain->data = $sign["RSA"]["chain"];
                $data->key->data   = $sign["RSA"]["key"];

                $domain = ("" . $this->domain);
                if (stringEx($domain)->startsWith("*."))
                    $domain = ("_ALL_" . stringEx($domain)->subString(1));

                $certificatePath = ("datadb://Certificate/" . $domain . "/");

                $data->cert->path  = $certificatePath . "cert.pem";
                $data->pem->path   = $certificatePath . "pem.pem";
                $data->chain->path = $certificatePath . "chain.pem";
                $data->key->path   = $certificatePath . "key.pem";

                \File::setContents($data->cert->path, $data->cert->data);
                \File::setContents($data->pem->path, $data->pem->data);
                \File::setContents($data->chain->path, $data->chain->data);
                \File::setContents($data->key->path, $data->key->data);

                \File::setContents($certificatePath . "expire.dat", \DateTimeEx::now());
                return $data;
            }

            return Arr([error => INTERNAL_SERVER_ERROR]);
        }
//
//        public static function generate()
//        {
//            $domain = \Config::get()->server->domain;
//            if (stringEx($domain)->isEmpty())
//                return null;
//
//            $currentUrl = \Http\Url::getCurrent();
//            if ($currentUrl != null)
//                $domain = $currentUrl->domain;
//
//            return self::generateByDomain($domain);
//        }
//
//        public static function generateByDomain($domain)
//        {
//            dump($domain);
//
//
//            return null;
//        }
    }
}