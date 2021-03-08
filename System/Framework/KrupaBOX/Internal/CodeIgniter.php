<?php

namespace {

class CodeIgniter
{
    protected static $instance = null;
    
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            $config = \Config::get();

            if (\Connection::isCommandLineRequest() == false)
            {
                define("PHAR_CODEIGNITER", true);
                \Import::PHAR(__KRUPA_PATH_LIBRARY__ . "CodeIgniter.phar/index.php");
            }
            else
            {
                $cachePath = (APPLICATION_FOLDER . ".cache/.phar/CodeIgniter.phar/");

                if (!\File::exists($cachePath . ".installed"))
                {
                    \DirectoryEx::createDirectory($cachePath);
                    $phar = new \Phar(__KRUPA_PATH_LIBRARY__ . "CodeIgniter.phar", 0);
                    $extracted = $phar->extractTo($cachePath, null, true);
                    if ($extracted == true)
                        \File::setContents($cachePath . ".installed", "OK");

                    if (!\File::exists($cachePath . ".installed"))
                    {
                        \Header::getContentType("application/json");
                        \Header::sendHeader();
                        echo \Serialize\Json::encode([error => INTERNAL_SERVER_ERROR, message => "Missing CodeIgniter lib."]);
                        exit;
                    }
                }

                define("PHAR_CODEIGNITER", false);
                \Import::PHP($cachePath . "index.php");
            }

            self::$instance = &codeigniter_get_instance();
        }
     
        return self::$instance;   
    }
}

}